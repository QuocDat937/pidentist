// Pi Dentist — Booking Form JS
// Client-side validation + AJAX submit. Vanilla JS, no jQuery.

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  var form         = document.getElementById('piBookingForm');
  if (!form) return;

  var fields       = document.getElementById('piFormFields');
  var successBox   = document.getElementById('piFormSuccess');
  var errorBanner  = document.getElementById('piFormErrorBanner');
  var submitBtn    = document.getElementById('piBookingSubmit');

  var inputName    = document.getElementById('pi_fullname');
  var inputPhone   = document.getElementById('pi_phone');
  var inputService = document.getElementById('pi_service');
  var inputNote    = document.getElementById('pi_note');

  var errorName    = document.getElementById('piErrorFullname');
  var errorPhone   = document.getElementById('piErrorPhone');

  var PHONE_REGEX  = /^0[0-9]{9,10}$/;

  /* ── Inline validation on blur ────────────────────── */

  inputName.addEventListener('blur', function () {
    validateName();
  });

  inputPhone.addEventListener('blur', function () {
    validatePhone();
  });

  /* Clear error on input */
  inputName.addEventListener('input', function () {
    if (inputName.value.trim().length >= 2) {
      clearError(inputName, errorName);
    }
  });

  inputPhone.addEventListener('input', function () {
    var clean = inputPhone.value.replace(/[\s\-\.]/g, '');
    if (PHONE_REGEX.test(clean)) {
      clearError(inputPhone, errorPhone);
    }
  });

  /* ── Validators ───────────────────────────────────── */

  function validateName() {
    var val = inputName.value.trim();
    if (val.length < 2) {
      showError(inputName, errorName, 'Vui lòng nhập họ và tên (ít nhất 2 ký tự).');
      return false;
    }
    clearError(inputName, errorName);
    return true;
  }

  function validatePhone() {
    var clean = inputPhone.value.replace(/[\s\-\.]/g, '');
    if (!PHONE_REGEX.test(clean)) {
      showError(inputPhone, errorPhone, 'Số điện thoại không hợp lệ (10–11 chữ số, bắt đầu bằng 0).');
      return false;
    }
    clearError(inputPhone, errorPhone);
    return true;
  }

  function showError(input, errorEl, msg) {
    input.classList.add('pi-input-error');
    errorEl.textContent = msg;
    errorEl.style.display = 'block';
  }

  function clearError(input, errorEl) {
    input.classList.remove('pi-input-error');
    errorEl.textContent = '';
    errorEl.style.display = 'none';
  }

  function clearAllErrors() {
    clearError(inputName, errorName);
    clearError(inputPhone, errorPhone);
    errorBanner.style.display = 'none';
  }

  /* ── Submit handler ───────────────────────────────── */

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    clearAllErrors();

    // Client-side validation.
    var isValid = true;
    if (!validateName()) isValid = false;
    if (!validatePhone()) isValid = false;

    if (!isValid) return;

    // Loading state.
    submitBtn.disabled = true;
    submitBtn.textContent = 'Đang gửi...';
    submitBtn.classList.add('pi-booking-btn--loading');

    // Build FormData.
    var formData = new FormData(form);
    formData.append('action', 'pi_booking_submit');

    // AJAX request.
    var xhr = new XMLHttpRequest();
    xhr.open('POST', piBookingAjax.ajaxurl, true);

    xhr.onload = function () {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Đặt lịch tư vấn miễn phí';
      submitBtn.classList.remove('pi-booking-btn--loading');

      var res;
      try {
        res = JSON.parse(xhr.responseText);
      } catch (err) {
        showBannerError('Có lỗi xảy ra, vui lòng thử lại hoặc gọi trực tiếp ' + piBookingAjax.phone + '.');
        return;
      }

      if (res.success) {
        // Success — hide form, show success message.
        fields.style.display = 'none';
        successBox.style.display = 'flex';
        successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else {
        // Server validation errors.
        if (res.data && res.data.fields) {
          var serverFields = res.data.fields;
          if (serverFields.pi_fullname) {
            showError(inputName, errorName, serverFields.pi_fullname);
          }
          if (serverFields.pi_phone) {
            showError(inputPhone, errorPhone, serverFields.pi_phone);
          }
        }

        if (res.data && res.data.message) {
          showBannerError(res.data.message);
        }
      }
    };

    xhr.onerror = function () {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Đặt lịch tư vấn miễn phí';
      submitBtn.classList.remove('pi-booking-btn--loading');
      showBannerError('Có lỗi xảy ra, vui lòng thử lại hoặc gọi trực tiếp ' + piBookingAjax.phone + '.');
    };

    xhr.send(formData);
  });

  function showBannerError(msg) {
    errorBanner.textContent = msg;
    errorBanner.style.display = 'block';
    errorBanner.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
});
