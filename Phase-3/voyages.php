<?php
// Lecture des voyages
$voyages = json_decode(file_get_contents(__DIR__ . '/data/voyages.json'), true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Voyages - Trip Tip</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="profil-section">
    <div class="profil-bubble">
        <h1>Nos Voyages 🌍</h1>
        <?php if (empty($voyages)): ?>
            <p>Aucun voyage disponible pour le moment.</p>
        <?php else: ?>
            <ul style="list-style: none; padding: 0;">
    <?php foreach ($voyages as $v): ?>
        <li style="margin-bottom: 30px; border: 1px solid #ddd; padding: 15px; border-radius: 10px; background-color: #fff;">
            <img src="<?= htmlspecialchars($v['image']) ?>" alt="<?= htmlspecialchars($v['titre']) ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">
            <strong><?= htmlspecialchars($v['titre']) ?></strong><br>
            Dates : <?= $v['date_debut'] ?> → <?= $v['date_fin'] ?><br>
            Étapes : <?= $v['nb_etapes'] ?><br>
            Prix : <?= $v['prix'] ?> €<br><br>
            <a href="voyage_detail.php?id=<?= $v['id'] ?>">
                <button style="padding: 8px 15px; border: none; background-color: #2563eb; color: white; border-radius: 5px; cursor: pointer;">Voir ce voyage</button>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

        <?php endif; ?>
    </div>
</body>
</html>
