// Script de interacción mínima: alternar tabs (sin dependencias)

const tabLogin = document.getElementById("tab-login");
const tabRegister = document.getElementById("tab-register");
const panelLogin = document.getElementById("panel-login");
const panelRegister = document.getElementById("panel-register");

function showLogin() {
  tabLogin.classList.add("bg-white", "text-sky-700", "shadow-sm");
  tabLogin.classList.remove("text-gray-600");
  tabRegister.classList.remove("bg-white", "text-sky-700", "shadow-sm");
  tabRegister.classList.add("text-gray-600");
  panelLogin.classList.remove("hidden");
  panelRegister.classList.add("hidden");
}

function showRegister() {
  tabRegister.classList.add("bg-white", "text-sky-700", "shadow-sm");
  tabRegister.classList.remove("text-gray-600");
  tabLogin.classList.remove("bg-white", "text-sky-700", "shadow-sm");
  tabLogin.classList.add("text-gray-600");
  panelRegister.classList.remove("hidden");
  panelLogin.classList.add("hidden");
}

tabLogin.addEventListener("click", showLogin);
tabRegister.addEventListener("click", showRegister);

// Inicial: login visible
showLogin();
