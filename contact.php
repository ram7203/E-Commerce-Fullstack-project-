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

    if(isset($_POST['send']))
    {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);

        $msg = $_POST['msg'];
        $msg = filter_var($msg, FILTER_SANITIZE_STRING);

        $select_message = $conn->prepare("SELECT * from `messages` WHERE name=? AND email=? AND number=? AND message=?");
        $select_message->execute([$name, $email, $number, $msg]);

        if($select_message->rowCount()>0)
        {
            $message[] = 'This message has already been sent!';
        }
        else
        {
            $send_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?, ?, ?, ?, ?)");
            $send_message->execute([$user_id, $name, $email, $number, $msg]);
            $message[] = 'message sent successfully!';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

    <?php
        include 'components/user_header.php'
    ?>

    <!-- contact section starts -->

    <section class="form-container">

        <form action="" method="post" class="box">
            <h3>send us a message!</h3>
            <input type="text" required placeholder="enter your name" maxlength="20" name="name" class="box">
            <input type="number" required placeholder="enter your number" max="9999999999" min="0" name="number" class="box" onkeypress="if(this.value.length==10) return false;">
            <input type="email" required placeholder="enter your email" maxlength="50" name="email" class="box">
            <textarea name="msg" placeholder="enter your message" required class="box" cols="30" rows="10"></textarea>
            <input type="submit" value="send message" class="btn" name="send">
        </form>

    </section>









    <?php
        include 'components/footer.php';
    ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    
</body>
</html>