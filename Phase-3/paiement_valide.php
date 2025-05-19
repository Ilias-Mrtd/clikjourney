<?php
session_start();

if (!isset($_SESSION['login']) || !isset($_SESSION['paiement'])) {
    header("Location: index.php");
    exit;
}

$paiement = $_SESSION['paiement'];

$commande = [
    "utilisateur" => $_SESSION['login'],
    "date" => date("Y-m-d H:i:s"),
    "transaction_id" => $paiement['transaction_id'] ?? 'inconnu',
    "voyage_id" => $paiement['voyage_id'] ?? 'inconnu',
    "montant" => $paiement['montant'] ?? 'inconnu',
    "statut" => $paiement['statut'] ?? 'accepté'
];

$fichier = __DIR__ . "/data/commandes.json";
$commandes = [];

if (file_exists($fichier)) {
    $contenu = file_get_contents($fichier);
    if (!empty($contenu)) {
        $commandes = json_decode($contenu, true) ?: [];
    }
}

$commandes[] = $commande;
file_put_contents($fichier, json_encode($commandes, JSON_PRETTY_PRINT));

unset($_SESSION['paiement']);
unset($_SESSION['transaction']);
unset($_SESSION['voyage_id']);

include_once 'includes/header.php';
?>

<div class="container">
    <div class="payment-success">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h2>Paiement accepté</h2>
        <p class="success-message">Votre réservation a été confirmée et votre paiement a été traité avec succès.</p>
        
        <div class="booking-details">
            <h3>Détails de votre réservation</h3>
            <p><strong>Référence de transaction :</strong> <?= htmlspecialchars($commande['transaction_id']) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($commande['date']) ?></p>
            <p><strong>Montant payé :</strong> <?= htmlspecialchars($commande['montant']) ?> €</p>
        </div>
        
        <div class="success-actions">
            <a href="profile.php" class="btn-profile">
                <i class="fas fa-user"></i> Accéder à mon profil
            </a>
            <a href="index.php" class="btn-home">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>