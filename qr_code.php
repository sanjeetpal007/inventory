<?php
// Include the PHP QR Code library
include('phpqrcode/qrlib.php');

// Define the path where the QR code will be saved
$qrFile = 'qrcodes_img/qrcode.png';

// Define the text or data that will be encoded into the QR code
$data = 'https://www.example.com';  // You can replace this with any data or URL

// Generate the QR code and save it as a PNG file
QRcode::png($data, $qrFile);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Custom Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
			
        }
        .qr-code-container {
            margin-bottom: 20px;
        }
		img
        /* Custom print styles */
        @media print {
            body {
                font-size: 12px;
				
            }
            button {
                display: none; /* Hide print button during print */
            }
            .qr-code-container {
                margin-top: 50px;
                page-break-before: always; /* Ensure the QR code starts on a new page */
            }
        }
    </style>
</head>
<body>

    <div class="qr-code-container">
        <h2>QR Code Example</h2>
    </div>

    <button onclick="customPrint()">Print QR Code</button>

    <script>
        function customPrint() {
            // Open a new window or frame to apply custom print styles
            const printWindow = window.open('', '', 'height=500,width=800');
            
            // Write the content for printing
            printWindow.document.write('<html><head><title>Print QR Code custom</title><style>');
            printWindow.document.write('body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; display:flex;}');
            printWindow.document.write('.qr-code-container { margin-bottom: 20px; }');
            printWindow.document.write('@media print { body { font-size: 12px; } button { display: none; } .qr-code-container { margin-top: 50px; } }');
            printWindow.document.write('</style></head><body>');
            //printWindow.document.write('<h2>QR Code </h2>');
            printWindow.document.write('<img src="' + '<?php echo $qrFile; ?>' + '" alt="QR Code"  style="align-content: left;width: 40%;height: 40%;"/>');
			printWindow.document.write('<H3 style="margin-top: 5%;width: 40%;font-size: 150%;">SERIAL NUMBER</h3>');
			printWindow.document.write('');
            printWindow.document.write('</body></html>');

            printWindow.document.close();  // Close the document to allow print
            printWindow.print();           // Trigger the print dialog
        }
    </script>

</body>

























<?php
$imagePath = 'qrcodes_img/qrcode.png'; // change this path as needed
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print QR Image</title>
</head>
<body style="text-align: center; font-family: Arial; margin-top: 50px;">

    <h2>Print QR Code</h2>
    <button onclick="printImage()">Print QR Code</button>

    <iframe id="printFrame" src="" style="display: none;"></iframe>

    <script>
        function printImage() {
            const imageURL = '<?php echo $imagePath; ?>';
            const printFrame = document.getElementById('printFrame');

            const doc = printFrame.contentWindow.document;
            doc.open();
            doc.write('<html><head><title>Print</title></head><body onload="window.print();window.close();" style="display:flex;">');
            doc.write('<img src="' + imageURL + '" style="width: 50%; height: 40%;">');
            doc.write('<h2 style="margin-top: 5%;width: 40%;font-size: 150%; margin-top: 10%;">SERIAL NUMBER</h2></body></html>');
            doc.close();
        }
    </script>




<h2 style="text-align:center;">Export All PCs to CSV</h2>

<div style="text-align:center;">
  <button onclick="downloadCSV()">Download CSV</button>
</div>

<script>
function downloadCSV() {
  window.location.href = 'export_all.php';
}
</script>










</body>











































<h2 style="text-align:center;">Export All PCs to CSV</h2>

<div style="text-align:center;">
  <button onclick="downloadCSV()">Download CSV</button>
</div>

<script>
function downloadCSV() {
  window.location.href = 'export_all.php';
}
</script>






</html>