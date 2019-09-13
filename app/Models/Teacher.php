<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $timestamps = false;

    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $visible = ['id', 'name', 'room'];

    public function slots()
    {
        return $this->hasMany('App\Models\Slot');
    }

    public function grades()
    {
        return $this->belongsToMany('App\Models\Grade');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }
}
