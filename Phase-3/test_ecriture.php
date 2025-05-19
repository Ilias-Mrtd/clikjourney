<?php
$fichier = "utilisateurs.json";

$donnees_test = [
    [
        "login" => "testuser",
        "mot_de_passe" => "pass",
        "role" => "utilisateur",
        "nom" => "Test User",
        "date_inscription" => date("Y-m-d"),
        "derniere_connexion" => date("Y-m-d"),
        "voyages" => []
    ]
];

// Tentative d'écriture
$resultat = file_put_contents($fichier, json_encode($donnees_test, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

if ($resultat) {
    echo "✅ Écriture réussie !";
} else {
    echo "❌ Échec de l'écriture dans utilisateurs.json";
}
