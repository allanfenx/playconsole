const formEmail = document.getElementById("formEmail");
const submitButton = document.getElementById("button");
const heroActions = document.getElementById("googlePlay");
const headerDownloadBtn = document.getElementById("headerDownloadBtn");
const heroDownloadBtn = document.getElementById("heroDownloadBtn");
const ctaDownloadBtn = document.getElementById("ctaDownloadBtn");
const testerPageUrl = "https://play.google.com/apps/testing/com.allanfenx.finance";

function getApiBaseUrl() {
    return window.location.origin;
}

function openTesterPage() {
    const testerWindow = window.open(testerPageUrl, "_blank");

    if (testerWindow) {
        testerWindow.opener = null;
        return true;
    }

    return false;
}

function trackLead(origem) {
    if (typeof gtag !== "function") {
        return;
    }

    gtag("event", "gerar_lead", {
        method: "formulario_landing",
        origem: origem,
    });
}

function showSuccessState() {
    if (formEmail) {
        formEmail.classList.add("is-hidden");
    }

    if (heroActions) {
        heroActions.classList.add("is-visible");
    }

    if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = "Enviado";
    }

    if (headerDownloadBtn) {
        headerDownloadBtn.classList.remove("is-hidden");
        headerDownloadBtn.classList.add("is-visible");
    }

    if (heroDownloadBtn) {
        heroDownloadBtn.classList.remove("is-hidden");
        heroDownloadBtn.classList.add("is-visible");
    }

    if (ctaDownloadBtn) {
        ctaDownloadBtn.classList.remove("is-hidden");
        ctaDownloadBtn.classList.add("is-visible");
    }
}

function getApiErrorMessage(error) {
    const payload = error?.response?.data;

    if (typeof payload === "string" && payload.trim()) {
        return payload;
    }

    if (payload && typeof payload === "object") {
        if (typeof payload.message === "string" && payload.message.trim()) {
            return payload.message;
        }

        if (typeof payload.error === "string" && payload.error.trim()) {
            return payload.error;
        }
    }

    if (typeof error?.message === "string" && error.message.trim()) {
        return error.message;
    }

    return "Não foi possível enviar o e-mail. Tente novamente.";
}

if (formEmail && submitButton && heroActions) {
    formEmail.addEventListener("submit", async (event) => {
        event.preventDefault();

        const emailInput = formEmail.querySelector("input[type='email']");
        const email = emailInput?.value?.trim() || "";
        const isGmail = /^[^\s@]+@gmail\.com$/i.test(email);

        if (emailInput) {
            emailInput.setCustomValidity(isGmail ? "" : "Aceitamos apenas endereços @gmail.com.");

            if (!emailInput.reportValidity()) {
                return;
            }
        }

        if (!isGmail) {
            return;
        }

        submitButton.disabled = true;
        submitButton.textContent = "Enviando...";

        // Abre no mesmo clique do usuário. Depois do await o navegador bloqueia pop-up.
        openTesterPage();

        try {
            await axios.post(`${getApiBaseUrl()}/google.php`, { email });

            trackLead("novo_cadastro");
            showSuccessState();
        } catch (error) {
            const apiMessage = getApiErrorMessage(error);
            const statusCode = error?.response?.status;
            const isAlreadyRegistered = statusCode === 409 || /already exists/i.test(apiMessage);

            console.log("Error response: ", error.response);
            console.log("Error code: ", error.code);
            console.log("Error message: ", error.message);

            if (isAlreadyRegistered) {
                trackLead("ja_cadastrado");
                showSuccessState();
                return;
            }

            submitButton.disabled = false;
            submitButton.textContent = "Quero instalar";
            alert(apiMessage);
        }
    });
}
