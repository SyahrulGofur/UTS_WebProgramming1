<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <style>
    body {
      background: url('assets/image/background.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    .kontener-form-signin {
      opacity: 95%;
    }
  </style>
</head>

<body>
  <div class="container d-flex flex-column w-100 vh-100">
    <form class="form-signin align-self-center flex-fill d-flex align-items-center" action="config/akun/login_akun.php" method="post">
      <div class="kontener-form-signin container py-5 p-5 rounded-3 bg-body-secondary d-flex flex-column justify-content-center shadow-lg">
        <h2 class="text-center">LOGIN</h2>
        <label for="username" class="sr-only">Username</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <?php
        if (isset($_SESSION['error'])) {
        ?>
          <div class="alert alert-warning mt-3" role="alert">
            <?php echo $_SESSION['error'] ?>
          </div>
        <?php
          $_SESSION['error'] = null;
        }
        ?>
        <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Login</button>
        <a href="page/register.php">Belum punya akun? daftar disini</a>
      </div>
    </form>
  </div>
  <?php include 'page/utils/footer.php' ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>