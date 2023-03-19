<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;
// スクール予約はここを参照している
class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks(); // getWeeksメソッドは下にあります
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){ // 今日より前の場合
          $html[] = '<td class="past-day calendar-td">';
        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">'; // 日付が書かれていないグレーな部分
        }
        $html[] = $day->render();

        if(in_array($day->everyDay(), $day->authReserveDay())){ // 予約している場合
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部"; // これから参加する箇所の表示
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }
          if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){ // 過去日
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">'.$reservePart.'</p>'; // 参加した部を表示したい
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{ // 参加する部を表示させる、キャンセルへ遷移
            $html[] =
            '<button type="submit"
            class="cancel-modal-open btn btn-danger p-0 w-75"
            name="delete_date" style="font-size:12px"
            cancel_reserve_view="予約日：'.$day->authReserveDate($day->everyDay())->first()->setting_reserve.'"
            cancel_reserve='.$day->authReserveDate($day->everyDay())->first()->setting_reserve.'
            cancel_part_view="時間：リモ'.$day->authReserveDate($day->everyDay())->first()->setting_part.'部"
            cancel_part='.$day->authReserveDate($day->everyDay())->first()->setting_part.'>
            '.$reservePart.'
            </button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
            // ↑ここをdeletePartsに変えると予約がされなくなった
          }
        }else{ // 予約していない
          if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){ // 過去日
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{ // 明日以降はプルダウンを表示させる
            $html[] = $day->selectPart($day->everyDay());
          }
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
