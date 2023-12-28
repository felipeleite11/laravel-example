<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Utils\DateTimeUtils;
use Kyslik\ColumnSortable\Sortable;

class Prefecture extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'prefectures';

    protected $fillable = [
        'state_id',
        'city_id',
        'zipcode',
        'address',
        'neighborhood',
        'gentilic',
        'birthdate',
        'phone',
        'association'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function getBirthdateAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

    protected function getBirthdateUnixAttribute()
    {
        $date = DateTimeUtils::getCarbonInstanceFromDatetimeBR($this->birthdate);

        return Carbon::parse($date)->format('Y-m-d');
    }

    public function mayor()
    {
        return $this->belongsTo(Election::class, 'mayor_id');
    }
}
