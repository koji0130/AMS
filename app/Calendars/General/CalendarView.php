<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

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
    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';
      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          //過去日の背景をグレーにするため、過去日のみにpast-dayクラスを設ける
          $html[] = '<td class="calendar-td '.$day->pastClassName().'">';
        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        $html[] = $day->render();

        if(in_array($day->everyDay(), $day->authReserveDay())){//ログインユーザーが予約していた場合
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){//過去日だった場合
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px;font-weight:bold;">'. $reservePart . '参加'.'</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{
            $html[] = '<button type="submit" class="btn btn-danger p-0 w-75 js-modal-open" name="delete_date" style="font-size:12px" reserve_day= "'.$day->authReserveDate($day->everyDay())->first()->setting_reserve .'" reserve_part="'.$reservePart.'" reserve_part_number="'.$day->authReserveDate($day->everyDay())->first()->setting_part.'" value="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'">'. $reservePart .'</button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }
        }else{
          //過去の日付に「受付終了」と表示させる。
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
          }else{
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
    //初日
    $firstDay = $this->carbon->copy()->firstOfMonth();
    //月末まで
    $lastDay = $this->carbon->copy()->lastOfMonth();
    //1週目
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    //作業用の日
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    //月末までループさせる
    while($tmpDay->lte($lastDay)){
      //週カレンダーViewを作成する
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      //次の週=+7日する
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
