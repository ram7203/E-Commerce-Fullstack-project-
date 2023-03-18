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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about</title>

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

    <!-- about section starts -->

    <section class="about">

        <div class="row">
            <div class="image">
                <img src="images/about-img.svg" alt="">
            </div>

            <div class="content">
                <h3>why choose us?</h3>
                <p>
                    Wide selection of products | Competitive prices | Exceptional customer service | Safe and secure shopping
                </p>
                <a href="contact.php" class="btn">contact us</a>
            </div>
        </div>

    </section>

    <!-- reviews section starts -->

    <section class="reviews">

        <h1 class="heading">clients's reviews</h1>

        <div class="swiper reviews-slider">
            <div class="swiper-wrapper">
               <div class="swiper-slide slide">
                    <img src="images/pic-1.png" alt="">
                    <p>I had a great experience shopping with this website. The selection of products is fantastic, and the prices are unbeatable. Shipping was fast, and my order arrived in perfect condition. I'll definitely be back!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>john smith</h3>
               </div> 

               <div class="swiper-slide slide">
                    <img src="images/pic-2.png" alt="">
                    <p>I was a little hesitant to order from this website, but I'm so glad I did. The customer service was exceptional - they answered all my questions and helped me find exactly what I was looking for. My order arrived quickly and was even better than I expected. I highly recommend this website!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>jane doe</h3>
               </div> 

               <div class="swiper-slide slide">
                    <img src="images/pic-3.png" alt="">
                    <p>I've been shopping with this website for a while now, and I have to say, I'm consistently impressed with the quality of their products and the level of service they provide. Their prices are unbeatable, and their shipping is always fast and reliable. I highly recommend them to anyone looking for a great online shopping experience.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>steve axe</h3>
               </div> 

               <div class="swiper-slide slide">
                    <img src="images/pic-4.png" alt="">
                    <p>I recently ordered a few items from this website and was blown away by the selection and quality of the products. The prices were incredibly competitive, and my order arrived quickly and in perfect condition. I'm so impressed with this website, and I'll definitely be a repeat customer!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>rachel greene</h3>
               </div> 

               <div class="swiper-slide slide">
                    <img src="images/pic-5.png" alt="">
                    <p>I had a small issue with my order, and the customer service team went above and beyond to help me resolve it quickly and efficiently. I was so impressed with their professionalism and dedication to customer satisfaction. I highly recommend this website for anyone looking for a hassle-free shopping experience.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>adam long</h3>
               </div> 

               <div class="swiper-slide slide">
                    <img src="images/pic-6.png" alt="">
                    <p>I was amazed by the exceptional customer service I received from this website. I had a question about my order, and they responded to my email within minutes, providing me with all the information I needed. The product I ordered was also of high quality and arrived in a timely manner. I'm definitely going to be a regular customer!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>kim lang</h3>
               </div> 

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
        var swiper = new Swiper(".reviews-slider", {
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