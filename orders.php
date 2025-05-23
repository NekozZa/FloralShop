<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    <title>ThewayShop - Ecommerce Bootstrap 4 HTML Template</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <!-- Start Main Top -->
    <?php include './views/partials/top_bar.php' ?>
    <!-- End Main Top -->

    <!-- Start Main Top -->
    <?php include './views/partials/navbar.php' ?>
    <!-- End Main Top -->

    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->

    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Wishlist</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active">Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Wishlist  -->
    <div class="wishlist-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive" style="overflow: hidden">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Amount </th>
                                    <th>Status</th>
                                    <th>Refund</th>
                                </tr>
                            </thead>
                            <tbody data-customer="<?= $_SESSION['customer_id'] ?>">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Wishlist -->

    <!-- Start Instagram Feed  -->
    <!-- End Instagram Feed  -->


    <!-- Start Footer  -->
    <?php include './views/partials/footer.php' ?>
    <!-- End Footer  -->

    <!-- Start copyright  -->
    <div class="footer-copyright">
        <p class="footer-company">All Rights Reserved. &copy; 2018 <a href="#">ThewayShop</a> Design By :
            <a href="https://html.design/">html design</a></p>
    </div>
    <!-- End copyright  -->

    <a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>

    <!-- ALL JS FILES -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
    <script src="js/jquery.superslides.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/inewsticker.js"></script>
    <script src="js/bootsnav.js."></script>
    <script src="js/images-loded.min.js"></script>
    <script src="js/isotope.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/baguetteBox.min.js"></script>
    <script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>

    <script>
        const tbody = document.querySelector('tbody')

        window.addEventListener('load', async () => {
            const orders = await getOrders(tbody.dataset.customer)
            let dict = {}

            orders.forEach((order) => {
                if (!dict[order.order_id]) {
                    dict[order.order_id] = [order];
                } else {
                    dict[order.order_id].push(order);
                }
            })

            console.log(dict)

            for (const key in dict) {
                const orderFlowers = createOrderFlowers(dict[key])
                const tr = createOrder(dict[key][0], orderFlowers)
                tbody.appendChild(tr)
            }
        })

        function createOrder(orderInfo, orderFlowers) {
            const tr = document.createElement('tr')
            tr.innerHTML += `
                <td class="name-pr">
                    ${orderFlowers}
                </td>

                <td class="price-pr">
                    <p>$${orderInfo.total_amount}</p>
                </td>

                <td class="quantity-box">${orderInfo.status}</td>

                <td class="add-pr">
                    <a class="btn hvr-hover" href="./contact-us.php?orderID=${orderInfo.order_id}">Refund Order</a>
                </td>
            `

            return tr
        }

        function createOrderFlowers(orderItems) {
            const ul = document.createElement('ul')
            
            orderItems.forEach(item => {
                const li = document.createElement('li')
                li.innerHTML= `<a href="">- ${item.name} x ${item.quantity}</a>`

                ul.appendChild(li)
            })

            return ul.innerHTML
        }

        async function getOrders(customer_id) {
            const res = await fetch(`./controller/order_controller.php?customer_id=${customer_id}`, { method: 'GET' })
            const data = await res.json()
            return data.return
        }

    </script>
</body>

</html>