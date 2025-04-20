document.addEventListener("DOMContentLoaded", () => {
  // Toggle sidebar (if you have one)
  const toggleBtn = document.querySelector("#toggleSidebar");
  const sidebar = document.querySelector(".sidebar");

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed");
    });
  }

  // Show any dismissable alerts
  document.querySelectorAll(".alert .close").forEach(btn => {
    btn.addEventListener("click", () => {
      btn.parentElement.style.display = "none";
    });
  });
});
