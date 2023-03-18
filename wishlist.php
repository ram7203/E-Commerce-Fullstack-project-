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
        header('location:home.php');
    }

    include 'components/wishlist_cart.php';

    if(isset($_POST['delete']))
    {
        $wishlist_id = $_POST['wishlist_id'];
        $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE id=?");
        $delete_wishlist->execute([$wishlist_id]);
        $message[] = 'item deleted successfully!';
    }

    if(isset($_GET['delete_all']))
    {
        $delete_all = $_GET['delete_all'];
        $delete_all_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id=?");
        $delete_all_wishlist->execute([$user_id]);
        header('location:wishlist.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wishlist</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

    <?php
        include 'components/user_header.php'
    ?>

    <!-- wishlist section starts -->

    <section class="products">

        <h1 class="heading">your wishlist</h1>

        <div class="box-container">
            <?php
                $grand_total=0;
                $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id=?"); 
                $select_wishlist->execute([$user_id]);
                if($select_wishlist->rowCount()>0)
                {
                    while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC))
                    {      
                        $grand_total += $fetch_wishlist['price'];
            ?>

            <form action="" method="post" class="box">
                <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
                <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
                <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
                <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
                <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">

                <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
                <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="" class="image">
                <div class="name"><?= $fetch_wishlist['name']; ?></div>
                <div class="flex">
                    <div class="price">₹<span><?= $fetch_wishlist['price']; ?></span> /-</div>
                    <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length==2) return false;">
                </div>
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                <input type="submit" value="delete item" onclick="return confirm('Do you want to delete item from wishlist?');" name="delete" class="delete-btn">
            </form>

            <?php
                    }

                }
                else
                {
                    echo '<p class="empty">your wishlist is empty!</p>';
                }
            ?>
        </div>

        <div class="grand-total">
            <p>grand total: <span>₹<?= $grand_total ?> /-</span></p>
            <a href="shop.php" class="option-btn">continue shopping</a>
            <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total>1)?'':'disabled'; ?>" onclick="return confirm('Do you want to delete all items from wishlist?');">delete all</a>
        </div>

    </section>









    <?php
        include 'components/footer.php';
    ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    
</body>
</html>