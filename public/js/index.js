async function addItem(productID) {
    const res = await fetch('/controller/cart.php', {
        method: 'POST',
        headers: {
            "Content-Type": 'application/json'
        },
        body: JSON.stringify({productID: productID})
    })

    const data = await res.json()
    
    if (data.action == 'Insert') {
        document.querySelectorAll('.item-count').forEach((itemCount) => {
            itemCount.innerHTML = `${Number(itemCount.innerHTML) + 1}`
        })
    }
}
