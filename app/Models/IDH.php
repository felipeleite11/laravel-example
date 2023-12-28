<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class IDH extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'idh';

    protected $fillable = [
        'state_id',
        'city_id',
        'year',
        'idhm',
        'idhmE',
        'idhmL',
        'idhmR'
    ];

    public $sortable = [
        'year',
        'idhm',
        'idhmE',
        'idhmL',
        'idhmR'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
