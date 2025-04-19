<?php include '../controller/database.php' ?>

<?php 
  include '../controller/database.php';
  include '../controller/mapbox.php';

  session_start();

  if (isset($_SESSION['UserID'])) {
    header('Location: index.php');
  }

  if (isset($_POST['username']) && isset($_POST['password']) &&
      isset($_POST['role']) && isset($_POST['address'])) {
      
      $address = $_POST['address'];
      $role = $_POST['role'];
      $username = $_POST['username'];
      $password = $_POST['password'];

      $userID = addNewAccount($conn, $address, $username, $password, $role);

      if (isset($_POST['shopName']) && $role === 'Seller') {
        $shopName = $_POST['shopName'];
        $shopDescription = $_POST['shopDescription'];
        addNewShop($conn, $shopName, $shopDescription);
      }

      $_SESSION['UserID'] = $userID;
      $_SESSION['Role'] = $role;

      header('Location: index.php');
  }

  function addNewAccount($conn, $address, $username, $password, $role) {
    $sql = "
        INSERT INTO account (Address, Username, Password, Role)
        VALUES ('$address', '$username', '$password', '$role')
    ";

    mysqli_query($conn, $sql);
    $userID = mysqli_insert_id($conn);
    return $userID;
  }

  function addNewShop($conn, $shopName, $shopAddress, $shopDescription) {
    $sql = "
      INSERT INTO shop (UserID, Name, Description, Address)
      VALUES ($userID, '$shopName', '$shopDescription', '$shopAddress')
    ";

    mysqli_query($conn, $sql);
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.11.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.css" type="text/css">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.11.0/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.js"></script>
  
    <style>
      #map { position: absolute; top: 0; bottom: 0; width: 100%; }

      .suggestion-container {
        z-index: 20;
      }

      .suggestion-item:hover {
        background-color: whitesmoke;
        cursor: pointer;
      }
    </style>
  </head>
  <body class="d-flex align-items-center" style="height: 100vh;">
    <div class="container p-0 w-auto h-auto border rounded shadow d-flex justify-content-center">
      <div class="row h-auto" style="width: 900px;">
        <div class="col-6 h-10 px-5 pt-5 pb-3" style="position: relative;">
          <a class="w-100 h-100" href="login.php"><i class="bi bi-arrow-left text-primary p-3" style="position: absolute; top: 0; left: 10px; cursor: pointer"></i></a>
          
          <form class="needs-validation mt-3" method="post" action="" novalidate>
            <div class="form-group mb-2" style="position: relative">
              <label for="">Address*</label>  
              <input type="text" class="form-control" name="address" autocomplete="off" required>
              <div class="invalid-feedback">Can't be empty</div>
              <div class="suggestion-container w-100 mt-2" style="position: absolute;">
                <div class="suggestions-0 border bg-white rounded shadow p-3" style="display: none">
                  <p class="suggestion-item"><i class="bi bi-geo-alt-fill"></i> ABC</p>
                </div>
              </div>
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
            

            <div class ="mt-3 shop-info" style="visibility: hidden">
              <div class="row mb-2">
                <div class="col-md-6 col-12">
                  <label for="">Shop Name*</label>
                  <input type="text" class="form-control" name="shopName">
                  <div class="invalid-feedback">Can't be empty</div>
                </div>

                <div class="col-md-6 col-12">
                  <label for="">Shop Description</label>
                  <input type="text" class="form-control" name="shopDescription">
                </div>
              </div>
              
              <div class="form-group mb-2" style="position: relative">
                <label for="">Address*</label>  
                <input type="text" class="form-control" name="shopAddress" autocomplete="off" required>
                <div class="invalid-feedback">Can't be empty</div>
                <div class="suggestion-container w-100 mt-2" style="position: absolute;">
                  <div class="suggestions-1 border bg-white rounded shadow p-3" style="display: none">
                    <p class="suggestion-item"><i class="bi bi-geo-alt-fill"></i> ABC</p>
                  </div>
                </div>
              </div>
            </div>

            <button class="btn btn-outline-primary w-100 mt-3" type="submit">Register</button>
            <small>Already have an account? <a href="login.php" style="text-decoration: none">Sign In</a></small>
          </form>
        </div>

        <div class="col-6 p-0">
          <div class="h-100 w-100" style="position: relative;">
            <div id="map">

            </div>
          </div>
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

        mapboxgl.accessToken = '<?= ACCESS_TOKEN ?>'

        const map = new mapboxgl.Map({
          container: 'map',
          style: 'mapbox://styles/mapbox/streets-v11',
          center: [-122.4194, 37.7749],
          zoom: 10
        })

        const shopInfo = document.querySelector('.shop-info')
        const btns = document.querySelectorAll('input[type="radio"]')
        const selectedBtn = document.querySelectorAll('input[type="radio"]:checked')
        const addressInputs = document.querySelectorAll('input[name*=ddress]')
        
        btns.forEach((btn) => {
          btn.onclick = () => {
            shopInfo.style.visibility = btn.value == 'Seller' ? 'visible' : 'hidden'
            const shopFields = document.querySelectorAll('input[name^=shop]')
            shopFields.forEach((field) => {
              field.required = btn.value == 'Seller' ? true : false;
            })
          }
        })

        addressInputs.forEach((input, index) => {
          const suggestions = document.querySelector(`.suggestions-${index}`)

          input.oninput = async () => {
            if (input.value.length < 3) {
              suggestions.innerHTML = '';
              suggestions.style.display = 'none';
              return
            }

            const text = encodeURIComponent(input.value)
            const res = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${text}.json?autocomplete=true&access_token=${mapboxgl.accessToken}`)
            const data = await res.json()

            suggestions.innerHTML = '';
            suggestions.style.display = 'block';
            data.features.forEach((feature) => {
              const suggestion = document.createElement('p');
              suggestion.innerHTML = `<i class="bi bi-geo-alt-fill"></i> ${feature.place_name}`
              suggestion.className = 'suggestion-item rounded p-2'
              suggestion.onclick = () => {
                map.flyTo({
                  center: feature.center, 
                  zoom: 14
                })

                new mapboxgl.Marker({color: 'black'}).setLngLat(feature.center).addTo(map)

                suggestions.innerHTML = '';
                suggestions.style.display = 'none';
                input.value = feature.place_name;
              }
              suggestions.appendChild(suggestion);
            })
          }
        })

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
