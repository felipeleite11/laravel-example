<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropositionType extends Model
{
    use HasFactory;

    protected $table = 'proposition_types';

    protected $fillable = [
        'description'
    ];
}
