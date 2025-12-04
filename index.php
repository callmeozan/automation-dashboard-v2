<!-- username = admin -->
<!-- password = admin123 -->
<?php
session_start();
// Kalau sudah login, lempar langsung ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Login - Automation Command Center</title> -->
     <title>Login - Automation & Management System</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/components/button.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <style>
        /* Animasi halus untuk background */
        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }
    </style>
</head>

<body class="bg-slate-950 text-slate-200 font-sans antialiased h-screen flex items-center justify-center relative overflow-hidden">

    <div class="absolute top-0 -left-4 w-72 h-72 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

    <div class="relative z-10 w-full max-w-md p-8 bg-slate-900/80 backdrop-blur-xl border border-slate-800 rounded-2xl shadow-2xl">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-800 mb-4 border border-slate-700 shadow-lg shadow-emerald-500/10 overflow-hidden p-1.5">
                <img src="image/gajah_tunggal.png" alt="Logo Dept" class="w-full h-full object-cover rounded-full">
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wide">JIS <span class="text-emerald-400">PORTAL.</span></h1>
            <p class="text-sm text-slate-500 mt-1">Automation & Management System</p>
        </div>

        <!-- <form id="loginForm" class="space-y-6"> -->
        <form action="auth.php" method="POST" class="space-y-6" id="loginForm">
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1 uppercase tracking-wider">ID Number</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-slate-500"></i>
                    </div>
                    <input type="text" name="username" class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-lg leading-5 bg-slate-950 text-slate-300 placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 sm:text-sm transition" placeholder="Enter your ID Number">
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1 uppercase tracking-wider">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-slate-500"></i>
                    </div>
                    <input type="password" name="password" class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-lg leading-5 bg-slate-950 text-slate-300 placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 sm:text-sm transition" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <!-- <input id="remember_me" type="checkbox" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-700 rounded bg-slate-800"> -->
                    <!-- <label for="remember_me" class="ml-2 block text-sm text-slate-400">Ingat Saya</label> -->
                </div>
                <div class="text-sm">
                    <!-- <a href="#" class="font-medium text-emerald-500 hover:text-emerald-400">Lupa Password?</a> -->
                    <!-- <a href="javascript:void(0)" onclick="forgotPassword()" class="font-medium text-emerald-500 hover:text-emerald-400 transition">Forgot Password?</a> -->
                    <a href="reset_password.php" class="font-medium text-emerald-500 hover:text-emerald-400 transition">Forgot Password?</a>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-emerald-500 transition shadow-lg shadow-emerald-600/20">
                    LOGIN<i class="fas fa-arrow-right ml-2 mt-1"></i>
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-xs text-slate-600">
                &copy; 2025 JIS Automation Dept. Internal Use Only.
            </p>
        </div>
    </div>

    <script>
        // Script UI Saja: Ubah tombol jadi 'Loading...' saat diklik
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                // JANGAN ada e.preventDefault(); biar form terkirim ke auth.php

                const btn = this.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;

                // Ubah tampilan tombol biar seolah-olah mikir
                btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Verifying...';
                btn.classList.add('opacity-75', 'cursor-not-allowed');
                // btn.disabled = true; // Jangan disable dulu biar data terkirim
            });
        }

        // FUNGSI LUPA PASSWORD
        // function forgotPassword() {
        //     Swal.fire({
        //         icon: 'info',
        //         title: 'Lupa Password?',
        //         html: `
        //             <p class="text-sm text-slate-300 mb-4">
        //                 Karena sistem ini bersifat internal, silakan hubungi Administrator untuk melakukan reset password manual.
        //             </p>
        //             <div class="bg-slate-800 p-3 rounded-lg text-left border border-slate-700">
        //                 <p class="text-xs text-slate-400 mb-1">Kontak Admin:</p>
        //                 <div class="flex items-center gap-2 text-emerald-400 font-bold">
        //                     <i class="fab fa-whatsapp"></i> 0812-3456-7890 (Pak Budi)
        //                 </div>
        //                 <div class="flex items-center gap-2 text-blue-400 font-bold mt-1">
        //                     <i class="fas fa-envelope"></i> admin.automation@jis.com
        //                 </div>
        //             </div>
        //         `,
        //         background: '#1e293b', // Dark mode theme
        //         color: '#fff',
        //         confirmButtonText: 'Oke, Saya Paham',
        //         confirmButtonColor: '#059669' // Emerald Green
        //     });
        // }
    </script>

    <?php
    if (isset($_GET['error'])) {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak!',
                text: 'ID (NIP) atau Password yang Anda masukkan salah.',
                background: '#1e293b', 
                color: '#fff', 
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Coba Lagi'
            }).then(() => {
                // Hapus parameter ?error=1 dari URL agar bersih
                window.history.replaceState(null, null, window.location.pathname);
            });
        </script>
        ";
    }
    ?>
</body>

</html>
</body>

</html>