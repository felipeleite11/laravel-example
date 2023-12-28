<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropositionSituation extends Model
{
    use HasFactory;

    protected $table = 'proposition_situations';

    protected $fillable = [
        'description'
    ];
}
