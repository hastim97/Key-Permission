<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $fillable = ['user_id', 'room_id', 'start_date', 'end_date', 'start_time', 'end_time', 'purpose', 'special notes', 'permission_hod', 'permission_vp', ];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function room()
    {
        return $this->belongsTo('App\Room', 'room_id');
    }
}
