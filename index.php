<!DOCTYPE html>
<html>
<head>
    <title>Safco Delivery Records</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <style>
        .form-container {
            margin-bottom: 20px; /* Add margin to create space between form and table */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Safco Delivery Records</h1>

        <div class="form-container"> <!-- Container for the form -->
            <div class="form-group">
                <label for="productDescription">Product Description:</label>
                <select id="productDescription" class="form-control" multiple>
                    <option value="Product 1">Product 1</option>
                    <option value="Product 2">Product 2</option>
                    <option value="Product 3">Product 3</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="kg">KG:</label>
                    <input type="text" id="kg" class="form-control" placeholder="Enter KG">
                </div>
                <div class="form-group col-md-3">
                    <label for="qty">QTY:</label>
                    <input type="number" id="qty" class="form-control" placeholder="Enter QTY">
                </div>
                <div class="form-group col-md-3">
                    <label for="unitPrice">Unit Price (€):</label>
                    <input type="number" id="unitPrice" class="form-control" placeholder="Enter Unit Price">
                </div>
                <div class="form-group col-md-3">
                    <label for="total">Total (€):</label>
                    <input type="text" id="total" class="form-control" disabled>
                </div>
            </div>

            <button id="addItem" class="btn btn-primary">Add Item</button>
        </div>

        <table id="itemTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Product Description</th>
                    <th>KG</th>
                    <th>QTY</th>
                    <th>Unit Price (€)</th>
                    <th>Total (€)</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#itemTable').DataTable();

            // Event handler for the "Add Item" button
            $('#addItem').on('click', function() {
                // Get input values
                var productDescription = $('#productDescription').val();
                var kg = $('#kg').val();
                var qty = parseFloat($('#qty').val());
                var unitPrice = parseFloat($('#unitPrice').val());

                // Calculate total
                var total = qty * unitPrice;

                // Create a new item object
                var item = {
                    productDescription: productDescription.join(', '),
                    kg: kg,
                    qty: qty,
                    unitPrice: unitPrice,
                    total: total.toFixed(2) + ' €'
                };

                // Send the data to the server for saving
                $.ajax({
                    type: "POST",
                    url: "save_data.php", // PHP script for saving data
                    data: item,
                    success: function(response) {
                        console.log(response);
                        // Update the DataTable
                        updateTable();
                    }
                });
            });

            // Function to update the DataTable
            function updateTable() {
                $.ajax({
                    type: "GET",
                    url: "get_data.php", // PHP script for retrieving data
                    success: function(data) {
                        var items = JSON.parse(data);
                        // Clear the table
                        $('#itemTable').DataTable().clear().draw();
                        // Populate the table with saved items
                        items.forEach(function(item) {
                            $('#itemTable').DataTable().row.add([item.productDescription, item.kg, item.qty, item.unitPrice, item.total]).draw();
                        });
                    }
                });
            }

            // Initial table population
            updateTable();
        });
    </script>
</body>
</html>
