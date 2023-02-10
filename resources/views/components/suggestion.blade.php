@props(['suggession'])
@php 


@endphp
<div class="my-2 shadow  text-white bg-dark p-1" id="" >
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{ $suggession->name }}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{ $suggession->email }}</td>
      <td class="align-middle"> 
    </table>
    <div>
      <input type="text" value="{{ $suggession->id }}" hidden name="user_requested" id="user_requested">
      <button id="create_request_btn_" class="btn btn-primary me-1" onclick="sendRequest(userId, suggestionId)" >Connect</button>
    </div>
  </div>
</div>
