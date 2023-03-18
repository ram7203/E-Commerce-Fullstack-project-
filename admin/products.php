<?php
    include '../components/connect.php';
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id))
    {
        header('location:admin_login.php');
    }

    if(isset($_POST['add_product']))
    {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);

        $details = $_POST['details'];
        $details = filter_var($details, FILTER_SANITIZE_STRING);

        $image_01 = $_FILES['image_01']['name'];
        $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
        $image_01_size = $_FILES['image_01']['size'];
        $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
        $image_01_folder = '../uploaded_img/'.$image_01;

        $image_02 = $_FILES['image_02']['name'];
        $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
        $image_02_size = $_FILES['image_02']['size'];
        $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
        $image_02_folder = '../uploaded_img/'.$image_02;

        $image_03 = $_FILES['image_03']['name'];
        $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
        $image_03_size = $_FILES['image_03']['size'];
        $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
        $image_03_folder = '../uploaded_img/'.$image_03;

        $select_products = $conn->prepare("SELECT * FROM `products` WHERE name=?");
        $select_products->execute([$name]);

        if($select_products->rowCOunt()>0)
        {
            $message[] = 'product name already exists!';
        }
        else
        {
            if($image_01_size > 2000000 or $image_02_size > 2000000 or $image_03_size > 2000000)
            {
                $message[] = 'image size is too large';
            }
            else
            {
                move_uploaded_file($image_01_tmp_name, $image_01_folder);
                move_uploaded_file($image_02_tmp_name, $image_02_folder);
                move_uploaded_file($image_03_tmp_name, $image_03_folder);

                $insert_product = $conn->prepare("INSERT INTO `products`(name, details, price, image_01, image_02, image_03) VALUES(?, ?, ?, ?, ?, ?)");
                $insert_product->execute([$name, $details, $price, $image_01, $image_02, $image_03]);

                $message[] = 'new product added!';
            }
        }
    }

    if(isset($_GET['delete']))
    {
        $delete_id = $_GET['delete'];
        $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id=?");
        $delete_product_image->execute([$delete_id]);
        $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);

        unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
        unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
        unlink('../uploaded_img/'.$fetch_delete_image['image_03']);

        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id=?");
        $delete_product->execute([$delete_id]);

        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid=?");
        $delete_cart->execute([$delete_id]);

        $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid=?");
        $delete_wishlist->execute([$delete_id]);

        header('location:products.php');
    }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php
    include '../components/admin_header.php'
?>

<!-- add products section starts -->
<section class="add-products">

    <h1 class="heading">add product</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="flex">

            <div class="inputBox">
                <span>product name (required)</span>
                <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box">
            </div>

            <div class="inputBox">
                <span>product price (required)</span>
                <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length==10) return false;" class="box">
            </div>

            <div class="inputBox">
                <span>image 01 (required)</span>
                <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image.png, image/webp" required>
            </div>

            <div class="inputBox">
                <span>image 02 (required)</span>
                <input type="file" name="image_02" class="box" accept="image/jpg, image/jpeg, image.png, image/webp" required>
            </div>

            <div class="inputBox">
                <span>image 03 (required)</span>
                <input type="file" name="image_03" class="box" accept="image/jpg, image/jpeg, image.png, image/webp" required>
            </div>

            <div class="inputBox">
                <span>product details</span>
                <textarea name="details" class="box" placeholder="enter product details" required maxlength="500" cols="30" rows="10"></textarea>
            </div>

            <input type="submit" value="add product" name="add_product" class="btn">
        </div>
    </form>

</section>


<!-- show products section starts -->

<section class="show-products" style="padding-top:0;">
    <h1 class="heading">products added</h1>

    <div class="box-container">

        <?php
            $show_products = $conn->prepare("SELECT * FROM `products`");
            $show_products->execute();
            if($show_products->rowCount()>0)
            {
                while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC))
                {
        ?>

        <div class="box">
            <img src="../uploaded_img/<?= $fetch_products['image_01'] ?>" alt="">
            <div class="name"><?= $fetch_products['name']; ?></div>
            <div class="price">₹<?= $fetch_products['price']; ?>/-</div>
            <div class="details"><?= $fetch_products['details']; ?></div>
            <div class="flex-btn">
                <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
                <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product');">delete</a>
            </div>
        </div>

        <?php
                 }
                }
                else
                {
                    echo '<p class="empty">no products added yet!</p>';
                }
        ?>

    </div>
</section>



<!-- custom js file link -->
<script src="../js/admin_script.js"></script>
    
</body>
</html>