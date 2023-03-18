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
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $password = $_POST['password'];
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $cpassword = $_POST['cpassword'];
        $cpassword = filter_var($cpassword, FILTER_SANITIZE_STRING);

        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email=?");
        $select_user->execute([$email]);

        $row = $select_user->fetch(PDO::FETCH_ASSOC);
        if($select_user->rowCount()>0)
        {
            $message[] = 'user already exists!';
        }
        else
        {
            if($password!=$cpassword)
            {
                $message[] = 'confirm password does not match!';
            }
            else
            {
                $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?, ?, ?)");
                $insert_user->execute([$name, $email, $cpassword]);
                $message[] = 'user registered successfully, please login now!';
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

    <?php
        include 'components/user_header.php'
    ?>

    <!-- user register section starts -->

    <section class="form-container">
    <form action="" method="post">
        <h3>register now</h3>
        <input type="text"  required maxlength="20" name="name" class="box" placeholder="enter your name" oninput="this.value.replace(/\s/g, '')">
        <input type="email"  required maxlength="50" name="email" class="box" placeholder="enter your email" oninput="this.value.replace(/\s/g, '')">
        <input type="password"  required maxlength="20" name="password" class="box" placeholder="enter your password" oninput="this.value.replace(/\s/g, '')">
        <input type="password"  required maxlength="20" name="cpassword" class="box" placeholder="confirm your password" oninput="this.value.replace(/\s/g, '')">
        <input type="submit" value="register now" class="btn" name="submit">
        <p>already have an account?</p>
        <a href="user_login.php" class="option-btn">login now</a>
    </form>
    </section>









    <?php
        include 'components/footer.php';
    ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    
</body>
</html>