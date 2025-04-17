<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.min.css">


<div class="container-fluid bg-dark mb-30" style="position: sticky; top: 0px; z-index: 300">
    <div class="row px-xl-5" style="position: relative">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    <?php 
                        $sql = "SELECT * FROM category";
                        $res = mysqli_query($conn, $sql);
                    ?>

                    <?php if (mysqli_num_rows($res) > 0) { ?>
                        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                            <a href="/views/shop.php?categoryID=<?= $row['CategoryID'] ?>" class="nav-item nav-link"><?= $row['Name'] ?></a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="index.php" class="text-decoration-none d-block d-lg-none">
                    <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="shop.php" class="nav-item nav-link">Shop</a>
                        <?php if (isset($_SESSION['Role']) && $_SESSION['Role'] === 'Seller') { ?>
                            <?php 
                                $userID = $_SESSION['UserID'];

                                $sql = "
                                    SELECT ShopID
                                    FROM shop
                                    WHERE shop.UserID = $userID
                                ";

                                $res = mysqli_query($conn, $sql);
                                $data = mysqli_fetch_assoc($res);
                            ?>

                            <a href="seller.php?shopID=<?= $data['ShopID'] ?>" class="nav-item nav-link">Shop Detail</a>
                        <?php } ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                            <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                <a href="cart.php" class="dropdown-item">Shopping Cart</a>
                                <a href="checkout.php" class="dropdown-item">Checkout</a>
                            </div>
                        </div>
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <a href="order.php" class="btn px-0 ml-3">
                            <i class="ri-truck-fill text-primary" style="font-size: 22px"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;"><?= isset($orderCount) ? $orderCount : 0 ?></span>                            
                        </a>

                        <a href="cart.php" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-primary" ></i>
                            <span class="badge text-secondary border border-secondary rounded-circle item-count" style="padding-bottom: 2px;"><?= isset($itemCount) ? $itemCount : 0 ?></span>      
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>


