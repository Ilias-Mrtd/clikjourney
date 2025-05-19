<?php
session_start();
require_once("getapikey.php");

$voyage_id = $_GET['voyage_id'] ?? $_POST['voyage_id'] ?? null;

if (!$voyage_id) {
    echo "Aucun voyage sélectionné.";
    exit;
}

$_SESSION['voyage_id'] = $voyage_id;

$voyage_id = intval($voyage_id);
$voyages = json_decode(file_get_contents(__DIR__ . "/data/voyages.json"), true);

$voyage = null;
foreach ($voyages as $v) {
    if ($v['id'] === $voyage_id) {
        $voyage = $v;
        break;
    }
}

if (!$voyage) {
    echo "Voyage introuvable.";
    exit;
}

$transaction_id = uniqid();
$vendeur = "MIM-IMM"; // Code groupe
$montant = number_format($voyage['prix'], 2, '.', '');
$retour = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/retour_paiement.php";
$api_key = getAPIKey($vendeur);
$control = md5($api_key . "#" . $transaction_id . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");

$_SESSION['transaction'] = [
    'id' => $transaction_id,
    'voyage_id' => $voyage_id,
    'montant' => $montant
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement - ClikJourney</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Paiement pour <?= htmlspecialchars($voyage['titre']) ?></h1>
        <p>Du <?= htmlspecialchars($voyage['date_debut'] ?? '...') ?> au <?= htmlspecialchars($voyage['date_fin'] ?? '...') ?></p>
        <p>Montant : <strong><?= $montant ?> €</strong></p>

        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
            <input type="hidden" name="transaction" value="<?= $transaction_id ?>">
            <input type="hidden" name="montant" value="<?= $montant ?>">
            <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
            <input type="hidden" name="retour" value="<?= $retour ?>">
            <input type="hidden" name="control" value="<?= $control ?>">
            
            <button type="submit">Procéder au paiement</button>
        </form>
        <p><small>Vous allez être redirigé vers notre partenaire bancaire sécurisé.</small></p>
    </div>
</body>
</html>