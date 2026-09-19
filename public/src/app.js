const formEmail = document.getElementById("formEmail");
const submitButton = document.getElementById("button");
const heroActions = document.getElementById("googlePlay");
const headerDownloadBtn = document.getElementById("headerDownloadBtn");
const heroDownloadBtn = document.getElementById("heroDownloadBtn");
const ctaDownloadBtn = document.getElementById("ctaDownloadBtn");
const testerPageUrl = "https://play.google.com/apps/testing/com.allanfenx.finance";
const testerOpenDelayMs = 15000;

function getApiBaseUrl() {
    return window.location.origin;
}

function wait(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
}

function writeTesterWaitPage(testerWindow, title, detail) {
    if (!testerWindow || testerWindow.closed) {
        return;
    }

    testerWindow.document.open();
    testerWindow.document.write(`<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>${title}</title>
  <style>
    body { font-family: Inter, system-ui, sans-serif; margin: 0; min-height: 100vh; display: grid; place-items: center;
      background: #f8fafc; color: #0f172a; text-align: center; padding: 2rem; }
    p { color: #475569; max-width: 28rem; line-height: 1.5; }
  </style>
</head>
<body>
  <div>
    <h1>${title}</h1>
    <p>${detail}</p>
  </div>
</body>
</html>`);
    testerWindow.document.close();
}

function openBlankTesterWindow() {
    const testerWindow = window.open("about:blank", "_blank");

    if (testerWindow) {
        testerWindow.opener = null;
        writeTesterWaitPage(
            testerWindow,
            "Cadastrando seu e-mail…",
            "Estamos incluindo você no Google Group de testadores. A página da Play abre em seguida."
        );
    }

    return testerWindow;
}

async function goToTesterPage(testerWindow) {
    const totalSeconds = Math.ceil(testerOpenDelayMs / 1000);

    for (let remaining = totalSeconds; remaining > 0; remaining -= 1) {
        writeTesterWaitPage(
            testerWindow,
            "E-mail cadastrado no grupo",
            `O Google Play ainda está liberando sua conta. Abrindo o convite em ${remaining}s…`
        );
        await wait(1000);
    }

    if (testerWindow && !testerWindow.closed) {
        testerWindow.location.href = testerPageUrl;
    }
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

        // Abre no clique; o destino só vai depois do cadastro no Google Group.
        const testerWindow = openBlankTesterWindow();

        try {
            await axios.post(`${getApiBaseUrl()}/google.php`, { email });

            trackLead("novo_cadastro");
            await goToTesterPage(testerWindow);
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
                await goToTesterPage(testerWindow);
                showSuccessState();
                return;
            }

            if (testerWindow && !testerWindow.closed) {
                testerWindow.close();
            }

            submitButton.disabled = false;
            submitButton.textContent = "Quero instalar";
            alert(apiMessage);
        }
    });
}
