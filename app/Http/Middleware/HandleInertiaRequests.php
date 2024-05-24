<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Inertia\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user_role = $request->user() ? $request->user()->getRoleNames()[0] : '';
        $role = $user_role ? Role::findByName($user_role) : '';
        return array_merge(parent::share($request), [
            'roles' => $request->user() ? $request->user()->getRoleNames() : [],
            'can' => $role ? $role->permissions->pluck('name') : [],
            'auth.user' => fn () => $request->user() ?
                $request->user()->only('id', 'name', 'email', 'profile_image') : null,

        ]);
    }
}
