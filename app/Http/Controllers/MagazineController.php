<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Administrator;
use App\Marketing_manager;
use App\Marketing_coordinator;
use App\Student;
use App\Magazine;
use App\Contribution;
use Session;
use Auth;
use DB;
use Validator;

use Zipper;
use Carbon\Carbon;

class MagazineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function downloadAllContribution($id){

        $public_dir=public_path().'/contributions';
        $zipFileName = 'selectedMagazine';
        //$allfiles = glob(public_path('contributions/*'));

        //dd($files);

        $zipFile = [];
        $contributions = Contribution::where('magazine_id', '=', $id)->where('published_status', '=', 1)->get();
        foreach ($contributions as $contribution) {
            $zipFile[]=$public_dir.'/'.$contribution->doc_or_image;
        }

        //dd($zipFile);

        $zip = Zipper::make($public_dir.'/'.$zipFileName)->add($zipFile)->close();

        return response()->download($public_dir.'/'.$zipFileName);

    }
    /**
     * Display a listing of the resource.
     */
    public function index() {

        if (Auth::user()->role==1) {

            $userInformation = Administrator::where('user_id', '=', Auth::user()->id)->get();
            $magazines = Magazine::all();
            //dd($magazines);
            return view('magazine')->with('magazines', $magazines)->with('userInformation', $userInformation);
        }
        elseif(Auth::user()->role==2){
            
            $userInformation = Marketing_manager::where('user_id', '=', Auth::user()->id)->get();
            $magazines = Magazine::all();
            //dd($magazines);
            return view('magazine')->with('magazines', $magazines)->with('userInformation', $userInformation);
        }
        elseif(Auth::user()->role==3){
            
            $userInformation = Marketing_coordinator::where('user_id', '=', Auth::user()->id)->get();
            $magazines = Magazine::all();

            //notification for marketing coordinator
            $notifications = DB::table('notifications')
                                ->join('contributions', 'notifications.contribution_id', '=', 'contributions.id')
                                ->join('students', 'contributions.student_id', '=', 'students.user_id')
                                ->where('notifications.marketing_coordinator_id', '=',  Auth::user()->id)
                                ->where('notifications.syn', '=',  0)
                                ->select('notifications.id', 'contributions.created_at', 'students.*')
                                ->get();

            return view('magazine')->with('magazines', $magazines)->with('userInformation', $userInformation)->with('notifications', $notifications);
            
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
            $magazines = Magazine::all();
            //dd($magazines);
            return view('magazine')->with('magazines', $magazines)->with('userInformation', $userInformation)->with('messages', $messages);
        }


        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $userInformation = Administrator::where('user_id', '=', Auth::user()->id)->get();
        return view('create_magazine')->with('userInformation', $userInformation);
    }

     /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'final_close_date' => 'required|date|after_or_equal:end_date',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //vadidate all request filed
        $this->validator($request->all())->validate();

        //return 'magazine successfully upload';


        $magazine = new Magazine;
        
        $magazine->name =  $request->name;
        $magazine->start_date =  $request->start_date;
        $magazine->end_date =  $request->end_date;
        $magazine->final_end_date =  $request->final_close_date;
        
        $magazine->save();

        Session::flash('response', 'Magazine has been created successfully..'); 
        
        $userInformation = Administrator::where('user_id', '=', Auth::user()->id)->get();
        return view('create_magazine')->with('userInformation', $userInformation);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) 
    {

        if (Auth::user()->role==1) {
            
            $userInformation = Administrator::where('user_id', '=', Auth::user()->id)->get();

            $magazine = Magazine::where('id', '=', $id)->first();

            $contributions = Contribution::where('contributions.magazine_id', '=', $magazine->id)->get();

            return view('magazine-contribution')->with('userInformation', $userInformation)->with('magazine', $magazine)->with('contributions', $contributions);
            //echo "magazine show";
            
        }
        elseif(Auth::user()->role==2){
            $userInformation = Marketing_manager::where('user_id', '=', Auth::user()->id)->get();

            $magazine = Magazine::where('id', '=', $id)->first();

            $contributions = Contribution::where('contributions.magazine_id', '=', $magazine->id)->get();

            return view('magazine-contribution')->with('userInformation', $userInformation)->with('magazine', $magazine)->with('contributions', $contributions);
            
        
        }
        elseif(Auth::user()->role==3){
            $userInformation = Marketing_coordinator::where('user_id', '=', Auth::user()->id)->get();

            $magazine = Magazine::where('id', '=', $id)->first();

            $contributions = Contribution::join('students', 'contributions.student_id', '=', 'students.user_id')
                                            ->join('faculties', 'students.faculty_id', '=', 'faculties.id')
                                            ->join('marketing_coordinators', 'faculties.marketing_coordinator_id', '=', 'marketing_coordinators.user_id')
                                            ->where('marketing_coordinators.user_id', '=', Auth::user()->id)
                                            ->where('contributions.magazine_id', '=', $magazine->id)
                                            ->select('contributions.*', 'students.first_name', 'students.last_name')
                                            ->get();

                                            //dd($contributions);

            //notification for marketing coordinator
            $notifications = DB::table('notifications')
                                ->join('contributions', 'notifications.contribution_id', '=', 'contributions.id')
                                ->join('students', 'contributions.student_id', '=', 'students.user_id')
                                ->where('notifications.marketing_coordinator_id', '=',  Auth::user()->id)
                                ->where('notifications.syn', '=',  0)
                                ->select('notifications.id', 'contributions.created_at', 'students.*')
                                ->get();


            return view('magazine-contribution')->with('userInformation', $userInformation)->with('magazine', $magazine)->with('contributions', $contributions)->with('notifications', $notifications);
            
        
        }

        elseif(Auth::user()->role==4){
            
            $userInformation = Student::where('user_id', '=', Auth::user()->id)->get();

            $magazine = Magazine::where('id', '=', $id)->first();

            $contributions = Contribution::where('student_id', '=', Auth::user()->id)->where('magazine_id', '=', $id)->get();

            //message for Student
            $messages = DB::table('messages')
                                ->join('marketing_coordinators', 'messages.marketing_coordinatord_id', 'marketing_coordinators.user_id')
                                ->where('messages.student_id', '=',  Auth::user()->id)
                                ->where('messages.syn', '=',  0)
                                ->select('*')
                                ->get();

            return view('magazine-contribution')->with('userInformation', $userInformation)->with('magazine', $magazine)->with('contributions', $contributions)->with('messages', $messages);
            
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validator($request->all())->validate();
        
        $magazine = Magazine::where('id', '=', $id)->first();
        
        $magazine->name =  $request->name;
        $magazine->start_date =  $request->start_date;
        $magazine->end_date =  $request->end_date;
        $magazine->final_end_date =  $request->final_close_date;

        $magazine->save();
        
        return redirect()->action(
                    'MagazineController@index', ['id' => $request->magazine_id]
                );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}

