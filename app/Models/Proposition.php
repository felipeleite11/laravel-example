<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Utils\DateTimeUtils;
use Kyslik\ColumnSortable\Sortable;

class Proposition extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'propositions';

    protected $fillable = [
        'state_id',
        'city_id',
        'type_id',
        'situation_id',
        'number',
        'year',
        'date',
        'description',
        'observation',
        'reference',
        'area',
        'file',
    ];

    public $sortable = [
        'year',
        'number',
        'date'
    ];

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    protected function getDateUnixAttribute()
    {
        $date = DateTimeUtils::getCarbonInstanceFromDatetimeBR($this->date);

        return Carbon::parse($date)->format('Y-m-d');
    }

    public function getIsPastAttribute() {
        return $this->date_unix < date('Y-m-d H:i:s');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function situation()
    {
        return $this->belongsTo(PropositionSituation::class);
    }

    public function type()
    {
        return $this->belongsTo(PropositionType::class);
    }
}

