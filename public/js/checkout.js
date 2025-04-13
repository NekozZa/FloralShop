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

subtotal.innerHTML = `$${sum}`
total.innerHTML = `$${sum}`

const shippingTypeBtns = document.querySelectorAll("input[name='shipping']")
const shippingField = document.querySelector('.shipping-expense')

function setShippingPrice(price) {
    shippingPrice = price
    shippingField.innerHTML = `$${shippingPrice}`
    total.innerHTML =`$${sum + shippingPrice}`
}

async function placeOrder () {
    const address = document.querySelector('.address')
    const paymentMethod = document.querySelector("input[name='payment']:checked")
    const shippingType = document.querySelector("input[name='shipping']:checked")
    
    if (areFieldsEmpty([address, paymentMethod, shippingType])) {
        throw Error("Fields are empty")
    }

    const res = await fetch('/controller/order.php', {
        method: "POST",
        headers: { "Content-Type": 'application/json' },
        body: JSON.stringify({
            address: address.value, 
            totalAmount: sum + shippingPrice,
            paymentMethod: paymentMethod.value,
            shippingType: shippingType.value
        })
    })

    const data = await res.json()
    window.location.href = '/views/index.php'
}

function areFieldsEmpty(fields) {
    const fieldHolders = document.querySelectorAll('.field')
    let isError = false
    
    fields.forEach((field, i) => {
        if (field == null || field == '') {
            fieldHolders[i].classList.add("border-danger") 
            isError = true
        } else {
            fieldHolders[i].classList.remove("border-danger") 
        }
    })

    return isError
}
