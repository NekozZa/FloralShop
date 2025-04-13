<div class="product-action">
    <?php if (isset($_SESSION['UserID'])) { ?>
        <?php if (!isset($_GET['shopID'])) { ?>
            <a class="btn btn-outline-dark btn-square" onclick="addItem(<?= $product['ProductID'] ?>)"><i class="fa fa-shopping-cart"></i></a>
        <?php } ?>
    <?php } else { ?>
        <a class="btn btn-outline-dark btn-square" href="login.php"><i class="fa fa-shopping-cart"></i></a>
    <?php } ?>
    
    <a class="btn btn-outline-dark btn-square" href="detail.php?productID=<?= $product['ProductID'] ?>"><i class="fa fa-search"></i></a>
</div>