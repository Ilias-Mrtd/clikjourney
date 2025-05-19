<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
    exit();
}
$id = $_GET['id'];
$voyages = json_decode(file_get_contents('data/voyages.json'), true);
$voyage = null;

foreach ($voyages as $v) {
    if ($v['id'] == $id) {
        $voyage = $v;
        break;
    }
}

if (!$voyage) {
    echo "Voyage non trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du voyage</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .etape { margin-bottom: 30px; }
        .etape h2 { color: #013220; margin-bottom: 10px; }
        .activite-grid, .hebergement-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .activite-card, .hebergement-item {
            width: 220px;
            background: #f4f4f4;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .activite-card img, .hebergement-item img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div id="theme-toggle" style="position: fixed; top: 20px; right: 20px; z-index: 999;">
    <button onclick="toggleDarkMode()" id="dark-mode-btn">🌙 Mode sombre</button>
</div>
<main class="detail-page">
    <div class="partial-screen-image">
        <img src="<?= $voyage['image']; ?>" alt="Image du voyage">
        <div class="image-title">
            <h1><?= htmlspecialchars($voyage['titre']); ?></h1>
        </div>
    </div>

    <section class="info-sections">
        <form id="reservationForm" method="POST" action="recapitulatif.php">
            <input type="hidden" name="voyage_id" value="<?= $voyage['id']; ?>">

            <div class="centered-title">Choisissez votre séjour</div>

            <label for="participants">Nombre de participants :</label>
            <input type="number" id="participants" name="participants" min="1" value="1" required>

            <div id="ages-container"></div>

            <label for="mois">Choisissez un mois :</label>
            <select name="mois" id="mois" onchange="updateDates()">
                <option value="05">Mai</option>
                <option value="06">Juin</option>
                <option value="07">Juillet</option>
                <option value="08">Août</option>
                <option value="09">Septembre</option>
                <option value="10">Octobre</option>
                <option value="11">Novembre</option>
                <option value="12">Décembre</option>
            </select>

            <div class="centered-title">Étapes</div>

            <?php foreach ($voyage['etapes'] as $index => $etape): ?>
                <div class="etape">
                    <h2><?= htmlspecialchars($etape['titre']) ?></h2>
                    <?php if (!empty($etape['description'])): ?>
                        <p><?= htmlspecialchars($etape['description']) ?></p>
                    <?php endif; ?>

                    <?php if (isset($etape['activites'])): ?>
                        <div class="activite-grid">
                            <?php foreach ($etape['activites'] as $activite): ?>
                                <div class="activite-card">
                                    <img src="<?= $activite['image']; ?>" alt="">
                                    <h3><?= htmlspecialchars($activite['titre']); ?></h3>
                                    <p><?= htmlspecialchars($activite['description']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($etape['hebergements'])): ?>
                        <div class="hebergement-grid">
                            <?php foreach ($etape['hebergements'] as $i => $hebergement): ?>
                                <div class="hebergement-item">
                                    <input type="radio" name="hebergement_<?= $index ?>" value="<?= $hebergement['prix'] ?>" id="heb<?= $index ?>_<?= $i ?>">
                                    <label for="heb<?= $index ?>_<?= $i ?>">
                                        <img src="<?= $hebergement['image']; ?>" alt="">
                                        <p><?= htmlspecialchars($hebergement['nom']); ?> - <?= $hebergement['prix']; ?> €</p>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <div style="margin-top: 20px;">
                <p>Total hébergements sélectionnés : <strong id="total-hebergement">0 €</strong></p>
            </div>

            <div class="centered-title">
                <p>Total : <span id="total"></span></p>
            </div>
            <div class="centered-title">
                <p id="date-sejour">Séjour du <span id="date-debut"></span> au <span id="date-fin"></span></p>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <button type="submit">Réserver</button>
            </div>

            <div class="prix-estime" style="margin-top: 20px;">
                <p>Prix de base : <?= $voyage['prix'] ?> €</p>
                <p>Total estimé : <strong id="total-estime">0 €</strong></p>
            </div>
        </form>
    </section>
</main>

<script>
function updateTotal() {
    const base = <?= $voyage['prix'] ?>;
    const participants = parseInt(document.getElementById("participants").value || 1);
    let supplement = 0;

    document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
        const prix = parseFloat(radio.value);
        if (!isNaN(prix)) supplement += prix;
    });

    const total = (base + supplement) * participants;
    document.getElementById("total").textContent = total + " €";
    document.getElementById("total-estime").textContent = total + " €";
    document.getElementById("total-hebergement").textContent = supplement + " €";
}

function updateDates() {
    const mois = document.getElementById('mois').value;
    const start = new Date(`2025-${mois}-01`);
    const end = new Date(start);
    end.setDate(start.getDate() + 6);

    const format = (date) => date.toISOString().split('T')[0];
    document.getElementById('date-debut').textContent = format(start);
    document.getElementById('date-fin').textContent = format(end);
}

function generateAgeFields() {
    const container = document.getElementById('ages-container');
    const nb = parseInt(document.getElementById('participants').value) || 1;
    container.innerHTML = '';
    for (let i = 1; i <= nb; i++) {
        const label = document.createElement('label');
        label.textContent = `Âge du participant ${i} :`;
        const input = document.createElement('input');
        input.type = 'number';
        input.name = 'ages[]';
        input.min = 0;
        input.required = true;
        input.style.marginBottom = '10px';
        container.appendChild(label);
        container.appendChild(input);
    }
}

document.getElementById('participants').addEventListener('input', () => {
    generateAgeFields();
    updateTotal();
});

document.addEventListener("DOMContentLoaded", () => {
    generateAgeFields();
    updateDates();
    updateTotal();

    document.querySelectorAll('input[type="radio"], #participants').forEach(el => {
        el.addEventListener("change", updateTotal);
    });
});

document.getElementById("reservationForm").addEventListener("submit", function(e) {
    document.querySelectorAll("input[name='hebergements[]']").forEach(el => el.remove());

    const form = this;
    const radios = form.querySelectorAll("input[type='radio']:checked");
    radios.forEach(radio => {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "hebergements[]";
        input.value = radio.value;
        form.appendChild(input);
    });
});
</script>
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