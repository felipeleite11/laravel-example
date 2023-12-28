<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Utils\DateTimeUtils;
use Kyslik\ColumnSortable\Sortable;

class Schedule extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'schedules';

    protected $fillable = [
        'state_id',
        'city_id',
        'event',
        'address',
        'datetime',
        'observation'
    ];

    public $sortable = [
        'event',
        'datetime'
    ];

    public function getDatetimeAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i');
    }

    protected function getDatetimeUnixAttribute()
    {
        $date = DateTimeUtils::getCarbonInstanceFromDatetimeBR($this->datetime);

        return Carbon::parse($date)->format('Y-m-d');
    }

    protected function getDateUnixAttribute()
    {
        $date = DateTimeUtils::getCarbonInstanceFromDatetimeBR($this->date);

        return Carbon::parse($date)->format('Y-m-d');
    }

    public function getIsPastAttribute() {
        return $this->datetime_unix < date('Y-m-d H:i:s');
    }

    public function getDateAttribute() {
        return date('d/m/Y', strtotime($this->datetime_unix));
    }

    public function getTimeAttribute() {
        return date('H:i', strtotime($this->datetime_unix));
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
