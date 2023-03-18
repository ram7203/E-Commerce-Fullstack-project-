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

    if(isset($_POST['submit']))
    {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
        $update_profile->execute([$name, $email, $user_id]);

        $empty_pass = '';
        $select_previous_password = $conn->prepare("SELECT password FROM `users` WHERE id=?");
        $select_previous_password->execute([$user_id]);
        $fetch_prev_password = $select_previous_password->fetch(PDO::FETCH_ASSOC);
        $prev_pass = $fetch_prev_password['password'];

        $old_pass = $_POST['old_password'];
        $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
        $new_pass = $_POST['new_password'];
        $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
        $cpass = $_POST['c_new_password'];
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        if($old_pass == $empty_pass)
        {
            $message[] = 'please enter old password!';
        }
        elseif($old_pass != $prev_pass)
        {
            $message[] = 'old password does not matched!';
        }
        elseif($new_pass != $cpass)
        {
            $message[] = 'confirm password does not matched!';
        }
        else
        {
            if($new_pass != $empty_pass)
            {
                $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                $update_pass->execute([$cpass, $user_id]);
                $message[] = 'password updated successfully!';
            }
            else
            {
                $message[] = 'please enter a new password!';
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
    <title>update profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

    <?php
        include 'components/user_header.php'
    ?>

    <!-- update profile section starts -->
    <section class="form-container">
    <form action="" method="post">
        <h3>update profile</h3>
        <input type="text"  required maxlength="20" name="name" class="box" placeholder="enter your name" oninput="this.value.replace(/\s/g, '')" value=<?= $fetch_profile['name'] ?>>
        <input type="email"  required maxlength="50" name="email" class="box" placeholder="enter your email" oninput="this.value.replace(/\s/g, '')" value=<?= $fetch_profile['email'] ?>>
        <input type="password"  maxlength="20" name="old_password" class="box" placeholder="enter your old password" oninput="this.value.replace(/\s/g, '')">
        <input type="password"  maxlength="20" name="new_password" class="box" placeholder="enter your new password" oninput="this.value.replace(/\s/g, '')">
        <input type="password"  maxlength="20" name="c_new_password" class="box" placeholder="confirm your new password" oninput="this.value.replace(/\s/g, '')">
        <input type="submit" value="update now" class="btn" name="submit">
    </form>
    </section>









    <?php
        include 'components/footer.php';
    ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    
</body>
</html>