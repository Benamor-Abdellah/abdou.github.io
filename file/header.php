<?php
 $host ="localhost";
 $username="root";
 $password="";
 $dbname="proje";

 $conn = mysqli_connect($host, $username, $password, $dbname);
 if(isset($conn)){
    echo"تم الاتصال ";
 }
 else{
    echo"فشل الاتصال ";
 }
 ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <!--start logo-->
            <div class="logo">
                <H1>السورية للديكور</H1>
            </div>
            <div>
            <img class="logo-img" src="img/casee.png" alt="">
            </div>
        <!--end logo-->
        <!--start search-->
            <div class="search">
                <div class="search_bar">
                    <form action="search.php" method="get">
                        <input type="text" class="search_input" name="search" placeholder="ابحث">
                        <button class="button_search" name="btn_search">بحث</button>
                    </form>
                </div>
            </div>
        <!--end search-->
    </header>
        <!--start of social media-->
        <nav>   
             <div class="social">
                <ul>
                    <li><a href="" target="_blank"><i class="fa-brands fa-facebook-f"></i></i></a></li>
                    <li><a href="" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="" target="_blank"><i class="fa-brands fa-tiktok"></i></a></li>
                    <li><a href="" target="_blank"><i class="fa-brands fa-snapchat"></i></a></li>
                </ul>
            </div>
            <!--start of section-->
            <div class="section">
    <ul>
        <li><a href="./index.php">الرئيسية</a></li>
       
        <?php
        $query = "SELECT * FROM section"; 
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?> 
        <li><a href="section.php?section=<?php echo $row['sectionname']; ?>"><?php echo $row['sectionname']; ?></a></li>
        <?php
        }
        ?>        
    </ul>
</div>
        </nav>
            <!-- end of section -->
        
        <div class="last-post">
            <h4>مضاف حديثا</h4>
            <ul>
            <?php
 $query="SELECT * FROM product ORDER BY id DESC LIMIT 4";
 $result=mysqli_query($conn,$query);
 while($row=mysqli_fetch_assoc($result)){
   

 ?>
                <li><a href="details.php?id=<?php echo $row['id'];?>">
                    <span class="span-image">
                        <img src="uploads/img//<?php echo $row['proimg'];?>" alt="">
                    </span>
                </a>
                </li>
                <?php 
 }
?>
               
            </ul>
        <!--cart start-->
        <div class="cart">
    <ul>
        <li><a href="login.php"><i class="fa-solid fa-user"></i></a></li>
        <li class="cart-icon">
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <span class="cart-count">
                <?php
                // استعلام لجلب عدد المنتجات في السلة
                $query = "SELECT COUNT(*) AS total_items FROM cart";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                echo $row['total_items']; // عرض عدد المنتجات
                ?>
            </span>
        </li>
    </ul>
</div>
        <!--cart end-->
        </div>