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
    <title>تفاصيل المنتج</title>
 </head>
 <style>
    main{
        display: flex;
        flex-wrap: wrap;
            }
            .container{
                    width:90%;
                    height: auto;
                    margin:20px auto;
                    border-radius: 8px;
            }
            .product_img{
                    float: left;
                    display: flex;
                    flex-wrap: wrap;
                    margin-bottom: 20px;
            }
            .product_img img {
                    width: 400px;
                    height: 400px;
                    margin-left: 40px;
                    margin-bottom:20px
            }
            .product_info{
            float:right;
            width:400px;
            height: 400px;
            text-align: center;
            font-size: 20px;
            margin-right: 50px
            padding: 20px; 
            margin-top: 30px;
            }
            .product_titele{
                margin:10px 0;
            }
            .product_price{
                    color: red;
                    margin:10px;
            }
            .product_description{
                    font-size: 16px;
                    line-height: 1.5;
            }
            .add_cart{
            width:150px;
            height: 35px;
            margin-left: 30px;
            padding:10px 10px;
            background-color: #fff;
            border-radius: 5px;
            }
            .add_cart:hover{
                    background-color: #e67e22;
            }
            .recently_added{
            float:right;
            width:30%;
            margin-top:30px;
            border-radius: 8px;
            padding:10px 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,1.0);
            }
            .add_img img{
            float:right;
            margin:10px 10px;
            width:70px;
            height: 70px;
            margin-right: 5px;
            border-radius: 10px;
            }
            .comment_info{
            float:left;
            width:50%;
            height: auto;
            margin:20px 10px;
            box-shadow: 0 2px 2px rgba(0,0,0,1.0);
            }
            h5{
                font-size: 20px;
                margin-top: 20px;
                text-align: center;
                color: black;
            }
            textarea{
            text-align: center;
            width:80%; 
            margin-top: 20px;
            margin-left: 50px;
            margin-bottom: 10px;
            padding: 10px;
            border:1px solid #ccc;
            border-radius: 10px;
            height: 50px;
            }
            .add_comment{
                width: 100px;
                height: 35px;
                margin-left: 40px;
                background-color: #fff;
                border-radius: 5px;
                padding: 10px 10px;
            }
            .add_comment:hover{
                background-color: #e67e22;
            }
            .comments{
                margin-top: 10px;
            }
            .comment{
                color: black;
                text-align: center;
                font-size: larger; 
            margin: 5px 5px;
            background-color: #fff;
            padding: 10px;
            border:1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            }
            .usename {
            padding: 4px 5px;
            text-align: right;
            color:blue;
            font-size: 20px;
            }

    
    
 </style>
 <body>
    <main>
    <?php
 $id = isset($_GET['id']) ? $_GET['id'] : null;
    if ($id !== null) {
        $query = "SELECT * FROM product WHERE id='$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
    }
 ?>
<!-- start img-->
        <div class="container">
            <div class="product_img">
                <img src="uploads/img//<?php echo $row['proimg'];?>" alt="">
                </div>
                 <!-- start information-->
                  <div class="product_info">
                    <h1 class="product_titele"><?php echo $row['proname'];?></h1>
                    <h2 class="product_price"><?php echo $row['proprice'];?>$ &nbsp; السعر</h2>
                    <!--product section-->
                <div class="product_section">
                    <a href="section.php?section=<?php echo $row['prosection'];?>">
                        <?php echo $row['prosection'];?></a>
                </div>
                    <h4 class="product_description">تفاصيل المنتج</h4>
                    <P><?php echo $row['prodescrip'];?></P>
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
                        <button class="add_cart" type="submit" name="add" value="add_cart">
                            <i class="fa-solid fa-cart-plus">&nbsp; &nbsp;</i>أضف إلى السلة</button>
                    </a>
                </div>
                  </div>
            
        </div>
 
    </main>
    <hr>
     <!--منتجات حديثة-->
     <div class="container">
        <div class="recently_added">
            <h4>منتجات حديثة</h4>
            <?php
            $query = "SELECT * FROM product WHERE id!='$id' ORDER BY rand() LIMIT 4";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            
        ?>
            <div class="add_img">
            <a href="details.php?id=<?php echo $row['id'];?>">
            <img src="uploads/img//<?php echo $row['proimg'];?>" >
                </a>
            </div>
            <?php
        }
            ?>
        </div>
          <!--نهاية منتجات حديثة-->
            <!-- تقييمات -->
  
             <div class="comment_info">
             <?php
     // إضافة تعليق
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
    $add_comment = isset($_POST['add_comment']) ? $_POST['add_comment'] : '';

    if (isset($add_comment)) {
        if (empty($comment)) {
            echo '<script>alert("من فضلك اكتب تعليق");</script>';
        } else {
            $query = "INSERT INTO comments (comment) VALUES ('$comment')";
            $result = mysqli_query($conn, $query);
        }
    }
}
        //عرض التعليقات
        $query = "SELECT * FROM comments";
        $result = mysqli_query($conn, $query);

          
            ?>
                <h5>هل تود تقييم هذا المنتج</h5>
                <form action="" method="post">
                    <textarea name="comment" id="" placeholder="قيم هذا المتنتج من فضلك" require></textarea>
                    <button class="add_comment" type="submit" name="add_comment">ارسال</button>
                </form>
                <h5>تقيمات العملاء</h5>
                <div class="comments">
                <?php
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div class='usename'>تقييم بواسطة :&nbsp;"  .$row['usename']."</div>";
                echo "<div class='comment'>"  .$row['comment']."</div>";
            }
        }else {
            echo "<div class='comment'>لا توجد تعليقات بعد</div>";
        }
            ?>
            </div>
               
             </div>
              
     </div>
      
 </body>
 </html>
 <?php
 include('file/footer.php');
 ?>