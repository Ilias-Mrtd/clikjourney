
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("mot_de_passe");
    const passwordToggle = document.querySelector(".toggle-password");
    const emailError = document.getElementById("email-error");
    const passwordError = document.getElementById("mot_de_passe-error");
    const passwordCounter = document.getElementById("password-counter");

    if (!form) return;

    form.addEventListener("submit", (e) => {
        let isValid = true;

        if (!emailInput.value.includes("@")) {
            emailError.textContent = "Adresse email invalide.";
            isValid = false;
        } else {
            emailError.textContent = "";
        }

        if (passwordInput.value.length < 6) {
            passwordError.textContent = "Mot de passe trop court (min. 6 caractères)";
            isValid = false;
        } else {
            passwordError.textContent = "";
        }

        if (!isValid) e.preventDefault();
    });

    if (passwordInput && passwordCounter) {
        passwordInput.addEventListener("input", () => {
            const length = passwordInput.value.length;
            passwordCounter.textContent = `${length} / 20`;
        });
    }

    if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener("click", () => {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            passwordToggle.textContent = type === "password" ? "👁" : "🙈";
        });
    }
});
