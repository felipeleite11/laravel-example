<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class City extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'cities';

    protected $fillable = [
        'code',
        'description'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
