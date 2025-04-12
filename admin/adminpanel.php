<?php
session_start();
include('../include/connected.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--strt fontawesome-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!--end fontawesome-->
    <title>نوحة التحكم</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>

<body>
<?php
if(!isset($_SESSION['email'])){
    header('location:../index.php');
    exit();
}
else{
    ?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['secadd'])) {
    $sectionname = isset($_POST['sectionname']) ? trim($_POST['sectionname']) : '';

    if (empty($sectionname)) {
        echo '<script>alert("الرجاء ملئ الحقل");</script>';
    } elseif (strlen($sectionname) > 50) {
        echo '<script>alert("الاسم طويل");</script>';
    } else {
        $sectionname = mysqli_real_escape_string($conn, $sectionname);
        $query = "INSERT INTO section (sectionname) VALUES ('$sectionname')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo '<script>alert("تمت الإضافة");</script>';
            // إعادة التوجيه بعد الإضافة
            header('Location: adminpanel.php');
            exit();
        } else {
            echo '<script>alert("حدث خطأ أثناء الإضافة");</script>';
        }
    }
}

if ($id !== null) {
    $query = "DELETE FROM section WHERE id='$id'";
    $delet = mysqli_query($conn, $query);
    if ($delet) {
        echo '<script>alert("تم الحذف");</script>';
        // إعادة التوجيه بعد الحذف
        header('Location: adminpanel.php');
        exit();
    } else {
        echo '<script>alert("لم يتم الحذف");</script>';
    }
}
?>
    <!--sidebar star-->
    <div class="sidebar_container">
<div class="sidebar">
<h1> لوحه تحكم الاداره </h1>
<ul>
<li><a href="../index.php" target="_blank"> الصفحة الرئيسية<i class="fa-solid fa-house"></i></a></li>
<li><a href="product.php" target="_blank"> صفحة المنتجات<i class="fa-solid fa-fill-drip"></i></a></li>
<li><a href="addproduct.php" target="_blank"> اضافة منتج<i class="fa-solid fa-folder-plus"></i></a></li>
<li><a href="members.php" target="_blank"> معلومات الاعضاء<i class="fa-solid fa-users"></i></a></li>
<li><a href="orders.php" target="_blank"> طلبات الزبائن<i class="fa-solid fa-folder-open"></i></a></li>
<li><a href="logout.php" target="_blank"> تسجيل الخروج<i class="fa-solid fa-right-from-bracket"></i></a></li>
</ul>
</div>

    <!--sidebar end-->

    <!--section start-->
    <div class="content_sec">
       <form action="adminpanel.php" method="POST">
        <label for="section">اضافة قسم </label>
        <input type="text" name="sectionname" id="section">
        <br>
        <button class="add" type="submit" name="secadd">اضافة قسم جديد</button>
       </form> 
       <br>
<!--tabel start-->
<table dir="rtl">
    <tr>
        <th>الرقم التسلسلي</th>
        <th>اسم القسم</th>
        <th>حذف القسم</th>
    </tr>
    <tr>
    <?php
$query="SELECT * FROM section ORDER BY id ASC"; // تعديل الاستعلام لترتيب النتائج تنازلياً
$result=mysqli_query($conn,$query);
while($row=mysqli_fetch_assoc($result)){
    ?> 

   
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['sectionname'];?></td>
        <td><a href="adminpanel.php?id=<?php echo $row['id'];?>"><button class="delet" type="button">حذف قسم</button></a></td>
    </tr>
    <?php
}
    ?>
</table>
<!--tabel end-->

    </div>  
 
    <!--section end-->

</div>

    <?php
    //غلق else 
}
?>
</body>
</html>