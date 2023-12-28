<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Utils\DateTimeUtils;
use Kyslik\ColumnSortable\Sortable;

class Contact extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'nick',
        'birthdate',
        'gender',
        'type',
        'occupation',

        'cep',
        'state_id',
        'city_id',
        'district',
        'address',
        'complement',

        'email',
        'landline',
        'phone',
        'phone_2',
        'observation',
        'political_info'
    ];

    public $sortable = [
        'name',
        'birthdate'
    ];

    public function getBirthdateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getBirthdateUnixAttribute($value)
    {
        return DateTimeUtils::formatDate($this->birthdate);
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
