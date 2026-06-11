<?php
session_start();
require '../config/db.php';

$msg = "";

// proses register
if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // cek email sudah ada
    $cek = $users->findOne(["email" => $email]);

    if($cek){
        $msg = "Email sudah terdaftar!";
    } else {
        $insert = $users->insertOne([
            "username" => $username,
            "email" => $email,
            "password" => $password
        ]);

        // Jika data berhasil disimpan, langsung alihkan ke halaman login
        if($insert->getInsertedCount() > 0) {
            header("Location: login.php");
            exit(); // Menghentikan eksekusi skrip agar redirect berjalan lancar
        } else {
            $msg = "Gagal melakukan registrasi, silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-slate-950 text-slate-100 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Watchlist Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-900 via-slate-950 to-black flex flex-col justify-between p-4">

    <!-- Header -->
    <header class="w-full max-w-7xl mx-auto px-6 sm:px-12 lg:px-16 py-6 flex justify-between items-center z-10 relative">
        <div class="flex flex-col">
            <span class="text-[9px] uppercase tracking-[0.25em] text-cyan-400 font-extrabold mb-0.5">@MOVELIST register</span>
        </div>
    </header>

    <!-- Konten Utama (Form Register) -->
    <div class="w-full max-w-md bg-slate-900/40 backdrop-blur-xl border border-slate-900 rounded-3xl p-8 sm:p-10 shadow-2xl shadow-indigo-500/5 relative overflow-hidden mx-auto my-auto">
        
        <div class="absolute -right-20 -top-20 w-40 h-40 bg-indigo-500/10 blur-3xl rounded-full pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-40 h-40 bg-cyan-500/10 blur-3xl rounded-full pointer-events-none"></div>

        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-white tracking-tight">
                Silahkan <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Registrasi</span>
            </h2>
        </div>

        <?php if($msg): ?>
            <?php 
                $isSuccess = (strpos($msg, 'berhasil') !== false); 
                $alertClass = $isSuccess 
                    ? "bg-emerald-950/30 border-emerald-500/30 text-emerald-400" 
                    : "bg-red-950/30 border-red-500/30 text-red-400";
            ?>
            <div class="border rounded-xl p-3.5 flex gap-2.5 items-center mb-6 text-xs <?= $alertClass ?> animate-fade-in">
                <?php if($isSuccess): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                <?php endif; ?>
                <span><?= $msg ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-[10px] uppercase tracking-wider text-slate-500 font-bold mb-2">Nama Pengguna</label>
                <input 
                    type="text" 
                    name="username" 
                    placeholder="Username" 
                    class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-slate-200 placeholder-slate-700 outline-none focus:border-indigo-500/50 transition duration-300"
                    required>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-wider text-slate-500 font-bold mb-2">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="nama@email.com" 
                    class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-slate-200 placeholder-slate-700 outline-none focus:border-indigo-500/50 transition duration-300"
                    required>
            </div>

            <div class="pb-2">
                <label class="block text-[10px] uppercase tracking-wider text-slate-500 font-bold mb-2">Kata Sandi Baru</label>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="••••••••" 
                    class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-slate-200 placeholder-slate-700 outline-none focus:border-indigo-500/50 transition duration-300"
                    required>
            </div>

            <button 
                name="register" 
                class="w-full bg-gradient-to-r from-indigo-500 to-cyan-500 hover:from-indigo-400 hover:to-cyan-400 text-slate-950 font-bold text-xs uppercase tracking-widest py-4 rounded-xl transition duration-300 shadow-lg shadow-indigo-500/10 active:scale-[0.98]">
                Buat Akun 
            </button>
        </form>

        <div class="flex items-center gap-4 my-6">
            <div class="h-[1px] bg-slate-800/80 flex-1"></div>
            <span class="text-[10px] uppercase tracking-widest text-slate-600 font-bold">Atau</span>
            <div class="h-[1px] bg-slate-800/80 flex-1"></div>
        </div>

        <a href="google_login.php" class="block mb-6">
            <button class="w-full bg-slate-950/40 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white font-semibold text-xs uppercase tracking-wider py-3.5 rounded-xl transition duration-300 flex items-center justify-center gap-2.5 active:scale-[0.98]">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                    <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.47 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Sign up with Google
            </button>
        </a>

        <div class="text-center">
            <p class="text-xs text-slate-500 font-medium tracking-wide">
                Sudah punya akun? 
                <a href="login.php" class="text-indigo-400 hover:text-indigo-300 font-bold underline underline-offset-4 decoration-slate-800 hover:decoration-indigo-400/50 hover:drop-shadow-[0_0_6px_rgba(129,140,248,0.6)] transition duration-300 ml-1">
                    Masuk di Sini
                </a>
            </p>
        </div>
    </div>

    <div class="w-full py-6 invisible"></div>

</body>
</html>