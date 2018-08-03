<?php

namespace App\Http\Controllers;
use App\Room;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use json;
use Carbon\Carbon;
use App\Permission;


class RoomController extends Controller
{


   	// ---------------GET /getRooms------------------------ //
    public function getRooms(){
      $rooms = Room::all();
      return response()->json($rooms);
    }

    // ---------------GET /getPermissionRoom-------------- //
    public function getPermissionRoom(Request $request){
        $startDay = 1;
        $month = $request->get('month');
        $year = $request->get('year');
        $endDay = cal_days_in_month(CAL_GREGORIAN, $month, $year);

       $monthStart =  Carbon::createFromDate($year, $month, $startDay)->toDateString();
        // echo $monthStart;

        $monthEnd = Carbon::createFromDate($year, $month, $endDay)->toDateString();
        //echo $monthEnd;

        $room_id = $request->get('room_id');
        //$room = Room::find($room_id);
//        ->where('start_date', '<=' , $monthStart)->Where('end_date','<=',$monthEnd)
        $permission =Permission::where('room_id','=',$room_id)->get(['purpose', 'start_date', 'end_date', 'start_time', 'end_time']);//->only(['permission_hod', 'permission_vp']);
       //purpose , start & end date
        return response()->json($permission);
    }

    // ---------------------GET /getPermissionDate------------------------- //
    public function getPermissionDate(Request $request){
        $checkDate = $request->get('date');
//        echo $checkDate;

        $permission = Permission::where('start_date', '<=' , $checkDate)->Where('end_date','>=',$checkDate)->get(['room_id', 'purpose', 'start_date', 'end_date', 'start_time', 'end_time']);//->only(['permission_hod', 'permission_vp']);
        return response()->json($permission);
    }

    // --------------------GET /getPermissionHod---------------------------- //
    public function getPermissionHod(Request $request){

        $api_token = $request->get('api_token');
        $hid = User::where('api_token','=',$api_token)->value('id');
        $query=Room::select('id')->where('hod_id',$hid)->get();
        $permission_list=Permission::whereIn('room_id',$query)->where('permission_hod','=',null)->get();
        $room_id_list=$permission_list->pluck('room_id');
        foreach ($room_id_list as $item) {
            $room_list[]=Room::select('room_no')->where('id',$item)->get();
        }
        $user_id_list= $permission_list->pluck('user_id');
        foreach ($user_id_list as $item) {
            $user_name_list[]=User::select('name')->where('id',$item)->get();
        }
        return response()->json(array($room_list,$user_name_list,$permission_list));
    }


    public function getPermissionVp(Request $request){

        $permission_list=Permission::where('permission_hod','=',1)->where('permission_vp','=',null)->get();
        $room_id_list=$permission_list->pluck('room_id');
        foreach ($room_id_list as $item) {
            $room_list[]=Room::select('room_no')->where('id',$item)->get();
        }
        $user_id_list= $permission_list->pluck('user_id');
        foreach ($user_id_list as $item) {
            $user_name_list[]=User::select('name')->where('id',$item)->get();
        }
        return response()->json(array($room_list,$user_name_list,$permission_list));
    }


    public function getPermissionUser(Request $request){
        $api_token = $request->get('api_token');
        $id = User::where('api_token','=',$api_token)->value('id');
        $permission_list=Permission::where('user_id',$id)->get();
        $room_id_list=$permission_list->pluck('room_id');
        foreach ($room_id_list as $item) {
            $room_list[]=Room::select('room_no')->where('id',$item)->get();
        }
        return response()->json(array($room_list,$permission_list));
    }


    public function getAllPermissionHod(Request $request){

        $api_token = $request->get('api_token');
        $hid = User::where('api_token','=',$api_token)->value('id');
        $query=Room::select('id')->where('hod_id',$hid)->get();
        $permission_list=Permission::whereIn('room_id',$query)->get();
        $room_id_list=$permission_list->pluck('room_id');
        foreach ($room_id_list as $item) {
            $room_list[]=Room::select('room_no')->where('id',$item)->get();
        }
        $user_id_list= $permission_list->pluck('user_id');
        foreach ($user_id_list as $item) {
            $user_name_list[]=User::select('name')->where('id',$item)->get();
        }
        return response()->json(array($room_list,$user_name_list,$permission_list));
    }


    public function getAllPermissionVp(Request $request){

        $permission_list=Permission::where('permission_hod','=',1)->get();
        $room_id_list=$permission_list->pluck('room_id');
        foreach ($room_id_list as $item) {
            $room_list[]=Room::select('room_no')->where('id',$item)->get();
        }
        $user_id_list= $permission_list->pluck('user_id');
        foreach ($user_id_list as $item) {
            $user_name_list[]=User::select('name')->where('id',$item)->get();
        }
        return response()->json(array($room_list,$user_name_list,$permission_list));
    }
}



