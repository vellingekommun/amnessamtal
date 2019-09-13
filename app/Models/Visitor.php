<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Visitor extends Model
{
    use Notifiable;
    public $timestamps = false;
    
    protected $table = 'visitors';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function slots()
    {
        return $this->hasMany('App\Models\Slot');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }    
}
