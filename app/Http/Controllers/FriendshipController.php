<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use App\Models\friendship;
use App\Http\Requests\StorefriendshipRequest;
use App\Http\Requests\UpdatefriendshipRequest;
use Illuminate\Http\Request;
class FriendshipController extends Controller
{



  //to get suggessions
    public function getSuggessions(Request $request)
    {  
        $requesterId = Auth::user()->id;
        $allFriends=friendship::pluck('user_requested');
        $suggessions=User::whereNotIn('id',$allFriends)->whereNot('id',$requesterId)->paginate(10);
       $count=User::whereNotIn('id',$allFriends)->whereNot('id',$requesterId)->count();
        if ($request->ajax()) {
          $response = array(
            "suggessions" => $suggessions,
            "count" => $count,
          );
          return (json_encode($response));}
    

         return $suggessions;

    }


//to get sent requests

    public function getSentRequests(Request $request)
    {   
        $sentRequests=auth()->user()->pendingFriendsTo()->paginate(10);
        $count=auth()->user()->pendingFriendsTo()->count();
        

            if ($request->ajax()) {
              $response = array(
                "sentRequest" =>$sentRequests,
                "count" => $count   
            );
    
            return (json_encode($response));}
            
            return $sentRequests;
    }

// to get recieved requests
    public function getRecievedRequests(Request $request)
    {  
        $recievedRequests=auth()->user()->pendingFriendsFrom()->paginate(10);
        $count=auth()->user()->pendingFriendsTo()->count();
        
            if ($request->ajax()) {
              $response = array(
                "recRequest" =>$recievedRequests,
                "count" => $count   
            );
            return (json_encode($response));}

            return $recievedRequests;
    }
 //to get firends list

    public function getConnections(Request $request)
    {  
        $data = '';
        $connections=auth()->user()->friends()->paginate(10);
        $count= auth()->user()->friends()->count();


        if ($request->ajax()) {
          $response = array(
            "connections" => $connections,
            "count" => $count,

        
        );
        return (json_encode($response));}

           
    }
    

 // to get mutual friends   

    public function getCommonConnections(Request $request) {

      $myFriends=auth()->user()->friends()->pluck('id')->toArray(); //users friends
        $hisFriends=User::find($request->id)->friends()->pluck('id')->toArray();// his friends's friends
        $result=array_intersect($myFriends,$hisFriends);//getting mututal friends ids
        $count=count($result);
        $result=User::whereIn('id',array_values($result))->paginate(10);
       
        if ($request->ajax()) {
          $response = array(
            "Commonconnections" => $result,
            "count" => $count,  
        );
        return (json_encode($response));}}

    // to send request
    public function sendRequest()
    {   
      

       $sendRequest=new friendship;
       $sendRequest->requester_id=Auth::user()->id;
       $sendRequest->user_requested=request()->id;
       $sendRequest->status=0;
       $sendRequest->save();
      


        $response = array(
            "myid" => "sent request",
        
        );
        return (json_encode($response));
    }


    public function deleteRequest()
    {
        $withDrawRequest=friendship::where('user_requested',request()->id)->where('requester_id',Auth::user()->id)->delete();
        $response = array(
            "myid" => "request deleted",
        
        );
        return (json_encode($response));
    }



   
    public function acceptRequest()
    {
        $acceptRequest=friendship::where('user_requested',Auth::user()->id)->where('requester_id',request()->id)->first();
        $acceptRequest->status=1;
        $acceptRequest->save();
        $response = array(
            "myid" => "request accepted",
        
        );
        return (json_encode($response));
    }

    
    public function removeConnection()
    {
        $withDrawRequest=friendship::where('status',1)->where(function($query) {$query->where('requester_id',Auth::user()->id)->orWhere('user_requested',Auth::user()->id);})->where(function($query) {$query->where('requester_id',request()->id)->orWhere('user_requested',request()->id);})->first()->delete();
      
        $response = array(
            "myid" => "Unfriend Succesful",
        
        );
        return (json_encode($response));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\friendship  $friendship
     * @return \Illuminate\Http\Response
     */
    public function edit(friendship $friendship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatefriendshipRequest  $request
     * @param  \App\Models\friendship  $friendship
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatefriendshipRequest $request, friendship $friendship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\friendship  $friendship
     * @return \Illuminate\Http\Response
     */
    public function destroy(friendship $friendship)
    {
        //
    }
}
