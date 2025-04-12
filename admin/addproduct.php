<?php
include('../include/connected.php');
?>
<?php
$proname = isset($_POST['proname']) ? $_POST['proname'] : '';
$proprice = isset($_POST['proprice']) ? $_POST['proprice'] : '';
$prosection = isset($_POST['prosection']) ? $_POST['prosection'] : '';
$prodescrip = isset($_POST['prodescrip']) ? $_POST['prodescrip'] : '';
$prounv = isset($_POST['prounv']) ? $_POST['prounv'] : '';
$proadd = isset($_POST['proadd']) ? $_POST['proadd'] : '';
/*img start*/
$IMAGENAME = isset($_FILES['proimg']['name']) ? $_FILES['proimg']['name'] : '';
$imageTmp = isset($_FILES['proimg']['tmp_name']) ? $_FILES['proimg']['tmp_name'] : '';
/*img end*/ 
if (isset($proadd) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($proname) || empty($proprice) || empty($prosection) || empty($prodescrip) || empty($IMAGENAME)) {
        echo '<script>alert("الرجاء ملئ جميع البيانات")</script>';
    } else {
        $Proimg = rand(0, 5000) . "_" . $IMAGENAME;
        move_uploaded_file($imageTmp, "../uploads/img/" . $Proimg);

        $query = "INSERT INTO product(proname, proimg, proprice, prosection, prodescrip, prounv)
                  VALUES ('$proname', '$Proimg', '$proprice', '$prosection', '$prodescrip', '$prounv')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo '<script>alert("تم إضافة المنشور بنجاح");</script>';
            // إعادة التوجيه بعد الإضافة
            header('Location: addproduct.php');
            exit();
        } else {
            echo '<script>alert("لم تتم إضافة المنشور");</script>';
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة المنتجات</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
<center>
    <main>
        <div class="form_product">
            <h1>إضافة منتج</h1>
            <form action="addproduct.php" method="post" enctype="multipart/form-data">
                <label for="name"> اسم المنتج </label>
                <input type="text" name="proname" id="name">

                <label for="file">صورة المنتج </label>
                <input type="file" name="proimg" id="file">

                <label for="price"> سعر المنتج </label>
                <input type="text" name="proprice" id="price">

                <label for="discription"> تفاصيل المنتج </label>
                <input type="text" name="prodescrip" id="discription">

                
                <!-- section start -->
                <div>
                    <label for="form_control"> الأقسام </label>
                    <select name="prosection" id="form_control">
                    <?php
                    $query = "SELECT * FROM section";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<option value="'.$row['sectionname'].'">'.$row['sectionname'].'</option>';
                    }
                    ?>
                    </select>
                </div><br><br>
                <!-- section end-->
                <button class="button" type="submit" name="proadd">اضف المنتج</button>
            </form>
        </div>
    </main>
</center>
</body>
</html>