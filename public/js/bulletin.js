$(function () {
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });

  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).addClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {

    });
  });

  $('.edit-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    var post_title = $(this).attr('post_title');
    var post_body = $(this).attr('post_body');
    var post_id = $(this).attr('post_id');
    $('.modal-inner-title input').val(post_title);
    $('.modal-inner-body textarea').text(post_body);
    $('.edit-modal-hidden').val(post_id);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });

});

$(function () {
  $('.category-header').click(function () {
    const subCategories = $(this).next('.sub-categories');
    if (!subCategories.is(':visible')) {
      // すでに表示されていない場合にのみ、`active` クラスを追加
      $(this).addClass('active');
    }
    // サブカテゴリーの表示を切り替え
    subCategories.slideToggle(400, function () {
      // スライドトグル完了後のコールバックで、閉じたかどうかを判断
      if (!$(this).is(':visible')) {
        // 閉じられていれば、`active` クラスを削除
        $(this).prev('.category-header').removeClass('active');
      }
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

});
