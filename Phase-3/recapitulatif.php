<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_POST['voyage_id']) || !isset($_POST['participants'])) {
    echo "Données incomplètes.";
    exit;
}

$voyage_id = intval($_POST['voyage_id']);
$participants = intval($_POST['participants']);
$hebergements_selectionnes = $_POST['hebergements'] ?? [];

$voyages = json_decode(file_get_contents(__DIR__ . "/data/voyages.json"), true);
$voyage = null;
foreach ($voyages as $v) {
    if ($v['id'] == $voyage_id) {
        $voyage = $v;
        break;
    }
}

if (!$voyage) {
    echo "Voyage introuvable.";
    exit;
}

$prix_base = $voyage['prix'];
$supplement_hebergements = 0;

foreach ($hebergements_selectionnes as $prix) {
    $supplement_hebergements += floatval($prix);
}

$total = ($prix_base + $supplement_hebergements) * $participants;

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

$deja_ajoute = false;
foreach ($_SESSION['panier'] as $item) {
    if ($item['voyage_id'] == $voyage_id) {
        $deja_ajoute = true;
        break;
    }
}
if (!$deja_ajoute) {
    $_SESSION['panier'][] = [
        'voyage_id' => $voyage_id,
        'titre' => $voyage['titre'],
        'participants' => $participants,
        'total' => $total,
        'date' => date('Y-m-d H:i:s')
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Récapitulatif du voyage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="recap-ajout-page">
    <div class="recap-ajout-container">
        <h1>Récapitulatif du voyage : <?= htmlspecialchars($voyage['titre']) ?></h1>

        <p><strong>Nombre de participants :</strong> <?= $participants ?></p>
        <p><strong>Prix de base par personne :</strong> <?= $prix_base ?> €</p>
        <p><strong>Supplément hébergements :</strong> <?= $supplement_hebergements ?> €</p>
        <p><strong style="font-size:19px;">Total : <?= $total ?> €</strong></p>
        
        <div style="margin: 30px 0;">
            <a href="mon_panier.php" class="btn-lien">🛒 Voir mon panier</a>
            <a href="index.php" class="btn-lien">🏠 Accueil</a>
        </div>

        <form method="post" action="paiement.php" style="margin-top: 24px;">
            <input type="hidden" name="voyage_id" value="<?= $voyage_id ?>">
            <input type="hidden" name="participants" value="<?= $participants ?>">
            <button type="submit" class="btn-lien btn-payer">💳 Payer</button>
        </form>
    </div>
</body>
</html>