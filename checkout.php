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

    if(isset($_POST['order']))
    {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $method = $_POST['method'];
        $method = filter_var($method, FILTER_SANITIZE_STRING);

        $address = $_POST['flat'].', '.$_POST['street'].', '.$_POST['city'].', '.$_POST['state'].', '.$_POST['country'].' - '.$_POST['pin_code'];
        $address = filter_var($address, FILTER_SANITIZE_STRING);

        $total_products = $_POST['total_products'];
        $total_products = filter_var($total_products, FILTER_SANITIZE_STRING);

        $total_price = $_POST['total_price'];
        $total_price = filter_var($total_price, FILTER_SANITIZE_STRING);

        $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
        $check_cart->execute([$user_id]);

        if($check_cart->rowCount()>0)
        {
            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);
            $message[] = 'order placed successfully!';

            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id=?");
            $delete_cart->execute([$user_id]);
        }
        else
        {
            $message[] = 'your cart is empty!';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

    <?php
        include 'components/user_header.php'
    ?>

    <!-- checkout section starts -->

    <section class="checkout">
        <h1 class="heading">your orders</h1>

        <div class="display-orders">
            <?php
                $grand_total=0;
                $cart_items[] = '';
                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?"); 
                $select_cart->execute([$user_id]);
                if($select_cart->rowCount()>0)
                {
                    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC))
                    {      
                        $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                        $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['quantity'].') -';
                        $total_products = implode($cart_items);
            ?>

            <p> <?= $fetch_cart['name']; ?>  <span>₹<?= $fetch_cart['price']; ?>/- x <?= $fetch_cart['quantity']; ?></span> </p>

            <?php
                    }

                }
                else
                {
                    echo '<p class="empty">your cart is empty!</p>';
                }
            ?>
        </div>
        
        <p class="grand-total">grand total: <span>₹<?= $grand_total ?> /-</span></p>

        <form action="" method="post">
            <h1 class="heading">place orders</h1>


            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>">

            <div class="flex">
                <div class="inputBox">
                    <span>your name: </span>
                    <input type="text" maxlength="20" placeholder="enter your name" required class="box" name="name">
                </div>

                <div class="inputBox">
                    <span>your number: </span>
                    <input type="number" min="0" max="9999999999" onkeypress="if(this.value.length==10) return false;" placeholder="enter your number" required class="box" name="number">
                </div>

                <div class="inputBox">
                    <span>your email: </span>
                    <input type="email" maxlength="50" placeholder="enter your email" required class="box" name="email">
                </div>

                <div class="inputBox">
                    <span>payment method: </span>
                    <select name="method" class="box">
                        <option value="cash on delivery">cash on delivery</option>
                        <option value="credit card">credit card</option>
                        <option value="upi">upi</option>
                    </select>
                </div>

                <div class="inputBox">
                    <span>address line 01: </span>
                    <input type="text" maxlength="50" placeholder="e.g. flat no. " required class="box" name="flat">
                </div>

                <div class="inputBox">
                    <span>address line 02: </span>
                    <input type="text" maxlength="50" placeholder="e.g. street name " required class="box" name="street">
                </div>

                <div class="inputBox">
                    <span>country: </span>
                    <input type="text" maxlength="50" placeholder="e.g. India " required class="box" name="country">
                </div>

                <div class="inputBox">
                    <span>state: </span>
                    <input type="text" maxlength="50" placeholder="e.g. Goa " required class="box" name="state">
                </div>

                <div class="inputBox">
                    <span>city: </span>
                    <input type="text" maxlength="50" placeholder="e.g. Panaji " required class="box" name="city">
                </div>

                <div class="inputBox">
                    <span>pincode: </span>
                    <input type="number" min="0" max="999999" placeholder="e.g. 403802 " onkeypress="if(this.value.length==6) return false;" required class="box" name="pin_code">
                </div>
            </div>

            <input type="submit" value="place order" class="btn <?= ($grand_total>1)?'':'disabled'; ?>" name="order">

        </form>

</section>









    <?php
        include 'components/footer.php';
    ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    
</body>
</html>