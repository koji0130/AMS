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
<div class="modal js-modal reserve-modal">
  <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
      <p>予約日時：<span class="modal-reserve-day">
        <span class="modal-reserve-day-display"></span>
        <input type="hidden" name="reserve_day" value="" form="deleteParts">
      </span></p>
      <p>時間：<span class="modal-reserve-part">
        <span class="modal-reserve-part-display"></span>
        <input type="hidden" name="reserve_part" value="" form="deleteParts">
      </span></p>
      <p>上記の予約をキャンセルしてもよろしいですか？</p>
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn btn-primary d-block" href="">閉じる</a>
          <input type="hidden" class="reserve-part-number" name="reserve_part_number" value="" form="deleteParts">
          <input type="submit" class="btn btn-danger d-inline-block" value="キャンセル" form="deleteParts">
        </div>
    </div>
</div>

@endsection
