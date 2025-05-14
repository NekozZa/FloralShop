<?php 
    session_start();

    if (!isset($_GET['type'])) {
        header('Location: admin.php?type=performance');
    }

    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header('Location: views/partials/login.php');
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" 
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" 
        crossorigin="anonymous"
        rel="stylesheet" 
    >

    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cal+Sans&display=swap');

        body {
            font-family: "Cal Sans", sans-serif;
        }

        a {
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body style='min-height: 100vh; height: 100vh'>
    <div class="container-fluid h-100">
        <div class="row d-flex flex-nowrap h-100">
            <div class="bg-dark p-3 w-auto" style="width: 10%;">
                <div class='text-light menu'>
                    <span >ADMIN <i class="bi bi-list"></i></span>

                    <div class='mt-5'>
                        <div class='d-flex justify-content-start'>
                            <a href="admin.php?type=performance" class="performance-menu">
                                <i class="bi bi-bar-chart-line-fill me-1"></i>  Dashboard
                            </a>
                        </div>
                    </div>

                    <div class='mt-3'>
                        <div class='d-flex justify-content-start'>
                            <a href="admin.php?type=staff" class="staff-menu">
                                <i class="bi bi-people-fill me-1"></i> Staff Management
                            </a>
                        </div>
                    </div>

                    <div class='mt-3'>
                        <div class='d-flex justify-content-start text-secondary'>
                            <a href="admin.php?type=storage" class="order-menu">
                                <i class="bi bi-box me-1"></i> Storage Management
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('views/partials/admin_' . $_GET['type'] . '.php') ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" 
        crossorigin="anonymous">
    </script>

    <script>
        window.addEventListener('load', () => {
            const params = new URLSearchParams(window.location.search)
            const type = params.get('type')

            const menuItems = document.querySelectorAll('.menu a')
            menuItems.forEach((item) => {
                if (item.className.includes(type)) {
                    item.classList.add('text-light')
                } else {
                    item.classList.remove('text-light')
                    item.classList.add('text-secondary')
                }
            })
        })
        
        function logOut() {
            sessionStorage.clear()
            window.location.href = 'views/partials/login.php'
        }
    </script>
</body>
</html>