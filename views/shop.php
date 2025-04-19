<?php  
    session_start();
    include '../controller/database.php';

    $limit = 20;
    $products = null;

    if (isset($_GET['categoryID'])) {
        $products = getRandomProductsByCategory ($conn, $_GET['categoryID'], $limit);
    } else if (isset($_GET['search'])) { 
        $products = getProductsBySearchBar($conn, $_GET['search'], $limit);
    } else if (isset($_GET['sorting'])) {
        $products = getProductsOrderedByField ($conn, $_GET['sorting'], 'DESC', $limit);
    } else {
        $products = getRandomProducts($conn, $limit);
    }
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
                    <span class="breadcrumb-item active">Shop List</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-1" value="0-100">
                            <label class="custom-control-label" for="price-1">$0 - $100</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-2" value="100-200">
                            <label class="custom-control-label" for="price-2">$100 - $200</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-3" value="200-300">
                            <label class="custom-control-label" for="price-3">$200 - $300</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-4" value="300-400">
                            <label class="custom-control-label" for="price-4">$300 - $400</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="price-5" value="400-500">
                            <label class="custom-control-label" for="price-5">$400 - $500</label>
                        </div>
                    </form>
                </div>
                <!-- Price End -->

                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Locations</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-1" value="0-100">
                            <label class="custom-control-label" for="price-1">Ho Chi Minh City</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-2" value="100-200">
                            <label class="custom-control-label" for="price-2">Ha Noi</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-3" value="200-300">
                            <label class="custom-control-label" for="price-3">Da Nang</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-4" value="300-400">
                            <label class="custom-control-label" for="price-4">Vung Tau</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="price-5" value="400-500">
                            <label class="custom-control-label" for="price-5">Hue</label>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a 
                                            class="dropdown-item <?= (isset($_GET['sorting']) && $_GET['sorting'] == 'CountReviews') ? 'text-primary' : '' ?>" 
                                            onclick="setSorting('CountReviews')" 
                                            style="cursor: pointer"
                                        >
                                            Popularity
                                        </a>

                                        <a 
                                            class="dropdown-item <?= (isset($_GET['sorting']) && $_GET['sorting'] == 'AvgRating') ? 'text-primary' : '' ?>" 
                                            onclick="setSorting('AvgRating')" 
                                            style="cursor: pointer"
                                        >
                                            Best Rating
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <?php if (count($products) > 0) { ?>
                        <?php foreach($products as $product) { ?>
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1 product">
                                <?php include './partials/product.php' ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->


    <!-- Footer Start -->
    <?php include './partials/footer.php' ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <script src="../public/js/shop.js?v=<?php echo time(); ?>"></script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/public/lib/easing/easing.min.js"></script>
    <script src="/public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="/public/js/main.js"></script>
</body>

</html>