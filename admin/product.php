<?php
include('../include/connected.php');
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة المنتجات</title>
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
        .delete-btn, .update-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #e60000;
        }
        .update-btn:hover {
            background-color: #0056b3;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>صفحة المنتجات</h1>
        <?php
        // كود حذف المنتج
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id !== null) {
            $query = "DELETE FROM product WHERE id='$id'";
            $delete = mysqli_query($conn, $query);
            if ($delete) {
                echo '<script>alert("تم الحذف بنجاح");</script>';
                header('Location: product.php');
                exit();
            } else {
                echo '<script>alert("لم يتم الحذف هناك خطأ ما");</script>';
            }
        }
        ?>
        <table>
            <tr>
                <th>رقم المنتج</th>
                <th>صورة المنتج</th>
                <th>اسم المنتج</th>
                <th>سعر المنتج</th>
                <th>توفر المنتج</th>
                <th>الأقسام</th>
                <th>تفاصيل المنتج</th>
                <th>حذف المنتج</th>
                <th>تعديل المنتج</th>
            </tr>
            <?php
            $query = "SELECT * FROM product";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><img src="../uploads/img/<?php echo $row['proimg']; ?>" alt="Product Image"></td>
                <td><?php echo $row['proname']; ?></td>
                <td><?php echo $row['proprice']; ?></td>
                <td><?php echo $row['prounv']; ?></td>
                <td><?php echo $row['prosection']; ?></td>
                <td><?php echo $row['prodescrip']; ?></td>
                <td><a href="product.php?id=<?php echo $row['id']; ?>"><button class="delete-btn">حذف</button></a></td>
                <td><a href="update.php?id=<?php echo $row['id']; ?>"><button class="update-btn">تعديل</button></a></td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='9'>لا توجد منتجات</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>