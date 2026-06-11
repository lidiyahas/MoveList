<?php
session_start();

require '../config/db.php';
require '../api/omdb.php';

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit;
}

$user = $users->findOne(["email" => $_SESSION['user']]);
$list = $watchlist->find(["user" => $_SESSION['user']]);
$count = $watchlist->countDocuments(["user" => $_SESSION['user']]);
?>

<!DOCTYPE html>
<html lang="en" class="bg-slate-950 text-slate-100 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Sineas - Watchlist Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-900 via-slate-950 to-black pb-16">

    <div class="fixed top-0 left-0 w-full z-50 backdrop-blur-md bg-slate-950/70 border-b border-slate-900/80 px-6 sm:px-12 lg:px-16 py-4">
        <header class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex flex-col">
                <span class="text-[10px] uppercase tracking-[0.2em] text-indigo-400 font-bold mb-0.5">MoveList Profile</span>
            </div>
            <div>
                <a href="index.php" class="text-center text-[11px] font-semibold uppercase tracking-widest px-5 py-2.5 rounded-xl bg-slate-800/40 text-slate-300 border border-slate-800 hover:bg-slate-800 hover:text-white transition duration-300 inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </header>
    </div>

    <div class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-16 pt-32 sm:pt-40">

        <section class="mb-16 bg-gradient-to-r from-slate-900/60 to-slate-950 rounded-3xl border border-slate-900 p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6 relative overflow-hidden shadow-xl">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/10 blur-3xl rounded-full pointer-events-none"></div>
            
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-cyan-500 text-slate-950 font-extrabold text-3xl flex justify-center items-center shadow-lg shadow-indigo-500/20 transform tracking-wider">
                <?= strtoupper(substr($user['username'] ?? 'S', 0, 1)) ?>
            </div>

            <div class="flex-1 text-center sm:text-left">
                <span class="text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold block mb-1">Profile</span>
                <h3 class="text-2xl font-extrabold text-white mb-1 tracking-tight"><?= htmlspecialchars($user['username'] ?? 'Sineas') ?></h3>
                <p class="text-sm text-slate-400 mb-4 font-medium"><?= htmlspecialchars($user['email'] ?? '-') ?></p>
                
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                    Koleksi: <?= $count ?> Film
                </div>
            </div>
        </section>

        <section>
            <div class="flex items-center gap-4 mb-8">
                <h3 class="text-xs font-bold tracking-[0.2em] uppercase text-slate-400">Koleksi Film Saya</h3>
                <div class="h-[1px] bg-slate-800 flex-1"></div>
            </div>

            <?php if($count > 0): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                    <?php foreach($list as $item): ?>
                        <?php
                        $poster = (!empty($item['poster']) && $item['poster'] != "N/A") 
                            ? $item['poster'] 
                            : "https://via.placeholder.com/250x350";

                        $detail = getMovieDetail($item['imdbID']);
                        ?>

                        <div class="group bg-gradient-to-b from-slate-900/40 to-slate-950 rounded-3xl overflow-hidden border border-slate-900 flex flex-col hover:-translate-y-2 hover:border-slate-800 hover:shadow-2xl hover:shadow-indigo-500/5 transition duration-300">
                            <div class="w-full h-[400px] bg-slate-950 relative overflow-hidden">
                                <img src="<?= $poster ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-80"></div>
                            </div>
                            
                            <div class="p-6 flex flex-col flex-1 relative -mt-10 bg-gradient-to-b from-transparent via-slate-950 to-slate-950">
                                <h4 class="text-base font-bold text-white leading-snug mb-2 group-hover:text-indigo-400 transition duration-300"><?= htmlspecialchars($item['title']) ?></h4>

                                <div class="text-[11px] text-slate-500 font-medium mb-4 flex flex-wrap gap-x-2 tracking-wide">
                                    <span class="text-indigo-400/80 font-semibold"><?= $detail['Year'] ?? '-' ?></span>
                                    <span class="text-slate-800">•</span>
                                    <span class="line-clamp-4"><?= $detail['Actors'] ?? '-' ?></span>
                                </div>

                                <p class="text-xs text-slate-400 leading-relaxed mb-6 line-clamp-6">
                                    <?= htmlspecialchars($detail['Plot'] ?? '-') ?>
                                </p>

                                <?php if(!empty($item['note'])): ?>
                                <div class="bg-slate-900/60 border border-slate-800/80 p-3.5 rounded-xl text-xs text-slate-400 mb-2 leading-relaxed">
                                    <span class="text-[10px] uppercase tracking-wider text-indigo-400 font-bold block mb-6">Memo</span>
                                    <?= htmlspecialchars($item['note']) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16 bg-slate-900/20 rounded-3xl border border-dashed border-slate-800">
                    <p class="text-sm text-slate-500 font-medium mb-4">Belum ada mahakarya sinema yang Anda simpan.</p>
                    <a href="index.php" class="text-xs font-bold text-cyan-400 hover:text-cyan-300 uppercase tracking-widest transition">Mulai Jelajahi →</a>
                </div>
            <?php endif; ?>
        </section>

    </div>

</body>
</html>