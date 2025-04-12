<?php
include('../include/connected.php');
?>
<?php
// select start
$id = isset($_GET['id']) ? $_GET['id'] : null;
if($id !== null){
    $query=" SELECT * FROM product WHERE id = '$id '";
    $result = mysqli_query($conn, $query);
    if($result){
        $row = mysqli_fetch_assoc($result);
       
    }
}
if (isset($_POST['update_pro']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['id_new'])) {
        $proname = isset($_POST['proname']) ? $_POST['proname'] : '';
        $proprice = isset($_POST['proprice']) ? $_POST['proprice'] : '';
        $prosection = isset($_POST['prosection']) ? $_POST['prosection'] : '';
        $prodescrip = isset($_POST['prodescrip']) ? $_POST['prodescrip'] : '';
        $prounv = isset($_POST['prounv']) ? $_POST['prounv'] : '';
        $id_new = isset($_GET['id_new']) ? $_GET['id_new'] : '';

        /*img start*/
        $IMAGENAME = isset($_FILES['proimg']['name']) ? $_FILES['proimg']['name'] : '';
        $imageTmp = isset($_FILES['proimg']['tmp_name']) ? $_FILES['proimg']['tmp_name'] : '';
        /*img end*/ 

        if (empty($prodescrip)) {
            echo '<script>alert("الرجاء اضافة تفاصيل للمنتج")</script>';
        } else {
            $Proimg = rand(0, 5000) . "_" . $IMAGENAME;
            move_uploaded_file($imageTmp, "../uploads/img/" . $Proimg);
            $query = "UPDATE product SET
                proname='$proname', 
                proimg='$Proimg', 
                proprice='$proprice', 
                prosection='$prosection', 
                prodescrip='$prodescrip', 
                prounv='$prounv' 
                WHERE id = '$id_new'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo '<script>alert("تم تعديل المنتج بنجاح");</script>';
                // إعادة التوجيه بعد الإضافة
                header("Location: ../index.php");
                exit();
            } else {
                echo '<script>alert("لم تتم تعديل المنتج");</script>';
            }
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المنتجات </title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
<center>
    <main>
        <div class="form_product">
            <h1>تعديل منتج</h1>
            <form action="update.php?id_new=<?php echo $row['id'];?>" method="post" enctype="multipart/form-data">
                <label for="name"> اسم المنتج </label>
                <input type="text" name="proname" id="name" value="<?php echo $row['proname'];?>">

                <label for="file">صورة المنتج </label>
                <input type="file" name="proimg" id="file" value="<?php echo $row['proimg'];?>">

                <label for="price"> سعر المنتج </label>
                <input type="text" name="proprice" id="price" value="<?php echo $row['proprice'];?>">

                <label for="discription"> تفاصيل المنتج </label>
                <input type="text" name="prodescrip" id="discription" value="<?php echo $row['prodescrip'];?>">

                <label for="unv"> توفر المنتج </label>
                <input type="text" name="prounv" id="unv" value="<?php echo $row['prounv'];?>">
                <!-- section start -->
                <div>
                    <label for="form_control"> الأقسام </label>
                    <select name="prosection" id="form_control" value="<?php echo $row['prosection'];?>">
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
                <button class="button" type="submit" name="update_pro">تعديل المنتج</button>
            </form>
        </div>
    </main>
</center>
</body>
</html>