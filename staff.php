<?php 
    session_start();

    if (!isset($_GET['type'])) {
        header('Location: staff.php?type=orders');
    }

    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
        header('Location: views/partials/login.php');
    } 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Orders - Staff Panel</title>
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="css/staff.css"> 

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
</head>
<body class="h-auto">
    <div class="container-fluid h-100">
        <div class="row flex-nowrap h-100">
            <div class="bg-dark w-auto p-3 menu h-auto">
                <span class="text-light">
                    STAFF
                    <i class="bi bi-list"></i>
                </span> 

                <div class="mt-5">
                    <a href="staff.php?type=orders" style="text-decoration: none" class="orders-menu">
                        <i class="bi bi-hourglass"></i> Pending Orders
                    </a>
                </div>

                <div class="mt-3">
                    <a href="staff.php?type=refunds" style="text-decoration: none" class="refunds-menu">
                        <i class="bi bi-hourglass"></i> Pending Refunds
                    </a>
                </div>
            </div>

            <div class="flex-fill h-100">
                <?php include('views/partials/staff_' . $_GET['type'] . '.php') ?>
            </div>  
        </div>
    </div>
    

<script src="js/bootstrap.min.js"></script>
<script>
    window.addEventListener('load', () => {
        const params = new URLSearchParams(window.location.search)
        const type = params.get('type')

        const menuItems = document.querySelectorAll('.menu a')

        console.log(menuItems)

        menuItems.forEach((item) => {
            if (item.className.includes(type)) {
                item.classList.add('text-light')
            } else {
                item.classList.remove('text-light')
                item.classList.add('text-secondary')
            }
        })
    })
</script>
</body>
</html>
