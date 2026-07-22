<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-wrapper {
            padding: 40px 0;
        }

        .main-title {
            color: #fff;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .main-title i {
            margin-right: 10px;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            font-weight: 600;
            padding: 15px 20px;
        }

        .card-header.bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .card-header.bg-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: #fff;
            border: none;
            padding: 15px 12px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-color: #f0f0f0;
        }

        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        footer {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .badge-qty {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 4px 12px;
            border-radius: 20px;
            color: #fff;
            font-weight: 600;
            display: inline-block;
        }

        .price-tag {
            font-weight: 700;
            color: #e74c3c;
            font-size: 1.05rem;
        }
    </style>
</head>

<body>

    <div class="main-wrapper">
        <div class="container">
            <h1 class="text-center main-title">
                <i class="bi bi-box-seam"></i> Product Inventory System
            </h1>

            <?php
            require_once 'db.php';

            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_product"])) {
                $product_name = trim($_POST["product_name"]);
                $category     = trim($_POST["category"]);
                $price        = trim($_POST["price"]);
                $quantity     = trim($_POST["quantity"]);
                $supplier     = trim($_POST["supplier"]);

                if (!empty($product_name) && !empty($category) && !empty($price) && !empty($quantity) && !empty($supplier)) {
                    $stmt = $conn->prepare("INSERT INTO products (product_name, category, price, quantity, supplier) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssdis", $product_name, $category, $price, $quantity, $supplier);

                    if ($stmt->execute()) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Product "<strong>' . htmlspecialchars($product_name) . '</strong>" added successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                              </div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Error: ' . $stmt->error . '
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                              </div>';
                    }
                    $stmt->close();
                } else {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            Please fill in all fields.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                          </div>';
                }
            }
            ?>

            <!-- Add Product Form Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Add New Product</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="product_name" class="form-label"><i class="bi bi-tag me-1"></i>Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="category" class="form-label"><i class="bi bi-folder me-1"></i>Category</label>
                                <input type="text" class="form-control" id="category" name="category" placeholder="e.g. Electronics" required>
                            </div>
                            <div class="col-md-4">
                                <label for="supplier" class="form-label"><i class="bi bi-truck me-1"></i>Supplier</label>
                                <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Supplier name" required>
                            </div>
                            <div class="col-md-3">
                                <label for="price" class="form-label"><i class="bi bi-currency-dollar me-1"></i>Price (₱)</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" placeholder="0.00" required>
                            </div>
                            <div class="col-md-3">
                                <label for="quantity" class="form-label"><i class="bi bi-box me-1"></i>Quantity</label>
                                <input type="number" min="0" class="form-control" id="quantity" name="quantity" placeholder="0" required>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" name="add_product" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-lg me-2"></i>Add Product
                                </button>
                            </div>
                    </form>
                </div>

                <!-- Inventory Items Table Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-table me-2"></i>Inventory Items</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                        <th>Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");

                                    if ($result && $result->num_rows > 0):
                                        while ($row = $result->fetch_assoc()):
                                    ?>
                                            <tr>
                                                <td><span class="badge bg-secondary rounded-pill"><?= $row['id'] ?></span></td>
                                                <td><strong><?= htmlspecialchars($row['product_name']) ?></strong></td>
                                                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['category']) ?></span></td>
                                                <td><span class="price-tag">₱<?= number_format($row['price'], 2) ?></span></td>
                                                <td><span class="badge-qty"><?= $row['quantity'] ?></span></td>
                                                <td><?= htmlspecialchars($row['supplier']) ?></td>
                                                <td><i class="bi bi-calendar me-1"></i><?= date("M d, Y h:i A", strtotime($row['created_at'])) ?></td>
                                            </tr>
                                        <?php
                                        endwhile;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                                No products found. Add one above!
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <footer class="text-center mt-4 mb-3">
                        <small><i class="bi bi-c-circle me-1"></i>Product Inventory System <?= date('Y') ?></small>
                    </footer>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>