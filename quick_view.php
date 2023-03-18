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

    include 'components/wishlist_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>quick view</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

    <?php
        include 'components/user_header.php'
    ?>

    <!-- quick view section starts -->

    <section class="quick-view">
        <h1 class="heading">quick view</h1>

        <?php
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id=?");
            $select_products->execute([$pid]);
            if($select_products->rowCount()>0)
            {
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC))
                {
         ?>

        <form action="" method="post" class="box">
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_products['image_01']; ?>">

            <div class="image-container">
                <div class="big-image">
                    <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                </div>
                <div class="small-image">
                    <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                    <img src="uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
                    <img src="uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">
                </div>
            </div>
            
            <div class="content">
                <div class="name"><?= $fetch_products['name']; ?></div>
                <div class="flex">
                    <div class="price">₹ <span><?= $fetch_products['price']; ?></span>/-</div>
                    <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length==2) return false;">
                </div>
                <div class="details"><?= $fetch_products['details']; ?></div>
                <div class="flex-btn">
                    <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
                </div>
            </div>
        </form>

        <?php
                }
            }
            else
            {
                echo '<p class="empty">no products found!</p>';
            }
        ?>
    </section>









    <?php
        include 'components/footer.php';
    ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    
</body>
</html>