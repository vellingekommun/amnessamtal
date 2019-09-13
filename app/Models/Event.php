<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Event extends Model
{
    public $timestamps = false;
    
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = [
        'starts_at',
        'ends_at',
        'booking_starts_at',
        'booking_ends_at',
    ];

    public function visitors()
    {
        return $this->hasMany('App\Models\Visitor');
    }

    public function teachers()
    {
        return $this->hasMany('App\Models\Teacher');
    }   

    public function grades()
    {
        return $this->hasMany('App\Models\Grade');
    }    

    public function __construct(array $attributes = []) {
        $this->prepareDateValues($attributes);

        parent::__construct($attributes);
    }

    protected function prepareDateValues(array &$attributes)
    {
        $dateFormat = $this->getDateFormat();

        foreach ($this->getDates() as $date) {
            if (isset($attributes[$date])) {
                $attributes[$date] = Carbon::parse($attributes[$date])->format($dateFormat);
            }
        }
    }

    public function update(array $attributes = [], array $options = []) {
        $this->prepareDateValues($attributes);

        return parent::update($attributes, $options);
    }

    public function scopeBookable($query)
    {
        return $query->where('booking_starts_at', '<', Carbon::now())->where('booking_ends_at', '>', Carbon::now());
    }
}
