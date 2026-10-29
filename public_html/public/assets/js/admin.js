(() => {
    'use strict';

    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('admin-overlay');
    const toggle = document.querySelector('[data-sidebar-toggle]');
    const closers = document.querySelectorAll('[data-sidebar-close]');

    const setSidebar = (open) => {
        if (!sidebar) return;

        sidebar.classList.toggle('is-open', open);
        document.body.classList.toggle('admin-menu-open', open);

        if (overlay) overlay.classList.toggle('hidden', !open);
        if (toggle) toggle.setAttribute('aria-expanded', String(open));
    };

    if (toggle) {
        toggle.addEventListener('click', () => {
            setSidebar(!sidebar.classList.contains('is-open'));
        });
    }

    closers.forEach((button) => {
        button.addEventListener('click', () => setSidebar(false));
    });

    if (sidebar) {
        sidebar.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) setSidebar(false);
            });
        });
    }

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setSidebar(false);
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) setSidebar(false);
    });

    // Konfirmasi sebelum menghapus data memakai modal khusus admin.
    const confirmModal = document.querySelector('[data-confirm-modal]');
    const confirmForms = document.querySelectorAll('form[data-confirm]');

    if (confirmModal && confirmForms.length) {
        const titleEl = confirmModal.querySelector('[data-confirm-title]');
        const messageEl = confirmModal.querySelector('[data-confirm-message]');
        const eyebrowEl = confirmModal.querySelector('[data-confirm-eyebrow]');
        const iconEl = confirmModal.querySelector('[data-confirm-icon]');
        const acceptBtn = confirmModal.querySelector('[data-confirm-accept]');
        const declineBtn = confirmModal.querySelector('[data-confirm-decline]');
        const closers = confirmModal.querySelectorAll('[data-confirm-close]');

        let pendingForm = null;
        let lastFocused = null;

        const focusableItems = () =>
            Array.from(
                confirmModal.querySelectorAll(
                    'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
                )
            ).filter((element) => element.offsetParent !== null);

        const openConfirm = (form) => {
            pendingForm = form;
            lastFocused = document.activeElement;

            titleEl.textContent = form.getAttribute('data-confirm-title') || 'Hapus data ini?';
            messageEl.textContent = form.getAttribute('data-confirm') || 'Tindakan ini tidak bisa dibatalkan.';

            if (eyebrowEl) {
                eyebrowEl.textContent = form.getAttribute('data-confirm-eyebrow') || 'Konfirmasi';
            }

            acceptBtn.textContent = form.getAttribute('data-confirm-label') || 'Hapus';

            if (iconEl) {
                iconEl.setAttribute('href', '#' + (form.getAttribute('data-confirm-icon') || 'i-trash'));
            }

            confirmModal.hidden = false;
            document.body.classList.add('admin-modal-open');

            // Fokuskan tombol aman lebih dulu agar Enter tidak langsung menghapus.
            window.setTimeout(() => declineBtn.focus(), 30);
        };

        const closeConfirm = () => {
            confirmModal.hidden = true;
            document.body.classList.remove('admin-modal-open');

            pendingForm = null;

            if (lastFocused && lastFocused.isConnected) {
                lastFocused.focus();
            }
        };

        confirmForms.forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (form.dataset.confirmed === 'true') {
                    delete form.dataset.confirmed;

                    return;
                }

                event.preventDefault();
                openConfirm(form);
            });
        });

        acceptBtn.addEventListener('click', () => {
            if (!pendingForm) return;

            const form = pendingForm;
            form.dataset.confirmed = 'true';

            closeConfirm();

            if (typeof form.requestSubmit === 'function') {
                form.requestSubmit();
            } else {
                form.submit();
            }
        });

        closers.forEach((button) => {
            button.addEventListener('click', closeConfirm);
        });

        document.addEventListener('keydown', (event) => {
            if (confirmModal.hidden) return;

            if (event.key === 'Escape') {
                event.preventDefault();
                closeConfirm();

                return;
            }

            if (event.key !== 'Tab') return;

            const items = focusableItems();

            if (items.length === 0) return;

            const first = items[0];
            const last = items[items.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        });
    }

    // Pratinjau gambar sebelum diunggah.
    document.querySelectorAll('[data-image-input]').forEach((input) => {
        input.addEventListener('change', () => {
            const file = input.files && input.files[0];
            const field = input.closest('[data-file-field]');
            const fileName = field ? field.querySelector('[data-file-name]') : null;

            if (fileName) {
                fileName.textContent = file ? file.name : 'Belum ada file dipilih';
            }

            if (!file || !file.type.startsWith('image/')) return;

            const form = input.closest('form');
            if (!form) return;

            const preview = form.querySelector('[data-image-preview]');
            const empty = form.querySelector('[data-image-empty]');

            if (preview) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }

            if (empty) empty.classList.add('hidden');
        });
    });

    // Buat slug otomatis dari judul/nama.
    const slugify = (text) =>
        text
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');

    document.querySelectorAll('[data-slug-source]').forEach((source) => {
        const form = source.closest('form');
        const target = form ? form.querySelector('[data-slug-target]') : null;

        if (!target) return;

        let touched = target.value.trim() !== '';

        target.addEventListener('input', () => {
            touched = target.value.trim() !== '';
            target.dataset.auto = 'false';
        });

        source.addEventListener('input', () => {
            if (touched && target.dataset.auto !== 'true') return;

            target.dataset.auto = 'true';
            target.value = slugify(source.value);
        });
    });

    // Notifikasi dapat ditutup dan hilang otomatis.
    document.querySelectorAll('[data-flash]').forEach((flash) => {
        const close = flash.querySelector('[data-flash-close]');

        if (close) {
            close.addEventListener('click', () => flash.remove());
        }

        window.setTimeout(() => {
            if (!flash.isConnected) return;

            flash.style.transition = 'opacity 300ms ease';
            flash.style.opacity = '0';
            window.setTimeout(() => flash.remove(), 320);
        }, 6000);
    });

    // Bulk select & delete handling for admin CRUD tables
    document.querySelectorAll('[data-bulk-table]').forEach((container) => {
        const selectAll = container.querySelector('[data-select-all]');
        const checkboxes = container.querySelectorAll('.item-checkbox');
        const bulkBtn = document.getElementById(container.getAttribute('data-bulk-btn') || 'bulk-delete-btn');

        const updateBulkState = () => {
            const checkedCount = Array.from(checkboxes).filter((cb) => cb.checked).length;
            if (bulkBtn) {
                bulkBtn.disabled = checkedCount === 0;
                const countSpan = bulkBtn.querySelector('[data-bulk-count]');
                if (countSpan) {
                    countSpan.textContent = checkedCount > 0 ? `(${checkedCount})` : '';
                }
            }
            if (selectAll) {
                selectAll.checked = checkedCount > 0 && checkedCount === checkboxes.length;
                selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
            }
        };

        if (selectAll) {
            selectAll.addEventListener('change', () => {
                checkboxes.forEach((cb) => {
                    cb.checked = selectAll.checked;
                });
                updateBulkState();
            });
        }

        checkboxes.forEach((cb) => {
            cb.addEventListener('change', updateBulkState);
        });

        updateBulkState();
    });

    // Populate bulk delete form with checked item IDs before submit
    document.querySelectorAll('form[action*="bulk-delete"]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            console.log('Bulk delete form submitted:', form.action);
            form.querySelectorAll('input[name="ids[]"]').forEach((el) => el.remove());

            const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
            if (checkedBoxes.length === 0) {
                console.log('No items selected');
                event.preventDefault();
                return;
            }

            checkedBoxes.forEach((cb) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                form.appendChild(input);
            });
            console.log('Added ids:', checkedBoxes.length);
        });
    });
})();
