<?php include '../controller/database.php' ?>

<?php 
  session_start();

  if (isset($_SESSION['UserID'])) {
    header('Location: index.php');
  }

  if (isset($_POST['username']) && isset($_POST['password'])) {
      $name = $_POST['username'];
      $password = $_POST['password'];

      $sql = "
          SELECT UserID, Role 
          FROM account 
          WHERE Username='$name' and Password='$password'
      ";

      $res = mysqli_query($conn, $sql);
      
      if (mysqli_num_rows($res) > 0) {
          $row = mysqli_fetch_assoc($res);
          $_SESSION['UserID'] = $row['UserID'];
          $_SESSION['Role'] = $row['Role'];

          header('Location: index.php');
      }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body class="d-flex align-items-center" style="height: 100vh;">
    <div class="container w-50 h-auto border rounded shadow d-flex justify-content-center" style="max-width: 400px">
      <div class="row w-100 h-auto">
          <div class="col-12 h-10 p-5">
              <form method="post">
                  <div class="form-group mb-2">
                      <label for="">Username</label>
                      <input type="text" class="form-control" name="username">
                  </div>

                  <div class="form-group mb-2">
                      <label for="">Password</label>
                      <input type="password" class="form-control" name="password">
                  </div>

                  <small>Don't have an account? <a href="register.php" style="text-decoration: none">Sign Up</a></small>

                  <button class="btn btn-outline-primary w-100 mt-5">Login</button>
              </form>
          </div>
      </div>
    </div>
  </body>
</html>
