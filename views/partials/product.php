<div class="product-item bg-light mb-4" style="cursor: pointer" onclick="viewProductDetail(<?= $product['ProductID'] ?>)">
    <style>
        @keyframes fade {
            0% {
                opacity: 0;
                display: block;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                display: none;
            }
        }

        .animation {
            animation: fade 2s ease forwards;
        }
    </style>

    <div class="product-img position-relative overflow-hidden" style="height: 30vh; z-index: 0">
        <img class="img-fluid w-100" src="/public/img/product-img-<?= $product['ProductID'] ?>.jpg?v=<?php echo time(); ?>" alt="" style="object-fit:contain">
        <?php include './partials/product_action.php' ?>
        
    </div>
    <div class="text-center py-4">
        <p 
            class="bg-primary text-mute px-3 rounded shadow notification-<?= $product['ProductID'] ?>" 
            style="position: absolute; top: -5px; left: 50%; transform: translate(-50%, -50%); opacity: 0"
        >
            Item added
        </p>

        <a class="h6 text-decoration-none text-truncate name" href=""><?= $product['Name'] ?></a>
        <div class="d-flex align-items-center justify-content-center mt-2">
            <h5 class="price"><?= $product['Price'] ?></h5><h6 class="text-muted ml-2"><del><?= $product['Price'] ?></del></h6>
        </div>
        <div class="d-flex align-items-center justify-content-center mb-1">
            <?php include './partials/product_rating.php' ?>
        </div>
    </div>

    <script>
        async function addItem(e, productID) {
            e.stopPropagation()

            const res = await fetch('/controller/cart.php', {
                method: 'POST',
                headers: {
                    "Content-Type": 'application/json'
                },
                body: JSON.stringify({productID: productID, quantity: 1})
            })

            const data = await res.json()
            
            if (data.action == 'Insert') {
                document.querySelectorAll('.item-count').forEach((itemCount) => {
                    itemCount.innerHTML = `${Number(itemCount.innerHTML) + 1}`
                })
            }

            notification = document.querySelector(`.notification-${productID}`)

            notification.addEventListener('animationend', () => {
                notification.classList.remove('animation')
            })

            notification.classList.add('animation')
        }

        function viewProductDetail(productID) {
            window.location.href = `/views/detail.php?productID=${productID}`
        }
    </script>
</div>
