$(function () {

});

document.addEventListener('DOMContentLoaded', function () {
  var modal = document.getElementById("cancelModal");
  var btns = document.querySelectorAll('.cancel-modal-open');
  var span = document.getElementsByClassName("close")[0];
  var confirmBtn = document.getElementById("confirmCancel");

  btns.forEach(function (btn) {
    btn.onclick = function () {
      modal.style.display = "block";
      var reserveId = this.getAttribute('data-reserve-id'); // データ属性から予約IDを取得
      confirmBtn.onclick = function () { // 確認ボタンをクリックしたときの処理
        console.log('キャンセル処理: ', reserveId); // 実際のキャンセル処理をここに実装
        modal.style.display = "none";
      }
    }
  });

  span.onclick = function () {
    modal.style.display = "none";
  }

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
});
