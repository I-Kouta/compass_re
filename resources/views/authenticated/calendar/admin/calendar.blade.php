@extends('layouts.sidebar')
<!-- スクール予約確認のビュー -->
<!-- ここは何故か過去日の色が変わっている -->
@section('content')
<div class="w-75 m-auto">
  <div class="w-100">
    <p>{{ $calendar->getTitle() }}</p>
    <p>{!! $calendar->render() !!}</p>
  </div>
</div>
@endsection
