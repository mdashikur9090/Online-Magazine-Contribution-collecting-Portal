<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Administrator;
use App\Marketing_manager;
use App\Marketing_coordinator;
use App\Student;
use App\Faculty_guest;
use App\Magazine;
use App\Notification;
use Auth;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {

        if (Auth::user()->role==1) {

            // $userInformation = Administrator::where('user_id', '=', Auth::user()->id)->get();
            // return view('home')->with('userInformation', $userInformation);
            return redirect('/report/statistics'); 
        }
		elseif(Auth::user()->role==2){
			
			// $userInformation = Marketing_manager::where('user_id', '=', Auth::user()->id)->get();
   //          return view('home')->with('userInformation', $userInformation);
            return redirect('/magazine'); 
		}
		elseif(Auth::user()->role==3){
            
            // $userInformation = Marketing_coordinator::where('user_id', '=', Auth::user()->id)->get();
            // $notifications = DB::table('notifications')
            //                     ->join('contributions', 'notifications.contribution_id', '=', 'contributions.id')
            //                     ->join('students', 'contributions.student_id', '=', 'students.user_id')
            //                     ->where('notifications.marketing_coordinator_id', '=',  Auth::user()->id)
            //                     ->where('notifications.syn', '=',  0)
            //                     ->select('notifications.id', 'contributions.created_at', 'students.*')
            //                     ->get();

            // return view('home')->with('userInformation', $userInformation)->with('notifications', $notifications);
            return redirect('/magazine'); 
        }elseif(Auth::user()->role==5){
			
			return redirect('/report/statistics');
		}
		else{

            //message for Student
            $messages = DB::table('messages')
                                ->join('marketing_coordinators', 'messages.marketing_coordinatord_id', 'marketing_coordinators.user_id')
                                ->where('messages.student_id', '=',  Auth::user()->id)
                                ->where('messages.syn', '=',  0)
                                ->select('*')
                                ->get();
			
			$userInformation = Student::where('user_id', '=', Auth::user()->id)->get();
            return view('home')->with('userInformation', $userInformation)->with('messages', $messages);
		}
        
    }
	  
	
}
