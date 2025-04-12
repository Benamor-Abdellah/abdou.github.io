<?php
session_set_cookie_params(300); // 30 دقيقة
session_start();
 ?>
<?php
 include('file/header.php');
 ?>
  <!--product start-->
  <main>
  <?php
 $query="SELECT * FROM product";
 $result=mysqli_query($conn,$query);
 while($row=mysqli_fetch_assoc($result)){
   

 ?>
<div class="about-container">
  <div class="about-text">
    <h1>حول شركتنا</h1>
    <p>
      السورية للديكورات والدهانات العصرية هي مؤسسة جزائرية متخصصة في تصميم الديكورات الداخلية والخارجية، وتوريد الدهانات الحديثة والمواد الصناعية المستخدمة في التشطيبات والبناء. يقع مقرها في طاهير، ولاية جيجل، وتقدم حلولًا متطورة للأفراد والشركات الباحثين عن تصاميم عصرية ومواد ذات جودة عالية لتحسين المساحات السكنية والتجارية. تعتمد المؤسسة على الابتكار والجودة في توفير المنتجات والخدمات، حيث توفر مجموعة متنوعة من الدهانات بخصائص مميزة، مثل المقاومة للعوامل الجوية والتشطيبات المختلفة، بالإضافة إلى استشارات متخصصة في مجال الديكور والتصميم لمساعدة العملاء في اختيار الأنسب لمشاريعهم.
    </p>
  </div>
  <img src="img/2022-10-04" alt="صورة عن الشركة" class="about-image">
</div>
            <!--product image-->
            <div class="product">
                <div class="product_img"><a href="details.php?id=<?php echo $row['id'];?>">
                    <img src="uploads/img//<?php echo $row['proimg'];?>" >
                    <span class="unvailabe"><?php echo $row['prounv'];?> </span>
                    <a href=""></a>
                </div>
            <!--product section-->
                <div class="product_section">
                    <a href="section.php?section=<?php echo $row['prosection'];?>">
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
                    <form action="cart.php?action<?php echo $row['id'];?>" method="post">
                    <button class="qty_count_mins">-</button>
                    <input type="number" id="quantity" name="h_quantity" value="1" min="1" max="50">
                    <input type="hidden" name="h_name" value="<?php echo $row['proname'];?>">
                    <input type="hidden" name="h_price" value="<?php echo $row['proprice'];?>">
                    <input type="hidden" name="h_img" value="<?php echo $row['proimg'];?>">
                    <button class="qty_count_add">+</button>
                </div>
                <br>
            <!--submit-->
                <div class="submit">
                    <a href="">
                        <button class="addto_cart" type="submit" name="add" value="add_cart">
                            <i class="fa-solid fa-cart-plus">&nbsp; &nbsp;</i>أضف إلى السلة
                        </button>
                    </a>
                </div>
                </form> 
            </div>
            <?php
  }
 ?>
        </main>
        <br>
        <br>
            <!--product start-->
            <?php
 include('file/footer.php');
 ?>