
<?php
 include('file/header.php');
 ?>
<?php
session_set_cookie_params(1800); // 30 دقيقة
session_start();
include('include/connected.php');

// التحقق من تسجيل الدخول
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// جلب بيانات المستخدم
$user_id = $_SESSION['id'];
$query = "SELECT * FROM customers WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// تغيير كلمة المرور
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE customers SET password = '$hashed_password' WHERE id = '$user_id'";
            mysqli_query($conn, $update_query);
            echo '<script>alert("تم تغيير كلمة المرور بنجاح");</script>';
        } else {
            echo '<script>alert("كلمات المرور الجديدة غير متطابقة");</script>';
        }
    } else {
        echo '<script>alert("كلمة المرور الحالية غير صحيحة");</script>';
    }
}

// تحديث الملف الشخصي
if (isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $update_query = "UPDATE customers SET name = '$name', email = '$email' WHERE id = '$user_id'";
    mysqli_query($conn, $update_query);
    echo '<script>alert("تم تحديث الملف الشخصي بنجاح");</script>';
    header('Location: customer_dashboard.php');
    exit();
}

// تسجيل الخروج
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
        }
        .sidebar {
            width: 25%;
            border-right: 1px solid #ddd;
            padding-right: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
        }
        .sidebar ul li a:hover {
            text-decoration: underline;
        }
        .content {
            width: 75%;
            padding-left: 20px;
        }
        .content h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function showSection(sectionId) {
            // إخفاء جميع الأقسام
            document.querySelectorAll('.content-section').forEach(section => {
                section.style.display = 'none';
            });
            // عرض القسم المحدد
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- الشريط الجانبي -->
        <div class="sidebar">
            <ul>
                <li><a href="#" onclick="showSection('profile-section')">تفاصيل الملف الشخصي</a></li>
                <li><a href="#" onclick="showSection('password-section')">تغيير كلمة المرور</a></li>
                <li><a href="#" onclick="showSection('logout-section')">تسجيل الخروج</a></li>
            </ul>
        </div>

        <!-- المحتوى -->
        <div class="content">
            <!-- تفاصيل الملف الشخصي -->
            <div id="profile-section" class="content-section">
                <h2>تفاصيل الملف الشخصي</h2>
                <form action="customer_dashboard.php" method="POST">
                    <label for="name">الاسم</label>
                    <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" required>

                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required>

                    <button type="submit" name="update_profile">تحديث الملف الشخصي</button>
                </form>
            </div>

            <!-- تغيير كلمة المرور -->
            <div id="password-section" class="content-section" style="display: none;">
                <h2>تغيير كلمة المرور</h2>
                <form action="customer_dashboard.php" method="POST">
                    <label for="current_password">كلمة المرور الحالية</label>
                    <input type="password" name="current_password" id="current_password" required>

                    <label for="new_password">كلمة المرور الجديدة</label>
                    <input type="password" name="new_password" id="new_password" required>

                    <label for="confirm_password">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>

                    <button type="submit" name="change_password">تغيير كلمة المرور</button>
                </form>
            </div>

            <!-- تسجيل الخروج -->
            <div id="logout-section" class="content-section" style="display: none;">
                <h2>تسجيل الخروج</h2>
                <form action="customer_dashboard.php" method="POST">
                    <button type="submit" name="logout">تسجيل الخروج</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
 include('file/footer.php');
 ?>