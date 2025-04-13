<?php 
    function getProductByID($conn, $productID) {
        $productID = $_GET['productID'];
        $sql = "
            SELECT product.*, COUNT(ReviewID) as CountReviews, AVG(Rating) as AvgRating 
            FROM product
            LEFT JOIN productreview ON product.ProductID = productreview.ProductID
            WHERE product.ProductID=$productID
        ";

        $res = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($res);
    }

    function getRandomProducts($conn, $limit) {
        $sql = "
            SELECT product.ProductID, product.Name, product.Price, AVG(Rating) as AvgRating, COUNT(ReviewID) as CountReviews
            FROM product
            LEFT JOIN productreview on product.ProductID = productreview.ProductID
            GROUP BY product.ProductID, product.Name, product.Price
            ORDER BY RAND() LIMIT $limit
        ";

        return mysqli_query($conn, $sql);
    }

    function getRandomProductsByCategory ($conn, $categoryID, $limit) {
        $sql = "
            SELECT product.ProductID, product.Name, product.Price, AVG(Rating) as AvgRating, COUNT(ReviewID) as CountReviews
            FROM product
            LEFT JOIN productreview ON product.ProductID = productreview.ProductID
            WHERE product.CategoryID = $categoryID
            GROUP BY product.ProductID, product.Name, product.Price
            ORDER BY RAND() LIMIT $limit
        ";
            
        return mysqli_query($conn, $sql);
    }

    function getShopProductsByShopID ($conn, $shopID) {
        $sql = "
            SELECT  product.Description,
                    product.CategoryID, 
                    product.StockQuantity, 
                    shop.ShopID, 
                    product.ProductID, 
                    product.Name, 
                    product.Price, 
                    AVG(productreview.Rating) as AvgRating, 
                    COUNT(ReviewID) as CountReviews
            FROM shop
            INNER JOIN product ON shop.ShopID = product.ShopID
            LEFT JOIN productreview ON product.ProductID = productreview.ProductID
            WHERE shop.ShopID = $shopID
            GROUP BY product.ProductID, product.Name, product.Price, shop.ShopID, product.StockQuantity, product.CategoryID, product.Description
            ORDER BY AvgRating DESC
        ";
            
        return mysqli_query($conn, $sql);
    }

    function getProductsOrderedByField ($conn, $field, $direction, $limit) {
        $sql = "
            SELECT product.ProductID, product.Name, product.Price, AVG(Rating) as AvgRating, COUNT(ReviewID) as CountReviews
            FROM product
            LEFT JOIN productreview ON product.ProductID = productreview.ProductID
            GROUP BY product.ProductID, product.Name, product.Price
            ORDER BY $field $direction LIMIT $limit
        ";
        
        return mysqli_query($conn, $sql);
    }

    function getProductsBySearchBar($conn, $search, $limit) {
        $sql = "
            SELECT product.ProductID, product.Name, product.Price, AVG(Rating) as AvgRating, COUNT(ReviewID) as CountReviews
            FROM product
            INNER JOIN category ON product.CategoryID = category.CategoryID
            LEFT JOIN productreview ON product.ProductID = productreview.ProductID
            WHERE category.Name like '%$search%' or product.Name like '%$search%'
            GROUP BY product.ProductID, product.Name, product.Price
            ORDER BY RAND() LIMIT $limit
        ";

        return mysqli_query($conn, $sql);
    }

?>