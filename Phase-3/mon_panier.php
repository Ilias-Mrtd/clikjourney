<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['supprimer'])) {
    $index = intval($_GET['supprimer']);
    if (isset($_SESSION['panier'][$index])) {
        unset($_SESSION['panier'][$index]);
        $_SESSION['panier'] = array_values($_SESSION['panier']); // réindexation
        header("Location: mon_panier.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon panier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="panier-page">
    <div id="theme-toggle" style="position: fixed; top: 20px; right: 20px; z-index: 999;">
    <button onclick="toggleDarkMode()" id="dark-mode-btn">🌙 Mode sombre</button>
</div>
    <div class="panier-container">
        <h1>🛒 Mon panier</h1>

        <?php if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])): ?>
            <ul>
                <?php foreach ($_SESSION['panier'] as $i => $voyage): ?>
                    <li>
                        <strong><?= htmlspecialchars($voyage['titre']) ?></strong><br>
                        Participants : <?= $voyage['participants'] ?><br>
                        Total : <?= $voyage['total'] ?> €<br>
                        Ajouté le : <?= $voyage['date'] ?><br><br>

                        <a class="payer" href="paiement.php?voyage_id=<?= $voyage['voyage_id'] ?>">💳 Payer</a>
                        <a class="supprimer" href="mon_panier.php?supprimer=<?= $i ?>">🗑 Supprimer</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Votre panier est vide.</p>
        <?php endif; ?>
    </div>
    <script>
function toggleDarkMode() {
    const body = document.body;
    body.classList.toggle('dark-mode');

    const mode = body.classList.contains('dark-mode') ? 'dark' : 'light';
    localStorage.setItem('theme', mode);
    updateThemeButton();
}

function updateThemeButton() {
    const isDark = document.body.classList.contains('dark-mode');
    const btn = document.getElementById('dark-mode-btn');
    if (btn) {
        btn.textContent = isDark ? '☀️ Mode clair' : '🌙 Mode sombre';
    }
}

window.addEventListener('DOMContentLoaded', () => {
    const saved = localStorage.getItem('theme');
    if (saved === 'dark') {
        document.body.classList.add('dark-mode');
    }
    updateThemeButton();
});
</script>
</body>
</html>