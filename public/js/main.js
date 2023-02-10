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
      dataType: 'html',
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
          $('#sent_requests .content').html(data);
        }

        if(mode=='recieved'){
          $('#recieved_requests').show();
        $('#sent_requests').hide();
        $('#recieved_requests .content').html(data);
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
        dataType: 'html',
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
            if(data===''){
              $('#sent_requests .justify-content-center .btn').hide();
            }
            $('#recieved_requests').hide();
            $('#sent_requests .content').append(data);
          }
  
          if(mode=='recieved'){
            $('#recieved_requests').show();
            if(data===''){
              $('#recieved_requests .justify-content-center .btn').hide();
            }
          $('#sent_requests').hide();
          $('#recieved_requests  .content').append(data);
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
    
    $('#suggessions').hide();
    $('#connections').show();
    $('.d-none ').hide();
    $('#recieved_requests').hide();
    $('#sent_requests').hide();
    $('#get_connections_btn').html('Connection('+data.count+'');
    $('#connections .content').append(data.data);
    
    
     
  })
}

function getMoreConnections() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
  var url=site_url +'/get-connections?page='+page;

  $.ajax({
          url: url,
          type: 'get',
          
          dataType: 'JSON',
          beforeSend: function()
          {
            $('#connections_in_common_skeleton').show();
          }
        }) .done( function(data) {
       
          $('#recieved_requests').hide();
          $('#sent_requests').hide();
          $('#suggessions').hide();
          $('#connections').show();
          if(data.data===''){
            $('#connections .justify-content-center .btn').hide();
          }
          
          $('#get_connections_btn').html('Connection('+data.count+'');
          $('#connections .content').append(data.data);
          
          
           
        })
      page++;
}

function getConnectionsInCommon(userId, connectionId) {
 
  var url=site_url +'/get-common-connections';
  alert(url)
  $.ajax({
          url: url,
          type: 'get',
          data: {
            id: connectionId,
        },
          dataType: 'JSON',
          success: function(data) {
              alert(data);
          }
      });
}

function getMoreConnectionsInCommon(userId, connectionId) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getSuggestions() {
  // your code here...
  
  var url=site_url +'/get-suggessions';

  $.ajax({
          url: url,
          type: 'get',
          dataType: 'html',
          beforeSend: function()
          {
            $('.d-none ').show();
          }
        })
          .done( function(data) {
       
            $('.d-none ').hide();
            $('#suggessions').show();
            $('#sent_requests').show();
      
            $('#sent_requests').hide();
            $('#recieved_requests').hide();
            $('#connections').hide();
            $('#suggessions .content').append(data);
            
             
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
          
          dataType: 'html',
          beforeSend: function()
          {
            $('.d-none ').show();
          }
        }) .done( function(data) {
     
          $('.d-none ').hide();
            $('#suggessions').show();
            $('#sent_requests').show();
      
            $('#sent_requests').hide();
            $('#recieved_requests').hide();
            $('#connections').hide();
            $('#suggessions .content').append(data);
          
          
           
        })
      page++;
}

function sendRequest(userId, suggestionId) {
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

function deleteRequest(userId, requestId) {
  
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

function acceptRequest(userId, requestId) {
  

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

function removeConnection(userId, connectionId) {
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