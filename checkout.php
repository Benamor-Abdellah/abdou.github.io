
<?php
 include('file/header.php');
 ?>
<?php
include('include/connected.php');
session_set_cookie_params(1800); // 30 دقيقة
session_start();

// التحقق من تسجيل الدخول
if (isset($_SESSION['id'])) {
    header('Location: checkout.php');
    exit();
}

// معالجة الطلب عند الإرسال
if (isset($_POST['place_order'])) {
    $user_id = $_SESSION['user_id'];
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

    if (empty($address) || empty($phone) || empty($payment_method)) {
        echo '<script>alert("يرجى ملء جميع الحقول لإكمال الطلب");</script>';
    } else {
        // إدخال الطلب في قاعدة البيانات
        $query = "INSERT INTO orders (user_id, address, phone, payment_method) VALUES ('$user_id', '$address', '$phone', '$payment_method')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo '<script>alert("تم إكمال الطلب بنجاح");</script>';
            header('Location: thank_you.php'); // إعادة التوجيه إلى صفحة الشكر
            exit();
        } else {
            echo '<script>alert("حدث خطأ أثناء إكمال الطلب");</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إكمال الطلب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .checkout-container {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .checkout-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .checkout-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #555;
        }
        .checkout-container input, .checkout-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .checkout-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .checkout-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h1>إكمال الطلب</h1>
        <form action="checkout.php" method="POST">
            <label for="address">العنوان</label>
            <input type="text" name="address" id="address" required>

            <label for="phone">رقم الهاتف</label>
            <input type="text" name="phone" id="phone" required>

            <label for="payment_method">طريقة الدفع</label>
            <select name="payment_method" id="payment_method" required>
                <option value="cash">الدفع عند الاستلام</option>
                <option value="credit_card">بطاقة ائتمان</option>
                <option value="paypal">PayPal</option>
            </select>

            <button type="submit" name="place_order">إكمال الطلب</button>
        </form>
    </div>
</body>
</html>
<?php
 include('file/footer.php');
 ?>