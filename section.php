<?php
 include('file/header.php');
 session_set_cookie_params(1800); // 30 دقيقة
session_start();


 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الاقسام</title>
  
 </head>
 <body>
<main>
<?php
  $section = isset($_GET['section']) ? $_GET['section'] : '';
    $query = "SELECT * FROM product WHERE prosection='$section' ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
               <!--product image-->
            <div class="product">
                <div class="product_img"><a href="details.php?id=<?php echo $row['id'];?>">
                    <img src="uploads/img//<?php echo $row['proimg'];?>" >
                    <span class="unvailabe"><?php echo $row['prounv'];?> </span>
                    <a href=""></a>
                </div>
            <!--product section-->
                <div class="product_section">
                    <a href="details.php?id=<?php echo $row['id'];?>">
                        <?php echo $row['prosection'];?></a>
                </div>
            <!--product name-->
                <div class="product_name">
                    <a href="details.php?id=<?php echo $row['id'];?>"><?php echo $row['proname'];?></a>
                </div>
            <!--product price-->
                <div class="product_price">
                    <a href="details.php?id=<?php echo $row['id'];?>"> <?php echo $row['proprice'];?> &nbsp;  السعر  </a>
                </div>
            <!--product description-->
                <div class="product_description">
                    <a href="details.php?id=<?php echo $row['id'];?>"><i class="fa-solid fa-eye"></i> لتفاصيل المنتج اضغط هنا</a>
                </div>
            <!--quantity-->
                <div class="qty_input">
                    <button class="qty_count_mins">-</button>
                    <input type="number" id="quantity" name="" value="1" min="1" max="50">
                    <button class="qty_count_add">+</button>
                </div>
                <br>
            <!--submit-->
                <div class="submit">
                    <a href="">
                        <button class="addto_cart" type="submit" name="">
                            <i class="fa-solid fa-cart-plus">&nbsp; &nbsp;</i>أضف إلى السلة
                        </button>
                    </a>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<div class="notification">لا توجد منتجات </div>';

            
        
    }
?>
</main>
 </body>
 </html>
 <?php
 include('file/footer.php');
 ?>