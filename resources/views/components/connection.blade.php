@props(['connection','connects'])

<div class="my-2 shadow text-white bg-dark p-1" id="">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{ $connection->name }}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{ $connection->email }}</td>
      <td class="align-middle">
    </table>
    <div>
      @php
      $id=$connection->id;
    
      $mutualConnects=App\Models\friendship::where('status',1)->get();

      
      $mutualConnects=App\Models\friendship::where('status',1)->where(function($query) use ($id) {$query->where('requester_id',$id)->orWhere('user_requested',$id);})->where(function($query) use ($connects) {$query->whereIn('requester_id',$connects)->orwhereIn('user_requested',$connects);})->get();

      @endphp
      <button style="width: 220px" id="get_connections_in_common_" class="btn btn-primary" type="button" onclick="getConnectionsInCommon(userId, connectionId)" 
        data-bs-toggle="collapse" data-bs-target="#collapse_" aria-expanded="false" aria-controls="collapseExample">
        Connections in common ({{ $mutualConnects->count() }})
      </button>
      <input type="text" value="{{ $connection->id }}" hidden name="unfriend" id="unfriend">
      <button id="remove_friend_btn_" class="btn btn-danger me-1" onclick="removeConnection(userId, connectionId)">Remove Connection</button>
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
      <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_" onclick="getMoreConnectionsInCommon(userId, connectionId)">Load
        more</button>
    </div>
  </div>
</div>
