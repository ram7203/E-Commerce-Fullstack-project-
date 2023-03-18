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

    if(isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $password = $_POST['password'];
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email=? AND password=?");
        $select_user->execute([$email, $password]);

        $row = $select_user->fetch(PDO::FETCH_ASSOC);
        if($select_user->rowCount()>0)
        {
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
            // $message = 'login successful!';
        }
        else
        {
            $message[] = 'incorrect email or password';
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

    <?php
        include 'components/user_header.php'
    ?>

    <!-- user login section starts -->

    <section class="form-container">
        <form action="" method="post">
            <h3>login now</h3>
            <input type="email"  required maxlength="50" name="email" class="box" placeholder="enter your email" oninput="this.value.replace(/\s/g, '')">
            <input type="password"  required maxlength="20" name="password" class="box" placeholder="enter your password" oninput="this.value.replace(/\s/g, '')">
            <input type="submit" value="login now" class="btn" name="submit">
            <p>don't have an account?</p>
            <a href="user_register.php" class="option-btn">register now</a>
        </form>
    </section>









    <?php
        include 'components/footer.php';
    ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    
</body>
</html>