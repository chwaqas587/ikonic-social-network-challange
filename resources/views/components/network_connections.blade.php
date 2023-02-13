@props(['suggessions','sentRequests','recievedRequests','connections','connects','suggessionsCount']);

<div class="row justify-content-center mt-5">
  <div class="col-12">
    <div class="card shadow  text-white bg-dark">
      <div class="card-header">Coding Challenge - Network connections</div>
      <div class="card-body">
        <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="btnradio" data-toggle="collapse" id="btnradio1" autocomplete="off"  onclick="getSuggestions()" checked>
          <label class="btn btn-outline-primary" for="btnradio1" id="get_suggestions_btn" >Suggestions ({{ $suggessionsCount }})</label>

          <input type="radio" class="btn-check" name="btnradio" data-toggle="collapse" id="btnradio2" autocomplete="off" onclick="getRequests('sent')">
          <label class="btn btn-outline-primary" for="btnradio2" id="get_sent_requests_btn">Sent Requests ({{ $sentRequests->count() }})</label>

          <input type="radio" class="btn-check" name="btnradio" data-toggle="collapse" id="btnradio3"  autocomplete="off" onclick="getRequests('recieved')">
          <label class="btn btn-outline-primary" for="btnradio3" id="get_received_requests_btn">Received
            Requests({{ $recievedRequests->count() }})</label>

          <input type="radio" class="btn-check" name="btnradio" data-toggle="collapse"  id="btnradio4"  autocomplete="off" onclick="getConnections()">
          <label class="btn btn-outline-primary" for="btnradio4" id="get_connections_btn">Connections ({{ $connections->count()-1 }})</label>
        </div>
        <hr>
        <div id="content" class="d-none">
        </div>
      <div id="sent_requests" class="collapse" >
        <div class="content" ></div>
        <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
          <button class="btn btn-primary" onclick="getMoreRequests('sent') " id="load_more_btn">Load more</button>
        </div>
      </div>
      <div  id="connections" class="collapse" >
        <div class="content" ></div>
        <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
          <button class="btn btn-primary" onclick="getMoreConnections() " id="load_more_btn">Load more</button>
        </div>
        </div>
      <div  id="recieved_requests" class="collapse" >
        <div class="content" ></div>
        
        <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
          <button class="btn btn-primary" onclick="getMoreRequests('recieved') " id="load_more_btn">Load more</button>
        </div>
      </div>
      <div  id="suggessions" class="collapse" >
        <div class="content" ></div>
        <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
          <div id="connections_in_common_skeleton" class=" d-none">
            <br>
            
            <div class="px-2">
              <div class="d-flex align-items-center  mb-2  text-white bg-dark p-1 shadow" style="height: 45px">
                <strong class="ms-1 text-primary">Loading...</strong>
                <div class="spinner-border ms-auto text-primary me-4" role="status" aria-hidden="true">

                </div>
              </div>
            </div>
          </div>
        <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
          <button class="btn btn-primary" onclick="getMoreSuggestions() " id="load_more_btn">Load more</button>
        </div>
      </div>
        </div>  
      </div>


        {{-- Remove this when you start working, just to show you the different components --}}

       
        
      </div>
    </div>
  </div>
</div>

{{-- Remove this when you start working, just to show you the different components --}}


