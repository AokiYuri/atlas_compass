$(function () {

});

document.addEventListener('DOMContentLoaded', function () {
  var modal = document.getElementById('cancelModal');
  var btns = document.querySelectorAll('.cancel-modal-open');
  var closeBtn = document.querySelector('.close');

  btns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var reserveId = this.getAttribute('data-reserve-id');
      var reserveDate = this.getAttribute('data-reserve-date');
      var reservePart = this.getAttribute('data-reserve-part');

      document.getElementById('modalReserveId').value = reserveId;
      document.querySelector('#cancelModal .modal-reserve-date').textContent = reserveDate;
      document.querySelector('#cancelModal .modal-reserve-part').textContent = reservePart;

      modal.style.display = 'block';
    });
  });

  closeBtn.onclick = function () {
    modal.style.display = 'none';
  }

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  }
});
