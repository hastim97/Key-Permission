<?php

namespace App\Http\Controllers;

use App\Room;
use App\User;
use App\Permission;
use Illuminate\Http\Request;
use DB;
use json;
use Carbon\Carbon;

class PermissionController extends Controller
{
    // --------------------POST /postPermission---------------------------- //
    public function postPermission(Request $request) {
        //$permissions = Permission::create($request->all());
        //$user_id = $request->post('user_id');

      /* 'form_params' => [
            'room_id' => 'room_id',
            'start_date' => 'start_date',
            'end_date' => 'end_date',
            'start_time' => 'start_time',//
            'end_time' => 'end_time',
            'purpose' => 'purpose',
            'special_notes' => 'special_notes',
            'permission_hod' => 'permission_hod',
            'permission_vp' => 'permission_vp',
        ]; */

        $api_token_D = $request->get('api_token');
        $user_id_D = User::where('api_token','=',$api_token_D)->value('id');
        $room_id_D = $request->get('room_id');
        $start_date_D = $request->get('start_date');
        $end_date_D = $request->get('end_date');
        $start_time_D = $request->get('start_time');
        $end_time_D = $request->get('end_time');
        $purpose_D = $request->get('purpose');
        $special_notes_D = $request->get('special_notes');

        $per = new Permission();
        $per->user_id = $user_id_D;
        $per->room_id = $room_id_D;
        $per->start_date = $start_date_D;
        $per->end_date = $end_date_D;
        $per->start_time = $start_time_D;
        $per->end_time = $end_time_D;
        $per->purpose = $purpose_D;
        $per->special_notes = $special_notes_D;
        $per->save();

        return response()->json($per, 201);

    }


    // --------------------POST /postPermissionHOD---------------------------- //
    public function postPermissionHod(Request $request) {

        $permission_id = $request->get('permission_id');
        $permission_hod_D = $request->get('permission_hod');
        $item = Permission::findorFail($permission_id);
        $item->permission_hod = $permission_hod_D;
        $item->save();
        return response()->json($item, 201);
    }

    // --------------------POST /postPermissionVP---------------------------- //
    public function postPermissionVp(Request $request) {

        $permission_id = $request->get('permission_id');
        $permission_vp_D = $request->get('permission_vp');
        $deal = Permission::findorFail($permission_id);
        //$deal->permission_hod = 1;
        $deal->permission_vp = $permission_vp_D;
        $deal->save();
        return response()->json($deal, 201);
    }


    public function deletePermission(Request $request){

        $permission_id = $request->get('permission_id');
        $row=Permission::find($permission_id);
        $row->delete();
//        echo $row;
        return response()->json($row, 201);
    }
}



/*
  $user_id = $request->post('user_id');
        'form_params' => [
            'grant_type' => 'refresh_token',
            'refresh_token' => 'the-refresh-token',
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'scope' => '',
        ],
 */

/*
    $permission_id = $request->post('id');

        $api_token_D = $request->get('api_token');

        $user_id_D = User::where('api_token','=',$api_token_D)->value('id');

        $room_id_D = $request->get('room_id');
        $permission_hod_D = $request->get('permission_hod');

        $per->room_id = $room_id_D;
        $per->permission_hod = $permission_hod_D;
        $per->save();
 */