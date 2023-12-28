<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentAdministration extends Model
{
    use HasFactory;

    protected $table = 'appointment_administrations';

    protected $fillable = [
        'description'
    ];
}
