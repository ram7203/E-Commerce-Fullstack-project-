<?php
    include 'components/connect.php';

    session_start();

    if(isset($_SESSION['user_id']))
    {
        $user_id = $_SESSION['user_id'];
    }
    else
    {
        $user_id = '';
    }

    include 'components/wishlist_cart.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

    <?php
        include 'components/user_header.php'
    ?>

    <div class="home-bg">

        <section class="swiper home-slider">
            <div class="swiper-wrapper">

                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="images/home-img-1.png" alt="">
                    </div>
                    <div class="content">
                       <span>upto 50% off</span> 
                       <h3>latest smartphones</h3>
                       <a href="shop.php" class="btn">shop now</a>
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="images/home-img-2.png" alt="">
                    </div>
                    <div class="content">
                       <span>upto 50% off</span> 
                       <h3>latest watches</h3>
                       <a href="shop.php" class="btn">shop now</a>
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="images/home-img-3.png" alt="">
                    </div>
                    <div class="content">
                       <span>upto 50% off</span> 
                       <h3>latest headphones and speakers</h3>
                       <a href="shop.php" class="btn">shop now</a>
                    </div>
                </div>

            </div>
            <div class="swiper-pagination"></div>
        </section>

    </div>

    <!-- home category starts  -->

    <section class="home-category">
        <h1 class="heading">shop by category</h1>

        <div class="swiper category-slider">
            <div class="swiper-wrapper">

               <a href="category.php?category=laptop" class="swiper-slide slide">
                    <img src="images/icon-1.png" alt="">
                    <h3>laptop</h3>
               </a> 

               <a href="category.php?category=tv" class="swiper-slide slide">
                    <img src="images/icon-2.png" alt="">
                    <h3>tv</h3>
               </a> 

               <a href="category.php?category=camera" class="swiper-slide slide">
                    <img src="images/icon-3.png" alt="">
                    <h3>camera</h3>
               </a> 

               <a href="category.php?category=mouse" class="swiper-slide slide">
                    <img src="images/icon-4.png" alt="">
                    <h3>mouse</h3>
               </a> 

               <a href="category.php?category=fridge" class="swiper-slide slide">
                    <img src="images/icon-5.png" alt="">
                    <h3>fridge</h3>
               </a> 

               <a href="category.php?category=washing" class="swiper-slide slide">
                    <img src="images/icon-6.png" alt="">
                    <h3>washing machine</h3>
               </a> 

               <a href="category.php?category=smartphone" class="swiper-slide slide">
                    <img src="images/icon-7.png" alt="">
                    <h3>smartphone</h3>
               </a>
               
               <a href="category.php?category=watch" class="swiper-slide slide">
                    <img src="images/icon-8.png" alt="">
                    <h3>watch</h3>
               </a> 

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>


    <!-- home products section starts -->

    <section class="home-products">
        <h1 class="heading">latest products</h1>

        <div class="swiper product-slider">
            <div class="swiper-wrapper">

                <?php
                    $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
                    $select_products->execute();
                    if($select_products->rowCount()>0)
                    {
                        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC))
                        {

                        
                ?>

                <form action="" method="post" class="slide swiper-slide">
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image_01']; ?>">

                    <button type="submit" name="add_to_wishlist" class="fas fa-heart"></button>
                    <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" class="image" alt="">
                    <div class="name"><?= $fetch_products['name']; ?></div>
                    <div class="flex">
                        <div class="price">₹ <span><?= $fetch_products['price']; ?></span>/-</div>
                        <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length==2) return false;">
                    </div>
                    <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                </form>

                <?php
                        }
                    }
                    else
                    {
                        echo '<p class="empty">no products added yet!</p>';
                    }
                ?>

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>





    <?php
        include 'components/footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

    <script>
        var swiper = new Swiper(".category-slider", {
        loop: true,
        grabCursor: true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
            },
        breakpoints: {
            0: {
                slidesPerView: 2,
            },
            640: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 5,
            },
        },
        });

        var swiper = new Swiper(".home-slider", {
        loop: true,
        grabCursor: true,
        pagination: {
            el: ".swiper-pagination",
            },
        });

        var swiper = new Swiper(".product-slider", {
        loop: true,
        grabCursor: true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
            },
        breakpoints: {
            550: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
        });
    </script>
    
</body>
</html>