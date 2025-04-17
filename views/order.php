<?php include '../controller/database.php' ?>

<?php 
    session_start();
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
                        <?php 
                            if (isset($_SESSION['UserID'])) {
                                $id = $_SESSION['UserID'];

                                $sql = "
                                    SELECT 
                                        order.OrderID,
                                        order.Status,
                                        product.ProductID,
                                        product.Name as ProductName,
                                        product.Price,
                                        orderitem.OrderItemID,
                                        orderitem.Quantity,
                                        orderitem.Price as Total,
                                        shop.Name as ShopName
                                    FROM account
                                    INNER JOIN `order` ON account.UserID = `order`.UserID
                                    INNER JOIN orderitem ON `order`.OrderID = orderitem.OrderID
                                    INNER JOIN product ON orderitem.ProductID = product.ProductID
                                    INNER JOIN shop ON product.ShopID = shop.ShopID
                                    WHERE account.UserID = $id
                                ";

                                $res = mysqli_query($conn, $sql);
                            }
                        ?>
                        <?php if (mysqli_num_rows($res) > 0) { ?>
                            <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                                <tr class="product-<?= $row['ProductID'] ?>" onclick="viewOrderDetail(<?= $row['OrderItemID'] ?>)" style="cursor: pointer;">
                                    <td class="d-flex justify-content-start align-items-center"><img src="/public/img/product-img-<?= $row['ProductID'] ?>.jpg?v=<?php echo time(); ?>" alt="" style="width: 50px;"><?= $row['ProductName'] ?></td>
                                    <td class="align-middle price"><?= $row['Price'] ?></td>
                                    <td class="align-middle"><?= $row['Quantity'] ?></td>
                                    <td class="align-middle total"><?= $row['Total'] ?></td>
                                    <td class="align-middle"><?= $row['Status'] ?></td>
                                    <td class="align-middle"><?= $row['ShopName'] ?></td>
                                </tr>
                            <?php } ?>
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