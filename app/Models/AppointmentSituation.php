<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentSituation extends Model
{
    use HasFactory;

    protected $table = 'appointment_situations';

    protected $fillable = [
        'description'
    ];
}
