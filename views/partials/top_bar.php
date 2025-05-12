<?php session_start(); ?>
<div class="main-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="custom-select-box">
                    <select id="basic" class="selectpicker show-tick form-control" data-placeholder="$ USD">
                        <option>¥ JPY</option>
                        <option>$ USD</option>
                        <option>€ EUR</option>
                    </select>
                </div>
                <div class="right-phone-box">
                    <p>Call US :- <a href="#"> +11 900 800 100</a></p>
                </div>
                <div class="our-link">
                    <ul>
                        <li><a href="#"><i class="fa fa-user s_color"></i> My Account</a></li>
                        <li><a href="#"><i class="fas fa-location-arrow"></i> Our location</a></li>
                        <li><a href="#"><i class="fas fa-headset"></i> Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="login-box">
                    <?php if (!isset($_SESSION['user_id'])): ?>
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
