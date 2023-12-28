<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;

class Election extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'elections';

    protected $fillable = [
        'year',
        'state_id',
        'city_id',
        'job',
        'number',
        'round',
        'name',
        'nickname',
        'situation',
        'situation_detail',
        'party',
        'party_number',
        'situation_candidate',
        'votes'
    ];

    public $sortable = [
        'name',
        'round',
        'party',
        'situation_candidate',
        'nickname'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function getJobAttribute($value)
    {
        return Str::ucfirst(Str::lower($value));
    }

    public function getModelDescriptionPluralAttribute() {
        $job = Str::lower($this->job);

        if(Str::endsWith($job, 'or')) {
            return $job.'es';
        }

        if(Str::startsWith($job, 'Deputado')) {
            $parts = Str::of($job)->explode(' ');

            $type = Str::replaceLast('l', 'is', $parts[1]);

            return $parts[0].'s '.$type;
        }

        return $job.'s';
    }
}
