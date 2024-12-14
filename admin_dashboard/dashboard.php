<?php 

include('db.php');

// Fetch sales data
$sql_today = "SELECT SUM(amount) AS total_sales FROM sales WHERE DATE(sale_date) = CURDATE()";
$stmt_today = $pdo->query($sql_today);
$sales_today = $stmt_today->fetch(PDO::FETCH_ASSOC)['total_sales'] ?? 0;

$sql_yesterday = "SELECT SUM(amount) AS total_sales FROM sales WHERE DATE(sale_date) = CURDATE() - INTERVAL 1 DAY";
$stmt_yesterday = $pdo->query($sql_yesterday);
$sales_yesterday = $stmt_yesterday->fetch(PDO::FETCH_ASSOC)['total_sales'] ?? 0;

$sql_this_year = "SELECT SUM(amount) AS total_sales FROM sales WHERE YEAR(sale_date) = YEAR(CURDATE())";
$stmt_this_year = $pdo->query($sql_this_year);
$sales_this_year = $stmt_this_year->fetch(PDO::FETCH_ASSOC)['total_sales'] ?? 0;

$sql_last_year = "SELECT SUM(amount) AS total_sales FROM sales WHERE YEAR(sale_date) = YEAR(CURDATE()) - 1";
$stmt_last_year = $pdo->query($sql_last_year);
$sales_last_year = $stmt_last_year->fetch(PDO::FETCH_ASSOC)['total_sales'] ?? 0;

// Fetch inventory data
$sql_inventory_value = "SELECT SUM(price * stock_quantity) AS total_inventory_value FROM inventory"; 
$stmt_inventory_value = $pdo->query($sql_inventory_value);
$inventory_value = $stmt_inventory_value->fetch(PDO::FETCH_ASSOC)['total_inventory_value'] ?? 0;

$sql_items_in_stock = "SELECT SUM(stock_quantity) AS total_items_in_stock FROM inventory"; 
$stmt_items_in_stock = $pdo->query($sql_items_in_stock);
$items_in_stock = $stmt_items_in_stock->fetch(PDO::FETCH_ASSOC)['total_items_in_stock'] ?? 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #d3d3d3, #a9a9a9); /* Gradient from light gray to darker gray */
        }
        .dashboard-header {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .report-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="dashboard-header">
    <h1>Admin Dashboard</h1>
</div>

<div class="container">
    <div class="row">
        <!-- Sales Report Section -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-3 mb-4">
                <div class="report-title">Sales Today</div>
                <div class="text-success fs-4">
                    <?php echo "₱" . number_format($sales_today, 2); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card p-3 mb-4">
                <div class="report-title">Sales Yesterday</div>
                <div class="text-primary fs-4">
                    <?php echo "₱" . number_format($sales_yesterday, 2); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card p-3 mb-4">
                <div class="report-title">Sales This Year</div>
                <div class="text-warning fs-4">
                    <?php echo "₱" . number_format($sales_this_year, 2); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card p-3 mb-4">
                <div class="report-title">Sales Last Year</div>
                <div class="text-danger fs-4">
                    <?php echo "₱" . number_format($sales_last_year, 2); ?>
                </div>
            </div>
        </div>

        <!-- Inventory Section -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-3 mb-4">
                <div class="report-title">Total Inventory Value</div>
                <div class="text-secondary fs-4">
                    <?php echo "₱" . number_format($inventory_value, 2); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card p-3 mb-4">
                <div class="report-title">Items in Stock</div>
                <div class="text-secondary fs-4">
                    <?php echo number_format($items_in_stock); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; <?php echo date("Y"); ?> Nyro. All rights reserved.
    </div>
</div>

<!-- Link to Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
