$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle(function () {
      // 完了後に実行されるコールバックで、表示状態に応じてクラスをトグル
      $('.search_conditions > p').toggleClass('active', $(this).is(':visible'));
    });

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
    // この部分で内容の表示/非表示を切り替え
    $(this).next('.subject_inner').slideToggle();

    // 矢印のクラスを切り替え、HTMLを更新
    $(this).find('.arrow').toggleClass('up');
    if ($(this).find('.arrow').hasClass('up')) {
      $(this).find('.arrow').html('&#x25B2;'); // 上向き矢印に変更
    } else {
      $(this).find('.arrow').html('&#x25BC;'); // 下向き矢印に戻す
    }
  });
});
