<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="/css/stil.css"/>
</head>
<body>
<?php
    require('database_connection.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;
            // Redirect to user dashboard page
            header("Location: cookingsite.php");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='index.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" method="post" name="login" >
        <h1 class="login-title">Вход</h1>
        <input type="text" class="login-input" name="username" placeholder="Потребителско име" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Парола"/>
        <input type="submit" value="Влез" name="submit" class="login-button"/>
        
        <p class="link"><a href="registration.php">Нов профил -></a></p>
        <p class="link"><a href="cookingsite_guest.php">Влизане като гост</a></p>

  </form>
<?php
    }
?>
</body>
</html>