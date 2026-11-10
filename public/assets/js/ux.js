/**
 * UX layer: form feedback + motion helpers. Plain JS, no dependencies.
 * - Submit buttons show a spinner and block double-submits.
 * - On invalid submit, the first bad field is scrolled to, focused and shaken.
 * - Labels highlight while their field has focus; required labels get a marker.
 * - Success alerts fade out on their own.
 */
(function () {
  'use strict';

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function shake(el) {
    if (!el || reduceMotion) return;
    el.classList.remove('ux-shake');
    void el.offsetWidth; // restart the animation
    el.classList.add('ux-shake');
    el.addEventListener('animationend', function () { el.classList.remove('ux-shake'); }, { once: true });
  }

  // What the user sees and should focus for a field (select2 hides the real <select>).
  function visibleTarget(field) {
    var next = field.nextElementSibling;
    if (next && next.classList.contains('select2')) return next.querySelector('.select2-selection') || next;
    return field;
  }

  function submitButtonsOf(form, submitter) {
    if (submitter) return [submitter];
    var list = Array.prototype.slice.call(form.querySelectorAll('button[type="submit"], input[type="submit"], button:not([type])'));
    if (form.id) {
      list = list.concat(Array.prototype.slice.call(document.querySelectorAll('[type="submit"][form="' + form.id + '"]')));
    }
    return list;
  }

  function setLoading(btn, on) {
    if (on) {
      btn.classList.add('ux-loading');
      btn.setAttribute('aria-busy', 'true');
      btn.disabled = true;
    } else {
      btn.classList.remove('ux-loading');
      btn.removeAttribute('aria-busy');
      btn.disabled = false;
    }
  }

  var loadingButtons = [];

  function resetLoading() {
    loadingButtons.forEach(function (btn) { setLoading(btn, false); });
    loadingButtons = [];
  }

  // 1) Invalid submit -> jump to and shake the first invalid field.
  document.addEventListener('invalid', function (event) {
    var form = event.target.form;
    if (!form || form.__uxInvalidHandled) return;
    form.__uxInvalidHandled = true;
    setTimeout(function () { form.__uxInvalidHandled = false; }, 0);

    var target = visibleTarget(event.target);
    target.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' });
    setTimeout(function () {
      try { event.target.focus({ preventScroll: true }); } catch (e) { /* hidden field */ }
      shake(target);
    }, reduceMotion ? 0 : 220);
  }, true);

  // 2) Valid submit -> spinner on the submit button, no double submit.
  document.addEventListener('submit', function (event) {
    var form = event.target;
    if (!(form instanceof HTMLFormElement) || form.hasAttribute('data-no-loading')) return;
    var submitter = event.submitter || null;

    // Wait one tick so any page script (AJAX submit, validation) can cancel first.
    // The browser has already captured the form data by then, so disabling is safe.
    setTimeout(function () {
      if (event.defaultPrevented) return;
      if (form.classList.contains('needs-validation') && !form.checkValidity()) return;

      submitButtonsOf(form, submitter).forEach(function (btn) {
        setLoading(btn, true);
        loadingButtons.push(btn);
      });

      // Safety net: if nothing navigates away (download, slow server), give the button back.
      setTimeout(resetLoading, 15000);
    }, 0);
  });

  // Back/forward cache restores the page as it was: clear stuck spinners.
  window.addEventListener('pageshow', function (event) { if (event.persisted) resetLoading(); });

  // 3) Label highlight on focus.
  function fieldWrapper(el) {
    return el.closest('.col-12, .col, [class*="col-"], .mb-3, .form-group');
  }
  document.addEventListener('focusin', function (event) {
    if (!event.target.matches('input, select, textarea')) return;
    var wrap = fieldWrapper(event.target);
    if (wrap) wrap.classList.add('ux-field-focus');
  });
  document.addEventListener('focusout', function (event) {
    if (!event.target.matches('input, select, textarea')) return;
    var wrap = fieldWrapper(event.target);
    if (wrap) wrap.classList.remove('ux-field-focus');
  });

  // 4) Required marker on labels that don't already show one.
  function markRequired(root) {
    root.querySelectorAll('input[required], select[required], textarea[required]').forEach(function (field) {
      if (field.type === 'hidden' || field.type === 'radio' || field.type === 'checkbox') return;
      var label = field.id ? document.querySelector('label[for="' + field.id + '"]') : null;
      if (!label) {
        var wrap = fieldWrapper(field);
        label = wrap ? wrap.querySelector('label') : null;
      }
      if (!label || label.classList.contains('ux-required')) return;
      if (/\*\s*$/.test(label.textContent) || label.querySelector('.text-danger')) return;
      label.classList.add('ux-required');
    });
  }

  // 5) Success alerts fade out after a few seconds.
  function autoDismissAlerts() {
    document.querySelectorAll('.alert-success').forEach(function (alert) {
      if (alert.dataset.uxDismiss === 'off') return;
      setTimeout(function () {
        alert.classList.add('ux-leave');
        setTimeout(function () { alert.remove(); }, 320);
      }, 4500);
    });
  }

  function init() {
    markRequired(document);
    autoDismissAlerts();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // Modals often hold forms: mark their required fields when they open.
  document.addEventListener('shown.bs.modal', function (event) { markRequired(event.target); });
})();
