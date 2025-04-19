<?php include '../controller/database.php' ?>

<?php 
  session_start();

  $err = '';
  $name = '';
  $password = '';

  if (isset($_SESSION['UserID'])) {
    header('Location: index.php');
  }

  if (isset($_POST['username']) && isset($_POST['password'])) {
    $name = $_POST['username'];
    $password = $_POST['password'];

    if (empty($name) && empty($password)) {
      $err = 'Fields are empty';
    } else if (empty($name)) {
      $err = 'Username is empty';
    } else if (empty($password)) {
      $err = 'Password is empty';
    } else {
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
      } else {
        $err = 'User is not found';
      }
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
    <style>
      .animation {
            animation: fade 2s ease-in-out forwards;
        }

        @keyframes fade {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
  </head>
  <body class="d-flex align-items-center" style="height: 100vh;">
    <div class="container w-50 h-auto border rounded shadow d-flex justify-content-center" style="max-width: 400px; position: relative;">
      <div class="row w-100 h-auto">
          <div class="col-12 h-10 p-5">
              <div 
                class="alert alert-danger mt-3 p-2 text-center animation" 
                style=" 
                        display: <?= empty($err) ? 'none' : 'block' ?>; 
                        position: absolute; 
                        top: -50px; 
                        left: 50%; 
                        transform: translate(-50%, -50%);
                        opacity: 0"
              >
                <?= $err ?>
              </div>
              
              <form class="" method="post" novalidate>
                  <div class="form-group mb-2">
                      <label for="">Username</label>
                      <input type="text" class="form-control" name="username" value="<?= $name ?>">
                      <div class="invalid-feedback">Can't be empty</div>
                  </div>

                  <div class="form-group mb-2">
                      <label for="">Password</label>
                      <input type="password" class="form-control" name="password" value="<?= $password ?>">
                      <div class="invalid-feedback">Can't be empty</div>
                  </div>

                  <button class="btn btn-outline-primary w-100 mt-2">Login</button>
                  <small>Don't have an account? <a href="register.php" style="text-decoration: none">Sign Up</a></small>
              </form>
          </div>
      </div>
    </div>

  <script>
    const alert = document.querySelector('.alert')
    const errMsg = '<?= $err ?>'
    

    
    if (errMes) {
      alert.classList.add('animation')
    } 

  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
