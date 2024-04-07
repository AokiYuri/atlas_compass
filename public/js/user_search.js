$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
    // 矢印のクラスを切り替える
    $(this).find('.arrow').toggleClass('up down');

    // 矢印の表示を切り替える（オプショナル）
    if ($(this).find('.arrow').hasClass('up')) {
      $(this).find('.arrow').html('&#x25B2;'); // 上向き矢印に変更
    } else {
      $(this).find('.arrow').html('&#x25BC;'); // 下向き矢印に戻す
    }
  });

  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
  });
});
