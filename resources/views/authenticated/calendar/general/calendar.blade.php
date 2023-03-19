@extends('layouts.sidebar')
<!-- スクール予約のビュー -->
@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
  <!-- ↑backgroundはカレンダー自体の背景 -->
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
<!-- ここにキャンセル時の非同期を表示させる -->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('deleteParts') }}" method="post">
      <div class="w-100">
        <div class="modal-inner-reserve w-50 m-auto">
          <p name="setting_reserve" class="m-auto p-0 w-75"></p>
          <input type="hidden" class="cancel-reserve-hidden" name="cancel_reserve">
        </div>
        <div class="modal-inner-part w-50 m-auto pt-3 pb-3">
          <p name="setting_part" class="m-auto p-0 w-75"></p>
          <input type="hidden" class="cancel-part-hidden" name="cancel_part">
        </div>
        <div class="w-50 m-auto pb-3">
          <p class="m-auto p-0 w-75">上記の予約をキャンセルしてもよろしいですか？</p>
        </div>
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>
          <input type="submit" class="btn btn-primary d-block" onclick="return confirm('予約をキャンセルします。よろしいでしょうか？')" value="キャンセル">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>
@endsection
