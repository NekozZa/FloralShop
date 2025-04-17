<div class="product-action" style="z-index: 10">
    <?php if (isset($_SESSION['UserID'])) { ?>
        <?php if (!isset($_GET['shopID'])) { ?>
            <a class="btn btn-outline-dark btn-square" onclick="addItem(event, <?= $product['ProductID'] ?>)"><i class="fa fa-shopping-cart"></i></a>
        <?php } else { ?>
            <a 
                class="btn btn-outline-dark btn-square inspect-item-btn" 
                data-bs-toggle="modal"  
                data-bs-target="#editProduct"
                onclick="editProduct(event, 
                                    <?= $product['ProductID'] ?>, 
                                    '<?= $product['Name'] ?>', 
                                    '<?= $product['Description'] ?>', 
                                    <?= $product['Price'] ?>,
                                    <?= $product['StockQuantity'] ?>,
                                    <?= $product['CategoryID'] ?>)"
            >
                <i class="bi bi-pencil-square"></i>
            </a>
            
            <a class="btn btn-outline-dark btn-square delete-btn" onclick="removeProduct(event, <?= $product['ProductID'] ?>)"><i class="bi bi-x"></i></a>
        <?php } ?>
    <?php } else { ?>
        <a class="btn btn-outline-dark btn-square" href="login.php"><i class="fa fa-shopping-cart"></i></a>
    <?php } ?>
    
    <a class="btn btn-outline-dark btn-square" href="detail.php?productID=<?= $product['ProductID'] ?>"><i class="fa fa-search"></i></a>
</div>

