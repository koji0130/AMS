$(function () {
  // 編集ボタン(class="js-modal-open")が押されたら発火
  $('.js-modal-open').on('click', function () {
    // モーダルの中身(class="js-modal")の表示
    $('.js-modal').fadeIn();
    // 押されたボタンから予約日を取得し変数へ格納
    var reserve_day = $(this).attr('reserve_day');
    // 押されたボタンから予約した時間を取得し変数へ格納
    var reserve_part = $(this).attr('reserve_part');
    // 取得した予約IDを取得し変数へ格納
    var reserve_id = $(this).attr('reserve_id');
    // 取得した予約日をモーダルの中身へ渡す
    $('.modal-reserve-day').text(reserve_day);
    // 取得した予約した時間のidをモーダルの中身へ渡す
    $('.modal-reserve-part').text(reserve_part);
    // 取得した予約IDをモーダルの中身へ渡す
    $('.edit-modal-hidden').val(reserve_id);
    return false;
  });
  // 背景部分や閉じるボタン(js-modal-close)が押されたら発火
  $('.js-modal-close').on('click', function () {
    // モーダルの中身(class="js-modal")を非表示
    $('.js-modal').fadeOut();
    return false;
  });

});
