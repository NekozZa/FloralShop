const tableWishList = document.querySelector('#tableWishList tbody')
fetch(`../controller/request_controller.php?action=getWishList`)
    .then(res => res.json())
    .then(data => {
        console.log(data)
        if(data.code == 0){
            let product = ''
            let listProducts = data.return
            listProducts.forEach(element => {
                product +=`
                <div class="cart-notification" id="cartNotification">
                    <div class="notification-content">
                        <i class="fas fa-check-circle"></i>
                        <span>Added Successfully!</span>
                    </div>
                </div>
                <tr>
                    <td class="thumbnail-img">
                        <a href="#">
                    <img class="img-fluid" src="${element.image_url}" alt="" />
                </a>
                    </td>
                    <td class="name-pr">
                        <a href="#">
                    ${element.name}
                </a>
                    </td>
                    <td class="price-pr">
                        <p>$ ${element.price}</p>
                    </td>
                    <td class="quantity-box">${element.stock_quantity}</td>
                    <td class="add-pr">
                        <a class="btn hvr-hover add-to-cart" href="#" data-product-id="${element.flower_id}">Add to Cart</a>
                    </td>
                    <td>
                        <a href="#" class = "removeRow" data-product-id="${element.wishlist_id}">
                    <i class="fas fa-times"></i>
                </a>
                    </td>
                </tr>`
            });
            
            tableWishList.innerHTML = product
        }

        
    })
    .catch(err => {
        console.error("Error fetching wishlist:", err);
    });

document.addEventListener('click', function(e){
    if (e.target.closest('.removeRow')) {
        console.log("hello")
        const btn = e.target.closest('.removeRow');
        //e.preventDefault();
         e.stopPropagation()
        let rowId = btn.getAttribute('data-product-id');
        console.log(rowId)
        fetch('../controller/request_controller.php?action=removeWishListRow', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({wishlist_id:  rowId})
        })
        .then(res => res.json())
        .then(data => {
            const row = btn.closest('tr')
            console.log(row)
            row.remove()
        })
        .catch(error => console.error('Error:', error));
    }
})