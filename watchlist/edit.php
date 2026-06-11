<?php
require '../config/db.php';

$id = $_GET['id'] ?? '';

if(empty($id)) {
    header("Location: index.php");
    exit();
}

if(isset($_POST['update'])){
    $watchlist->updateOne(
        ["_id" => new MongoDB\BSON\ObjectId($id)],
        ['$set' => ["note" => $_POST['note']]]
    );

    header("Location: index.php");
    exit();
}

$item = $watchlist->findOne([
    "_id" => new MongoDB\BSON\ObjectId($id)
]);
?>

<!DOCTYPE html>
<html lang="en" class="bg-slate-950 text-slate-100 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Catatan - Watchlist Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-900 via-slate-950 to-black flex flex-col justify-between p-4">

    <header class="w-full max-w-7xl mx-auto px-6 sm:px-12 lg:px-16 py-6 flex justify-between items-center z-10 relative">
        <div class="flex flex-col">
            <span class="text-[9px] uppercase tracking-[0.25em] text-cyan-400 font-extrabold mb-0.5">@MOVELIST Note</span>
        </div>
    </header>

    <div class="w-full max-w-md bg-slate-900/40 backdrop-blur-xl border border-slate-900 rounded-3xl p-8 sm:p-10 shadow-2xl shadow-indigo-500/5 relative overflow-hidden mx-auto my-auto">
        
        <div class="absolute -right-20 -top-20 w-40 h-40 bg-indigo-500/10 blur-3xl rounded-full pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-40 h-40 bg-cyan-500/10 blur-3xl rounded-full pointer-events-none"></div>

        <div class="mb-8">
            <span class="text-[10px] uppercase tracking-[0.2em] text-indigo-400 font-bold mb-1 block">MoveList</span>
            <h2 class="text-2xl font-extrabold text-white tracking-tight">
                Edit <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Catatan</span>
            </h2>
        </div>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-[10px] uppercase tracking-wider text-slate-500 font-bold mb-2">Masukan Catatan Film</label>
                <input 
                    type="text" 
                    name="note" 
                    value="<?= htmlspecialchars($item['note'] ?? '') ?>" 
                    placeholder="Tulis opini atau catatan pengingat di sini..." 
                    class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-slate-200 placeholder-slate-700 outline-none focus:border-indigo-500/50 transition duration-300"
                    required>
            </div>

            <button 
                name="update" 
                class="w-full bg-gradient-to-r from-indigo-500 to-cyan-500 hover:from-indigo-400 hover:to-cyan-400 text-slate-950 font-bold text-xs uppercase tracking-widest py-4 rounded-xl transition duration-300 shadow-lg shadow-indigo-500/10 active:scale-[0.98]">
                Simpan Perubahan
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-xs text-slate-500 font-medium tracking-wide">
                Batal mengubah? 
                <a href="index.php" class="text-indigo-400 hover:text-indigo-300 font-bold underline underline-offset-4 decoration-slate-800 hover:decoration-indigo-400/50 hover:drop-shadow-[0_0_6px_rgba(129,140,248,0.6)] transition duration-300 ml-1">
                    Kembali ke Watchlist
                </a>
            </p>
        </div>

    </div>

    <div class="w-full py-6 invisible"></div>

</body>
</html>

```