const cartNum = document.querySelector('.badge')
const cartList = document.querySelector('.cart-list')

window.addEventListener('load', async () => {
    getCartSidebarItems()
})

async function getCartSidebarItems() {
    const res = await fetch('./controller/cart_controller.php', {method: 'GET'})
    const data = await res.json()
    const items = data.return
    updateInterface(items)
}

function updateInterface(items) {
    cartList.innerHTML = `
        <li class="total">
            <a href="cart.php" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
        </li>
    `
    cartNum.innerHTML = items.length

    items.forEach((item) => {
        cartList.insertBefore(createCartSidebarItem(item), cartList.childNodes[cartList.childNodes.length - 2])
    })
}
    
function createCartSidebarItem(item) {
    const li = document.createElement('li')
    li.innerHTML = `
        <a href="#" class="photo"><img src=${item.image_url} class="cart-thumb" alt="" /></a>
        <h6><a href="#">${item.name}</a></h6>
        <p>${item.quantity}x - <span class="price">$${item.price}</span></p>
    `
    return li
}
