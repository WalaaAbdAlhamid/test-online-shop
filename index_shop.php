<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

function execute_query($connect_database, $query, $params = [], $types = '') {
    $stmt = mysqli_prepare($connect_database, $query);
    if ($params) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    return $stmt;
}

// إضافة منتج إلى العربة
if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'] ?? null;
    $product_price = $_POST['product_price'] ?? null;
    $product_image = $_POST['product_image'] ?? null;
    $product_quantity = intval($_POST['product_quantity'] ?? 1);

    if (!$product_name || !$product_price || !$product_image) {
        $message[] = 'يرجى التأكد من ملء جميع الحقول.';
    } else {
        $select_cart_query = "SELECT * FROM cart WHERE name = ? AND user_id = ?";
        $stmt = execute_query($connect_database, $select_cart_query, [$product_name, $user_id], 'si');
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $message[] = 'المنتج أضيف بالفعل إلى عربة التسوق!';
        } else {
            $insert_cart_query = "INSERT INTO cart (user_id, name, price, image, quantity) VALUES (?, ?, ?, ?, ?)";
            execute_query($connect_database, $insert_cart_query, [$user_id, $product_name, $product_price, $product_image, $product_quantity], 'isdsi');
            $message[] = 'المنتج يضاف إلى عربة التسوق!';
        }
    }
}

// تحديث كمية المنتج في العربة
if (isset($_POST['update_cart'])) {
    $update_quantity = intval($_POST['cart_quantity']);
    $update_id = intval($_POST['cart_id']);
    $update_cart_query = "UPDATE cart SET quantity = ? WHERE id = ?";
    execute_query($connect_database, $update_cart_query, [$update_quantity, $update_id], 'ii');
    $message[] = 'تم تحديث كمية سلة التسوق بنجاح!';
}

// حذف منتج من العربة
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    $remove_cart_query = "DELETE FROM cart WHERE id = ?";
    execute_query($connect_database, $remove_cart_query, [$remove_id], 'i');
    header('Location: index_shop.php');
    exit();
}

// حذف جميع المنتجات من العربة
if (isset($_GET['delete_all'])) {
    $delete_all_query = "DELETE FROM cart WHERE user_id = ?";
    execute_query($connect_database, $delete_all_query, [$user_id], 'i');
    header('Location: index_shop.php');
    exit();
}

// استعلام للحصول على جميع المنتجات في عربة التسوق
$grand_total = 0;
$cart_query = "SELECT * FROM cart WHERE user_id = ?";
$stmt = execute_query($connect_database, $cart_query, [$user_id], 'i');
$cart_items = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عربة التسوق</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .user-profile {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .user-profile p {
            margin: 0;
            font-size: 1.2em;
        }
        .user-profile .delete-btn {
            background: #dc3545;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
        }
        .user-profile .delete-btn:hover {
            background: #c82333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }
        .table th {
            background: #007bff;
            color: #ffffff;
        }
        .table tr:nth-child(even) {
            background: #f2f2f2;
        }
        .table-bottom {
            font-weight: bold;
        }
        .btn {
            background: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn:hover {
            background: #0056b3;
        }
        .message {
            color: green;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message" onclick="this.remove();">' . htmlspecialchars($msg) . '</div>';
        }
    }
    ?>

    <div class="container">
        <div class="user-profile">
            <?php
            $select_user_query = "SELECT * FROM users WHERE id = ?";
            $stmt = execute_query($connect_database, $select_user_query, [$user_id], 'i');
            $fetch_user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
            ?>
            <p>المستخدم الحالي: <span><?php echo htmlspecialchars($fetch_user['name']); ?></span></p>
        </div>
        <div class="flex" style="margin-top: 10px;">
            <a href="index_shop.php?logout=true" onclick="return confirm('هل أنت متأكد أنك تريد تسجيل الخروج؟');" class="delete-btn">تسجيل الخروج</a>
        </div>

        <h1 class="heading">عربة التسوق</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>اسم المنتج</th>
                    <th>سعر المنتج</th>
                    <th>الكمية</th>
                    <th>إجمالي السعر</th>
                    <th>حذف المنتج</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($cart_items) > 0) {
                    while ($row = mysqli_fetch_assoc($cart_items)) {
                        $total_price = $row['price'] * $row['quantity'];
                        $grand_total += $total_price;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?>$</td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo $total_price; ?>$</td>
                        <td><a href="index_shop.php?remove=<?php echo $row['id']; ?>" class="delete-btn">حذف</a></td>
                    </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>لا توجد منتجات في عربة التسوق</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr class="table-bottom">
                    <td colspan="3">المبلغ الإجمالي:</td>
                    <td><?php echo $grand_total; ?>$</td>
                    <td>
                        <a href="index_shop.php?delete_all" onclick="return confirm('حذف كل المنتجات من العربة؟');" class="delete-btn <?php echo ($grand_total > 0) ? '' : 'disabled'; ?>">حذف الكل</a>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div style="text-align: center;">
            <a href="shop.php" class="btn">الرجوع إلى صفحة المنتجات</a>
        </div>
    </div>
</body>
</html>

