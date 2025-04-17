<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-12 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">My Account</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(!isset($_SESSION['UserID'])) {?>
                            <a href='login.php' class="dropdown-item" type="button">Sign in</a>
                            <a href='register.php' class="dropdown-item" type="button">Sign up</a>
                        <?php } else { ?>
                            <button class="dropdown-item logout-btn" type="button">Log out</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="d-inline-flex align-items-center d-block d-lg-none">
                <a href="cart.php" class="btn px-0 ml-2">
                    
                    <?php 
                        if (isset($_SESSION['UserID'])) {
                            $id = $_SESSION['UserID'];

                            $sql = "
                                SELECT COUNT(cartitem.CartItemID) as ItemCount
                                FROM account
                                INNER JOIN cart ON account.UserID = cart.UserID
                                INNER JOIN cartitem ON cart.CartID = cartitem.CartID
                                WHERE account.UserID = $id
                            ";

                            $res = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($res);
                            $itemCount = $row['ItemCount'];

                            $sql = "
                                SELECT COUNT(OrderItemID) as OrderCount
                                FROM `order`
                                INNER JOIN orderitem ON order.OrderID = orderitem.OrderID
                                WHERE order.UserID = $id 
                            ";

                            $res = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($res);
                            $orderCount = $row['OrderCount'];
                        }
                    ?>
                    <i class="ri-truck-fill text-dark ml-3" style="font-size: 22px"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;"><?= isset($orderCount) ? $orderCount : 0 ?></span>

                    <i class="fas fa-shopping-cart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle item-count" style="padding-bottom: 2px;"><?= isset($itemCount) ? $itemCount : 0 ?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            <a href="login.php" class="text-decoration-none">
                <span class="h1 text-uppercase text-primary bg-dark px-2">Multi</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shop</span>
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form method="GET" action="/views/shop.php">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search for products">
                    <span class="input-group-text bg-transparent text-primary" style="cursor: pointer;">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-6 text-right">
            <p class="m-0">Customer Service</p>
            <h5 class="m-0">+012 345 6789</h5>
        </div>
    </div>
</div>

<script>

    const btn = document.querySelector('form span')
    const logout = document.querySelector('.logout-btn')

    btn.onclick = () => {
        document.querySelector('form').submit()
    }

    if (logout) {
        logout.onclick = () => {
            console.log('Test')
            window.location.href = 'logout.php'
        }
    }
    
</script>