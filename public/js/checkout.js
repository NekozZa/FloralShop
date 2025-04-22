const totals = document.querySelectorAll('.total')
const subtotal = document.querySelector('.checkout-subtotal')
const shipping = document.querySelector('.checkout-shipping')
const total = document.querySelector('.checkout-total')

const shippingTypeBtns = document.querySelectorAll("input[name='shipping']")
const shippingField = document.querySelector('.shipping-expense')
const popupContainer = document.querySelector('.pop-up-container')
const popup = document.querySelector('.pop-up')

let sum = 0
let shippingPrice = 0
let totalPrice = 0


totals.forEach((total) => {
    const amount = Number(total.innerHTML)
    sum = sum + amount
})

totalPrice = sum
subtotal.innerHTML = `$${sum.toFixed(2)}`
total.innerHTML = `$${sum.toFixed(2)}`

function setPaymentMethod(method) {
    const qrCode = document.querySelector('.qr-container')
    const placeOrderBtn = document.querySelector('.place-order-btn')
    qrCode.style.display = method == 'Direct' ? 'none' : 'flex'
    placeOrderBtn.style.display = method == 'Direct' ? 'block' : 'none'
    updateQrCode()
}

function setShippingPrice(price) {
    shippingPrice = price
    totalPrice = shippingPrice + sum
    shippingField.innerHTML = `$${shippingPrice}`
    total.innerHTML =`$${(totalPrice).toFixed(2)}`
    updateQrCode()
}

async function placeOrder () {
    const address = document.querySelector('.address')
    const paymentMethod = document.querySelector("input[name='payment']:checked")
    const shippingType = document.querySelector("input[name='shipping']:checked")

    const [orderCreated, cartCleared] = await Promise.all([
        await createOrder(address.value, paymentMethod.value, shippingType.value),
        deleteCartItems()
    ])

    if (!orderCreated) throw new Error('Can not create order')
    if (!cartCleared) throw new Error('Can not clear cart items')

    popupContainer.style.display = 'block'
    popup.classList.add('animation')

    popup.addEventListener('animationend', () => {
        popupContainer.style.display = 'none'
        window.location.href = '/views/index.php'
    })
}

async function createOrder(address, paymentMethod, shippingType) {
    const res = await fetch('/controller/order.php', {
        method: "POST",
        headers: { "Content-Type": 'application/json' },
        body: JSON.stringify({
            address: address, 
            totalAmount: totalPrice,
            paymentMethod: paymentMethod,
            shippingType: shippingType,
            isPaid: (paymentMethod == 'Bank Transfer') ? 1 : 0
        })
    })

    const data = await res.json()

    return data.message == 'Successful'
}

async function deleteCartItems() {
    const res = await fetch('/controller/cart.php', {
        method: "DELETE"
    })
    
    const data = await res.json()

    return data.message == 'Successful'
}

async function updateQrCode() {
    const address = document.querySelector('.address')
    const paymentMethod = document.querySelector("input[name='payment']:checked")
    const shippingType = document.querySelector("input[name='shipping']:checked")

    const res = await fetch('/controller/qr_code.php', {
        method: "POST",
        body: JSON.stringify({
            address: address.value,
            totalAmount: totalPrice,
            paymentMethod: paymentMethod.value,
            shippingType: shippingType.value
        })
    })

    const data = await res.json();

    document.querySelector('img').src = data.imgURI;
}

