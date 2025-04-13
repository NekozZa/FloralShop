<?php include '../controller/database.php' ?>

<?php 
  session_start();

  if (isset($_SESSION['UserID'])) {
    header('Location: index.php');
  }

  if (isset($_POST['username']) && isset($_POST['password']) 
      && isset($_POST['role']) && isset($_POST['shopName'])
      && isset($_POST['address'])) {
      
      $address = $_POST['address'];
      $role = $_POST['role'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $shopName = $_POST['shopName'];
      $shopDescription = $_POST['shopDescription'];

      $sql = "
          INSERT INTO account (Address, Username, Password, Role)
          VALUES ('$address', '$username', '$password', '$role')
      ";

      mysqli_query($conn, $sql);

      if ($role === 'Seller') {
        $userID = mysqli_insert_id($conn);

        $sql = "
          INSERT INTO shop (UserID, Name, Description)
          VALUES ($userID, '$shopName', '$shopDescription')
        ";
      }

      mysqli_query($conn, $sql);
      $_SESSION['UserID'] = $userID;
      $_SESSION['Role'] = $role;

      header('Location: index.php');
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
    <div class="container w-50 h-auto border rounded shadow d-flex justify-content-center">
      <div class="row w-100 h-auto">
          <div class="col-12 h-10 p-5">
              <form class="needs-validation" method="post" novalidate>
                <div class="form-group mb-2">
                  <label for="">Address*</label>  
                  <input type="text" class="form-control" name="address" required>
                  <div class="invalid-feedback">Can't be empty</div>
                </div>

                <div class="form-group mb-2">
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <label for="">Username*</label>
                      <input type="text" class="form-control" name="username" required>
                      <div class="invalid-feedback">Can't be empty</div>
                    </div>
                      
                    <div class="col-md-6 col-12">
                      <label for="">Password*</label>
                      <input type="password" class="form-control" name="password" required>
                      <div class="invalid-feedback">Can't be empty</div>
                    </div>
                  </div>
                    
                </div>

                <div class="form-group">
                  <label class="mb-2" for="">Role*</label>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" value="Customer" required>
                    <label class="form-check-label">Customer</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" value="Seller" required>
                    <label class="form-check-label">Seller</label>
                  </div>
                  <div class="invalid-feedback">Can't be empty</div>
                </div>
                

                <div class ="form-group mt-5 shop-info" style="display: none">
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <label for="">Shop Name*</label>
                      <input type="text" class="form-control" name="shopName" required>
                      <div class="invalid-feedback">Can't be empty</div>
                    </div>

                    <div class="col-md-6 col-12">
                      <label for="">Shop Description</label>
                      <input type="text" class="form-control" name="shopDescription">
                    </div>
                  </div>
                  
                </div>

                <button class="btn btn-outline-primary w-100 mt-5" type="submit">Register</button>
            </form>
          </div>
      </div>
    </div>

    <script>
      (function() {
        'use strict';
          window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();

        const shopInfo = document.querySelector('.shop-info')
        const btns = document.querySelectorAll('input[type="radio"]')
        const selectedBtn = document.querySelectorAll('input[type="radio"]:checked')

        if (selectedBtn) {
          shopInfo.style.display = selectedBtn.value == 'Seller' ? 'block' : 'none'
        }
        
        btns.forEach((btn) => {
          btn.onclick = () => {
            shopInfo.style.display = btn.value == 'Seller' ? 'block' : 'none'
          }
        })

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
