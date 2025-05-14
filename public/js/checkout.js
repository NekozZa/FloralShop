async function placeOrder(accountID){
    const cartItems = await fetchCartItems();
    // console.log(cartItems);
    // if(cartItems.length === 0){
    //     alert('Cannot place order.')
    // }
    const totalAmount = parseFloat(document.getElementById('total').textContent.replace('$',''));
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
    console.log('Payment Method:', paymentMethod);
    if (!cartItems || cartItems.length === 0) {
        $('#orderErrorModal').modal('show');
        return;
    }
    fetch('./controller/order_controller.php',{
        method: 'POST',
        headers:{
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            account_id: accountID,
            cart_items: cartItems,
            total_amount: totalAmount,
            payment_method: paymentMethod,
        })
    })
    .then(response => response.json())
    .then(responseData =>{
        if(responseData.code === 0){
            $('#orderSuccessModal').modal('show');
            fetchCartItems();
        }
        else{
            $('#orderErrorModal').modal('show');
        }
    })
    .catch(error => {
        console.log('Error:', error);
        $('#orderErrorModal').modal('show');
    })

}

async function fetchCartItems(){
    let items;
    const res = await fetch('./controller/cart_controller.php',{
        method: 'GET'
    })
    const data = await res.json();
    if(data.code === 0){
        items = data.return;
        loadCartItems(data.return);
        calculateSummary(data.return);
        return items;
    }
    else{
        alert(data.message);
    }
}
    
function loadCartItems(items){
    const cart = document.getElementById('cart');
    cart.innerHTML = ''
    if(items.length === 0){
        cart.innerHTML = `<p>Your cart is empty. </p>`
        return;
    }
    items.forEach(item => {
        const cartItem = document.createElement('div')
        cartItem.classList.add('media', 'mb-2', 'border-bottom');
        cartItem.innerHTML =
        `<div class="media-body"> 
        <a href="detail.html">${item.name}</a>
        <div class="small text-muted">Price: $${item.price}<span class="mx-2">|</span> Qty: ${item.quantity}<span class="mx-2">|</span> Subtotal: $${(item.price * item.quantity).toFixed(2)}</div>
        </div>`;
        cart.appendChild(cartItem)
    });
}
function calculateSummary(items){
    //Initialize variables
    let subtotal = 0;
    
    //Testing
    let discount = 1000; 
    let couponDiscount = 500; 
    let tax = 20
    let shippingCost = 0;
    let grandtotal = 0
    let opt1 = document.getElementById('shippingOption1');
    let opt2 = document.getElementById('shippingOption2');
    let opt3 = document.getElementById('shippingOption3');
    let totalProduct = 0;
    //Calculate subtotal
    items.forEach(item => {
        subtotal += item.price * item.quantity;
        totalProduct += item.quantity;
    });

    //Shipping Cost
    if(opt1.checked){
        shippingCost = 0;
    }
    else if(opt2.checked){
        shippingCost = parseFloat(opt2.value);
    }
    else if(opt3.checked){
        shippingCost = parseFloat(opt3.value);
    }
    
    grandtotal = ((subtotal - discount -couponDiscount) + tax + shippingCost).toFixed(2);
    //Show UI
    document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById('discount').textContent = `$${discount.toFixed(2)}`;
    document.getElementById('coupon-discount').textContent = `$${couponDiscount.toFixed(2)}`;
    document.getElementById('tax').textContent = `$${tax.toFixed(2)}`;
    document.getElementById('shipping').textContent = shippingCost === 0 ? 'Free' : `$${shippingCost.toFixed(2)}`;
    document.getElementById('total').textContent = `$${grandtotal}`;
}


document.addEventListener("DOMContentLoaded", function(){
    fetchCartItems();
    
    const shippingOptions = document.querySelectorAll('input[name="shipping-option"]');
    shippingOptions.forEach(option =>{
        option.addEventListener('change',function(){
            fetchCartItems();
        })
    })
})



    