<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: connexion.php");
    exit();
}

$login = $_SESSION["login"];
$utilisateursFile = __DIR__ . "/data/utilisateurs.json";
$utilisateurs = json_decode(file_get_contents($utilisateursFile), true);

$utilisateur = null;
foreach ($utilisateurs as &$u) {
    if ($u["login"] === $login) {
        $utilisateur = &$u;
        break;
    }
}

if (!$utilisateur) {
    echo "<p style='color:red;'>Utilisateur non trouvé.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach (["nom", "email", "pseudo", "naissance", "adresse"] as $champ) {
        if (isset($_POST[$champ])) {
            $utilisateur[$champ] = $_POST[$champ];
        }
    }

    $utilisateur["derniere_connexion"] = date("Y-m-d");
    file_put_contents($utilisateursFile, json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: profil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil utilisateur</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/profil.js" defer></script>
</head>
<body class="profil-fixed-page">
    <div id="theme-toggle">
        <button onclick="toggleDarkMode()" id="dark-mode-btn">🌙 Mode sombre</button>
    </div>

    <header class="header-profil">
        <h1>Mon profil utilisateur</h1>
    </header>

    <main class="profil-section">
        <div class="profil-bubble">
            <h2>Informations personnelles</h2>
            <form method="post" action="profil.php">
                <?php
                $champs = [
                    "nom" => "Nom",
                    "pseudo" => "Pseudo",
                    "naissance" => "Date de naissance",
                    "adresse" => "Adresse",
                    "email" => "Email"
                ];
                foreach ($champs as $key => $label): ?>
                    <div class="champ-modifiable">
                        <label for="<?= $key ?>"><?= $label ?> :</label>
                        <input type="<?= $key === 'email' ? 'email' : 'text' ?>" 
                               id="<?= $key ?>" name="<?= $key ?>" 
                               value="<?= htmlspecialchars($utilisateur[$key] ?? '') ?>" 
                               readonly>
                        <button type="button" class="modifier-btn" data-champ="<?= $key ?>">🖊</button>
                        <button type="button" class="valider-btn" data-champ="<?= $key ?>" style="display:none;">✅</button>
                        <button type="button" class="annuler-btn" data-champ="<?= $key ?>" style="display:none;">❌</button>
                    </div>
                <?php endforeach; ?>

                <button id="submit-btn" type="submit" style="display:none;">Soumettre les modifications</button>
            </form>
        </div>
    </main>

    <footer>
        <p>© 2025 - ClickJourney</p>
    </footer>

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
        btn.textContent = isDark ? '☀️ Mode clair' : '🌙 Mode sombre';
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