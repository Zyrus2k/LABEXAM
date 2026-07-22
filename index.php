<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h1 class="text-center mb-4">📦 Product Inventory System</h1>

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
                        Product "<strong>' . htmlspecialchars($product_name) . '</strong>" added successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>';
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error: ' . $stmt->error . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>';
                }
                $stmt->close();
            } else {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Please fill in all fields.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
            }
        }
        ?>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Add New Product</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                        <div class="col-md-4">
                            <label for="supplier" class="form-label">Supplier</label>
                            <input type="text" class="form-control" id="supplier" name="supplier" required>
                        </div>
                        <div class="col-md-3">
                            <label for="price" class="form-label">Price ($)</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="col-md-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" min="0" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" name="add_product" class="btn btn-primary w-100">
                                ➕ Add Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">📋 Inventory Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
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
                                        <td><?= $row['id'] ?></td>
                                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                                        <td><?= htmlspecialchars($row['category']) ?></td>
                                        <td>$<?= number_format($row['price'], 2) ?></td>
                                        <td><?= $row['quantity'] ?></td>
                                        <td><?= htmlspecialchars($row['supplier']) ?></td>
                                        <td><?= date("M d, Y h:i A", strtotime($row['created_at'])) ?></td>
                                    </tr>
                                <?php
                                endwhile;
                            else:
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">No products found. Add one above!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer class="text-center text-muted mt-4 mb-3">
            <small>Product Inventory System &copy; <?= date('Y') ?></small>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>