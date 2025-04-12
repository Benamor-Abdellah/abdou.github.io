<?php
 include('file/header.php');
 session_set_cookie_params(1800); // 30 دقيقة
session_start();


 ?>
 <?php
if(isset($_GET['btn_search'])){
    $search = $_GET['search'];
    $query = "SELECT * FROM product WHERE prosection LIKE '%$search%'
     OR proname LIKE '%$search%'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo'
               <div class="product">
                <div class="product_img">
                    <img src="uploads/img//'.$row['proimg'].'" >
                    <span class="unvailabe">'.$row['prounv'].'</span>
                    </a>
                </div>
            <!--product section-->
                <div class="product_section">
                    <a href="">'.$row['prosection'].'</a>
                </div>
            <!--product name-->
                <div class="product_name">
                    <a href="">'. $row['proname'].'</a>
                </div>
            <!--product price-->
                <div class="product_price">
                    <a href=""> '. $row['proprice'].' &nbsp;  السعر  </a>
                </div>
            <!--product description-->
                <div class="product_description">
                    <a href="details.php"><i class="fa-solid fa-eye">'. $row['prodescrip'].'</i> لتفاصيل المنتج اضغط هنا</a>
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
           
            ';

        }
    }
    else{
        echo '<div class="notification">المنتج الذي تبجث عنه غير متوفر</div>'; 
}
}
 ?>
             <?php
 include('file/footer.php');
 ?>