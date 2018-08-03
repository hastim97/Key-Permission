<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function viewHOD(){
        return view('hod');
    }

    public function viewVP(){
        return view('vp');
    }
    public function viewCalendar(){
        return view('calendar');
    }

    public function login(){
        return view('login');
    }

    public function register(){
        return view('register');
    }

    public function forgotPassword(){
        return view('forgot_password');
    }

    public function viewAllRequestsStudent(){
        return view('permissionStudent');
    }

    public function viewAllRequestsHOD(){
        return view('permissionHOD');
    }

    public function viewAllRequestsVP(){
        return view('permissionVP');
    }
}
