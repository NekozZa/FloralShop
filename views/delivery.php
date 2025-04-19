<?php 
    include '../controller/database.php';
    include '../controller/mapbox.php';

    session_start();

    if (!isset($_GET['orderItemID'])) {
        header('Location: index.php');
    }

    $orderItemID = $_GET['orderItemID'];

    $sql = "
        SELECT Route, shop.Address as Start, `order`.Address as End
        FROM orderitem
        INNER JOIN `order` ON `order`.OrderID = orderitem.OrderID
        INNER JOIN product ON orderitem.ProductID = product.ProductID
        INNER JOIN shop ON product.ShopID = shop.ShopID
        WHERE orderItemID = $orderItemID

    ";

    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    $route = $data['Route'];
    $start = $data['Start'];
    $end = $data['End'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="/public/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="/public/css/style.css" rel="stylesheet">

    <link href="https://api.mapbox.com/mapbox-gl-js/v3.11.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.css" type="text/css">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.11.0/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.js"></script>

    <style>
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }

        .bootstrap-marker {
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        ul {
            list-style: none;
            padding: 0;
        }
        li {
            color: #D8D8D8;
            position: relative;
            padding: 10px;
        }
        
        li:before {
            content: '';
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #D8D8D8;
            position: absolute;
            left: -15px;
            top: 50%;
            transform: translateY(-40%);
        }

        li:not(:last-child):after {
            content: '';
            width: 2px;
            height: 100%;
            background: #D8D8D8;
            position: absolute;
            left: -8px;
            top: 50%;
        }

        .pass:not(:last-child):after,
        .pass:before {
            background: #3d464d;
        }

        .pass {
            color: #3d464d;
        }
    </style>
</head>

    <body>
        <!-- Topbar Start -->
        <?php include './partials/topbar.php' ?>
        <!-- Topbar End -->


        <!-- Navbar Start -->
        <?php include './partials/navbar.php' ?>
        <!-- Navbar End -->


        <!-- Carousel Start -->
        

        <!-- Products Start -->
        <div class="container pt-5 pb-3" >
            <div class="row">
                <div class="col-md-4 border rounded p-5 h-auto">
                    <h6 class="text-dark"><i class="bi bi-box-seam-fill"></i> </i>Order Delivery Tracker</h6>
                    <ul>
                        <li class="pass"><?= $start ?></li>

                        <li>...</li>

                        <li><?= $end ?></li>
                    </ul>
                </div>

                <div class="col-md-8"style="position: relative; height: 50vh">
                    <div class="border" id="map"></div>
                </div>
            </div>
            
        </div>
        <!-- Products End -->


    
        <!-- Footer Start -->
        <?php include './partials/footer.php' ?>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
        
        <script>
            const route = '<?= $route ?>'
            const stations = route.split(';')
            const start = stations[0].split(',').map(Number)
            const end = stations[1].split(',').map(Number)

            mapboxgl.accessToken = '<?= ACCESS_TOKEN ?>'
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: start,
                zoom: 13
            });


            const startMarker = document.createElement('div')
            startMarker.className = 'bootstrap-marker text-danger'
            startMarker.innerHTML = '<i class="bi bi-geo-alt-fill"></i>'

            const endMarker = document.createElement('div')
            endMarker.className = 'bootstrap-marker text-danger'
            endMarker.innerHTML = '<i class="bi bi-flag-fill"></i>'

            new mapboxgl.Marker(startMarker).setLngLat(start).addTo(map)
            new mapboxgl.Marker(endMarker).setLngLat(end).addTo(map)

            async function getRoute(start, end) {
                const res = await fetch(`https://api.mapbox.com/directions/v5/mapbox/driving/${route}?access_token=${mapboxgl.accessToken}&steps=true&geometries=geojson`)
                const data = await res.json();
                const directions = data.routes[0].geometry.coordinates;

                const bounds = new mapboxgl.LngLatBounds()
                bounds.extend(start)
                bounds.extend(end)

                map.fitBounds(bounds, {
                    padding: 50
                })

                map.addSource('route', {
                    type: 'geojson',
                    data: {
                        type: 'Feature',
                        properties: {},
                        geometry: {
                            type: 'LineString',
                            coordinates: directions
                        }
                    }
                });

                map.addLayer({
                    id: 'route',
                    type: 'line',
                    source: 'route',
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    paint: {
                        'line-color': '#3887be',
                        'line-width': 5,
                        'line-opacity': 0.75
                    }
                });
            }

            map.on('load', () => {
                getRoute(start, end)
            })
        </script>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="/public/lib/easing/easing.min.js"></script>
        <script src="/public/lib/owlcarousel/owl.carousel.min.js"></script>

        <!-- Template Javascript -->
        <script src="/public/js/main.js"></script>
    </body>

</html>