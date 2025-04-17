const totals = document.querySelectorAll('.total')
const subtotal = document.querySelector('.checkout-subtotal')
const shipping = document.querySelector('.checkout-shipping')
const total = document.querySelector('.checkout-total')

let sum = 0
let shippingPrice = 0

totals.forEach((total) => {
    const amount = Number(total.innerHTML)
    sum = sum + amount
})

subtotal.innerHTML = `$${sum.toFixed(2)}`
total.innerHTML = `$${sum.toFixed(2)}`

const shippingTypeBtns = document.querySelectorAll("input[name='shipping']")
const shippingField = document.querySelector('.shipping-expense')
const popupContainer = document.querySelector('.pop-up-container')
const popup = document.querySelector('.pop-up')

function setShippingPrice(price) {
    shippingPrice = price
    shippingField.innerHTML = `$${shippingPrice}`
    total.innerHTML =`$${(sum + shippingPrice).toFixed(2)}`
}

async function placeOrder () {
    const address = document.querySelector('.address')
    const paymentMethod = document.querySelector("input[name='payment']:checked")
    const shippingType = document.querySelector("input[name='shipping']:checked")
    
    if (areFieldsEmpty([address, paymentMethod, shippingType])) {
        throw Error("Fields are empty")
    }



    const [orderCreated] = await Promise.all([
        createOrder(address.value, sum + shippingPrice, paymentMethod.value, shippingType.value),
        // deleteCartItems()
    ])

    if (!orderCreated) throw new Error('Can not create order')
    // if (!cartCleared) throw new Error('Can not clear cart items')

    popupContainer.style.display = 'block'
    popup.classList.add('animation')

    popup.addEventListener('animationend', () => {
        popupContainer.style.display = 'none'
        // window.location.href = '/views/index.php'
    })
}

function areFieldsEmpty(fields) {
    const fieldHolders = document.querySelectorAll('.field')
    let isError = false
    
    fields.forEach((field, i) => {
        if (field == null || field.value == '') {
            fieldHolders[i].classList.add("border-danger") 
            isError = true
        } else {
            fieldHolders[i].classList.remove("border-danger") 
        }
    })

    return isError
}

async function createOrder(address, total, paymentMethod, shippingType) {
    const res = await fetch('/controller/order.php', {
        method: "POST",
        headers: { "Content-Type": 'application/json' },
        body: JSON.stringify({
            address: address, 
            totalAmount: total,
            paymentMethod: paymentMethod,
            shippingType: shippingType
        })
    })

    const data = await res.json()
    console.log(data.coord);

    return data.message == 'Successful'
}

async function deleteCartItems() {
    const res = await fetch('/controller/cart.php', {
        method: "DELETE"
    })
    
    const data = await res.json()

    return data.message == 'Successful'
}

