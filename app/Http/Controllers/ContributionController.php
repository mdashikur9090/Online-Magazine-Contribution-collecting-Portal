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
use App\Notification;
use App\Faculty_guest;
use Auth;
use DB;
use Validator;
use Carbon\Carbon;

use Storage;

//SELECT COUNT(contributions.id) AS contributions_number, faculties.name FROM `contributions` INNER JOIN students ON (contributions.student_id=students.user_id)  INNER JOIN  faculties ON (students.faculty_id=faculties.id) WHERE contributions.magazine_id=1 GROUP BY students.faculty_id 

//SELECT COUNT(students.user_id), faculties.name AS totalContribution FROM `faculties`  INNER JOIN students ON (faculties.id=students.faculty_id) WHERE students.user_id IN (SELECT DISTINCT student_id FROM contributions WHERE contributions.magazine_id = 1) GROUP BY faculties.id


class ContributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showStatisticsReport(){

        if ( Auth::user()->role==1) {
            //get user information
            $userInformation = Administrator::where('user_id', '=', Auth::user()->id)->get();
        }elseif( Auth::user()->role==5 ) {
            //get user information
            $userInformation = Faculty_guest::where('user_id', '=', Auth::user()->id)->get();

        }

        

        $noContributionsEachFacultyEAY = [];
        $noContributorsEachFacultyEAY = [];

        //get all magazine
        $magazines = Magazine::all();

        foreach ($magazines as $magazine) {
            //number of contributon
            $facultiesContribution = DB::table('contributions')
                                        ->select(DB::raw('COUNT(contributions.id) AS contributions_number, faculties.name, magazines.name as magazine_name'))
                                        ->join('students', 'student_id', 'user_id')
                                        ->join('magazines', 'magazine_id', 'magazines.id')
                                        ->join('faculties', 'faculty_id', 'faculties.id')
                                        ->where('magazine_id', '=', $magazine->id)
                                        ->groupBy('faculty_id')
                                        ->get();

            //now push into array
            array_push($noContributionsEachFacultyEAY, $facultiesContribution);

            //number of contributors
            $facultiesContributors = DB::table('faculties')
                                        ->select(DB::raw('COUNT(students.user_id) AS totalContribution, faculties.name, (SELECT name FROM magazines WHERE magazines.id='.$magazine->id.') as magazine_name'))
                                        ->join('students', 'id', 'faculty_id')
                                        ->groupBy('faculty_id')
                                        ->whereRaw('students.user_id IN (SELECT DISTINCT student_id FROM contributions WHERE contributions.magazine_id = '.$magazine->id.')')
                                        ->get();

            //now push into array
            array_push($noContributorsEachFacultyEAY, $facultiesContributors);
        }

        

        //number of contributon for parcentage
            $fContributionforPercentage = DB::table('contributions')
                                        ->select(DB::raw('COUNT(contributions.id) AS totalContribution, faculties.name'))
                                        ->join('students', 'student_id', 'user_id')
                                        ->join('faculties', 'faculty_id', 'faculties.id')
                                        ->where('magazine_id', '=', 1)
                                        ->groupBy('faculty_id')
                                        ->get();

                                        //dd($noContributionsEachFacultyEAY);
                                        //dd($fContributionforPercentage);
                                        //dd($noContributorsEachFacultyEAY);
                    


        
        return view('reports')->with('userInformation', $userInformation)->with('noContributionsEachFacultyEAY', $noContributionsEachFacultyEAY)->with('noContributorsEachFacultyEAY', $noContributorsEachFacultyEAY)->with('fContributionforPercentage', $fContributionforPercentage);
    }

    public function showExceptionReport(){

        $userInformation = Administrator::where('user_id', '=', Auth::user()->id)->get();

        $conWithoutcommnets = Contribution::where('comment', '=', null)->get();

        $expiedCommnets =[];
        foreach ($conWithoutcommnets as $conWithoutcommnet) {
            if ( Carbon::parse($conWithoutcommnet->created_at)->addDay(14)->lessThan(Carbon::now('+6:00')) ) {
                array_push($expiedCommnets, $conWithoutcommnet);
            }

            //for testing perpouse
            // echo Carbon::parse($conWithoutcommnet->created_at)->addDay(14)."</br>";
            // echo Carbon::parse($conWithoutcommnet->created_at)->addDay(14)->lessThan(Carbon::now())."</br>";
        }

        return view('exception-report')->with('userInformation', $userInformation)->with('conWithoutcommnets', $conWithoutcommnets)->with('expiedCommnets', $expiedCommnets);
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //validate all the fields
        Validator::make($request->all(), [
            'doc_or_img' => 'required|array',
            'doc_or_img.*' => 'required|file|mimes:jpeg,bmp,png,docx',
            'atc'    => 'required',
            ])->validate();

        $paths  = [];

        for ($i=0; $i < count($request->doc_or_img); $i++) { 
            //store contribution to databse

            $fileExtension = $request->doc_or_img[$i]->getClientOriginalExtension();
            $fileName  = 'di' . uniqid() . '.' . $fileExtension;

            $paths[] = Storage::disk('public_contributions')->put($fileName, file_get_contents($request->doc_or_img[$i]));

            $contribution = new Contribution;

            $contribution->magazine_id = $request->magazine_id;
            $contribution->student_id  = Auth::user()->id;
            $contribution->doc_or_image    = $fileName;            

            $contribution->save();

            //make notification for marketing coordinator
            $notification = new Notification;

            //get marketing cordinator id
            $mcid = DB::table('students')
                        ->join('faculties', 'students.faculty_id', '=', 'faculties.id')
                        ->where('user_id', '=',  Auth::user()->id)
                        ->select('faculties.marketing_coordinator_id')
                        ->first();

            $notification->marketing_coordinator_id = $mcid->marketing_coordinator_id;;
            $notification->contribution_id           = $contribution->id;
            $notification->syn                       = 0;

            $notification->save();


        }

        return redirect()->action(
                    'MagazineController@show', ['id' => $request->magazine_id]
                );

        
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        
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
    public function update(Request $request, $id) {
        //validate all the fields
        Validator::make($request->all(), [
            'doc_or_img' => 'required|file|mimes:jpeg,bmp,png,docx',
            ])->validate();

        //echo $id;
        $contribution = Contribution::where('id', '=', $id)->get();

        //dd($contribution);

        //delete the file from storage
        Storage::disk('public_contributions')->delete($contribution[0]->doc_or_image);

        //now store new file
        $fileExtension = $request->doc_or_img->getClientOriginalExtension();
        $fileName  = 'di' . uniqid() . '.' . $fileExtension;
        $paths[] = Storage::disk('public_contributions')->put($fileName, file_get_contents($request->doc_or_img));

        DB::table('contributions')
            ->where('id', $contribution[0]->id)
            ->update(['doc_or_image' => $fileName]);


        return redirect()->action(
                    'MagazineController@show', ['id' => $contribution[0]->magazine_id]
                );

        
    }

    public function updatePublishedStatus(Request $request) {
        //validate all the fields
        Validator::make($request->all(), [
            'contribution_id' => 'required|array',
            'published_status' => 'required|array',
            'contribution_id.*' => 'required|integer',
            'published_status.*' => 'required|integer|in:0,1',
            ])->validate();

        for ($i=0; $i < count($request->published_status); $i++) { 
            DB::table('contributions')
                ->where('id', $request->contribution_id[$i] )
                ->update(['published_status' => $request->published_status[$i] ]);
        }

        return redirect()->action(
                    'MagazineController@show', ['id' => $request->magazine_id]
                );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
    public function comment(Request $request) {
        //validate all the fields
        Validator::make($request->all(), [
            'comment' => 'required|string',
            ])->validate();

        $contribution = Contribution::where('id', '=', $request->contribution_id)->first();
        $contribution->comment = $request->comment;

        $contribution->save();

        return redirect()->action(
                    'MagazineController@show', ['id' => $contribution->magazine_id]
                );
    }
}
