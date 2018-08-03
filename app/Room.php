<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $fillable = ['room_no','hod_id','description','multiple',];

    public function permissions()
    {
        return $this->hasMany('App\Permission', 'room_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'hod_id');
    }
}
