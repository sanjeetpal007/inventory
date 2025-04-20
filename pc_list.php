<?php
include 'auth.php';
include 'db.php';
checkAuth();

$pcs = $pdo->query("SELECT * FROM pc")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PC Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/html5-qrcode"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f9f9f9;
    }

    .form-container {
      
      top: 0;
      left: 0;
      right: 0;
      background: #fff;
      padding: 16px 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      z-index: 100;
    }

    .form-controls {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
    }

    .form-controls input,
    .form-controls select {
      padding: 6px;
      font-size: 14px;
    }

    .container {
      flex: 1;
      overflow-y: auto;
      margin-top: 2%;
      padding: 0 20px 40px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      margin-top: 10px;
    }

    th, td {
      padding: 8px;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: #f4f4f4;
      white-space: nowrap;
    }

    .pagination {
      display: flex;
      justify-content: flex-end;
      gap: 5px;
      margin-top: 15px;
    }

    .pagination button {
      padding: 8px 14px;
      border: none;
      background-color: #eee;
      cursor: pointer;
      border-radius: 6px;
      font-size: 14px;
    }

    .pagination button.active,
    .pagination button:hover {
      background-color: #4CAF50;
      color: white;
    }

    .btn {
      background-color: #4CAF50;
      color: white;
      padding: 8px 14px;
      text-decoration: none;
      border-radius: 6px;
      display: inline-block;
      font-size: 14px;
      border: none;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #45a049;
    }

    .btn-small {
      padding: 6px 10px;
    }

    .back-btn {
      display: flex;
      justify-content: flex-start;
      margin-top: 20px;
    }

    #qr-reader {
      margin-top: 10px;
      display: none;
      max-width: 300px;
    }
	/* Card UI for mobile */
    .pc-card {
      display: none;
      flex-direction: column;
      background: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 16px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
    }

    .pc-card div {
      margin-bottom: 6px;
    }

    .pc-card label {
      font-weight: bold;
    }
    @media (max-width: 768px) {
      table {
        display: none;
      }

      .form-controls {
        flex-direction: column;
        align-items: stretch;
      }

      .pagination {
        justify-content: center;
      }

      .back-btn {
        justify-content: center;
      }

      .pc-card {
        display: flex;
      }
    }
	
	
	
  </style>
</head>
<body>

<div class="form-container">
  <div class="form-controls">
    <a href="pc_add.php" class="btn">➕ Add New PC</a>
    <div>
      <label for="search">Search / Scan:</label>
      <div style="display: flex; gap: 6px; align-items: center;">
        <input type="text" id="search" placeholder="Scan or search anything...">
        <button id="scanBtn" class="btn btn-small" type="button">📷 Scan</button>
      </div>
    </div>
    <div>
      <label for="entries">Show</label>
      <select id="entries">
        <option value="5" selected>5</option>
        <option value="10" >10</option>
        <option value="25">25</option>
        <option value="50">50</option>
      </select>
      entries
    </div>
  </div>
</div>

<div class="container">
  <div id="qr-reader"></div>

  <table id="pcTable">
    <thead>
      <tr>
        <th>SN</th>
        <th>Vendor</th>
        <th>Invoice</th>
        <th>Model</th>
        <th>Serial</th>
        <th>Correct Serial</th>
        <th>Workstation</th>
        <th>Username</th>
        <th>Floor</th>
        <th>User ID</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <?php foreach ($pcs as $pc): ?>
        <tr data-row>
          <td><?= htmlspecialchars($pc['SN']) ?></td>
          <td><?= htmlspecialchars($pc['VENDOR_NAME']) ?></td>
          <td><?= htmlspecialchars($pc['INVOICE_NO']) ?></td>
          <td><?= htmlspecialchars($pc['DESKTOP_PC_MODEL']) ?></td>
          <td><?= htmlspecialchars($pc['PC_SERIAL_NUMBER']) ?></td>
          <td><?= htmlspecialchars($pc['CORRECT_SERIAL_NUMBER']) ?></td>
          <td><?= htmlspecialchars($pc['WORKSTATION']) ?></td>
          <td><?= htmlspecialchars($pc['USERNAME']) ?></td>
          <td><?= htmlspecialchars($pc['FLOOR_NUMBER']) ?></td>
          <td><?= htmlspecialchars($pc['USER_ID']) ?></td>
          <td>
            <a class="btn btn-small" href="pc_edit.php?id=<?= $pc['id'] ?>">Edit</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  
  <!-- Cards for small screens -->
  <div id="cardContainer">
    <?php foreach ($pcs as $pc): ?>
      <div class="pc-card" data-card>
        <div><label>SN:</label> <?= htmlspecialchars($pc['SN']) ?></div>
        <div><label>Vendor:</label> <?= htmlspecialchars($pc['VENDOR_NAME']) ?></div>
        <div><label>Invoice:</label> <?= htmlspecialchars($pc['INVOICE_NO']) ?></div>
        <div><label>Model:</label> <?= htmlspecialchars($pc['DESKTOP_PC_MODEL']) ?></div>
        <div><label>Serial:</label> <?= htmlspecialchars($pc['PC_SERIAL_NUMBER']) ?></div>
        <div><label>Correct Serial:</label> <?= htmlspecialchars($pc['CORRECT_SERIAL_NUMBER']) ?></div>
        <div><label>Workstation:</label> <?= htmlspecialchars($pc['WORKSTATION']) ?></div>
        <div><label>Username:</label> <?= htmlspecialchars($pc['USERNAME']) ?></div>
        <div><label>Floor:</label> <?= htmlspecialchars($pc['FLOOR_NUMBER']) ?></div>
        <div><label>User ID:</label> <?= htmlspecialchars($pc['USER_ID']) ?></div>
        <div><a class="btn btn-small" href="pc_edit.php?id=<?= $pc['id'] ?>">Edit</a></div>
      </div>
    <?php endforeach; ?>
  </div>

  <div id="pagination" class="pagination"></div>

  <div class="back-btn">
    <a href="dashboard.php" class="btn">⬅️ Back to Dashboard</a>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const table = document.getElementById('pcTable');
  const tbody = document.getElementById('tableBody');
  const allRows = Array.from(tbody.querySelectorAll('tr[data-row]')).map(row => row.cloneNode(true));
  const pagination = document.getElementById('pagination');
  const searchInput = document.getElementById('search');
  const entriesSelect = document.getElementById('entries');

  let currentPage = 1;
  let rowsPerPage = parseInt(entriesSelect.value);

  function filterRows() {
    const term = searchInput.value.toLowerCase();
    return allRows.filter(row =>
      Array.from(row.cells).some(cell =>
        cell.textContent.toLowerCase().includes(term)
      )
    );
  }

  function renderTable() {
    const filtered = filterRows();
    const start = (currentPage - 1) * rowsPerPage;
    const pageRows = filtered.slice(start, start + rowsPerPage);

    tbody.innerHTML = '';

    if (pageRows.length > 0) {
      pageRows.forEach(row => tbody.appendChild(row));
    } else {
      const noDataRow = document.createElement('tr');
      noDataRow.innerHTML = `<td colspan="11" style="text-align:center; padding: 20px; color: #999;">No results found.</td>`;
      tbody.appendChild(noDataRow);
    }

    renderPagination(filtered.length);
  }

  function renderPagination(total) {
    const pageCount = Math.ceil(total / rowsPerPage);
    pagination.innerHTML = '';

    if (pageCount <= 1) return;

    for (let i = 1; i <= pageCount; i++) {
      const btn = document.createElement('button');
      btn.textContent = i;
      btn.className = (i === currentPage) ? 'active' : '';
      btn.addEventListener('click', () => {
        currentPage = i;
        renderTable();
      });
      pagination.appendChild(btn);
    }
  }

  searchInput.addEventListener('input', () => {
    currentPage = 1;
    renderTable();
  });

  entriesSelect.addEventListener('change', () => {
    rowsPerPage = parseInt(entriesSelect.value);
    currentPage = 1;
    renderTable();
  });

  renderTable();

  // Barcode scanner logic
  const scanBtn = document.getElementById('scanBtn');
  const qrReader = document.getElementById('qr-reader');

  scanBtn.addEventListener('click', () => {
    qrReader.style.display = 'block';
    const html5QrCode = new Html5Qrcode("qr-reader");

    Html5Qrcode.getCameras().then(devices => {
      if (devices && devices.length) {
        html5QrCode.start(
          { facingMode: "environment" },
          { fps: 10, qrbox: 250 },
          scannedValue => {
            document.getElementById('search').value = scannedValue;
            currentPage = 1;
            renderTable();

            html5QrCode.stop();
            qrReader.style.display = 'none';
          },
          error => {
            // Ignore scanning errors
          }
        ).catch(err => {
          console.error("Camera start error:", err);
          alert("Could not start scanner. Please allow camera access.");
        });
      }
    }).catch(err => {
      console.error("Camera access error:", err);
      alert("Camera not found or access denied.");
    });
  });
});
</script>

</body>
</html>
