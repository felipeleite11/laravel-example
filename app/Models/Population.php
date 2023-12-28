<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Population extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'population';

    protected $fillable = [
        'state_id',
        'quantity',
        'year',
        'men',
        'women',
        'birth',
        'death',
        'birth_rate',
        'mortality_rate'
    ];

    public $sortable = [
        'year',
        'quantity',
        'men',
        'women',
        'birth',
        'death',
        'birth_rate',
        'mortality_rate',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
