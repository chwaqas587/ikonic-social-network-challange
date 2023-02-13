var skeletonId = 'skeleton';
var contentId = 'content';
var skipCounter = 0;
var takeAmount = 10;
var page = 2;


function getRequests(mode) {

  if(mode=='sent'){
  var url=site_url +'/get-sent-requests';}
  if(mode=='recieved'){
    var url=site_url +'/get-recieved-request';}

    $.ajax({
      url: url,
      type: 'get',
      dataType: 'json',
      beforeSend: function()
      {
        $('.d-none ').show();
      }
    })
      .done( function(data) {

        $('#suggessions').hide();
        $('#connections').hide();
        $('.d-none ').hide();
        if(mode=='sent'){
          
          $('#sent_requests').show();
          $('#recieved_requests').hide();
          if(data.sentRequest.data<10){
            $('#sent_requests #load_more_btn').hide();
          }
          $.each(data.sentRequest.data, function (key, value) {
            
          $('#sent_requests .content').append('<div class="my-2 shadow text-white bg-dark p-1" id="">\
                    <div class="d-flex justify-content-between">\
                      <table class="ms-1">\
                        <td class="align-middle">'+value.name+'</td>\
                        <td class="align-middle"> - </td>\
                        <td class="align-middle">'+value.email+'</td>\
                        <td class="align-middle">\
                      </table>\
                      <div>\
                        <input type="text" value="'+value.id+'" hidden name="user_withdraw" id="user_withdraw">\
                          <button id="cancel_request_btn_" class="btn btn-danger me-1" onclick="deleteRequest('+value.id+')">Withdraw Request</button>\
                     </div>\
                    </div>\
                  </div>\
                  ');});
        }

        if(mode=='recieved'){
          
          $('#recieved_requests').show();
        $('#sent_requests').hide();
        if(data.recRequest.data<10){
          $('#recieved_requests #load_more_btn').hide();
        }
        $.each(data.recRequest.data, function (key, recRequest) {
          $('#recieved_requests .content').append('<div class="my-2 shadow text-white bg-dark p-1" id="">\
                    <div class="d-flex justify-content-between">\
                      <table class="ms-1">\
                        <td class="align-middle">'+recRequest.name+'</td>\
                        <td class="align-middle"> - </td>\
                        <td class="align-middle">'+recRequest.email+'</td>\
                        <td class="align-middle">\
                      </table>\
                      <div>\
                        <button id="accept_request_btn_" class="btn btn-primary me-1" onclick="acceptRequest('+recRequest.id+')">Accept</button>\
                     </div>\
                    </div>\
                  </div>\
                  ');});
      }
        
        
        
         
      })
}
 
function getMoreRequests(mode) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
  if(mode=='sent'){
    var url=site_url +'/get-sent-requests?page='+page;}
    if(mode=='recieved'){
      var url=site_url +'/get-recieved-request?page='+page;}

      $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        beforeSend: function()
        {
          $('.d-none ').show();
        }
      })
        .done( function(data) {
       
          $('#suggessions').hide();
          $('#connections').hide();
          $('.d-none ').hide();
          if(mode=='sent'){
          $('#sent_requests').show();
          $('#recieved_requests').hide();
          console.log(data);
          $.each(data.sentRequest.data, function (key, value) {
            
          $('#sent_requests .content').append('<div class="my-2 shadow text-white bg-dark p-1" id="">\
                    <div class="d-flex justify-content-between">\
                      <table class="ms-1">\
                        <td class="align-middle">'+value.name+'</td>\
                        <td class="align-middle"> - </td>\
                        <td class="align-middle">'+value.email+'</td>\
                        <td class="align-middle">\
                      </table>\
                      <div>\
                        <input type="text" value="'+value.id+'" hidden name="user_withdraw" id="user_withdraw">\
                          <button id="cancel_request_btn_" class="btn btn-danger me-1" onclick="deleteRequest('+value.id+')">Withdraw Request</button>\
                     </div>\
                    </div>\
                  </div>\
                  ');});
                  if(data.sentRequest.data<10){
                    $('#sent_requests #load_more_btn').hide();
                  }
          }
  
          if(mode=='recieved'){
            $('#recieved_requests').show();
            $('#sent_requests').hide();
            
            $.each(data.recRequest.data, function (key, recRequest) {
              console.log(value);
              $('#recieved_requests .content').append('<div class="my-2 shadow text-white bg-dark p-1" id="">\
                        <div class="d-flex justify-content-between">\
                          <table class="ms-1">\
                            <td class="align-middle">'+recRequest.name+'</td>\
                            <td class="align-middle"> - </td>\
                            <td class="align-middle">'+recRequest.email+'</td>\
                            <td class="align-middle">\
                          </table>\
                          <div>\
                            <button id="accept_request_btn_" class="btn btn-primary me-1" onclick="acceptRequest('+recRequest.id+')">Accept</button>\
                         </div>\
                        </div>\
                      </div>\
                      ');});
                      if(data.recRequest.data<10){
                        $('#recieved_requests #load_more_btn').hide();
                      }
        }
          
          
          
           
        });
      page++;
}

function getConnections() {
  // your code here...
  var url=site_url +'/get-connections';

$.ajax({
  url: url,
  type: 'get',
  dataType: 'json',
  beforeSend: function()
  {
    $('.d-none ').show();
  }
})
  .done( function(data) {
    console.log(data);
    $.each(data.connections.data, function (key, value) {
      $('#connections .content').append('<div class="my-2 shadow text-white bg-dark p-1" id="">\
      <div class="d-flex justify-content-between">\
        <table class="ms-1">\
          <td class="align-middle">'+value.name+'</td>\
          <td class="align-middle"> - </td>\
          <td class="align-middle">'+value.email+'</td>\
          <td class="align-middle">\
        </table>\
        <div><button style="width: 220px" id="get_connections_in_common_" class="btn btn-primary" type="button" onclick="getConnectionsInCommon('+value.id+')" \
            data-bs-toggle="collapse" data-bs-target="#collapse_" aria-expanded="false" aria-controls="collapseExample">\
            Connections in common ('+data.connections.data.length+')\
          </button>\
          <input type="text" value='+value.id+' hidden name="unfriend" id="unfriend">\
          <button id="remove_friend_btn_" class="btn btn-danger me-1" onclick="removeConnection('+value.id+')">Remove Connection</button>\
        </div>\
      </div>\
      <div class="collapse" id="collapse_">\
        <div id="content_" class="p-2">\
       </div>\
       <div class="d-flex justify-content-center w-100 py-2">\
          <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_" onclick="getMoreConnectionsInCommon('+value.id+')">Load\
            more</button>\
        </div>\
      </div>\
    </div>');
    });
    $('#suggessions').hide();
    $('#connections').show();
    $('.d-none ').hide();

    $('#recieved_requests').hide();
    $('#sent_requests').hide();
    $('#get_connections_btn').html('Connection('+data.count+')');
    if(data.connections.data<10){
      $('#connections #load_more_btn').hide();
    }
    
     
  });
}

function getMoreConnections() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
  var url=site_url +'/get-connections?page='+page;

  $.ajax({
    url: url,
    type: 'get',
    dataType: 'json',
    beforeSend: function()
    {
      $('.d-none ').show();
    }
  })
    .done( function(data) {
      console.log(data.count);
      $.each(data.connections.data, function (key, value) {
        $('#connections .content').append('<div class="my-2 shadow text-white bg-dark p-1" id="">\
        <div class="d-flex justify-content-between">\
          <table class="ms-1">\
            <td class="align-middle">'+value.name+'</td>\
            <td class="align-middle"> - </td>\
            <td class="align-middle">'+value.email+'</td>\
            <td class="align-middle">\
          </table>\
          <div><button style="width: 220px" id="get_connections_in_common_" class="btn btn-primary" type="button" onclick="getConnectionsInCommon('+value.id+')" \
              data-bs-toggle="collapse" data-bs-target="#collapse_" aria-expanded="false" aria-controls="collapseExample">\
              Connections in common ('+data.connections.data.length+')\
            </button>\
            <input type="text" value='+value.id+' hidden name="unfriend" id="unfriend">\
            <button id="remove_friend_btn_" class="btn btn-danger me-1" onclick="removeConnection('+value.id+')">Remove Connection</button>\
          </div>\
        </div>\
        <div class="collapse" id="collapse_">\
          <div id="content_" class="p-2">\
          </div>\
          <div class="d-flex justify-content-center w-100 py-2">\
            <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_" onclick="getMoreConnectionsInCommon('+value.id+')">Load\
              more</button>\
          </div>\
        </div>\
      </div>');
      });
      $('#suggessions').hide();
      $('#connections').show();
      $('.d-none ').hide();
  
      $('#recieved_requests').hide();
      $('#sent_requests').hide();
      $('#get_connections_btn').html('Connection('+data.count+')');
      if(data.connections.data<10){
        $('#connections #load_more_btn').hide();
      }
      
       
    });
      page++;
}

function getConnectionsInCommon( connectionId) {
 
  var url=site_url +'/get-common-connections';
 
  $.ajax({
          url: url,
          type: 'get',
          data: {
            id: connectionId,
        },
          dataType: 'JSON',
          success: function(data) {
            $.each(data.Commonconnections.data, function (key, value) {
            $("#content_").append('<div class="p-2 shadow rounded mt-2  text-white bg-dark">'+value.name+' - '+value.email+'</div>');
              console.log(data.Commonconnections.data);
             
            });
          }});
}

function getMoreConnectionsInCommon( connectionId) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...

  var url=site_url +'/get-common-connections?page='+page;
 
  $.ajax({
          url: url,
          type: 'get',
          data: {
            id: connectionId,
        },
          dataType: 'JSON',
          success: function(data) {
            alert('hello');
            $.each(data.Commonconnections.data, function (key, value) {
            $("#content_").append('<div class="p-2 shadow rounded mt-2  text-white bg-dark">'+value.name+' - '+value.email+'</div>');
              console.log(data.Commonconnections.data);
              $("#load_more_connections_in_common_").hide();
            });
          }});
}

function getSuggestions() {
  // your code here...
  
  var url=site_url +'/get-suggessions';

  $.ajax({
          url: url,
          type: 'get',
          dataType: 'json',
          beforeSend: function()
          {
            $('.d-none ').show();
          }
        })
          .done( function(data) {
            console.log(data.suggessions.data);

            $.each(data.suggessions.data, function (key, value) {
              $('#suggessions .content').append('<div class="my-2 shadow  text-white bg-dark p-1" id="" >\
                        <div class="d-flex justify-content-between">\
                          <table class="ms-1">\
                            <td class="align-middle">'+value.name+'</td>\
                            <td class="align-middle"> - </td>\
                            <td class="align-middle">'+value.email+'</td>\
                            <td class="align-middle"> \
                          </table>\
                          <div>\
                            <input type="text" value="'+value.id+'" hidden name="user_requested" id="user_requested">\
                            <button id="create_request_btn_" class="btn btn-primary me-1" onclick="sendRequest('+value.id+')" >Connect</button>\
                          </div>\
                        </div>\
                      </div>');});
       
            $('.d-none ').hide();
            $('#suggessions').show();
            $('#sent_requests').show();
            $('#get_suggessions_btn').html('');
            $('#get_suggessions_btn').html('Suggessions('+data.count+')');
            $('#sent_requests').hide();
            $('#recieved_requests').hide();
            $('#connections').hide();
            if(data.suggessions.data<10){
              $('#suggessions #load_more_btn').hide();
            }
            
             
          });
      
      
  

}

document.addEventListener("load", getSuggestions());

function getMoreSuggestions() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...

  var url=site_url +'/get-suggessions?page='+page;

  $.ajax({
    url: url,
    type: 'get',
    dataType: 'json',
    beforeSend: function()
    {
      $('.d-none ').show();
    }
  })
    .done( function(data) {
      console.log(data.suggessions.data);

      $.each(data.suggessions.data, function (key, value) {
        $('#suggessions .content').append('<div class="my-2 shadow  text-white bg-dark p-1" id="" >\
                  <div class="d-flex justify-content-between">\
                    <table class="ms-1">\
                      <td class="align-middle">'+value.name+'</td>\
                      <td class="align-middle"> - </td>\
                      <td class="align-middle">'+value.email+'</td>\
                      <td class="align-middle"> \
                    </table>\
                    <div>\
                      <input type="text" value="'+value.id+'" hidden name="user_requested" id="user_requested">\
                      <button id="create_request_btn_" class="btn btn-primary me-1" onclick="sendRequest('+value.id+')" >Connect</button>\
                    </div>\
                  </div>\
                </div>');});
 
      $('.d-none ').hide();
      $('#suggessions').show();
      $('#sent_requests').show();
      $('#get_suggessions_btn').html('Suggessions(<span id="count">'+data.count+'</span>');
      $('#sent_requests').hide();
      $('#recieved_requests').hide();
      $('#connections').hide();
      if(data.suggessions.data<10){
        $('#suggessions #load_more_btn').hide();
      }
    
      
       
    });
      page++;
}

function sendRequest( suggestionId) {
  // your code here...
  var url=site_url +'/send-request';


        $.ajax({
          url: url,
          type: 'get',
          data: {
            id: suggestionId,
        },
          dataType: 'html',
          beforeSend: function()
          {
            $('.d-none ').show();
          }
        })
          .done( function(data) {
       
            $('.d-none ').hide();
            
            alert('request Sent')
            
             
          });
         
       
        
}

function deleteRequest(requestId) {
  
  var url=site_url +'/delete-request';

  $.ajax({
          url: url,
          type: 'get',
          data: {
              id: requestId,
          },
          dataType: 'JSON',
          success: function(data) {
              alert('request deleted')
          }
      });

}

function acceptRequest( requestId) {
  

  var url=site_url +'/accept-request';

    $.ajax({
            url: url,
            type: 'get',
            data: {
                id: requestId,
            },
            dataType: 'JSON',
            success: function(data) {
               
            }
        });
}

function removeConnection( connectionId) {
  var url=site_url +'/remove-connection';

    $.ajax({
            url: url,
            type: 'get',
            data: {
                id: connectionId,
            },
            dataType: 'JSON',
            success: function(data) {
                alert(data.myid);
            }
        });
}

$(function () {
  //getSuggestions();
});