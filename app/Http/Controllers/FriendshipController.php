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
    public function getSuggessions(Request $request)
    {  $data = '';
        $requesterId = Auth::user()->id;
        $allFriends=friendship::pluck('user_requested');
        $suggessions=User::whereNotIn('id',$allFriends)->whereNot('id',$requesterId)->paginate(10);
        $count=$suggessions->count();
        if ($request->ajax()) {

            foreach ($suggessions as $suggession) {
				$data.='<div class="my-2 shadow  text-white bg-dark p-1" id="" >
                <div class="d-flex justify-content-between">
                  <table class="ms-1">
                    <td class="align-middle">'. $suggession->name .'</td>
                    <td class="align-middle"> - </td>
                    <td class="align-middle">'. $suggession->email.'</td>
                    <td class="align-middle"> 
                  </table>
                  <div>
                    <input type="text" value="'. $suggession->id .'" hidden name="user_requested" id="user_requested">
                    <button id="create_request_btn_" class="btn btn-primary me-1" onclick="sendRequest('.Auth::user()->id.', '.$suggession->id.')" >Connect</button>
                  </div>
                </div>
              </div>';
			}

        return $data;}

        return $suggessions;

    }


    public function getSentRequests(Request $request)
    {   
        $requesterId = Auth::user()->id;
        $data = '';
        $friends=friendship::get();
        $sentRequests=$friends->where('requester_id',$requesterId)->where('status',0)->pluck('user_requested');
        $sentRequests=User::whereIn('id',$sentRequests)->paginate(10);
        

            if ($request->ajax()) {

                foreach ($sentRequests as $sentRequest) {
                    $data.='<div class="my-2 shadow text-white bg-dark p-1" id="">
                    <div class="d-flex justify-content-between">
                      <table class="ms-1">
                        <td class="align-middle">'.$sentRequest->name.'</td>
                        <td class="align-middle"> - </td>
                        <td class="align-middle">'.$sentRequest->email.'</td>
                        <td class="align-middle">
                      </table>
                      <div>
                        <input type="text" value="'.$sentRequest->id.'" hidden name="user_withdraw" id="user_withdraw">
                          <button id="cancel_request_btn_" class="btn btn-danger me-1"
                            onclick="deleteRequest('.Auth::user()->id.', '.$sentRequest->id.')">Withdraw Request</button>
                        
                      </div>
                    </div>
                  </div>';
                }
    
            return $data;}
            
            return $sentRequests;
    }


    public function getRecievedRequests(Request $request)
    {    $data = '';
        $requesterId = Auth::user()->id;
        $friends=friendship::get();
        $recievedRequests=$friends->where('user_requested',$requesterId)->where('status',0)->pluck('requester_id');
        $recievedRequests=User::whereIn('id',$recievedRequests)->paginate(10);

        if ($request->ajax()) {
        
            foreach ($recievedRequests as $recievedRequest) {
                $data.='<div class="my-2 shadow text-white bg-dark p-1" id="">
                <div class="d-flex justify-content-between">
                  <table class="ms-1">
                    <td class="align-middle">'.$recievedRequest->name.'</td>
                    <td class="align-middle"> - </td>
                    <td class="align-middle">'.$recievedRequest->email.'</td>
                    <td class="align-middle">
                  </table>
                  <div>
                    <input type="text" value="'.$recievedRequest->id.'" hidden name="user_withdraw" id="user_withdraw">
                   
                      <button id="accept_request_btn_" class="btn btn-primary me-1"
                        onclick="acceptRequest('.Auth::user()->id.', '.$recievedRequest->id.')">Accept</button>
                    
                  </div>
                </div>
              </div>';
            }

        return $data;}

            return $recievedRequests;
    }


    public function getConnections(Request $request)
    {   
        $requesterId = Auth::user()->id;
        $data = '';
        $connects=friendship::where('status',1)->where(function($query) {$query->where('requester_id',Auth::user()->id)->orWhere('user_requested',Auth::user()->id);})->pluck('user_requested');
        $connections=User::whereIn('id',$connects)->paginate(10);
        $count= $connections->count();

        if ($request->ajax()) {

            foreach ($connections as $connection) {
                
              
                $data.='<div class="my-2 shadow text-white bg-dark p-1" id="">
                <div class="d-flex justify-content-between">
                  <table class="ms-1">
                    <td class="align-middle">'.$connection->name .'</td>
                    <td class="align-middle"> - </td>
                    <td class="align-middle">'. $connection->email.'</td>
                    <td class="align-middle">
                  </table>
                  <div><button style="width: 220px" id="get_connections_in_common_" class="btn btn-primary" type="button" onclick="getConnectionsInCommon('.Auth::user()->id.', '.$connection->id.')" 
                      data-bs-toggle="collapse" data-bs-target="#collapse_" aria-expanded="false" aria-controls="collapseExample">
                      Connections in common ()
                    </button>
                    <input type="text" value='.$connection->id.' hidden name="unfriend" id="unfriend">
                    <button id="remove_friend_btn_" class="btn btn-danger me-1" onclick="removeConnection('.Auth::user()->id.', '.$connection->id.')">Remove Connection</button>
                  </div>
              
                </div>
                <div class="collapse" id="collapse_">
              
                  <div id="content_" class="p-2">
                    {{-- Display data here --}}
                    <x-connection_in_common />
                  </div>
                  <div id="connections_in_common_skeletons_">
                    {{-- Paste the loading skeletons here via Jquery before the ajax to get the connections in common --}}
                  </div>
                  <div class="d-flex justify-content-center w-100 py-2">
                    <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_" onclick="getMoreConnectionsInCommon('.Auth::user()->id.', '.$connection->id.')">Load
                      more</button>
                  </div>
                </div>
              </div>';
            }
            $response = array(
                "data" => $data,
                "count"=>$count,
            
            );
            return $response;}

            return $connections;
    }

    public function getCommonConnections(Request $request) {
     
         $connects=friendship::where('status',1)->where(function($query) {$query->where('requester_id',Auth::user()->id)->orWhere('user_requested',Auth::user()->id);})->pluck('user_requested','requester_id');
         $hisConnects=friendship::where('status',1)->where('requester_id', 1)->pluck('user_requested','requester_id');
         $hisConnects1=friendship::where('status',1)->where('user_requested', 1)->pluck('user_requested','requester_id');
         $merged = $hisConnects->merge($hisConnects1);
         dd($hisConnects1);
         return $hisConnects1;
    }
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
