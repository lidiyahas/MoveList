<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" class="bg-slate-950 text-slate-100 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist Premium - Arsip Sinema Personal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-900 via-slate-950 to-black flex flex-col justify-between relative overflow-x-hidden">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-cyan-500/10 blur-[120px] rounded-full pointer-events-none z-0"></div>
    <div class="absolute bottom-0 left-1/3 w-[300px] h-[300px] bg-indigo-500/5 blur-[100px] rounded-full pointer-events-none z-0"></div>

    <header class="w-full max-w-7xl mx-auto px-6 sm:px-12 lg:px-16 py-6 flex justify-between items-center z-10 relative">
        <div class="flex flex-col">
            <span class="text-[9px] uppercase tracking-[0.25em] text-cyan-400 font-extrabold mb-0.5">MOVELIST home</span>
        </div>
    </header>

    <main class="w-full max-w-7xl mx-auto px-6 sm:px-12 lg:px-16 flex flex-col items-center justify-center text-center my-auto py-12 z-10 relative">
        
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900/80 border border-slate-800 text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold mb-6 shadow-inner">
            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
            Projek Basis Data Non Relasi
        </div>

        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight max-w-3xl leading-[1.15] mb-6">
            APLIKASI <br class="hidden sm:inline">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-indigo-400 to-cyan-400 bg-size-200 animate-gradient">
                MOVELIST
            </span>
        </h2>

        <p class="text-sm sm:text-base text-slate-400 max-w-xl leading-relaxed mb-10 font-medium">
            Selamat datang di Aplikasi Movelist. Temukan ratusan ribu judul, lacak tontonan impian, dan tulis memori sinematik Anda dalam satu platform berdesain premium.
        </p>

        <div class="w-full max-w-md bg-slate-900/30 backdrop-blur-xl border border-slate-900/80 p-6 sm:p-8 rounded-3xl shadow-2xl shadow-cyan-500/5">
            
            <!-- Mengunci tampilan agar hanya memuat pilihan login dan daftar -->
            <div class="flex flex-col gap-3.5">
                <a href="auth/login.php" class="w-full text-center bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs uppercase tracking-widest py-4 rounded-xl transition duration-300 shadow-lg shadow-cyan-500/10 active:scale-[0.98]">
                    Login
                </a>
                
                <a href="auth/register.php" class="w-full text-center bg-slate-950/60 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white font-bold text-xs uppercase tracking-widest py-4 rounded-xl transition duration-300 active:scale-[0.98]">
                    Daftar 
                </a>

                <div class="flex items-center gap-4 my-2">
                    <div class="h-[1px] bg-slate-900 flex-1"></div>
                    <span class="text-[9px] uppercase tracking-widest text-slate-600 font-bold">Atau</span>
                    <div class="h-[1px] bg-slate-900 flex-1"></div>
                </div>

                <a href="auth/google_login.php" class="w-full text-center bg-slate-950/40 border border-slate-900 hover:border-slate-800 text-slate-400 hover:text-white font-semibold text-xs uppercase tracking-wider py-3.5 rounded-xl transition duration-300 flex items-center justify-center gap-2.5 active:scale-[0.98]">
                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.47 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Continue with Google
                </a>
            </div>

        </div>
    </main>

    <footer class="w-full max-w-7xl mx-auto px-6 sm:px-12 lg:px-16 py-6 text-center text-[11px] text-slate-600 font-medium tracking-wide z-10 relative border-t border-slate-900/40">
        &copy; <?= date('Y') ?> MoveList Premium.
    </footer>

</body>
</html>