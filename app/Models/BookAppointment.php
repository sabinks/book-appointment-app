<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAppointment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'dob', 'booking_date_time', 'description', 'user_id', 'status'];
}
