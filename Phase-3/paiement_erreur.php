<?php
session_start();
unset($_SESSION['transaction']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement échoué - ClikJourney</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container error-page">
        <div class="error-icon" style="font-size:60px; color:#e53935; margin-bottom: 20px;">
            &#10060;
        </div>
        <h2>Erreur de paiement</h2>
        <p class="error-message">Nous n'avons pas pu traiter votre paiement.<br>
        Veuillez vérifier vos informations et réessayer.</p>
        
        <div class="error-details">
            <h3>Causes possibles :</h3>
            <ul>
                <li>Informations de carte bancaire incorrectes</li>
                <li>Numéro de carte invalide</li>
                <li>Date d'expiration dépassée</li>
                <li>Code de sécurité (CVV) incorrect</li>
                <li>Fonds insuffisants sur le compte</li>
                <li>Problème technique temporaire</li>
            </ul>
        </div>
        <div class="error-actions" style="margin-top:30px;">
            <?php if (isset($_SESSION['voyage_id'])): ?>
                <a href="paiement.php?voyage_id=<?= $_SESSION['voyage_id'] ?>" class="btn-retry">🔄 Réessayer le paiement</a>
                <a href="recapitulatif.php" class="btn-summary">⬅️ Retour au récapitulatif</a>
            <?php else: ?>
                <a href="index.php" class="btn-home">🏠 Retour à l'accueil</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>