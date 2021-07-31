<?php

include 'config.php';

session_start();

if (isset($_SESSION["user_id"])) {
  header("Location: welcome.php");
}

if (isset($_POST["resetPassword"])) {
  $email = mysqli_real_escape_string($conn, $_POST["email"]);

  $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

  if (mysqli_num_rows($check_email) > 0) {
      $data = mysqli_fetch_assoc($check_email);
      
      $to = $email;
      $subject = "Reset Password - Pure Coding YouTube";
    
      $message = "
      <html>
      <head>
      <title>{$subject}</title>
      </head>
      <body>
      <p><strong>Dear {$data['full_name']},</strong></p>
      <p>Forgot Password? Not a problem. Click below link to reset your password.</p>
      <p><a href='{$base_url}reset-password.php?token={$data['token']}'>Reset Password</a></p>
      </body>
      </html>
      ";
    
      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
      // More headers
      $headers .= "From: ". $my_email;
    
      if (mail($to,$subject,$message,$headers)) {
        echo "<script>alert('We have sent a reset password link to your email - {$email}.');</script>";
      } else {
        echo "<script>alert('Mail not sent. Please try again.');</script>";
      }
  } else {
      echo "<script>alert('Email not found.');</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <title>Sign in & Sign up Form - Pure Coding</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" method="post" class="sign-in-form">
          <h2 class="title">Reset Password</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Email Address" name="email" value="<?php echo $_POST['email']; ?>" required />
          </div>
          <input type="submit" value="Send Verification Link" name="resetPassword" class="btn solid" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Forgot Password ?</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
            ex ratione. Aliquid!
          </p>
        </div>
        <img src="img/log.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="app.js"></script>
</body>

</html>