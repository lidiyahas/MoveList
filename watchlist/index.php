<?php
session_start();

require '../config/db.php';
require '../api/omdb.php';

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit;
}



$movies = null;
$searchError = false;

if(isset($_GET['search'])){
    $movies = searchMovie($_GET['search']);
    
    // Memeriksa jika Film tidak ditemukan
    if (isset($movies['Response']) && $movies['Response'] === 'False') {
        $searchError = true;
    }
}



$list = $watchlist->find([
    "user" => $_SESSION['user']
]);
?>

<!DOCTYPE html>
<html lang="en" class="bg-slate-950 text-slate-100 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist Premium</title>
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
        <header class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex flex-col">
                <span class="text-[10px] uppercase tracking-[0.2em] text-cyan-400 font-bold mb-0.5">Movelist </span>
                <h2 class="text-xl font-extrabold text-white tracking-tight">
                    Selamat Datang <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-indigo-400"><?= htmlspecialchars($_SESSION['username']) ?></span>
                </h2>
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <a href="profile.php" class="flex-1 sm:flex-none text-center text-[11px] font-semibold uppercase tracking-widest px-5 py-2.5 rounded-xl bg-slate-800/40 text-slate-300 border border-slate-800 hover:bg-slate-800 hover:text-white transition duration-300">
                    Profil
                </a>
                <a href="../auth/logout.php" class="flex-1 sm:flex-none text-center text-[11px] font-semibold uppercase tracking-widest px-5 py-2.5 rounded-xl bg-red-950/20 text-red-400 border border-red-900/30 hover:bg-red-900/50 hover:text-red-300 transition duration-300">
                    Logout
                </a>
            </div>
        </header>
    </div>

    <div class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-16 pt-32 sm:pt-40">

        <main class="mb-16">
            <div class="max-w-xl">
                <label class="block text-[11px] uppercase tracking-[0.15em] text-slate-500 font-bold mb-3">Pencarian Film</label>
                <form method="GET" class="flex gap-3 bg-slate-900/50 p-2 rounded-2xl border border-slate-800/80 focus-within:border-cyan-500/50 transition duration-300 mb-6">
                    <input 
                        type="text"
                        name="search"
                        placeholder="Ketik judul film atau serial..."
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
                        class="flex-1 border-none outline-none bg-transparent px-4 py-3 text-sm text-slate-200 placeholder-slate-600 focus:ring-0"
                        required>
                    <button type="submit" class="bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs uppercase tracking-wider px-6 rounded-xl transition duration-300 shadow-lg shadow-cyan-500/20">
                        Cari
                    </button>
                </form>

                <?php if($searchError): ?>
                    <div class="bg-gradient-to-r from-red-950/30 to-amber-950/20 border border-red-500/30 rounded-2xl p-4 flex gap-3.5 items-start animate-fade-in animate-[pulse_3s_infinite]">
                        <div class="p-2 rounded-xl bg-red-500/10 text-red-400 mt-0.5 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold uppercase tracking-wider text-red-400 mb-0.5">Film Tidak Ditemukan</span>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Sinema dengan kata kunci "<span class="text-slate-200 font-semibold"><?= htmlspecialchars($_GET['search']) ?></span>" gagal terdeteksi dalam arsip. Periksa kembali ejaan kata kunci Anda.
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </main>

        <?php if(isset($movies['Search']) && !$searchError): ?>
        
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-8">
                <h3 class="text-xs font-bold tracking-[0.2em] uppercase text-cyan-400">Hasil Pencarian</h3>
                <div class="h-[1px] bg-slate-800 flex-1"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <?php foreach($movies['Search'] as $movie): ?>
                    <?php
                    $poster = (!empty($movie['Poster']) && $movie['Poster'] != "N/A")
                        ? $movie['Poster']
                        : "https://via.placeholder.com/250x350";

                    $detail = getMovieDetail($movie['imdbID']);
                    $videoId = getTrailerVideoId($movie['Title']);
                    ?>

                    <div class="group bg-gradient-to-b from-slate-900/40 to-slate-950 rounded-3xl overflow-hidden border border-slate-900 flex flex-col hover:-translate-y-2 hover:border-slate-800 hover:shadow-2xl hover:shadow-cyan-500/5 transition duration-300">
                        <div class="w-full h-[400px] bg-slate-950 relative overflow-hidden">
                            <img src="<?= $poster ?>" alt="<?= htmlspecialchars($movie['Title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-80"></div>
                        </div>
                        <div class="p-6 flex flex-col flex-1 relative -mt-10 bg-gradient-to-b from-transparent via-slate-950 to-slate-950">
                            <h4 class="text-base font-bold text-white leading-snug mb-2 group-hover:text-cyan-400 transition duration-300"><?= htmlspecialchars($movie['Title']) ?></h4>
                            
                            <div class="text-[11px] text-slate-500 font-medium mb-4 flex flex-wrap gap-x-2 tracking-wide">
                                <span class="text-cyan-400/80 font-semibold"><?= $detail['Year'] ?? '-' ?></span>
                                <span class="text-slate-800">•</span>
                                <span class="line-clamp-1"><?= $detail['Actors'] ?? '-' ?></span>
                            </div>

                            <p class="text-xs text-slate-400 leading-relaxed mb-6 line-clamp-3">
                                <?= htmlspecialchars(substr($detail['Plot'] ?? '-', 0, 120)) ?>...
                            </p>

                            <?php if(!empty($videoId)): ?>
                                <div class="text-[11px] font-bold uppercase tracking-wider text-cyan-400 hover:text-cyan-300 cursor-pointer mb-6 inline-flex items-center gap-1.5 transition duration-200 hover:underline" onclick="openTrailer('<?= $videoId ?>')">
                                    Putar Cuplikan
                                </div>
                            <?php else: ?>
                                <div class="text-[11px] text-slate-600 font-medium tracking-wide uppercase mb-6">Cuplikan tidak tersedia</div>
                            <?php endif; ?>

                            <div class="mt-auto pt-4 border-t border-slate-900 flex">
                                <a class="w-full text-center text-xs font-bold uppercase tracking-wider py-3.5 px-4 rounded-xl bg-transparent hover:bg-white text-white hover:text-slate-950 border border-slate-800 hover:border-white transition duration-300" 
                                   href="add.php?title=<?= urlencode($movie['Title']) ?>&id=<?= $movie['imdbID'] ?>&poster=<?= urlencode($poster) ?>">
                                    Simpan Koleksi
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div>
            <div class="flex items-center gap-4 mb-8">
                <h3 class="text-xs font-bold tracking-[0.2em] uppercase text-slate-400">Daftar Tontonan</h3>
                <div class="h-[1px] bg-slate-800 flex-1"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <?php foreach($list as $item): ?>
                    <?php
                    $detail = getMovieDetail($item['imdbID']);
                    $poster = (!empty($item['poster']) && $item['poster'] != "N/A")
                        ? $item['poster']
                        : "https://via.placeholder.com/250x350";
                    $videoId = getTrailerVideoId($item['title']);
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

                            <p class="text-xs text-slate-400 leading-relaxed mb-6 line-clamp-8">
                                <?= htmlspecialchars($detail['Plot'] ?? '-') ?>
                            </p>

                            <?php if(!empty($item['note'])): ?>
                            <div class="bg-slate-900/60 border border-slate-800/80 p-3.5 rounded-xl text-xs text-slate-400 mb-6 leading-relaxed">
                                <span class="text-[10px] uppercase tracking-wider text-indigo-400 font-bold block mb-1">Memo</span>
                                <?= htmlspecialchars($item['note']) ?>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($videoId)): ?>
                                <div class="text-[11px] font-bold uppercase tracking-wider text-cyan-400 hover:text-cyan-300 cursor-pointer mb-6 inline-flex items-center gap-1.5 transition duration-200 hover:underline" onclick="openTrailer('<?= $videoId ?>')">
                                    Putar Cuplikan
                                </div>
                            <?php else: ?>
                                <div class="text-[11px] text-slate-600 font-medium tracking-wide uppercase mb-6">Cuplikan tidak tersedia</div>
                            <?php endif; ?>

                            <div class="mt-auto pt-4 border-t border-slate-900 flex gap-3">
                                <a class="flex-1 text-center text-xs font-bold uppercase tracking-wider py-2.5 px-3 rounded-xl border border-slate-800 text-slate-400 hover:bg-slate-800 hover:text-white transition duration-200" 
                                   href="edit.php?id=<?= $item['_id'] ?>">
                                    Ubah
                                </a>
                                <a class="flex-1 text-center text-xs font-bold uppercase tracking-wider py-2.5 px-3 rounded-xl border border-red-950/50 text-red-400 hover:bg-red-950/20 transition duration-200" 
                                   href="delete.php?id=<?= $item['_id'] ?>">
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <div id="trailerModal" class="hidden fixed inset-0 z-50 bg-black/90 backdrop-blur-md justify-center items-center p-4 sm:p-10">
        <div class="w-full max-w-4xl bg-black rounded-3xl overflow-hidden relative shadow-2xl shadow-black border border-slate-900">
            <button class="absolute -top-12 right-0 bg-transparent border-none text-slate-500 text-xs font-bold uppercase tracking-widest cursor-pointer hover:text-white transition" onclick="closeTrailer()">
                Tutup Dimensi
            </button>
            <iframe id="trailerFrame" src="" allowfullscreen class="w-full aspect-video border-none block"></iframe>
        </div>
    </div>

    <script>
    function openTrailer(videoId){
        const modal = document.getElementById('trailerModal');
        const frame = document.getElementById('trailerFrame');
        frame.src = "https://www.youtube.com/embed/" + videoId + "?autoplay=1";
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeTrailer(){
        const modal = document.getElementById('trailerModal');
        const frame = document.getElementById('trailerFrame');
        frame.src = "";
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    window.onclick = function(event){
        const modal = document.getElementById('trailerModal');
        if(event.target == modal){
            closeTrailer();
        }
    }
    </script>

</body>
</html>