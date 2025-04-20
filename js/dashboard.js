document.addEventListener("DOMContentLoaded", () => {
  const chartCanvas = document.getElementById("statsChart");

  if (chartCanvas) {
    const ctx = chartCanvas.getContext("2d");

    const statsChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Laptops", "Desktops", "Monitors", "Keyboards", "Others"],
        datasets: [{
          label: "Inventory Count",
          data: [12, 19, 3, 5, 2],
          backgroundColor: "#007bff"
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        }
      }
    });
  }
});
