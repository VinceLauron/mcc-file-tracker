<?php
if(!isset($_SESSION['login_id']))
header('location:login.php');
include 'db_connect.php';

// Fetch all requests
$result_all_requests = $conn->query("SELECT * FROM request ORDER BY date_created DESC");
$all_requests = [];
if ($result_all_requests) {
    while ($row = $result_all_requests->fetch_assoc()) {
        $all_requests[] = $row;
    }
} else {
    echo "Error retrieving all requests: " . $conn->error;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .container {
    width: 100%;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
    .card {
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .card h4 {
        margin: 0;
    }
    .card-body {
        padding: 15px;
    }
    .text-white {
        color: #fff;
    }
    .bg-success {
        background-color: #28a745;
    }
    .text-right {
        text-align: right;
    }
    table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    table-layout: fixed;
}

th, td {
    padding: 8px;
    text-align: left;
    word-wrap: break-word;
    white-space: normal;
    overflow-wrap: break-word;
    max-width: 200px;
}
    th {
        background-color: #f2f2f2;
    }
    .input-group {
        width: 100%;
        margin-bottom: 20px;
    }
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    .action-buttons button {
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        color: #fff;
        border-radius: 4px;
    }
    .view-btn {
        background-color: #007bff;
    }
    .print-btn {
        background-color: #28a745;
    }
    #pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }
    #pagination button {
        padding: 5px 10px;
        margin: 0 5px;
        cursor: pointer;
    }
    #pageDisplay {
        margin: 0 10px;
    }
</style>
<div class="container">
    <h2>All Requests</h2>
    <div class="row">
        <div class="col-lg-12">
            <div class="col-md-4 input-group ml-auto">
                <input type="text" class="form-control" id="search" aria-label="Search" aria-describedby="inputGroup-sizing-sm" placeholder="Search...">
                <div class="input-group-append">
                    <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
    <table id="requestsTable">
        <thead>
            <tr>
                <th>ID Number</th>
                <th>Full Name</th>
                <th>Contact</th>
                <th>Course</th>
                <th>Document Type</th>
                <th>Purpose</th>
                <th>Date Created</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($all_requests) > 0): ?>
                <?php foreach ($all_requests as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['id_number']); ?></td>
                        <td><?php echo htmlspecialchars($request['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($request['contact']); ?></td>
                        <td><?php echo htmlspecialchars($request['course']); ?></td>
                        <td><?php echo htmlspecialchars($request['docu_type']); ?></td>
                        <td><?php echo htmlspecialchars($request['purpose']); ?></td>
                        <td><?php echo htmlspecialchars($request['date_created']); ?></td>
                        <td><?php echo htmlspecialchars($request['status']); ?></td>
                        <td>
                            <div class="action-buttons">
                                <button class="view-btn" data-toggle="modal" data-target="#viewModal" onclick="setModalData(<?php echo htmlspecialchars(json_encode($request)); ?>)">View</button>
                                <button class="print-btn" onclick="printRequest(<?php echo htmlspecialchars(json_encode($request)); ?>)">Print</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No requests found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div id="pagination">
        <button class="btn-primary" id="prevPage" onclick="prevPage()">Previous</button>
        <span id="pageDisplay"></span>
        <button class="btn-primary" id="nextPage" onclick="nextPage()">Next</button>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">View Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <table class="table table-bordered">
        <tr>
            <th>ID Number</th>
            <td id="view-id-number" style="word-wrap: break-word;"></td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td id="view-fullname" style="word-wrap: break-word;"></td>
        </tr>
        <tr>
            <th>Contact</th>
            <td id="view-contact" style="word-wrap: break-word;"></td>
        </tr>
        <tr>
            <th>Course</th>
            <td id="view-course" style="word-wrap: break-word;"></td>
        </tr>
        <tr>
            <th>Document Type</th>
            <td id="view-docu-type" style="word-wrap: break-word;"></td>
        </tr>
        <tr>
            <th>Purpose</th>
            <td id="view-purpose" style="word-wrap: break-word;"></td>
        </tr>
        <tr>
            <th>Date Created</th>
            <td id="view-date-created" style="word-wrap: break-word;"></td>
        </tr>
        <tr>
            <th>Status</th>
            <td id="view-status" style="word-wrap: break-word;"></td>
        </tr>
    </table>
</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    let currentPage = 1;
    const rowsPerPage = 5;
    const table = document.getElementById('requestsTable');
    const rows = Array.from(table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'));

    function displayPage(page, filteredRows) {
        const rowsToDisplay = filteredRows || rows;
        const totalPages = Math.ceil(rowsToDisplay.length / rowsPerPage);

        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = 'none';
        }

        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        for (let i = start; i < end && i < rowsToDisplay.length; i++) {
            rowsToDisplay[i].style.display = '';
        }

        document.getElementById('pageDisplay').textContent = `Page ${page} of ${totalPages}`;
    }

    function updatePagination(filteredRows) {
        currentPage = 1;
        displayPage(currentPage, filteredRows);
    }

    function nextPage() {
        const filteredRows = getFilteredRows();
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

        if (currentPage < totalPages) {
            currentPage++;
            displayPage(currentPage, filteredRows);
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            displayPage(currentPage, getFilteredRows());
        }
    }

    function getFilteredRows() {
        const filter = document.getElementById('search').value.toLowerCase();
        return rows.filter(row => {
            const cells = Array.from(row.getElementsByTagName('td'));
            return cells.some(cell => cell.textContent.toLowerCase().includes(filter));
        });
    }

    document.getElementById('search').addEventListener('input', function () {
        const filteredRows = getFilteredRows();
        updatePagination(filteredRows);
    });

    function setModalData(request) {
        document.getElementById('view-id-number').textContent = request.id_number;
        document.getElementById('view-fullname').textContent = request.fullname;
        document.getElementById('view-contact').textContent = request.contact;
        document.getElementById('view-course').textContent = request.course;
        document.getElementById('view-docu-type').textContent = request.docu_type;
        document.getElementById('view-purpose').textContent = request.purpose;
        document.getElementById('view-date-created').textContent = request.date_created;
        document.getElementById('view-status').textContent = request.status;
    }

    function getDocumentFee(documentType) {
    // Define document fees
    const documentFees = {
        'TRANSCRIPT OF RECORDS': 150,  // Based on the notes table showing TOR fee is 150
        'GOOD MORAL CERTIFICATES': 0   // Good moral is free
    };
    
    return documentFees[documentType] || 0;
}

function printRequest(request) {
    let printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print Request</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 0; padding: 0; }');
    printWindow.document.write('.invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; line-height: 24px; color: #555; }');
    printWindow.document.write('.invoice-box table { width: 100%; line-height: inherit; text-align: left; }');
    printWindow.document.write('.invoice-box table td { padding: 5px; vertical-align: top; }');
    printWindow.document.write('.invoice-box table tr td:nth-child(2) { text-align: right; }');
    printWindow.document.write('.invoice-box table tr.top table td { padding-bottom: 20px; }');
    printWindow.document.write('.invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; }');
    printWindow.document.write('.invoice-box table tr.information table td { padding-bottom: 40px; }');
    printWindow.document.write('.invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }');
    printWindow.document.write('.invoice-box table tr.details td { padding-bottom: 20px; }');
    printWindow.document.write('.invoice-box table tr.item td { border-bottom: 1px solid #eee; }');
    printWindow.document.write('.invoice-box table tr.item.last td { border-bottom: none; }');
    printWindow.document.write('.invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }');
    printWindow.document.write('.fee-section { margin-top: 20px; border-top: 2px solid #eee; padding-top: 10px; }');
    printWindow.document.write('.fee-amount { font-size: 18px; font-weight: bold; color: #333; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');

    printWindow.document.write('<div class="invoice-box">');
    printWindow.document.write('<table cellpadding="0" cellspacing="0">');
    printWindow.document.write('<tr class="top">');
    printWindow.document.write('<td colspan="2">');
    printWindow.document.write('<table>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<td class="title">');
    printWindow.document.write('<img src="img/mcc1.png" style="width:100%; max-width:150px;">');
    printWindow.document.write('</td>');
    printWindow.document.write('<td>');
    printWindow.document.write('Date: ' + request.date_created + '<br>');
    printWindow.document.write('</td>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</table>');
    printWindow.document.write('</td>');
    printWindow.document.write('</tr>');

    printWindow.document.write('<tr class="information">');
    printWindow.document.write('<td colspan="2">');
    printWindow.document.write('<table>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<td>');
    printWindow.document.write('<strong>Full Name:</strong> ' + request.fullname + '<br>');
    printWindow.document.write('<strong>ID Number:</strong> ' + request.id_number + '<br>');
    printWindow.document.write('<strong>Contact:</strong> ' + request.contact + '<br>');
    printWindow.document.write('</td>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</table>');
    printWindow.document.write('</td>');
    printWindow.document.write('</tr>');

    printWindow.document.write('<tr class="heading">');
    printWindow.document.write('<td>Document Type</td>');
    printWindow.document.write('<td>Details</td>');
    printWindow.document.write('</tr>');

    printWindow.document.write('<tr class="item">');
    printWindow.document.write('<td>Course</td>');
    printWindow.document.write('<td>' + request.course + '</td>');
    printWindow.document.write('</tr>');

    printWindow.document.write('<tr class="item">');
    printWindow.document.write('<td>Document Type</td>');
    printWindow.document.write('<td>' + request.docu_type + '</td>');
    printWindow.document.write('</tr>');

    printWindow.document.write('<tr class="item">');
    printWindow.document.write('<td>Purpose</td>');
    printWindow.document.write('<td>' + request.purpose + '</td>');
    printWindow.document.write('</tr>');

    // Add document fee section
    const fee = getDocumentFee(request.docu_type);
    printWindow.document.write('<tr class="fee-section">');
    printWindow.document.write('<td><strong>Document Fee:</strong></td>');
    printWindow.document.write('<td class="fee-amount">₱' + fee.toFixed(2) + '</td>');
    printWindow.document.write('</tr>');

    printWindow.document.write('</table>');
    printWindow.document.write('</div>');

    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
    displayPage(currentPage);
</script>
