<?php 
    include '../controller/database.php';
    include '../controller/mapbox.php';

    session_start();

    if (!isset($_GET['orderItemID'])) {
        header('Location: index.php');
    }

    $orderItemID = $_GET['orderItemID'];

    $sql = "
        SELECT Route
        FROM orderitem
        WHERE orderItemID = $orderItemID
    ";

    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    $route = $data['Route'];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="/public/css/style.css" rel="stylesheet">

    <link href="https://api.mapbox.com/mapbox-gl-js/v3.11.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.css" type="text/css">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.11.0/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.js"></script>

    <style>
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
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
                <div class="col-md-6">

                </div>

                <div class="col-md-6"style="position: relative; height: 50vh">
                    <div id="map"></div>
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
            mapboxgl.accessToken = '<?= ACCESS_TOKEN ?>'
            const map = new mapboxgl.Map({
                container: 'map',
                // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [-79.4512, 43.6568],
                zoom: 13
            });


            const route = '<?= $route ?>'
            const stations = route.split(';')
            const start = stations[0].split(',').map(Number)
            const end = stations[1].split(',').map(Number)

            new mapboxgl.Marker({ color: 'green' }).setLngLat(start).addTo(map);
            new mapboxgl.Marker({ color: 'red' }).setLngLat(end).addTo(map);

            async function getRoute(start, end) {
                const res = await fetch(`https://api.mapbox.com/directions/v5/mapbox/driving/${route}?access_token=${mapboxgl.accessToken}&steps=true&geometries=geojson`)
                const data = await res.json();
                const directions = data.routes[0].geometry.coordinates;

                map.setCenter(directions[directions.length / 2]); // Set the map center to the first coordinate of the route
                map.setZoom(13);

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