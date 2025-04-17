<?php include '../controller/database.php' ?>

<?php 
    session_start();
    include '../controller/product.php';

    if (!isset($_SESSION['UserID'])) {
        header('Location: login.php');
    }

    $shopID = $_GET['shopID'];
    $products = getShopProductsByShopID ($conn, $shopID);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="/public/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <?php include './partials/topbar.php' ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <?php include './partials/navbar.php' ?>

    <div class="container-fluid px-5 shadow-sm border-bottom" style="height: auto">
        <div class="row mb-3">
            <div class="col-lg-3 ps-0 mb-3">
                <div class="border rounded p-2 d-flex" style="height: auto">
                    <div class="border rounded rounded-circle" onclick="addShopImage()" style="height: 10vh; width: 10vh; overflow: hidden">
                        <?php 
                            $type = 'img';
                            $content = 'Select avatar';
                            include './partials/drop_zone.php'
                        ?>
                    </div>

                    <div class="ml-3 mt-3 text-primary">
                        <?php 
                            $sql = "
                                SELECT Name, Description
                                FROM shop
                                WHERE shop.ShopID = $shopID
                            ";
                    
                            $data = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($data);
                        ?>

                        <?= $row['Name'] ?>
                        <p class="text-dark">
                            <small><?= $row['Description'] ?></small>    
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 p-0 d-flex justify-content-between">
                <ul class="m-0 p-0" style="list-style: none">
                    <li class="mb-2">
                        <?php 
                            $sql = "
                                SELECT COUNT(product.ProductID) as TotalProducts
                                FROM shop
                                INNER JOIN product ON shop.ShopID = product.ShopID 
                                WHERE shop.ShopID = $shopID
                            ";
                    
                            $data = mysqli_query($conn, $sql);
                            $length = mysqli_fetch_assoc($data);
                        ?>
                        <i class="bi bi-box-seam"></i> Products: <?= $length['TotalProducts'] ?>
                    </li>
                    <li>
                        <?php 
                            $sql = "
                                SELECT AVG(productreview.Rating) as AvgRating
                                FROM shop
                                INNER JOIN product ON shop.ShopID = product.ShopID 
                                INNER JOIN productreview ON product.ProductID = productreview.ProductID
                                WHERE shop.ShopID = $shopID
                            ";

                            $data = mysqli_query($conn, $sql);
                            $rating = mysqli_fetch_assoc($data);
                        ?>
                        <i class="bi bi-star"></i> Rating: <?= number_format($rating['AvgRating'], 2, '.', '') ?>
                    </li>
                </ul>

                <ul class="ms-auto align-self-start">
                    <button class="btn btn-primary " data-bs-toggle="modal"  data-bs-target="#addProduct">Add product</button>
                    <button class="btn btn-primary" data-bs-toggle="modal"  data-bs-target="#listOrder">List order</button>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-5 pb-3">
        <div class="row px-3 px-xl-5" style="min-height: 10vh">
            <div class="rounded d-flex align-items-center" style="width: 100%">
                <?php 
                    $type = 'banner';
                    $content = 'Drop banner';
                    include './partials/drop_zone.php'
                ?>
            </div>
        </div>
    </div>

    
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
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
                            <div class="d-flex align-items-center">
                                <form class="" method="GET" action="/views/shop.php">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-primary" style="cursor: pointer;">
                                            <i class="fa fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" oninput="searchProduct(event)" name="search" placeholder="Search for products">
                                    </div>
                                </form>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Latest</a>
                                        <a class="dropdown-item" href="#">Popularity</a>
                                        <a class="dropdown-item" href="#">Best Rating</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <?php if (mysqli_num_rows($products) > 0) { ?>
                        <?php while ($product = mysqli_fetch_assoc($products)) { ?>
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1 product product-<?= $product['ProductID'] ?>">
                                <?php include './partials/product.php' ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>

    <div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="editProductModalLabel">
        <div class="modal-dialog  modal-lg h-75">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit the information of product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-form">
                        <div class="row">
                            <!-- Cột trái: hình ảnh -->
                            <div class="col-md-6 border-end">
                                <div class="mb-3">
                                    <label for="imageUpload" class="form-label">Image of product:</label>
                                    <img id="previewImage" src= "" alt="Ảnh sản phẩm" class="img-fluid mb-3" style="max-height: 200px;">
                                    <input type="file" class="form-control" id="imageUpload" name="productImage" accept="images/*">
                                </div>
                            </div>

                            <div class="col-md-6">
                                
                                <div class="mb-3">
                                    <label for="idProduct" class="form-label">ID:</label>
                                    <input type="text" class="form-control" id="productID" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="nameProduct" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description:</label>
                                    <input type="text" class="form-control" id="description">
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price:</label>
                                    <input type="text" class="form-control" id="price">
                                </div>
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity:</label>
                                    <input type="text" class="form-control" id="stockQuantity">
                                </div>
                                <div class="mb-3">
                                    <label for="categoryID" class="form-label">Category ID:</label>
                                    <input type="text" class="form-control" id="categoryID">
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="updateProduct(<?= $shopID ?>)">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductModalLabel">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add more products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-form">
                        <div class="row">
                            <div class="col-md-6 border-end">
                                <div class="mb-3">
                                    <label for="imageUpload" class="form-label">Image of product:</label>
                                    <img id="previewImage" src= ""  class="img-fluid mb-3" style="max-height: 200px;">
                                    <input type="file" class="form-control" id="imageUpload" name="productImage" accept="images/*">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nameNewProduct" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="newName">
                                </div>
                                <div class="mb-3">
                                    <label for="descriptionNew" class="form-label">Description:</label>
                                    <input type="text" class="form-control" id="newDescription">
                                </div>
                                <div class="mb-3">
                                    <label for="priceNew" class="form-label">Price:</label>
                                    <input type="text" class="form-control" id="newPrice">
                                </div>
                                <div class="mb-3">
                                    <label for="quantityNew" class="form-label">Quantity:</label>
                                    <input type="text" class="form-control" id="newStockQuantity">
                                </div>
                                <div class="mb-3">
                                    <label for="categoryNewID" class="form-label">CategoryID:</label>
                                    <input type="text" class="form-control" id="newCategoryID">
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="addProduct(<?= $shopID ?>)">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="listOrder" tabindex="-1" aria-labelledby="listOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Address</th>
                                <th>Quantity</th>
                                <th>Order Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                            <?php 
                                $sql = "
                                    SELECT OrderDate, Status, Address, Name, Quantity, TotalAmount
                                    FROM `order`
                                    INNER JOIN orderitem ON `order`.OrderID = orderitem.OrderID
                                    INNER JOIN product ON orderitem.ProductID = product.ProductID
                                    WHERE product.ShopID = $shopID && Status = 'Pending'
                                ";

                                $orders = mysqli_query($conn, $sql);
                            ?>
                        <tbody>
                            <?php if (mysqli_num_rows($orders) > 0) { ?>
                                <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
                                    <tr>
                                        <td><?=$order['Name'] ?></td>
                                        <td><?=$order['Quantity'] ?></td>
                                        <td><?=$order['Address'] ?></td>
                                        <td><?=$order['OrderDate'] ?></td>
                                        <td><?=$order['Status'] ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include './partials/footer.php' ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <script src="../public/js/shop.js?v=<?php echo time(); ?>"></script>
    <script src="/public/js/seller.js?v=<?php echo time(); ?>"></script>
    <script src="/public/js/dropZone.js?v=<?php echo time(); ?>"></script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/public/lib/easing/easing.min.js"></script>
    <script src="/public/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="/public/js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js?v=2" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>