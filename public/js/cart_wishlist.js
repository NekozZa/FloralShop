document.addEventListener('click', function (e) {
    const btn = e.target.closest('.add-to-wishlist');
    if (btn) {
        console.log("hello")
        e.preventDefault();
        const productId = btn.getAttribute('data-product-id');
        
        fetch('./controller/request_controller.php?action=addWishlist', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `flower_id=${encodeURIComponent(productId)}`
        })
        .then(res => res.json())
        .then(data => {
            console.log(btn)
            btn.classList.add('active');
            setTimeout(() => {
                btn.classList.remove('active');
            }, 500);

            // Hiển thị thông báo "Thêm thành công"
            const notification = document.getElementById('cartNotification');
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
            
        })
        .catch(error => console.error('Error:', error));
    }
    else if(e.target.closest('.add-to-cart')){
        const btn = e.target.closest('.add-to-cart')
        console.log("hello")
        e.preventDefault();
        const productId = btn.getAttribute('data-product-id');

        fetch('./controller/request_controller.php?action=addToCart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `flower_id=${encodeURIComponent(productId)}`
        })
        .then(res => res.json())
        .then(data => {
            console.log(btn)
            btn.classList.add('active');
            setTimeout(() => {
                btn.classList.remove('active');
            }, 500);

            const notification = document.getElementById('cartNotification');
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        })
        .catch(error => console.error('Error:', error));
    }
});