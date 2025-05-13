<div class="main-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="our-link">
                    <ul>
                        <li><a href="my-account.php"><i class="fa fa-user s_color"></i> My Account</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="login-box">
                    <?php if (!isset($_SESSION['account_id'])): ?>
                        <select id="loginDropdown" class="selectpicker show-tick form-control" data-placeholder="Sign In">
                            <option selected disabled>Sign In</option>
                            <option value="views/partials/register.php">Register Here</option>
                            <option value="views/partials/login.php">Sign In</option>
                        </select>
                        <script>
                            document.getElementById('loginDropdown').addEventListener('change', function () {
                                const targetUrl = this.value;
                                if (targetUrl) {
                                    window.location.href = targetUrl;
                                }
                            });
                        </script>
                    <?php else: ?>
                        <span class="text-white mr-2">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                        <a href="views/partials/logout.php" class="btn btn-sm btn-outline-danger">Logout</a>
                    <?php endif; ?>
                </div>
                <div class="text-slid-box">
                    <div id="offer-box" class="carouselTicker">
                        <ul class="offer-box">
                            <li><i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT80</li>
                            <li><i class="fab fa-opencart"></i> 50% - 80% off on Vegetables</li>
                            <li><i class="fab fa-opencart"></i> Off 10%! Shop Vegetables</li>
                            <li><i class="fab fa-opencart"></i> Off 50%! Shop Now</li>
                            <li><i class="fab fa-opencart"></i> Off 10%! Shop Vegetables</li>
                            <li><i class="fab fa-opencart"></i> 50% - 80% off on Vegetables</li>
                            <li><i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT30</li>
                            <li><i class="fab fa-opencart"></i> Off 50%! Shop Now</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
