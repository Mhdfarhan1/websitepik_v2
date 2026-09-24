<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'PIK-R REQUEST | Generasi Berencana' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_utama.png') }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Dancing+Script:wght@600;700&family=Montserrat:wght@800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Web Push & Notification Client -->
    <script src="{{ route('webpush.client-script') }}?v=3.0"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            light: '#60a5fa',
                            DEFAULT: '#3b82f6',
                            dark: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        html,
        body {
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
            position: relative;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Glassmorphism Utilities */
        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        }

        .hero-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* Premium Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #3b82f6;
        }

        /* Reading Progress Bar */
        #progress-bar {
            height: 4px;
            background: linear-gradient(to right, #3b82f6, #2dd4bf);
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            z-index: 100;
            transition: width 0.1s ease;
        }

        /* Desktop Dropdown Functionality */
        @media (min-width: 768px) {
            .dropdown:hover .dropdown-menu {
                display: block;
                animation: slideDown 0.3s ease forwards;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            z-index: 100;
            border-radius: 16px;
            padding: 12px 0;
            margin-top: 0;
            top: 100%;
            border: 1px solid rgba(241, 245, 249, 0.8);
            backdrop-filter: blur(10px);
        }

        /* Bridge to prevent menu from closing when moving mouse from trigger to menu */
        .dropdown-menu::before {
            content: "";
            position: absolute;
            top: -20px;
            left: 0;
            right: 0;
            height: 20px;
            background: transparent;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px 20px;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .dropdown-menu a:hover {
            color: #3b82f6;
            background-color: #f8fafc;
        }

        /* Glass Cards */
        .glass-card-premium {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card-premium:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px -20px rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
        }

        /* Animated Background Gradients */
        .bg-animated {
            background: linear-gradient(-45deg, #eff6ff, #f0fdfa, #faf5ff, #f8fafc);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Officer Card Specifics */
        .officer-card {
            position: relative;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .officer-card:hover {
            transform: translateY(-15px);
        }

        .glass-info {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }
    </style>
    @stack('styles')
</head>

<body class="bg-white">
    <div id="progress-bar"></div>

    <x-layouts.navbar />

    <main>
        {{ $slot }}
    </main>

    <x-layouts.footer />

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize AOS
            AOS.init({
                once: true,
                offset: 120,
                duration: 800,
                easing: 'ease-out-cubic'
            });

            // Reading Progress Bar
            window.addEventListener('scroll', () => {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                document.getElementById("progress-bar").style.width = scrolled + "%";

                // Navbar scroll effect
                const nav = document.getElementById('main-nav');
                const navContainer = document.getElementById('nav-container');
                const topbar = document.getElementById('topbar');

                if (window.scrollY > 50) {
                    nav?.classList.add('shadow-md');
                    nav?.classList.remove('shadow-sm');
                    if (window.innerWidth >= 1024) {
                        navContainer?.classList.replace('h-20', 'h-16');
                        if (topbar) topbar.style.marginTop = `-${topbar.offsetHeight}px`;
                    }
                } else {
                    nav?.classList.remove('shadow-md');
                    nav?.classList.add('shadow-sm');
                    if (window.innerWidth >= 1024) {
                        navContainer?.classList.replace('h-16', 'h-20');
                        if (topbar) topbar.style.marginTop = '0';
                    }
                }

                // Back to Top Button
                const btt = document.getElementById('back-to-top');
                if (window.scrollY > 500) {
                    btt?.classList.replace('opacity-0', 'opacity-100');
                    btt?.classList.remove('pointer-events-none');
                } else {
                    btt?.classList.replace('opacity-100', 'opacity-0');
                    btt?.classList.add('pointer-events-none');
                }
            });

            document.getElementById('back-to-top')?.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // FAQ Accordion
            document.querySelectorAll('.faq-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('i');
                    content.classList.toggle('hidden');
                    icon.classList.toggle('rotate-45');
                });
            });

            // Mobile menu toggle (Sidebar Style)
            const btn = document.getElementById('mobile-menu-btn');
            const closeBtn = document.getElementById('close-mobile-menu');
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');

            function openSidebar() {
                sidebar?.classList.remove('translate-x-full');
                overlay?.classList.remove('hidden');
                setTimeout(() => {
                    overlay?.classList.remove('opacity-0');
                }, 10);
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar?.classList.add('translate-x-full');
                overlay?.classList.add('opacity-0');
                setTimeout(() => {
                    overlay?.classList.add('hidden');
                }, 300);
                document.body.style.overflow = '';
            }

            if (btn) btn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);

            // Mobile Sidebar Dropdown toggle
            const mobileSidebarDropdownBtns = document.querySelectorAll('.mobile-sidebar-dropdown-btn');
            mobileSidebarDropdownBtns.forEach(dropdownBtn => {
                const triggerRow = dropdownBtn.parentElement;
                triggerRow?.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const content = triggerRow.nextElementSibling;
                    const icon = dropdownBtn.querySelector('i');

                    if (content?.classList.contains('max-h-0')) {
                        content.classList.remove('max-h-0');
                        content.classList.add('max-h-[500px]');
                        icon?.classList.add('rotate-180');
                    } else if (content) {
                        content.classList.remove('max-h-[500px]');
                        content.classList.add('max-h-0');
                        icon?.classList.remove('rotate-180');
                    }
                });
            });

            // Counter Animation
            const counters = document.querySelectorAll('.counter');
            const speed = 200;

            const startCount = (counter) => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const inc = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        startCount(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 1 });

            counters.forEach(counter => observer.observe(counter));

            // Gallery Slider Navigation
            const gallerySlider = document.getElementById('gallery-slider');
            const prevGalleryBtn = document.getElementById('prev-gallery');
            const nextGalleryBtn = document.getElementById('next-gallery');

            if (gallerySlider && prevGalleryBtn && nextGalleryBtn) {
                const scrollAmount = 400;

                prevGalleryBtn.addEventListener('click', () => {
                    gallerySlider.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                });

                nextGalleryBtn.addEventListener('click', () => {
                    gallerySlider.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                });

                gallerySlider.addEventListener('scroll', () => {
                    const maxScroll = gallerySlider.scrollWidth - gallerySlider.clientWidth;
                    prevGalleryBtn.style.opacity = gallerySlider.scrollLeft <= 5 ? '0' : '1';
                    prevGalleryBtn.style.pointerEvents = gallerySlider.scrollLeft <= 5 ? 'none' : 'auto';

                    nextGalleryBtn.style.opacity = gallerySlider.scrollLeft >= maxScroll - 5 ? '0' : '1';
                    nextGalleryBtn.style.pointerEvents = gallerySlider.scrollLeft >= maxScroll - 5 ? 'none' : 'auto';
                });
            }
        });
    </script>
    <x-dashboard.alert />
    <x-notifications.push-prompt-bottom />
    @stack('scripts')
</body>

</html>