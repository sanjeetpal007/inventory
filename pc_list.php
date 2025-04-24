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
    /* Your existing styles remain mostly the same */
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
      flex-wrap: wrap;
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
      padding: 8px 10px;
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
      display: inline-block;
      width: 32%;
    }

    @media (max-width: 768px) {
      table {
        display: none;
      }
      #search {
        width: 80%;
      }
      .form-controls {
        flex-direction: column;
        align-items: stretch;
      }
      .back-btn {
        justify-content: center;
      }
      .pc-card {
        display: flex;
      }
    }

    th.sortable {
      cursor: pointer;
      position: relative;
    }

    th.sortable::after {
      content: '';
      position: absolute;
      right: 8px;
      font-size: 12px;
    }

    th.sortable.asc::after {
      content: ' ▲';
    }

    th.sortable.desc::after {
      content: ' ▼';
    }
  </style>
</head>
<body>

<div class="form-container">
  <div class="form-controls">
    <a href="pc_add.php" class="btn">➕ Add New PC</a>
    <div>
      <div style="display: flex; gap: 6px; align-items: center;">
        <input type="text" id="search" placeholder="Scan or search anything...">
        <button id="scanBtn" class="btn btn-small" type="button">📷 Scan</button>
      </div>
    </div>
    <div>
      <label for="entries">Show</label>
      <select id="entries">
        <option value="5" >5</option>
        <option value="10"selected>10</option>
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
        <th class="sortable">SN</th>
        <th class="sortable">Vendor</th>
        <th class="sortable">Invoice</th>
        <th class="sortable">Model</th>
        <th class="sortable">Serial</th>
        <th class="sortable">Correct Serial</th>
        <th class="sortable">Workstation</th>
        <th class="sortable">Username</th>
        <th class="sortable">Floor</th>
        <th class="sortable">User ID</th>
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
          <td><a class="btn btn-small" href="pc_edit.php?id=<?= $pc['ID'] ?>">Edit</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

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
	<a class="btn"onclick="downloadCSV()" style="margin-left: 10px;">Download CSV</a>
  </div>
</div>

<script>
function downloadCSV() {
  window.location.href = 'export_all_pc.php';
}
document.addEventListener('DOMContentLoaded', function () {
  const tableBody = document.getElementById('tableBody');
  const allRows = Array.from(tableBody.querySelectorAll('tr[data-row]')).map(row => row.cloneNode(true));
  const cardContainer = document.getElementById('cardContainer');
  const allCards = Array.from(cardContainer.querySelectorAll('.pc-card')).map(card => card.cloneNode(true));
  const searchInput = document.getElementById('search');
  const entriesSelect = document.getElementById('entries');
  const pagination = document.getElementById('pagination');

  let currentPage = 1;
  let rowsPerPage = parseInt(entriesSelect.value);
  let currentSort = { index: null, direction: 'asc' };

  function getFiltered(rowsOrCards) {
    const term = searchInput.value.toLowerCase();
    return rowsOrCards.filter(el =>
      el.textContent.toLowerCase().includes(term)
    );
  }

  function sortRows(rows) {
    const { index, direction } = currentSort;
    if (index === null) return rows;

    return rows.sort((a, b) => {
      const valA = a.cells[index].textContent.trim().toLowerCase();
      const valB = b.cells[index].textContent.trim().toLowerCase();
      const numA = parseFloat(valA), numB = parseFloat(valB);
      const isNumeric = !isNaN(numA) && !isNaN(numB);
      let cmp = isNumeric ? numA - numB : valA.localeCompare(valB);
      return direction === 'asc' ? cmp : -cmp;
    });
  }

  function renderTableAndCards() {
    const filteredRows = getFiltered(allRows);
    const sortedRows = sortRows(filteredRows);
    const start = (currentPage - 1) * rowsPerPage;
    const paginatedRows = sortedRows.slice(start, start + rowsPerPage);

    tableBody.innerHTML = '';
    if (paginatedRows.length) {
      paginatedRows.forEach(row => tableBody.appendChild(row));
    } else {
      tableBody.innerHTML = `<tr><td colspan="11" style="text-align:center; padding: 20px; color: #999;">No results found.</td></tr>`;
    }

    // Cards (mobile)
    const filteredCards = getFiltered(allCards);
    const paginatedCards = filteredCards.slice(start, start + rowsPerPage);
    cardContainer.innerHTML = '';
    paginatedCards.forEach(card => cardContainer.appendChild(card));

    renderPagination(Math.ceil(filteredRows.length / rowsPerPage));
  }

function renderPagination(totalPages) {
  pagination.innerHTML = '';
  if (totalPages <= 1) return;

  const before = 3;
  const after = 4;
  const startPage = Math.max(2, currentPage - before); // start from 2 to avoid duplicate first page
  const endPage = Math.min(totalPages - 1, currentPage + after); // end at totalPages - 1 to avoid duplicate last page

  // First Page
  const firstBtn = document.createElement('button');
  firstBtn.textContent = '1';
  firstBtn.className = (currentPage === 1) ? 'active' : '';
  firstBtn.onclick = () => {
    currentPage = 1;
    renderTableAndCards();
  };
  pagination.appendChild(firstBtn);

  // Dots after first page if needed
  if (startPage > 2) {
    const dots = document.createElement('span');
    dots.textContent = '...';
    dots.style.padding = '8px';
    pagination.appendChild(dots);
  }

  // Page range
  for (let i = startPage; i <= endPage; i++) {
    const btn = document.createElement('button');
    btn.textContent = i;
    btn.className = (i === currentPage) ? 'active' : '';
    btn.onclick = () => {
      currentPage = i;
      renderTableAndCards();
    };
    pagination.appendChild(btn);
  }

  // Dots before last page if needed
  if (endPage < totalPages - 1) {
    const dots = document.createElement('span');
    dots.textContent = '...';
    dots.style.padding = '8px';
    pagination.appendChild(dots);
  }

  // Last Page
  const lastBtn = document.createElement('button');
  lastBtn.textContent = totalPages;
  lastBtn.className = (currentPage === totalPages) ? 'active' : '';
  lastBtn.onclick = () => {
    currentPage = totalPages;
    renderTableAndCards();
  };
  pagination.appendChild(lastBtn);
}




  searchInput.addEventListener('input', () => {
    currentPage = 1;
    renderTableAndCards();
  });

  entriesSelect.addEventListener('change', () => {
    rowsPerPage = parseInt(entriesSelect.value);
    currentPage = 1;
    renderTableAndCards();
  });

  document.querySelectorAll('#pcTable thead th.sortable').forEach((th, index) => {
    th.addEventListener('click', () => {
      const isSame = currentSort.index === index;
      currentSort.direction = isSame && currentSort.direction === 'asc' ? 'desc' : 'asc';
      currentSort.index = index;
      document.querySelectorAll('#pcTable thead th.sortable').forEach(h => h.classList.remove('asc', 'desc'));
      th.classList.add(currentSort.direction);
      renderTableAndCards();
    });
  });

  renderTableAndCards();

  // Barcode Scanner
  const scanBtn = document.getElementById('scanBtn');
  const qrReader = document.getElementById('qr-reader');

  scanBtn.addEventListener('click', () => {
    qrReader.style.display = 'block';
    const html5QrCode = new Html5Qrcode("qr-reader");

    Html5Qrcode.getCameras().then(devices => {
      if (devices.length) {
        html5QrCode.start(
          { facingMode: "environment" },
          { fps: 10, qrbox: 250 },
          scannedValue => {
            searchInput.value = scannedValue;
            currentPage = 1;
            renderTableAndCards();
            html5QrCode.stop();
            qrReader.style.display = 'none';
          }
        ).catch(err => alert("Failed to start camera"));
      }
    }).catch(() => alert("Camera access denied"));
  });
});
</script>
</body>
</html>
