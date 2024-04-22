@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<!-- モーダル -->
<div id="cancelModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>予約をキャンセルしますか？</p>
    <button id="confirmCancel">キャンセルする</button>
  </div>
</div>

<style>
  .modal { display: none; /* Hidden by default */ position: fixed; /* Stay in place */ z-index: 1; /* Sit on top */ left: 0; top: 0; width: 100%; /* Full width */ height: 100%; /* Full height */ overflow: auto; /* Enable scroll if needed */ background-color: rgb(0,0,0); /* Fallback color */ background-color: rgba(0,0,0,0.4); /* Black w/ opacity */ }
  .modal-content { background-color: #fefefe; margin: 15% auto; /* 15% from the top and centered */ padding: 20px; border: 1px solid #888; width: 80%; /* Could be more or less, depending on screen size */ }
  .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; }
  .close:hover, .close:focus { color: black; text-decoration: none; cursor: pointer; }
</style>
@endsection
