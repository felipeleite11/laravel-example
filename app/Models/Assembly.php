<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    use HasFactory;

    protected $table = 'assemblies';

    protected $fillable = [
        'state_id',
        'city_id',
        'address',
        'neighborhood',
        'zipcode',
        'phone',
        'email',
        'president_id'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function president()
    {
        return $this->belongsTo(Election::class);
    }
}
