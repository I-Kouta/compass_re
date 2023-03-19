$(function () {
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id'); // category_id="{{ $category->id }}"を変数に代入
    $('.slide_num' + category_id).toggleClass('active'); // 反転する矢印について
    $('.category_num' + category_id).slideToggle(); // サブカテゴリの該当するcategory_idを'category_num'クラスに付与
  });

  $(document).on('click', '.like_btn', function (e) { // thisは'like_btn'のこと
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id'); // post_id="{{ $post->id }}"を変数に代入している,投稿の特定
    var count = $('.like_counts' + post_id).text(); // 該当する投稿(post_idで特定)のいいね数をtextで取得
    var countInt = Number(count); // count変数を数値に変換

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

  $('.edit-modal-open').on('click',function(){
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

  $('.cancel-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    //表示させる値は文字を結合すること
    var setting_reserve_view = $(this).attr('cancel_reserve_view');
    var setting_reserve = $(this).attr('cancel_reserve');
    var setting_part_view = $(this).attr('cancel_part_view');
    var setting_part = $(this).attr('cancel_part');
    $('.modal-inner-reserve p').text(setting_reserve_view);
    $('.cancel-reserve-hidden').val(setting_reserve);
    $('.modal-inner-part p').text(setting_part_view);
    $('.cancel-part-hidden').val(setting_part);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });

});
