function addToWishlist(e, flowerID) {
    e.preventDefault();

    fetch('./controller/wishlist_controller.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `flower_id=${encodeURIComponent(flowerID)}`
    })
    .then(res => res.json())
    .then(data => {
        const notification = document.getElementById('cartNotification');
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
        
    })
    .catch(error => console.error('Error:', error));
}

function addToCart(e, flowerID) {
    e.preventDefault();
    fetch('./controller/cart_controller.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `flower_id=${encodeURIComponent(flowerID)}`
    })
    .then(res => res.json())
    .then(data => {
        const notification = document.getElementById('cartNotification');
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    })
    .catch(error => console.error('Error:', error));
}
