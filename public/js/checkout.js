
document.addEventListener("DOMContentLoaded", function(){
    
    function fetchCartItems(){
        fetch('./controller/cart_controller.php',{
            method: 'GET',
            headers:{
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(responeseData =>{
            console.log(responeseData);
            if(responeseData.code === 0){
                loadCartItems(responeseData.return);
                calculateSummary(responeseData.return);
            }
            else{
                alert(responeseData.message);
            }
        })
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
    const shippingOptions = document.querySelectorAll('input[name="shipping-option"]');
    shippingOptions.forEach(option =>{
        option.addEventListener('change',function(){
            fetchCartItems();
        })
    })
    fetchCartItems();

    const placeOrderButton = document.getElementById('place-order-btn');
    placeOrderButton.addEventListener('click', function(){
        
    })
    
})

    