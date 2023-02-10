<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\friendship;
use Illuminate\Http\Request;
use App\Models\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $requesterId = Auth::user()->id;
       
         $friends=friendship::get();
         $sentRequests=$friends->where('requester_id',$requesterId)->where('status',0)->pluck('user_requested');
         $recievedRequests=$friends->where('user_requested',$requesterId)->where('status',0)->pluck('requester_id');
         $connects=friendship::where('status',1)->where(function($query) {$query->where('requester_id',Auth::user()->id)->orWhere('user_requested',Auth::user()->id);})->pluck('user_requested');
         $allFriends=$friends->pluck('user_requested');
         $suggessions=User::whereNotIn('id',$allFriends)->whereNot('id',$requesterId)->get();
         $sentRequests=User::whereIn('id',$sentRequests)->get();
         $recievedRequests=User::whereIn('id',$recievedRequests)->get();
         $connections=User::whereIn('id',$connects)->get();
        return view('home',compact('suggessions','sentRequests','recievedRequests','connections','connects'));
    }




    
}
