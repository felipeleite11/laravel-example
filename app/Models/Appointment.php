<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Utils\DateTimeUtils;
use Kyslik\ColumnSortable\Sortable;

class Appointment extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'appointments';

    protected $fillable = [
        'state_id',
        'city_id',
        'administration_id',
        'type_id',
        'date',
        'name',
        'phone',
        'observation',
        'reference',
        'responsible',
        'situation_id'
    ];

    public $sortable = [
        'date',
        'name',
        'reference',
        'responsible',
        'city_id'
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

    public function type()
    {
        return $this->belongsTo(AppointmentType::class);
    }

    public function administration()
    {
        return $this->belongsTo(AppointmentAdministration::class);
    }

    public function situation()
    {
        return $this->belongsTo(AppointmentSituation::class);
    }
}
