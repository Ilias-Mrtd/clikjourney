<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<p>Accès refusé. Réservé aux administrateurs.</p>";
    exit;
}

$utilisateursFile = __DIR__ . "/data/utilisateurs.json";
$utilisateurs = json_decode(file_get_contents($utilisateursFile), true);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Liste des utilisateurs</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/admin.js" defer></script>
</head>
<body class="admin-page">
    <div id="theme-toggle" style="position: fixed; top: 20px; right: 20px; z-index: 999;">
        <button onclick="toggleDarkMode()" id="dark-mode-btn">🌙 Mode sombre</button>
    </div>

    <div class="admin-container">
        <h1>Liste des utilisateurs</h1>
        <table>
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Nom</th>
                    <th>Rôle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['login']) ?></td>
                        <td><?= htmlspecialchars($user['nom']) ?></td>
                        <td>
                            <select class="role-select" data-login="<?= $user['login'] ?>">
                                <option value="utilisateur" <?= $user['role'] === 'utilisateur' ? 'selected' : '' ?>>Utilisateur</option>
                                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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