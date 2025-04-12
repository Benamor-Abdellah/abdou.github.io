<?php
include('include/connected.php');
session_set_cookie_params(300); // 30 دقيقة
session_start();

// التحقق مما إذا كانت الجلسة مسجلة بالفعل
if (isset($_SESSION['id'])) {
    header('Location: customer_dashboard.php');
    exit();
}

if (isset($_POST['login'])) {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($email) || empty($password)) {
        echo '<script>alert("يرجى ملء جميع الحقول");</script>';
    } else {
        $query = "SELECT * FROM customers WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                echo '<script>alert("تم تسجيل الدخول بنجاح");</script>';
                header('Location: customer_dashboard.php'); // إعادة التوجيه إلى صفحة التحديث
                exit();
            } else {
                echo '<script>alert("كلمة المرور غير صحيحة");</script>';
            }
        } else {
            echo '<script>alert("البريد الإلكتروني غير مسجل");</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
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
        .login-container {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #555;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        .login-container p {
            margin-top: 15px;
            color: #555;
        }
        .login-container a {
            color: #007bff;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>تسجيل الدخول</h1>
        <form action="login.php" method="POST">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" name="email" id="email" required>

            <label for="password">كلمة المرور</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="login">تسجيل الدخول</button>
        </form>
        <p>لا تملك حسابًا؟ <a href="register.php">إنشاء حساب</a></p>
    </div>
</body>
</html>