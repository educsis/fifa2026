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
  const container = document.getElementById("toast-container");
  if (!container) return;

  const toast = document.createElement("div");
  toast.className =
    "toast-card w-full max-w-sm rounded-3xl border border-white/10 bg-slate-950/95 p-4 text-sm text-slate-100 shadow-2xl shadow-slate-950/20";
  toast.innerHTML = `<div class="flex items-start justify-between gap-4 p4"><div class="flex items-center gap-3"><span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl ${type === "error" ? "bg-rose-500/15 text-rose-300" : "bg-emerald-400/15 text-emerald-300"}">${type === "error" ? "⚠️" : "✅"}</span><div><p class="font-semibold">${type === "error" ? "Error" : "Listo"}</p><p class="mt-1 text-slate-400">${message}</p></div></div><button class="text-slate-400 transition hover:text-white">×</button></div>`;
  container.appendChild(toast);

  const closeButton = toast.querySelector("button");
  closeButton.addEventListener("click", () => toast.remove());

  setTimeout(() => {
    toast.remove();
  }, 5500);
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
