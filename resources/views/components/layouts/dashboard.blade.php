<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Admin | PIK-R REQUEST' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_utama.png') }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f8fafc;
            color: #1e293b;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar for dashboard */
        ::-webkit-scrollbar {
            width: 5px;
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

        /* Glass Effects */
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Top Progress Bar for Instant Feedback on Navigation */
        #page-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #2563eb, #38bdf8, #f59e0b);
            z-index: 999999;
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
            box-shadow: 0 0 12px rgba(37, 99, 235, 0.8);
            pointer-events: none;
            display: none;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased">
    <!-- Instant Navigation Progress Bar -->
    <div id="page-progress-bar"></div>

    <x-dashboard.alert />

    <div class="min-h-screen bg-[#f8fafc] flex" 
         x-data="{ 
             sidebarOpen: localStorage.getItem('dashboard_sidebar_open') !== 'false', 
             mobileMenu: false, 
             isMobile: window.innerWidth < 1024 
         }" 
         x-init="
             $watch('sidebarOpen', val => localStorage.setItem('dashboard_sidebar_open', val));
             isMobile = window.innerWidth < 1024; 
             if(isMobile) sidebarOpen = false;
         " 
         @resize.window="isMobile = window.innerWidth < 1024; if(isMobile) sidebarOpen = false">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="mobileMenu" 
             x-transition:enter="transition-opacity ease-linear duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             @click="mobileMenu = false" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] lg:hidden">
        </div>

        <x-dashboard.sidebar />

        <!-- Main Body -->
        <main class="flex-1 flex flex-col min-w-0 transition-all duration-300">
            <x-dashboard.header />

            <!-- Content Area -->
            <div class="p-6 lg:p-10 space-y-8 max-w-[1600px] mx-auto w-full">
                {{ $slot }}
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Restore and persist sidebar scroll position
            const navScroll = document.getElementById('sidebarNavScroll');
            if (navScroll) {
                const savedScroll = sessionStorage.getItem('dashboard_sidebar_scroll');
                if (savedScroll !== null) {
                    navScroll.scrollTop = parseInt(savedScroll, 10);
                }
                navScroll.addEventListener('scroll', function () {
                    sessionStorage.setItem('dashboard_sidebar_scroll', navScroll.scrollTop);
                }, { passive: true });
            }

            // Top progress bar indicator for seamless instant navigation feel
            const progressBar = document.getElementById('page-progress-bar');
            document.addEventListener('click', function (e) {
                const link = e.target.closest('a');
                if (!link) return;

                const href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('javascript:') || link.target === '_blank') return;
                if (link.origin !== window.location.origin) return;

                // Show top progress bar immediately
                if (progressBar) {
                    progressBar.style.display = 'block';
                    progressBar.style.width = '35%';
                    progressBar.style.opacity = '1';
                    setTimeout(() => {
                        progressBar.style.width = '80%';
                    }, 120);
                }
            });

            // Global helper to show processing alert on form submissions
            window.showProcessingAlert = function (form) {
                if (!form) return;
                
                const method = (form.getAttribute('method') || 'GET').toUpperCase();
                if (method === 'GET') return; // Skip GET forms (search / filter)

                // Skip if HTML5 form validation fails
                if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
                    return;
                }

                // Identify submit button & message
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                const isDelete = (form.querySelector('input[name="_method"][value="DELETE"]') || 
                                  (submitBtn && submitBtn.textContent.toLowerCase().includes('hapus')) ||
                                  (form.action && (form.action.toLowerCase().includes('destroy') || form.action.toLowerCase().includes('delete'))));
                
                let titleText = 'Memproses Data...';
                let subText = 'Sedang menyimpan data, mohon tunggu sebentar...';

                if (isDelete) {
                    titleText = 'Memproses Penghapusan...';
                    subText = 'Sedang menghapus data, mohon tunggu...';
                } else if (submitBtn && (submitBtn.textContent.toLowerCase().includes('update') || submitBtn.textContent.toLowerCase().includes('perbarui'))) {
                    titleText = 'Memperbarui Data...';
                    subText = 'Sedang menyimpan perubahan, mohon tunggu...';
                }

                // Update button text & spinner
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.disabled = true;
                    submitBtn.dataset.origHtml = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-xs"></i> <span>Memproses...</span>';
                    submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
                }

                // Display SweetAlert2 loading dialog
                if (window.Swal) {
                    Swal.fire({
                        title: titleText,
                        text: subText,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        customClass: {
                            popup: 'rounded-3xl p-6',
                            title: 'text-lg font-bold text-[#1b3c66]'
                        }
                    });
                }
            };

            // Global submit listener
            document.addEventListener('submit', function (e) {
                if (e.defaultPrevented) return;
                const form = e.target;
                if (!form || form.tagName !== 'FORM') return;

                setTimeout(function () {
                    if (!e.defaultPrevented) {
                        window.showProcessingAlert(form);
                    }
                }, 10);
            });

            // Override HTMLFormElement.prototype.submit for JS programmatic submits
            const origSubmit = HTMLFormElement.prototype.submit;
            HTMLFormElement.prototype.submit = function () {
                window.showProcessingAlert(this);
                return origSubmit.apply(this, arguments);
            };
        });
    </script>
    @stack('scripts')
</body>
</html>
