// =========================
// LOAD SAVED THEME
// =========================
document.addEventListener("DOMContentLoaded", () => {

    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "light") {
        document.body.classList.add("light-mode");
    }

    updateIcon();
});

// =========================
// TOGGLE FUNCTION
// =========================
function toggleTheme() {

    document.body.classList.toggle("light-mode");

    if (document.body.classList.contains("light-mode")) {
        localStorage.setItem("theme", "light");
    } else {
        localStorage.setItem("theme", "dark");
    }

    updateIcon();
}

// =========================
// UPDATE ICON
// =========================
function updateIcon() {

    const btn = document.getElementById("themeToggle");

    if (!btn) return;

    if (document.body.classList.contains("light-mode")) {
        btn.innerText = "☀️";
    } else {
        btn.innerText = "🌙";
    }
}