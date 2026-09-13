<script>
    document.addEventListener('DOMContentLoaded', function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#2563eb',
                customClass: { popup: 'rounded-2xl' }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#e11d48',
                customClass: { popup: 'rounded-2xl' }
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                title: 'Peringatan!',
                text: "{{ session('warning') }}",
                icon: 'warning',
                confirmButtonColor: '#f59e0b',
                customClass: { popup: 'rounded-2xl' }
            });
        @endif

        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: "{{ session('info') }}"
            });
        @endif
    });
</script>
