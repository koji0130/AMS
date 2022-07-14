$(function () {
  // 編集ボタン(class="js-modal-open")が押されたら発火
  $('.js-modal-open').on('click', function () {
    // モーダルの中身(class="js-modal")の表示
    $('.js-modal').fadeIn();
    // 押されたボタンから予約日を取得し変数へ格納
    var reserve_day = $(this).attr('reserve_day');
    var reserve_day_display = $(this).attr('reserve_day');
    // 押されたボタンから予約した時間を取得し変数へ格納
    var reserve_part = $(this).attr('reserve_part');
    var reserve_part_display = $(this).attr('reserve_part');
    var reserve_part_number = $(this).attr('reserve_part_number');
    // 取得した予約日をモーダルの中身へ渡す
    $('.modal-reserve-day input').val(reserve_day);
    $('.modal-reserve-day-display').text(reserve_day);
    // 取得した予約した部をモーダルの中身へ渡す
    $('.modal-reserve-part input').val(reserve_part);
    $('.modal-reserve-part-display').text(reserve_part);
    $('.reserve-part-number').val(reserve_part_number);
    return false;
  });
  // 背景部分や閉じるボタン(js-modal-close)が押されたら発火
  $('.js-modal-close').on('click', function () {
    // モーダルの中身(class="js-modal")を非表示
    $('.js-modal').fadeOut();
    return false;
  });

});
