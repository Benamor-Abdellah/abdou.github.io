<?php
include('include/connected.php');
session_set_cookie_params(1800); // 30 دقيقة
session_start();

if (isset($_POST['register'])) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($name) || empty($email) || empty($password)) {
        echo '<script>alert("يرجى ملء جميع الحقول");</script>';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // تشفير كلمة المرور
        $query = "INSERT INTO customers (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo '<script>alert("تم التسجيل بنجاح");</script>';
            header('Location: login.php'); // إعادة التوجيه إلى صفحة تسجيل الدخول
            exit();
        } else {
            echo '<script>alert("حدث خطأ أثناء التسجيل");</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التسجيل</title>
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
        .register-container {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .register-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .register-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #555;
        }
        .register-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .register-container button:hover {
            background-color: #0056b3;
        }
        .register-container p {
            margin-top: 15px;
            color: #555;
        }
        .register-container a {
            color: #007bff;
            text-decoration: none;
        }
        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>التسجيل</h1>
        <form action="register.php" method="POST">
            <label for="name">الاسم</label>
            <input type="text" name="name" id="name" required>

            <label for="email">البريد الإلكتروني</label>
            <input type="email" name="email" id="email" required>

            <label for="password">كلمة المرور</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="register">تسجيل</button>
        </form>
        <p>هل لديك حساب؟ <a href="login.php">تسجيل الدخول</a></p>
    </div>
</body>
</html>