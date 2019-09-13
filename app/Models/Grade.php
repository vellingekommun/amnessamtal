<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public $timestamps = false;
    
    protected $table = 'grades';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function teachers()
    {
        return $this->belongsToMany('App\Models\Teacher');
    }
}
