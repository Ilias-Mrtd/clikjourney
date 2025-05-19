<?php
session_start();
require_once("getapikey.php");


if (!isset($_GET['transaction']) || !isset($_GET['montant']) || 
    !isset($_GET['vendeur']) || !isset($_GET['status']) || !isset($_GET['control'])) {
    echo "Paramètres manquants dans la redirection.";
    exit;
}

$transaction = $_GET['transaction'];
$montant = $_GET['montant'];
$vendeur = $_GET['vendeur'];
$status = $_GET['status'];
$control = $_GET['control'];

$api_key = getAPIKey($vendeur);

$expected_control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");

if ($control !== $expected_control) {
    echo "Erreur: Les données de retour ne sont pas valides.";
    exit;
}

if ($status === "accepted") {
    $_SESSION['paiement'] = [
        'transaction_id' => $transaction,
        'montant' => $montant,
        'voyage_id' => $_SESSION['voyage_id'] ?? 'inconnu',
        'date' => date("Y-m-d H:i:s"),
        'statut' => 'accepté'
    ];
    
    header("Location: paiement_valide.php");
    exit;
} else {
    header("Location: paiement_erreur.php");
    exit;
}
?>