const checkout = document.querySelector('.checkout')
updateOrderTotal()

checkout.onclick = () => {
    window.location.href = "/views/checkout.php"
}

async function updateQuantity(id, offset) {
    const quantityField = document.querySelector(`.product-${id} input`);
    const quantity = Number(quantityField.value)

    if (quantity <= 1 && offset < 0) {
        deleteItem(id)
        return
    }

    await fetch('/controller/cart.php', {
        method: 'PUT',
        headers: { "Content-Type": 'application/json' },
        body: JSON.stringify({productID: id, offset: offset})
    })

    updateItemTotal(id)
    updateOrderTotal()
}

async function deleteItem(id) {
    console.log(id)

    const res = await fetch('/controller/cart.php', {
        method: 'DELETE',
        headers: { "Content-Type": 'application/json' },
        body: JSON.stringify({productID: id})
    })
    
    const data = await res.json()
    console.log(data)

    
    document.querySelector(`.product-${id}`).remove()
    updateOrderTotal()
}

function updateItemTotal(id) {
    const price = document.querySelector(`.product-${id} .price`).innerHTML
    const quantity = document.querySelector(`.product-${id} input`).value
    document.querySelector(`.product-${id} .total`).innerHTML = (Number(price) * Number(quantity)).toFixed(2)
}

function updateOrderTotal() {
    const totals = document.querySelectorAll('.total')
    const total = document.querySelector('.checkout-total')

    let sum = 0

    totals.forEach((total) => {
        const amount = Number(total.innerHTML)
        sum = sum + amount
    })

    total.innerHTML = `$${sum.toFixed(2)}`
}