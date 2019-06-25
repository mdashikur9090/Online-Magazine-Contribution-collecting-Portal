<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Student;
use App\Message;
use App\Administrator;
use App\Marketing_manager;
use App\Marketing_coordinator;
use App\Notification;
use Auth;
use DB;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userInformation = Student::where('user_id', '=', Auth::user()->id)->get();

        //message for notification
        $messages = DB::table('messages')
                            ->join('marketing_coordinators', 'messages.marketing_coordinatord_id', 'marketing_coordinators.user_id')
                            ->where('messages.student_id', '=',  Auth::user()->id)
                            ->where('messages.syn', '=',  0)
                            ->select('*')
                            ->get();

        //all message
        $allMessages = DB::table('messages')
                            ->join('marketing_coordinators', 'messages.marketing_coordinatord_id', 'marketing_coordinators.user_id')
                            ->where('messages.student_id', '=',  Auth::user()->id)
                            ->select('*')
                            ->get();

        return view('message')->with('userInformation', $userInformation)->with('messages', $messages)->with('allMessages', $allMessages);

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
    public function sendMessage(Request $request)
    {
        echo "string";
        //
        $message = new Message;
        $message->marketing_coordinatord_id = $request->m_coordinator_id;
        $message->student_id = $request->student_id;
        $message->message = $request->message;
        $message->syn = 0;

        $message->save();

        $request->session()->flash('message_status', 'Message has been send successful!');

        return redirect()->action(
                    'MagazineController@show', ['id' => $request->magazine_id]
                );
     }

    /**
     * Display the specified resource.
     */
    public function clear($id)
    {
        //clear notification
        $notification = Notification::find($id);
        $notification->syn = 1;
        $notification->save();

        //get the magazine for redirect to magazine contribution
        $mid = DB::table('notifications')
                ->join('contributions', 'notifications.contribution_id', '=', 'contributions.id')
                ->where('notifications.id', '=',  $notification->id)
                ->select('contributions.magazine_id')
                ->first();

        return redirect()->action(
                    'MagazineController@show', ['id' => $mid->magazine_id]
                );
    }

    public function seenMessage($id)
    {
        //clear notification
        $message = Message::find($id);
        $message->syn = 1;
        $message->save();

        return redirect('message');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
