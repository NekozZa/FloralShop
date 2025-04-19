<?php 
    session_start();
    include '../controller/database.php';

    $orderItems = isset($_SESSION['UserID']) ? getOrderItems($conn) : [];
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
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="/public/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <?php include './partials/topbar.php' ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <?php include './partials/navbar.php' ?>
    <!-- Navbar End -->


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="index.php">Home</a>
                    <span class="breadcrumb-item active">Orders</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid" style="min-height: 25vh">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Shop</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php foreach($orderItems as $orderItem) { ?>
                            <tr 
                                class="product-<?= $orderItem['ProductID'] ?>" 
                                onclick="viewOrderDetail(<?= $orderItem['OrderItemID'] ?>)" 
                                style="cursor: pointer;"
                            >
                                <td class="d-flex justify-content-start align-items-center">
                                    <img src="/public/img/product-img-<?= $orderItem['ProductID'] ?>.jpg?v=<?php echo time(); ?>" 
                                    style="width: 50px;"
                                >
                                    <?= $orderItem['ProductName'] ?>
                                </td>

                                <td class="align-middle price"><?= $orderItem['Price'] ?></td>
                                <td class="align-middle"><?= $orderItem['Quantity'] ?></td>
                                <td class="align-middle total"><?= $orderItem['Total'] ?></td>
                                <td class="align-middle"><?= $orderItem['Status'] ?></td>
                                <td class="align-middle"><?= $orderItem['ShopName'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Cart End -->


    <!-- Footer Start -->
    <?php include './partials/footer.php' ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <script>
        function viewOrderDetail(orderItemID) {
            window.location.href = `/views/delivery.php?orderItemID=${orderItemID}`
        }

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