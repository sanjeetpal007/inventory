document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("pcAddForm");

  if (form) {
    form.addEventListener("submit", function (e) {
      const requiredFields = [
        "VENDOR_NAME", "INVOICE_NO", "BILL_DATE", "SN", "OUTSTATION",
        "DESKTOP_PC_MODEL", "RAM_SIZE", "ROM_SIZE", "PC_SERIAL_NUMBER"
      ];

      let valid = true;
      let missingFields = [];

      requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (!field || field.value.trim() === "") {
          valid = false;
          missingFields.push(fieldId.replace(/_/g, ' '));
          field.classList.add("error");
        } else {
          field.classList.remove("error");
        }
      });

      if (!valid) {
        e.preventDefault();
        alert("Please fill in the following required fields:\n" + missingFields.join(", "));
      }
    });
  }
});
