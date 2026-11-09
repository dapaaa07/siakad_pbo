(() => {
  'use strict';

  const STORAGE_KEY = 'color-scheme';
  const metaScheme = document.querySelector('meta[name="color-scheme"]');
  const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

  function resolveScheme(stored) {
    if (stored === 'dark' || stored === 'light') {
      return stored;
    }
    return mediaQuery.matches ? 'dark' : 'light';
  }

  function applyTheme(stored) {
    const metaVal = (stored === 'dark' || stored === 'light') ? stored : 'light dark';
    if (metaScheme) {
      metaScheme.setAttribute('content', metaVal);
    }

    const effective = resolveScheme(stored);
    const isDark = effective === 'dark';

    document.body.classList.toggle('dark-mode', isDark);

    const navbar = document.querySelector('.main-header');
    if (navbar) {
      navbar.classList.toggle('navbar-dark', isDark);
      navbar.classList.toggle('navbar-light', !isDark);
      navbar.classList.toggle('navbar-white', !isDark);
    }

    const toggleBtn = document.getElementById('theme-toggle-btn');
    if (toggleBtn) {
      toggleBtn.setAttribute('aria-pressed', String(isDark));
      const labelEl = toggleBtn.querySelector('[data-theme-label]');
      const iconEl = toggleBtn.querySelector('[data-theme-icon]');
      if (labelEl) {
        labelEl.textContent = isDark ? 'Mode Terang' : 'Mode Gelap';
      }
      if (iconEl) {
        iconEl.className = isDark ? 'fas fa-sun mr-1' : 'fas fa-moon mr-1';
      }
      toggleBtn.setAttribute(
        'aria-label',
        isDark ? 'Ubah ke mode terang' : 'Ubah ke mode gelap'
      );
    }

    window.dispatchEvent(new CustomEvent('siakad:theme-change', {
      detail: { scheme: effective }
    }));
  }

  function getStoredScheme() {
    try {
      return localStorage.getItem(STORAGE_KEY);
    } catch {
      return null;
    }
  }

  function setStoredScheme(value) {
    try {
      if (value === null) {
        localStorage.removeItem(STORAGE_KEY);
      } else {
        localStorage.setItem(STORAGE_KEY, value);
      }
    } catch {
      // Storage may be blocked in restricted browser contexts; apply in-memory only.
    }
  }

  function initThemeToggle() {
    applyTheme(getStoredScheme());

    const toggleBtn = document.getElementById('theme-toggle-btn');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => {
        const currentlyDark = resolveScheme(getStoredScheme()) === 'dark';
        const target = currentlyDark ? 'light' : 'dark';
        const system = mediaQuery.matches ? 'dark' : 'light';

        // Remove override when returning to system scheme so future OS changes take effect.
        const nextStored = target === system ? null : target;
        setStoredScheme(nextStored);
        applyTheme(nextStored);
      });
    }

    mediaQuery.addEventListener('change', () => {
      if (!getStoredScheme()) {
        applyTheme(null);
      }
    });

    window.addEventListener('storage', (event) => {
      if (event.key === STORAGE_KEY) {
        applyTheme(event.newValue);
      }
    });
  }

  function initDeleteDialog() {
    const dialog = document.getElementById('confirm-delete-dialog');
    if (!dialog) {
      return;
    }

    const nameEl = document.getElementById('delete-target-name');
    const formEl = document.getElementById('delete-target-form');
    const cancelBtn = document.getElementById('delete-cancel-btn');

    document.addEventListener('click', (event) => {
      const trigger = event.target.closest('[data-delete-trigger]');
      if (!trigger) {
        return;
      }

      if (nameEl) {
        nameEl.textContent = trigger.getAttribute('data-delete-name') || 'data ini';
      }
      if (formEl) {
        formEl.setAttribute('action', trigger.getAttribute('data-delete-url') || window.location.pathname);
      }

      if (typeof dialog.showModal === 'function') {
        dialog.showModal();
      } else {
        dialog.setAttribute('open', 'open');
      }
    });

    if (cancelBtn) {
      cancelBtn.addEventListener('click', () => {
        dialog.close('cancel');
      });
    }

    dialog.addEventListener('close', () => {
      dialog.returnValue = '';
    });

    // Fallback light-dismiss for browsers without native dialog closedby="any"
    if (!('closedBy' in HTMLDialogElement.prototype)) {
      let pressedOutside = false;
      const isOutside = (e) => {
        const rect = dialog.getBoundingClientRect();
        return e.clientX < rect.left || e.clientX > rect.right || e.clientY < rect.top || e.clientY > rect.bottom;
      };
      dialog.addEventListener('pointerdown', (e) => {
        pressedOutside = isOutside(e);
      });
      dialog.addEventListener('pointerup', (e) => {
        if (pressedOutside && isOutside(e)) {
          dialog.close('cancel');
        }
      });
    }
  }

  function initPasswordToggles() {
    document.querySelectorAll('[data-toggle-password]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const inputId = btn.getAttribute('data-toggle-password');
        const input = inputId ? document.getElementById(inputId) : null;
        if (!input) {
          return;
        }
        const reveal = input.type === 'password';
        input.type = reveal ? 'text' : 'password';
        btn.setAttribute('aria-pressed', String(reveal));
        btn.setAttribute('aria-label', reveal ? 'Sembunyikan password' : 'Tampilkan password');
        const icon = btn.querySelector('i');
        if (icon) {
          icon.className = reveal ? 'fas fa-eye-slash' : 'fas fa-eye';
        }
      });
    });
  }

  function initFormSubmitLoading() {
    document.querySelectorAll('form[data-loading-submit]').forEach((form) => {
      form.addEventListener('submit', () => {
        if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
          return;
        }
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn && !submitBtn.disabled) {
          submitBtn.disabled = true;
          const loadingText = submitBtn.getAttribute('data-loading-text') || 'Memproses...';
          submitBtn.textContent = loadingText;
        }
      });
    });
  }

  function initFileInputs() {
    if (typeof window.bsCustomFileInput !== 'undefined') {
      window.bsCustomFileInput.init();
    }

    document.querySelectorAll('input[type="file"][data-preview-target]').forEach((input) => {
      input.addEventListener('change', () => {
        const targetId = input.getAttribute('data-preview-target');
        const img = targetId ? document.getElementById(targetId) : null;
        const file = input.files && input.files[0];
        if (!img || !file || !file.type.startsWith('image/')) {
          return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
          if (e.target && typeof e.target.result === 'string') {
            img.src = e.target.result;
            img.hidden = false;
          }
        };
        reader.readAsDataURL(file);
      });
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
    initDeleteDialog();
    initPasswordToggles();
    initFormSubmitLoading();
    initFileInputs();
  });
})();
