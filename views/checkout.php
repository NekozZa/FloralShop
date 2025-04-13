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
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
                <div class="mb-5 ">
                    <div class="row mb-1">
                        <div class="col-md-12 form-group">
                            <div class="bg-light p-3 rounded border field">
                                <label>Address</label>
                                <input class="form-control address" type="text" placeholder="123 Street">
                            </div>
                            
                        </div>
                    </div>

                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6 mb-4">
                            <div class="bg-light p-3 rounded border field">
                                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Payment</span></h5>
                                <div class="">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="payment" id="paypal" value="Paypal">
                                            <label class="custom-control-label" for="paypal">Paypal</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="payment" id="directcheck" value="Direct Check">
                                            <label class="custom-control-label" for="directcheck">Direct Check</label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="payment" id="banktransfer" value="Bank Transfer">
                                            <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded border field">
                                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Shipping</span></h5>
                                <div class="">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="shipping" id="regular" value="Regular" onclick="setShippingPrice(5)">
                                            <label class="custom-control-label" for="regular">Regular</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="shipping" id="fast" value="Fast" onclick="setShippingPrice(10)">
                                            <label class="custom-control-label" for="fast">Fast</label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="shipping" id="flash" value="Flash" onclick="setShippingPrice(20)">
                                            <label class="custom-control-label" for="flash">Flash</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse mb-5" id="shipping-address">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Shipping Address</span></h5>
                    <div class="bg-light p-30">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Address Line</label>
                                <input class="form-control" type="text" placeholder="123 Street">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                <div class="bg-light p-30 mb-3">
                    <div class="border-bottom">
                        <h6 class="mb-3">Products</h6>
                        <?php 
                            if (isset($_SESSION['UserID'])) {
                                $id = $_SESSION['UserID'];

                                $sql = "
                                    SELECT 
                                        product.Name,  
                                        product.Price * cartItem.quantity as 'Total'
                                    FROM account
                                    INNER JOIN cart ON account.UserID = cart.UserID
                                    INNER JOIN cartitem ON cart.CartID = cartitem.CartID
                                    INNER JOIN product ON product.ProductID = cartitem.ProductID
                                    WHERE account.UserID = $id
                                ";

                                $res = mysqli_query($conn, $sql);
                            }
                        ?>
                        <?php if (mysqli_num_rows($res) > 0) { ?>
                            <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                                <div class="d-flex justify-content-between">
                                    <p><?= $row['Name'] ?></p>
                                    <p class="total"><?= $row['Total'] ?></p>
                                </div>
                            <?php } ?>
                        <?php } else {?>
                            <strong class="text-danger">Your cart is empty!</strong>
                        <?php } ?>
                    </div>
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 class="checkout-subtotal">$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium shipping-expense">$0</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 class="checkout-total">$160</h5>
                        </div>
                    </div>
                </div>

                <button 
                    class="btn btn-block btn-primary font-weight-bold py-3 place-order-btn" 
                    style="display: <?= mysqli_num_rows($res) > 0 ? 'block' : 'none' ?>" 
                    onclick="placeOrder()"
                >
                        Place Order
                </button>
            </div>
        </div>
    </div>
    <!-- Checkout End -->


    <!-- Footer Start -->
    <?php include './partials/footer.php' ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <script src="../public/js/checkout.js?v=<?php echo time(); ?>"></script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/public/lib/easing/easing.min.js"></script>
    <script src="/public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="/public/js/main.js"></script>
</body>

</html>