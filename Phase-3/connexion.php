<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST["login"] ?? "";
    $mot_de_passe = $_POST["mot_de_passe"] ?? "";
$json = file_get_contents("data/utilisateurs.json");
$utilisateurs = json_decode(file_get_contents(__DIR__ . "/data/utilisateurs.json"), true);

    foreach ($utilisateurs as &$u) {
        if ($u["login"] === $login && $u["mot_de_passe"] === $mot_de_passe) {
            $_SESSION["login"] = $login;
            $_SESSION["role"] = $u["role"];
            $_SESSION["nom"] = $u["nom"];
            $u["derniere_connexion"] = date("Y-m-d");
            file_put_contents("data/utilisateurs.json", json_encode($utilisateurs, JSON_PRETTY_PRINT));
            header("Location: index.php");
            exit;
        }
    }
    $erreur = "Identifiants incorrects.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/form_validation.js" defer></script>
</head>
<body class="connexion-page">
    <div id="theme-toggle" style="position: fixed; top: 20px; right: 20px; z-index: 999;">
    <button onclick="toggleDarkMode()" id="dark-mode-btn">🌙 Mode sombre</button>
</div>
    <div class="connexion-container">
        <h1>Connexion</h1>

        <?php if (!empty($erreur)) echo "<p class='error'>" . htmlspecialchars($erreur) . "</p>"; ?>

        <form method="post">
            <label for="login">Login</label>
            <input type="text" id="login" name="login" required>

            <label for="mot_de_passe">Mot de passe</label>
            <div class="password-container">
                <input type="password" id="mot_de_passe" name="mot_de_passe" maxlength="20" required>
                <span class="toggle-password">👁 Afficher</span>
            </div>

            <span id="password-counter">0 / 20</span>
            <span class="error" id="mot_de_passe-error"></span>

            <button type="submit">Connexion</button>
        </form>
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
