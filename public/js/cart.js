const tableWishList = document.querySelector('#tableCartList tbody')
fetch(`./controller/request_controller.php?action=getCartList`)
    .then(res => res.json())
    .then(data => {
        console.log(data)
        if(data.code == 0){
            let product = ''
            let listProducts = data.return
            listProducts.forEach(element => {
                product +=`
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
                    <td class="quantity-box"><input type="number" size="4" value="${element.quantity}" min="0" step="1" class="c-input-text qty text"></td>
                    <td class="total-pr">
                        <p>$ ${element.price * element.quantity}</p>
                    </td>
                    <td class="remove-pr${element.cartitemId}">
                        <a href="#" class = "removeRow" data-product-id="${element.cartitemId}">
                    <i class="fas fa-times"></i>
                </a>
                    </td>
                </tr>
                `
            });
            
            tableWishList.innerHTML = product
        } 
    })
    .catch(err => {
        console.error("Error fetching cartlist:", err);
    });

document.addEventListener('click', function(e){
    if (e.target.closest('.removeRow')) {
        console.log("hello")
        const btn = e.target.closest('.removeRow');
        //e.preventDefault();
        e.stopPropagation()
        let rowId = btn.getAttribute('data-product-id');
        console.log(rowId)
        fetch('./controller/request_controller.php?action=removeCartListRow', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({cartitem_id: rowId})
        })
        .then(res => res.json())
        .then(data => {
            const row = btn.closest('tr')
            console.log(row)
            row.remove()
        })
        .catch(error => console.error('Error:', error));
    }
    if(e.target.closest('.update-box')){
        const btn = e.target.closest('.removeRow');
        e.stopPropagation()
    }
})

tableWishList.addEventListener('input', function (e) {
    if (e.target.matches('.quantity-box input')) {
        const input = e.target;
        const quantity = parseInt(input.value) || 0;

        const row = input.closest('tr');
        const priceText = row.querySelector('.price-pr p').textContent;
        const price = parseFloat(priceText.replace('$', '').trim()) || 0;

        const totalCell = row.querySelector('.total-pr p');
        totalCell.textContent = `$ ${ (price * quantity).toFixed(2) }`;
    }
});