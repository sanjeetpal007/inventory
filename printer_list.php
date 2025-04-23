<?php
include 'auth.php';
include 'db.php';


require 'autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;















checkAuth();

$printers = $pdo->query("SELECT * FROM printer")->fetchAll(PDO::FETCH_ASSOC);

/**


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Export working!');

$writer = new Xlsx($spreadsheet);
$writer->save('test.xlsx');

echo "Excel file created.";






if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = 'printer';
    $stmt = $pdo->query("SELECT * FROM `$table`");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    if (count($rows) > 0) {
        // Add headers
        $headers = array_keys($rows[0]);
        $sheet->fromArray([$headers], NULL, 'A1');

        // Add rows
        $sheet->fromArray($rows, NULL, 'A2');
    }

    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$table.xlsx\"");
    header('Cache-Control: max-age=0');

    // Write to output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
**/






















?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Printer Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/html5-qrcode"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
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

    /* Card UI for mobile */
    .printer-card {
      display: none;
      flex-direction: column;
      background: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 16px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
    }

    .printer-card div {
      margin-bottom: 6px;
    }

    .printer-card label {
      font-weight: bold;
	  display: inline-block;
		width: 32%;
    }

    @media (max-width: 768px) {
      table {
        display: none;
      }
	#search{
		width:80%
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

      .printer-card {
        display: flex;
      }
    }
	/* Sorting styles */
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
    <a href="printer_add.php" class="btn">➕ Add New Printer</a>
    <div>
     
      <div style="display: flex; gap: 6px; align-items: center;">
        <input type="text" id="search" placeholder="Scan or search anything...">
        <button id="scanBtn" class="btn btn-small" type="button">📷 Scan</button>
      </div>
    </div>
	<div>
		<form action="printer_list.php" method="post">
			<button type="submit">Export to Excel</button>
		</form>
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    <div>
      <label for="entries">Show</label>
      <select id="entries">
        <option value="5" selected>5</option>
        <option value="10">10</option>
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
        <th class="sortable">Actions</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <?php foreach ($printers as $printer): ?>
        <tr data-row>
          <td><?= htmlspecialchars($printer['SN']) ?></td>
          <td><?= htmlspecialchars($printer['VENDOR_NAME']) ?></td>
          <td><?= htmlspecialchars($printer['INVOICE_NO']) ?></td>
          <td><?= htmlspecialchars($printer['PRINTER_MODEL']) ?></td>
          <td><?= htmlspecialchars($printer['PRINTER_SERIAL_NUMBER']) ?></td>
          <td><?= htmlspecialchars($printer['CORRECT_SERIAL_NUMBER']) ?></td>
          <td><?= htmlspecialchars($printer['WORKSTATION']) ?></td>
          <td><?= htmlspecialchars($printer['USER_NAME']) ?></td>
          <td><?= htmlspecialchars($printer['FLOOR_NUMBER']) ?></td>
          <td><?= htmlspecialchars($printer['USER_ID']) ?></td>
          <td><a class="btn btn-small" href="printer_edit.php?id=<?= $printer['id'] ?>">Edit</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Cards for small screens -->
  <div id="cardContainer">
    <?php foreach ($printers as $printer): ?>
      <div class="printer-card" data-card>
        <div><label>SN:</label> <?= htmlspecialchars($printer['SN']) ?></div>
        <div><label>Vendor:</label> <?= htmlspecialchars($printer['VENDOR_NAME']) ?></div>
        <div><label>Invoice:</label> <?= htmlspecialchars($printer['INVOICE_NO']) ?></div>
        <div><label>Model:</label> <?= htmlspecialchars($printer['PRINTER_MODEL']) ?></div>
        <div><label>Serial:</label> <?= htmlspecialchars($printer['PRINTER_SERIAL_NUMBER']) ?></div>
        <div><label>Correct Serial:</label> <?= htmlspecialchars($printer['CORRECT_SERIAL_NUMBER']) ?></div>
        <div><label>Workstation:</label> <?= htmlspecialchars($printer['WORKSTATION']) ?></div>
        <div><label>Username:</label> <?= htmlspecialchars($printer['USER_NAME']) ?></div>
        <div><label>Floor:</label> <?= htmlspecialchars($printer['FLOOR_NUMBER']) ?></div>
        <div><label>User ID:</label> <?= htmlspecialchars($printer['USER_ID']) ?></div>
        <div><a class="btn btn-small" href="printer_edit.php?id=<?= $printer['id'] ?>">Edit</a></div>
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
  const cardContainer = document.getElementById('cardContainer');
  const allRows = Array.from(tbody.querySelectorAll('tr[data-row]')).map(row => row.cloneNode(true));
  const allCards = Array.from(cardContainer.querySelectorAll('.printer-card')).map(card => card.cloneNode(true));
  const pagination = document.getElementById('pagination');
  const searchInput = document.getElementById('search');
  const entriesSelect = document.getElementById('entries');

  let currentPage = 1;
  let rowsPerPage = parseInt(entriesSelect.value);
  let currentSort = { index: null, direction: 'asc' };

  function filterContent(term) {
    return {
      rows: allRows.filter(row =>
        Array.from(row.cells).some(cell =>
          cell.textContent.toLowerCase().includes(term)
        )
      ),
      cards: allCards.filter(card =>
        card.textContent.toLowerCase().includes(term)
      )
    };
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

  function renderTable() {
    const term = searchInput.value.toLowerCase();
    const { rows: filteredRows, cards: filteredCards } = filterContent(term);

    const sortedRows = sortRows(filteredRows);
    const pageRows = sortedRows.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage);
    tbody.innerHTML = '';
    if (pageRows.length > 0) {
      pageRows.forEach(row => tbody.appendChild(row));
    } else {
      tbody.innerHTML = `<tr><td colspan="11" style="text-align:center; padding: 20px; color: #999;">No results found.</td></tr>`;
    }

    const pageCards = filteredCards.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage);
    cardContainer.innerHTML = '';
    if (pageCards.length > 0) {
      pageCards.forEach(card => cardContainer.appendChild(card));
    } else {
      cardContainer.innerHTML = `<div style="text-align:center; padding: 20px; color: #999;">No results found.</div>`;
    }

    renderPagination(filteredRows.length);
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

  document.querySelectorAll('#pcTable thead th.sortable').forEach((th, index) => {
    th.addEventListener('click', () => {
      const isSame = currentSort.index === index;
      currentSort.direction = isSame && currentSort.direction === 'asc' ? 'desc' : 'asc';
      currentSort.index = index;

      document.querySelectorAll('#pcTable thead th.sortable').forEach(h => h.classList.remove('asc', 'desc'));
      th.classList.add(currentSort.direction);

      renderTable();
    });
  });

  renderTable();

  // Barcode scanner
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
          error => {}
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
