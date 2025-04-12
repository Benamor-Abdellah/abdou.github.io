

<?php
session_set_cookie_params(1800); // 30 دقيقة
session_start();
ob_start(); // بدء تخزين المخرجات مؤقتًا
include('file/header.php');

// تفعيل عرض الأخطاء
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// التحقق مما إذا كانت الجلسة مسجلة بالفعل
if (isset($_SESSION['id'])) {
    header('Location: cart.php.php');
    exit();
}

// كود إضافة المنتج إلى السلة
$add = isset($_POST['add']) ? $_POST['add'] : '';
if (!empty($add)) {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $productname = isset($_POST['h_name']) ? $_POST['h_name'] : '';
    $productprice = isset($_POST['h_price']) ? $_POST['h_price'] : '';
    $productimg = isset($_POST['h_img']) ? $_POST['h_img'] : '';
    $productquantity = isset($_POST['h_quantity']) ? $_POST['h_quantity'] : '';

    // التحقق من وجود المنتج في السلة
    $add_cart = "SELECT * FROM cart WHERE name='$productname'";
    $result = mysqli_query($conn, $add_cart);
    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("المنتج موجود في السلة");</script>';
        header('Location: cart.php');
        exit();
    } else {
        // إضافة المنتج إلى السلة
        $insert_cart = "INSERT INTO cart (name, price, img, quantity) VALUES ('$productname', '$productprice', '$productimg', '$productquantity')";
        $result = mysqli_query($conn, $insert_cart);
        if ($result) {
            echo '<script>alert("تم إضافة المنتج إلى السلة");</script>';
            header('Location: cart.php');
            exit();
        } else {
            echo '<script>alert("فشل في إضافة المنتج إلى السلة");</script>';
        }
    }
}

// كود الحذف
$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id !== null) {
    $query = "DELETE FROM cart WHERE id='$id'";
    $delete = mysqli_query($conn, $query);
    if ($delete) {
        echo '<script>alert("تم الحذف بنجاح");</script>';
        header('Location: cart.php');
        exit();
    } else {
        echo '<script>alert("لم يتم الحذف هناك خطأ ما");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلة السوق</title>
    <style>
        /* تصميم الصفحة */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: rgba(0, 0, 0, 0.2);
            direction: rtl;
        }
        .cart_table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .cart_table th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .cart_table th {
            background-color: #d3d8e4;
        }
        .cart_table img {
            width: 70px;
            height: 70px;
        }
        .remove {
            background-color: #0a79a5;
            color: white;
            border: none;
            padding: 10px 10px;
            cursor: pointer;
        }
        .remove:hover {
            background-color: rgb(4, 59, 110);
        }
        .cart_total h6 {
            font-size: large;
            color: black;
        }
        .cart_total button {
            transition: transform 0.3s ease;
            padding: 10px 40px;
        }
        .cart_total button a {
            text-decoration: none;
            color: #fff;
        }
        .cart_total button:hover {
            transform: scale(1.2);
            background-color: #0a79a5;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>سلة التسوق</h1>
        <!--start table-->
        <table class="cart_table">
            <tr>
                <th>صورة المنتج</th>
                <th>رقم المنتج</th>
                <th>اسم المنتج</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>الإجمالي</th>
                <th>حذف المنتج</th>
            </tr>
            <?php
            $query = "SELECT * FROM cart";
            $result = mysqli_query($conn, $query);
            $total = 0;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $subtotal = (float)$row['quantity'] * (float)$row['price'];
                    $total += $subtotal;
            ?>
            <tr>
                <td><img src="uploads/img/<?php echo $row['img']; ?>" alt=""></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td>$<?php echo $row['price']; ?></td>
                <td>$<?php echo number_format($subtotal, 2); ?></td>
                <td><a href="cart.php?id=<?php echo $row['id']; ?>"><button class="remove">حذف</button></a></td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='7'>لا توجد منتجات في السلة</td></tr>";
            }
            ?>
        </table>
        <!--end table-->
        <div class="cart_total">
            <h6>المجموع: $<?php echo number_format($total, 2); ?></h6>
            <button><a href="checkout.php">إتمام الطلب</a></button>
        </div>
    </div>
</body>
</html>
<?php
 include('file/footer.php');
 ?>