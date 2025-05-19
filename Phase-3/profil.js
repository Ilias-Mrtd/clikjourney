
document.addEventListener("DOMContentLoaded", () => {
    const boutonsModifier = document.querySelectorAll(".modifier-btn");
    const submitBtn = document.getElementById("submit-btn");
    let modifié = false;
    const valeursInitiales = {};

    boutonsModifier.forEach(btn => {
        const champ = btn.dataset.champ;
        const input = document.getElementById(champ);
        const validerBtn = document.querySelector(`.valider-btn[data-champ='${champ}']`);
        const annulerBtn = document.querySelector(`.annuler-btn[data-champ='${champ}']`);

        valeursInitiales[champ] = input.value;

        btn.addEventListener("click", () => {
            input.removeAttribute("readonly");
            btn.style.display = "none";
            validerBtn.style.display = "inline";
            annulerBtn.style.display = "inline";
        });

        validerBtn.addEventListener("click", () => {
            input.setAttribute("readonly", true);
            validerBtn.style.display = "none";
            annulerBtn.style.display = "none";
            btn.style.display = "inline";
            modifié = true;
            submitBtn.style.display = "block";
        });

        annulerBtn.addEventListener("click", () => {
            input.value = valeursInitiales[champ];
            input.setAttribute("readonly", true);
            validerBtn.style.display = "none";
            annulerBtn.style.display = "none";
            btn.style.display = "inline";
        });
    });
});
