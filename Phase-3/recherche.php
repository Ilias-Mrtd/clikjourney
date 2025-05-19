<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche - Trip Tip</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="theme-toggle" style="position: fixed; top: 20px; right: 20px; z-index: 999;">
    <button onclick="toggleDarkMode()" id="dark-mode-btn">🌙 Mode sombre</button>
</div>
    <div id="search-bar" style="text-align: center; margin: 30px 0;">
    <input type="text" id="search-input" placeholder="🔍 Rechercher un voyage..." style="padding: 10px 20px; width: 300px; border-radius: 8px; border: 1px solid #ccc; font-size: 16px;">
</div>
    <div id="tri-options" style="text-align: center; margin: 30px;">
    <label for="tri-select" style="font-size: 18px; font-weight: bold;">Trier les voyages par :</label>
    <select id="tri-select" style="padding: 10px; margin-left: 10px; border-radius: 5px; font-size: 16px;">
        <option value="default">-- Aucun tri --</option>
        <option value="prix">Prix croissant</option>
        <option value="date">Date de départ</option>
        <option value="duree">Durée</option>
        <option value="etapes">Nombre d'étapes</option>
    </select>
</div>

    </header>
    <main>
        <section class="search-section">
    <div class="search-item" 
     data-prix="850" 
     data-date="2025-07-01" 
     data-duree="6" 
     data-etapes="2"
     style="background-image: url('101.jpg');">
    <a href="voyage_detail.php?id=101">
        <h2>Les majestueuses cascades d’Ouzoud</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="600" 
     data-date="2025-07-02" 
     data-duree="5" 
     data-etapes="2"
     style="background-image: url('102.jpg');">
    <a href="voyage_detail.php?id=102">
        <h2>Les plages paradisiaques de Saïdia</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="650" 
     data-date="2025-07-03" 
     data-duree="4" 
     data-etapes="2"
     style="background-image: url('103.jpg');">
    <a href="voyage_detail.php?id=103">
        <h2>Tous les chemins mènent à Casablanca</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="700" 
     data-date="2025-07-04" 
     data-duree="3" 
     data-etapes="2"
     style="background-image: url('104.jpg');">
    <a href="voyage_detail.php?id=104">
        <h2>La ville aux 1000 et une histoires - Fès</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="900" 
     data-date="2025-07-04" 
     data-duree="3" 
     data-etapes="2"
     style="background-image: url('105.jpg');">
    <a href="voyage_detail.php?id=105">
        <h2>L’incontournable océan de sable - Sahara</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="510" 
     data-date="2025-07-05" 
     data-duree="2" 
     data-etapes="1"
     style="background-image: url('106.jpg');">
    <a href="voyage_detail.php?id=106">
        <h2>Quand cimes enneigées et soleil flirtent - Oukaimeden</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="500" 
     data-date="2025-07-01" 
     data-duree="6" 
     data-etapes="2"
     style="background-image: url('107.jpg');">
    <a href="voyage_detail.php?id=107">
        <h2>La ville reflet du ciel - Chefchaouen</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="490" 
     data-date="2025-07-01" 
     data-duree="6" 
     data-etapes="2"
     style="background-image: url('108.jpg');">
    <a href="voyage_detail.php?id=108">
        <h2>Vestige d’éternité : la cité perdue de Volubilis</h2>
    </a>
    </div>
     <div class="search-item" 
     data-prix="800" 
     data-date="2025-07-01" 
     data-duree="6" 
     data-etapes="2"
     style="background-image: url('109.jpg');">
    <a href="voyage_detail.php?id=109">
        <h2>Essaouira – La perle de l’Atlantique</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="450" 
     data-date="2025-07-01" 
     data-duree="6" 
     data-etapes="2"
     style="background-image: url('110.jpg');">
    <a href="voyage_detail.php?id=110">
        <h2>Marrakech – L’ensorcelante ville rouge</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="590" 
     data-date="2025-07-01" 
     data-duree="6" 
     data-etapes="2"
     style="background-image: url('111.jpg');">
    <a href="voyage_detail.php?id=110">
        <h2>Tétouan – Entre tradition andalouse et Méditerranée</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="850" 
     data-date="2025-07-01" 
     data-duree="6" 
     data-etapes="2"
     style="background-image: url('112.jpg');">
    <a href="voyage_detail.php?id=112">
        <h2>Taroudant – La petite Marrakech</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="670" 
     data-date="2025-07-01" 
     data-duree="6" 
     data-etapes="2"
     style="background-image: url('113.jpg');">
    <a href="voyage_detail.php?id=113">
        <h2>Ifrane – La Suisse marocaine</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="870" 
     data-date="2025-07-01" 
     data-duree="6" 
     data-etapes="2"
     style="background-image: url('114.jpg');">
    <a href="voyage_detail.php?id=114">
        <h2>Dakhla – Entre désert et océan</h2>
    </a>
    </div>
    <div class="search-item" 
     data-prix="800" 
     data-date="2025-07-01" 
     data-duree="6" 
     data-etapes="2"
     style="background-image: url('115.jpg');">
    <a href="voyage_detail.php?id=115">
        <h2>Zagora – Aux portes du désert</h2>
    </a>
    </div>
</section>

    </main>
    <footer>
        <p>&copy; 2025 Trip Tip. Tous droits réservés.</p>
    </footer>
    <script>
document.getElementById("tri-select").addEventListener("change", function () {
    const critere = this.value;
    const voyages = Array.from(document.querySelectorAll(".search-item"));
    const container = document.querySelector(".search-section");

    if (critere === "default") return;

    const comparateurs = {
        prix: (a, b) => parseInt(a.dataset.prix) - parseInt(b.dataset.prix),
        date: (a, b) => new Date(a.dataset.date) - new Date(b.dataset.date),
        duree: (a, b) => parseInt(a.dataset.duree) - parseInt(b.dataset.duree),
        etapes: (a, b) => parseInt(a.dataset.etapes) - parseInt(b.dataset.etapes)
    };

    voyages.sort(comparateurs[critere]);
    voyages.forEach(v => container.appendChild(v));
});
</script>
<script>
document.getElementById("search-input").addEventListener("input", function () {
    const query = this.value.toLowerCase();
    const voyages = document.querySelectorAll(".search-item");

    voyages.forEach(voyage => {
        const titre = voyage.querySelector("h2").textContent.toLowerCase();
        if (titre.includes(query)) {
            voyage.style.display = "block";
        } else {
            voyage.style.display = "none";
        }
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