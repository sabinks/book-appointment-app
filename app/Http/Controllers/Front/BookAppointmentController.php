<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BookAppointment;
use App\Jobs\BookAppointmentJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class BookAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookAppointment = BookAppointment::where('booking_date_time', '>=', Carbon::now()->toDateTimeString())->get()->pluck(['booking_date_time']);
        return Inertia::render('BookAppointment', ['appointments' => $bookAppointment]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|lowercase|email',
            'phone' => 'required',
            'dob' => 'required',
            'booking_date' => 'required',
            'booking_time' => 'required',
            'description' => 'required|max:1000'
        ]);

        DB::beginTransaction();
        try {
            $input = $request->only(['name', 'email', 'phone', 'dob', 'description']);
            $input['booking_date_time'] = $request->booking_date . " " . $request->booking_time;
            $random_password = Str::random(12);
            $client = User::whereEmail($request->email)->count();
            if (!$client) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'dob' => $request->dob,
                    'phone' => $request->phone,
                    // 'self_signup' => false,
                    // 'admin_added' => false,
                    'is_active' => false,
                    'password' => Hash::make($random_password),
                ]);
                $input['user_id'] = $user->id;
                $user->assignRole('Member');
            } else {
                $input['user_id'] = $client['id'];
            }
            $BookAppointment = BookAppointment::create($input);
            BookAppointmentJob::dispatch($BookAppointment);

            DB::commit();
            return response()->json([
                'message' => 'Thank you for booking appointment with us, we will contact you soon!',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function checkAppointmentAvailability()
    {
        $bookAppointment = BookAppointment::where('booking_date_time', '>=', Carbon::now()->toDateTimeString())->get()->pluck(['booking_date_time']);
        return $bookAppointment;
    }
}
