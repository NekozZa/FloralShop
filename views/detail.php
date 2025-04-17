<?php include '../controller/database.php' ?>

<?php 
    session_start();
    include '../controller/product.php';
    
    $productID = $_GET['productID'];
    $product = getProductByID($conn, $productID);
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
                    <span class="breadcrumb-item active">Shop Detail</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="../public/img/product-img-<?= $product['ProductID'] ?>.jpg?v=<?php echo time(); ?>" alt="Image">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3><?= $product['Name'] ?></h3>
                    <div class="d-flex align-items-center mb-3">
                        <?php include './partials/product_rating.php' ?>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">$<?= $product['Price'] ?></h3>
                    <p class="mb-4"><?= $product['Description'] ?></p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-primary px-3 add-item-btn" data-product-i-d=<?= $product['ProductID'] ?>><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (<?= $product['CountReviews'] ?>)</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Product Description</h4>
                            <p><?= $product['Description'] ?></p>
                        </div>
                        
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php 
                                        $sql = "
                                            SELECT Comment, CreateDate, Rating, Username 
                                            FROM productreview
                                            INNER JOIN account ON productreview.UserID=account.UserID
                                            WHERE productreview.ProductID=$productID
                                        ";

                                        $res = mysqli_query($conn, $sql);
                                    ?>

                                    <h4 class="mb-4"><?= mysqli_num_rows($res) ?> review for "<?= $product['Name'] ?>"</h4>

                                    <?php if (mysqli_num_rows($res) > 0) { ?>
                                        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                                            <div class="media mb-4">
                                                <div class="media-body">
                                                    <h6><?= $row['Username'] ?><small> - <i><?= $row['CreateDate'] ?></i></small></h6>
                                                    <div class="text-primary d-flex mb-2">                                                            
                                                        <div>
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                                <?php if ($i <= $row['Rating']) { ?>
                                                                    <i class="fas fa-star"></i>
                                                                <?php } else { ?>
                                                                    <i class="far fa-star"></i>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <p><?= $row['Comment'] ?></p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6">
                                    <?php 
                                        if (isset($_SESSION['UserID'])) {
                                            $userID = $_SESSION['UserID'];

                                            $sql = "
                                                SELECT * 
                                                FROM shop
                                                INNER JOIN product ON shop.shopID = product.shopID
                                                WHERE shop.UserID = $userID and product.ProductID = $productID
                                            ";

                                            $res = mysqli_query($conn, $sql);
                                            $isOwner = mysqli_num_rows($res) > 0 ? true : false;
                                    ?>

                                        <?php if ($isOwner) { ?>
                                            <h4 class="mb-1">This is your product!</h4>
                                            <p class="text-danger">You can not review your product!</p>
                                        <?php } else { ?>
                                            <h4 class="mb-4">Leave a review</h4>
                                            <div class="d-flex my-3">
                                                <p class="mb-0 mr-2">Your Rating * :</p>
                                                <div class="text-primary">
                                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                        <button class="btn p-0 text-primary" value="<?= $i ?>" onclick="updateRating(event)">
                                                            <i class="far fa-star" style="pointer-events: none;"></i>
                                                        </button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="form-group">
                                                    <label for="message">Your Review *</label>
                                                    <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <button class="btn btn-primary add-comment-btn px-3" onclick="addComment(<?= $productID ?>)">Leave Your Review</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <h4 class="mb-1">You haven't logged in!</h4>
                                        <h3><a href="login.php">Log in now</a></h3>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                    <div class="owl-carousel related-carousel">
                        <?php 
                            $categoryID = $product['CategoryID'];
                            $randomProductsByCategory = getRandomProductsByCategory($conn, $categoryID, 8);
                        ?>

                        <?php if (mysqli_num_rows($randomProductsByCategory) > 0) { ?>
                            <?php while ($product = mysqli_fetch_assoc($randomProductsByCategory)) { ?>
                                <?php if ($product['ProductID'] != $productID) { ?>
                                    <?php include './partials/product.php' ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
        </div>
    </div>
    <!-- Products End -->


    <!-- Footer Start -->
    <?php include './partials/footer.php' ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <script src="/public/js/detail.js"></script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/public/lib/easing/easing.min.js"></script>
    <script src="/public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="/public/js/main.js"></script>
</body>

</html>