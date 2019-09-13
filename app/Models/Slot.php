<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Slot extends Model
{
    public $timestamps = false;

    protected $dates = ['starts_at', 'booked_at', 'reserved_at'];

    protected $table = 'slots';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $appends = ['is_reserved_or_booked', 'time'];
    protected $visible = ['id', 'teacher_id', 'time', 'is_reserved_or_booked'];

    public function visitor()
    {
        return $this->belongsTo('App\Models\Visitor');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }

    public function getIsReservedOrBookedAttribute()
    {
        return ($this->booked_at != NULL || $this->reserved_at > Carbon::now()->subMinutes(10))?$this->visitor_id:false;
    }

    public function isBooked()
    {
        return $this->booked_at != NULL && $this->visitor_id > 0;
    }

    public function isBlocked()
    {
        return $this->visitor_id == 0 && $this->booked_at != NULL;
    }    

    public function getTimeAttribute()
    {
        return $this->starts_at->format('H:i');
    }


    public function scopeBookableBy($query, $visitorId)
    {
        return $query->where(function ($query) use ($visitorId) {
            $query->where(function ($query) use ($visitorId){
                $query->where(function ($query) use ($visitorId) {
                    $query->where('visitor_id', $visitorId)->orWhereNull('visitor_id');
                });
            })
            ->orWhere(function ($query) {
                $query->where(function ($query) {
                    $query->where('reserved_at', '<', Carbon::now()->subMinutes(10))->orWhereNull('reserved_at');
                })->whereNull('booked_at');
            });
        });
    }

    public function scopeReservedBy($query, $visitorId)
    {
        return $query->where('visitor_id', $visitorId)->where(function ($query) {
                    $query->where('reserved_at', '>', Carbon::now()->subMinutes(10))->orWhereNotNull('booked_at');
                });
    }

    public function scopeBookedBy($query, $visitorId)
    {
        return $query->where('visitor_id', $visitorId)->whereNotNull('booked_at');
    }

    public function scopeBooked($query)
    {
        return $query->whereNotNull('booked_at');
    }

    public function scopeForVisitorWithEmail($query, $visitorEmail)
    {
        return $query->whereHas('visitor', function($q) use ($visitorEmail){
            $q->where('email', $visitorEmail);
        });
    }
}
