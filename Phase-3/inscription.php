<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"] ?? "";
    $pseudo = $_POST["pseudo"] ?? "";
    $naissance = $_POST["naissance"] ?? "";
    $adresse = $_POST["adresse"] ?? "";
    $login = $_POST["login"] ?? "";
    $mot_de_passe = $_POST["mot_de_passe"] ?? "";
    $email = $_POST["email"] ?? "";

    if ($nom && $pseudo && $naissance && $adresse && $login && $mot_de_passe && $email) {
        $utilisateursFile = __DIR__ . "/data/utilisateurs.json";
        $utilisateurs = [];

        if (file_exists($utilisateursFile)) {
            $json = file_get_contents($utilisateursFile);
            $utilisateurs = json_decode($json, true);
        }

        $existeDeja = false;
        foreach ($utilisateurs as $u) {
            if ($u["login"] === $login) {
                $existeDeja = true;
                break;
            }
        }

        if (!$existeDeja) {
            $nouvelUtilisateur = [
                "login" => $login,
                "mot_de_passe" => $mot_de_passe,
                "role" => "utilisateur",
                "nom" => $nom,
                "pseudo" => $pseudo,
                "naissance" => $naissance,
                "adresse" => $adresse,
                "email" => $email,
                "date_inscription" => date("Y-m-d"),
                "derniere_connexion" => date("Y-m-d"),
                "voyages" => []
            ];
            $utilisateurs[] = $nouvelUtilisateur;
            file_put_contents($utilisateursFile, json_encode($utilisateurs, JSON_PRETTY_PRINT));
            header("Location: connexion.php");
            exit;
        } else {
            $erreur = "Ce login existe déjà.";
        }
    } else {
        $erreur = "Tous les champs sont requis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/form_validation.js" defer></script>
</head>
<body class="inscription-page">
    <div id="theme-toggle" style="position: fixed; top: 20px; right: 20px; z-index: 999;">
        <button onclick="toggleDarkMode()" id="dark-mode-btn">🌙 Mode sombre</button>
    </div>

    <div class="inscription-container">
        <h1>Inscription</h1>
        <?php if (!empty($erreur)) echo "<p class='error'>" . htmlspecialchars($erreur) . "</p>"; ?>

        <form method="post">
            <label for="nom">Nom complet</label>
            <input type="text" id="nom" name="nom" required>

            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" required>

            <label for="naissance">Date de naissance</label>
            <input type="date" id="naissance" name="naissance" required>

            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" maxlength="50" required>
            <span class="error" id="email-error"></span>

            <label for="login">Login</label>
            <input type="text" id="login" name="login" required>

            <label for="mot_de_passe">Mot de passe</label>
            <div class="password-container">
                <input type="password" id="mot_de_passe" name="mot_de_passe" maxlength="20" required>
                <span class="toggle-password">👁</span>
            </div>
            <span id="password-counter">0 / 20</span>
            <span class="error" id="mot_de_passe-error"></span>

            <button type="submit">Valider</button>
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