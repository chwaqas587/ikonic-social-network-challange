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
$d1=auth()->user()->friends()->get();
        
        $requesterId = Auth::user()->id;
       
         $friends=friendship::get();
         $sentRequests=auth()->user()->pendingFriendsTo()->paginate(10);
         $sentCount=auth()->user()->pendingFriendsTo()->count();
         $recievedRequests=auth()->user()->pendingFriendsFrom()->paginate(10);
         $recievedCount=auth()->user()->pendingFriendsTo()->count();
         $allFriends=$friends->pluck('user_requested');
         $suggessions=User::whereNotIn('id',$allFriends)->whereNot('id',$requesterId)->paginate(10);
         $suggessionsCount=User::whereNotIn('id',$allFriends)->whereNot('id',$requesterId)->count();
         $connections=auth()->user()->friends()->paginate(10);
        $connects= auth()->user()->friends()->count();
        return view('home',compact('suggessionsCount','suggessions','sentRequests','recievedRequests','connections','connects'));
    }




    
}
