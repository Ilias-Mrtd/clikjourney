
document.addEventListener("DOMContentLoaded", () => {
    const selects = document.querySelectorAll(".role-select");

    selects.forEach(select => {
        select.addEventListener("change", () => {
            select.disabled = true;
            const login = select.dataset.login;
            const nouveauRole = select.value;

            console.log(`Modification simulée pour ${login} → ${nouveauRole}`);

            setTimeout(() => {
                select.disabled = false;
                alert(`Rôle de ${login} mis à jour (simulé) en ${nouveauRole}`);
            }, 3000);
        });
    });
});
