const csrfMetaName = document.querySelector('meta[name="csrf-token-name"]');
const csrfMetaHash = document.querySelector('meta[name="csrf-token"]');
const csrfName = csrfMetaName ? csrfMetaName.content : null;
let csrfHash = csrfMetaHash ? csrfMetaHash.content : null;

function updateCsrfToken(newHash) {
  if (!newHash) {
    return;
  }
  csrfHash = newHash;
  if (csrfMetaHash) {
    csrfMetaHash.setAttribute("content", newHash);
  }
}

function showToast(message, type = "success") {
  if (window.Swal && typeof window.Swal.fire === "function") {
    Swal.fire({
      icon: type === "error" ? "error" : "success",
      title: type === "error" ? "Error" : "Listo",
      text: message,
      toast: true,
      position: "top-end",
      timer: 4000,
      timerProgressBar: true,
      showConfirmButton: false,
      customClass: {
        popup: "swal2-toast-popup",
      },
    });
    return;
  }

  alert(message);
}

function attachMobileMenu() {
  const header = document.querySelector(".page-header");
  const toggle = document.querySelector(".nav-toggle");
  if (!header || !toggle) return;

  toggle.addEventListener("click", () => {
    const expanded = toggle.getAttribute("aria-expanded") === "true";
    toggle.setAttribute("aria-expanded", String(!expanded));
    header.classList.toggle("nav-open");
  });
}

async function postJson(url, payload) {
  const formData = new FormData();
  Object.entries(payload).forEach(([key, value]) => {
    formData.append(key, value);
  });
  if (csrfName && csrfHash) {
    formData.append(csrfName, csrfHash);
  }

  const response = await fetch(url, {
    method: "POST",
    credentials: "same-origin",
    body: formData,
  });

  return await response.json();
}

function collectPredictionData(matchId) {
  const homeInput = document.querySelector(
    `input[data-match-id='${matchId}'][data-side='home']`,
  );
  const awayInput = document.querySelector(
    `input[data-match-id='${matchId}'][data-side='away']`,
  );
  return {
    match_id: matchId,
    home_goals: homeInput ? homeInput.value : "",
    away_goals: awayInput ? awayInput.value : "",
  };
}

async function savePrediction(matchId) {
  const payload = collectPredictionData(matchId);
  if (payload.home_goals === "" || payload.away_goals === "") {
    showToast("Ingresa ambos valores para guardar el pronóstico.", "error");
    return;
  }

  const result = await postJson(
    `${window.APP_URL}guardar-pronosticos`,
    payload,
  );
  updateCsrfToken(result.csrf_hash);

  if (result.success) {
    showToast(result.message);
  } else {
    showToast(result.message, "error");
  }
}

async function saveAllPredictions() {
  const inputs = document.querySelectorAll(".prediction-input");
  const matchMap = {};
  inputs.forEach((input) => {
    const id = input.dataset.matchId;
    const side = input.dataset.side;
    matchMap[id] = matchMap[id] || {
      match_id: id,
      home_goals: "",
      away_goals: "",
    };
    matchMap[id][side === "home" ? "home_goals" : "away_goals"] = input.value;
  });

  for (const matchId in matchMap) {
    if (
      matchMap[matchId].home_goals === "" ||
      matchMap[matchId].away_goals === ""
    ) {
      continue;
    }
    await savePrediction(matchId);
  }
}

function attachPredictionListeners() {
  const inputs = document.querySelectorAll(".prediction-input");
  inputs.forEach((input) => {
    input.addEventListener("blur", (event) => {
      const matchId = event.target.dataset.matchId;
      if (matchId) {
        savePrediction(matchId);
      }
    });
  });

  const saveAllButton = document.getElementById("save-all");
  if (saveAllButton) {
    saveAllButton.addEventListener("click", async () => {
      saveAllButton.disabled = true;
      await saveAllPredictions();
      saveAllButton.disabled = false;
    });
  }
}

function startCountdownTimer() {
  const countdownEl = document.getElementById("countdown");
  if (!countdownEl) return;

  const targetValue = countdownEl.dataset.target;
  if (!targetValue) {
    countdownEl.textContent = "Próximamente disponible.";
    return;
  }

  const targetTime = Date.parse(targetValue);
  if (Number.isNaN(targetTime)) {
    countdownEl.textContent = "Próximamente disponible.";
    return;
  }

  const updateCountdown = () => {
    const diff = targetTime - Date.now();
    if (diff <= 0) {
      countdownEl.textContent =
        "La quiniela ya está abierta: puedes jugar ahora.";
      return;
    }

    const seconds = Math.floor(diff / 1000);
    const days = Math.floor(seconds / 86400);
    const hours = Math.floor((seconds % 86400) / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secs = seconds % 60;

    countdownEl.textContent = `Faltan ${days}d ${String(hours).padStart(2, "0")}h ${String(minutes).padStart(2, "0")}m ${String(secs).padStart(2, "0")}s`;
  };

  updateCountdown();
  const timerId = setInterval(() => {
    updateCountdown();
    if (Date.now() >= targetTime) {
      clearInterval(timerId);
    }
  }, 1000);
}

document.addEventListener("DOMContentLoaded", () => {
  attachPredictionListeners();
  attachMobileMenu();
  startCountdownTimer();
});
