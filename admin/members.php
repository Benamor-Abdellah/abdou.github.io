<?php
include('../include/connected.php');

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معلومات الأعضاء</title>
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
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>معلومات الأعضاء</h1>
        <table>
            <tr>
                <th>رقم العضو</th>
                <th>اسم العضو</th>
                <th>البريد الإلكتروني</th>
                <th>حذف العضو</th>
            </tr>
            <?php
            $query = "SELECT * FROM customers ORDER BY id ASC"; // استعلام لجلب بيانات الأعضاء
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td><a href='members.php?delete_id=" . $row['id'] . "'><button class='delete-btn'>حذف</button></a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>لا يوجد أعضاء مسجلين</td></tr>";
            }
            ?>
        </table>
    </div>

    <?php
    // كود حذف العضو
    $delete_id = isset($_GET['delete_id']) ? $_GET['delete_id'] : null;
    if ($delete_id !== null) {
        $query = "DELETE FROM customers WHERE id='$delete_id'";
        $delete = mysqli_query($conn, $query);
        if ($delete) {
            echo '<script>alert("تم الحذف بنجاح");</script>';
            // إعادة التوجيه بعد الحذف
            header('Location: members.php');
            exit();
        } else {
            echo '<script>alert("لم يتم الحذف هناك خطأ ما");</script>';
        }
    }
    ?>
</body>
</html>