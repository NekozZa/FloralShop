<?php 
    session_start();
    include '../controller/database.php';

    $cartItems = isset($_SESSION['UserID']) ? getCartItems($conn) : [];
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
                    <span class="breadcrumb-item active">Shopping Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php foreach($cartItems as $cartItem) { ?>
                            
                            <tr class="product-<?= $cartItem['ProductID'] ?>">
                                <td class="align-middle">
                                    <img 
                                        src="../public/img/product-img-<?= $cartItem['ProductID'] ?>.jpg?v=<?php echo time(); ?>" 
                                        alt="" 
                                        style="width: 50px;"
                                    >
                                    <?= $cartItem['Name'] ?>
                                </td>
                                
                                <td class="align-middle price"><?= $cartItem['Price'] ?></td>
                                
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button 
                                                class="btn btn-sm btn-primary btn-minus" 
                                                onclick="updateQuantity(<?= $cartItem['ProductID'] ?>, -1)"
                                            >
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>

                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm bg-secondary border-0 text-center" 
                                            value="<?= $cartItem['Quantity'] ?>"
                                        >

                                        <div class="input-group-btn">
                                            <button 
                                                class="btn btn-sm btn-primary btn-plus " 
                                                onclick="updateQuantity(<?= $cartItem['ProductID'] ?>, 1)"
                                            >
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="align-middle total"><?= $cartItem['Total'] ?></td>

                                <td class="align-middle">
                                    <button 
                                        class="btn btn-sm btn-danger" 
                                        onclick="deleteItem(<?= $cartItem['ProductID'] ?>)"
                                    >
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 class="checkout-total">$160</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3 checkout">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->


    <!-- Footer Start -->
    <?php include './partials/footer.php' ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    
    <script src="../public/js/cart.js?v=<?php echo time(); ?>"></script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/public/lib/easing/easing.min.js"></script>
    <script src="/public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="/public/js/main.js"></script>
</body>

</html>