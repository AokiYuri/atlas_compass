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
        <p>予約をキャンセルしますか？</p>
        <p>日付: <span class="modal-reserve-date"></span></p>
        <p>時間: <span class="modal-reserve-part"></span></p>
        <form action="{{ route('deleteParts') }}" method="post">
            @csrf
            <input type="hidden" name="reserve_id" id="modalReserveId">
            <button type="button" class="btn btn-close">閉じる</button>
            <button type="submit" class="btn btn-danger">キャンセルする</button>
        </form>
    </div>
</div>

<style>
  .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4); }
  .modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; }
  .btn-close { background-color: #007bff; color: white; border-color: #007bff; }
  .btn-close:hover { background-color: #007bff; color: white; border-color: #007bff; } /* ホバー時もスタイルが変わらないようにする */
</style>
@endsection
