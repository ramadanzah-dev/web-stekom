(() => {
    'use strict';

    const header = document.getElementById('site-header');
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const menuPanel = document.querySelector('[data-menu-panel]');
    const menuIcon = document.querySelector('[data-menu-icon]');
    const menuIconClose = document.querySelector('[data-menu-icon-close]');

    const syncHeader = () => {
        if (!header) return;
        header.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    syncHeader();
    window.addEventListener('scroll', syncHeader, { passive: true });

    const setMenu = (open) => {
        if (!menuToggle || !menuPanel) return;

        menuToggle.setAttribute('aria-expanded', String(open));
        menuToggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
        menuPanel.classList.toggle('hidden', !open);
        document.body.classList.toggle('overflow-hidden', open);

        if (menuIcon) menuIcon.classList.toggle('hidden', open);
        if (menuIconClose) menuIconClose.classList.toggle('hidden', !open);
    };

    if (menuToggle && menuPanel) {
        menuToggle.addEventListener('click', () => {
            setMenu(menuToggle.getAttribute('aria-expanded') !== 'true');
        });

        menuPanel.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setMenu(false));
        });

        window.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && menuToggle.getAttribute('aria-expanded') === 'true') {
                setMenu(false);
                menuToggle.focus();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) setMenu(false);
        });
    }

    const reveals = document.querySelectorAll('.reveal');

    if (!('IntersectionObserver' in window) || reveals.length === 0) {
        reveals.forEach((element) => element.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    reveals.forEach((element) => observer.observe(element));
})();
