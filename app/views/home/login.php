<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IPD System</title>
    <!-- <link rel="icon" type="image/png" href="<?= BASEURL; ?>/images/logo.png" /> -->
    <link href="<?= BASEURL; ?>/ace/Login/css.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/login/materialdesignicons.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/login/bootstrap.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/login/login.css">

    <style>
      .bgImage{
        background-image: url('<?= BASEURL; ?>/images/bg-image-login.jpeg');
        /* no-repeat center center fixed */
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }
    </style>
</head>
<body class="bgImage">
  <main>
    <div class="container" style="margin-top:40px; border-radius: 50%;">
      <div class="row justify-content-center">
        <div class="col-lg-6 login-wrapper my-auto login-section-wrapper">
          
          <div id="msg-alert" style="background-color:red;color:white;">
              <?php
                  Flasher::msgInfo();
              ?>
          </div>

          <form action="<?= BASEURL; ?>/home/members" id="sign_in" method="POST">
            <div class="form-group">
              <label for="email">User ID / Email</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="email@example.com">
            </div>
            <div class="form-group mb-4">
              <label for="password">Password</label>
              <input type="password" name="password"  class="form-control" placeholder="enter your passsword">
            </div>
            <input name="login" id="login" class="btn btn-block login-btn" type="submit" value="Login">
            
          </form>
          <a href="#!" class="forgot-password-link"></a>
          <p class="login-wrapper-footer-text"><a href="#!" class="text-reset"></a></p>
        </div>
          <!-- <div class="login-wrapper my-auto">
        </div> -->
        <!-- <div class="col-sm-4 px-0 d-none d-sm-block">
          <img src="<?= BASEURL; ?>/images/login-wlp2.jpg" alt="login image" class="login-img">
        </div> -->
      </div>
    </div>
  </main>

  

  <script src="<?= BASEURL; ?>/assets/login/jquery-3.js"></script>
  <script src="<?= BASEURL; ?>/assets/login/popper.js"></script>
  <script src="<?= BASEURL; ?>/assets/login/bootstrap.js"></script>

  <script>
    $(function(){
      document.getElementById("username").focus();
    })
  </script>
</body>
</html>