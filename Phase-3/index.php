<?php
session_start();
$voyages = json_decode(file_get_contents('data/voyages.json'), true);
$selection = array_slice($voyages, 0, 4);
?>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="admin.php" class="bouton-admin">🔒 Afficher les utilisateurs</a>
<?php endif; ?>

<?php if (isset($_SESSION['login'])): ?>
    <div style="position: fixed; top: 20px; left: 750px; z-index: 999;">
        <a href="mon_panier.php" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            🛒 Voir mon panier
        </a>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue sur Trip Tip</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="profil-section">
    <div id="theme-toggle" style="position: fixed; top: 20px; right: 20px; z-index: 999;">
    <button onclick="toggleDarkMode()" id="dark-mode-btn">🌙 Mode sombre</button>
</div>
    <div class="profil-bubble">
        <h1>Bienvenue sur Trip Tip 🌍</h1>
        <p>Découvrez nos voyages les plus populaires :</p>

        <ul>
            <?php foreach ($selection as $v): ?>
                <li>
                    <strong><?= htmlspecialchars($v['titre']) ?></strong><br>
                    Prix : <?= $v['prix'] ?> €<br>
                    <a href="voyage_detail.php?id=<?= $v['id'] ?>"><button>Voir ce voyage</button></a>
                </li>
            <?php endforeach; ?>
        </ul>

        <hr>

        <h2>🌐 Découvrir tous nos voyages</h2>
        <p>Envie d'encore plus de destinations ? Accédez à la liste complète de nos voyages organisés !</p>
        <a href="recherche.php"><button>Voir tous les voyages</button></a>

        <br><br>
        <?php if (isset($_SESSION['login'])): ?>
            <p>Connecté en tant que <?= htmlspecialchars($_SESSION['login']) ?> (<a href="profil.php">Profil</a> | <a href="deconnexion.php">Déconnexion</a>)</p>
        <?php else: ?>
            <p><a href="connexion.php">Se connecter</a> ou <a href="inscription.php">S'inscrire</a> pour réserver</p>
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