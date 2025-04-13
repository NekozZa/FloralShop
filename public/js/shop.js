const products = document.querySelectorAll(".product")
const priceFilters = document.querySelectorAll("input[id*='price-']")

priceFilters.forEach((filter) => {
    filter.onclick = () => {
        const checkedPriceFilters = document.querySelectorAll("input[id*='price-']:checked")
        let prices = []

        checkedPriceFilters.forEach((filter) => {
            const bounds = filter.value.split('-')
            const min = Number(bounds[0])
            const max = Number(bounds[1])
            prices.push(min, max)
        })

        range = prices.length != 0 ? [Math.min(...prices), Math.max(...prices)] : [0, Infinity]
        console.log(range)
        updateProducts(range)
    }
})

function updateProducts(range) {
    products.forEach((product) => {
        const price = Number(product.querySelector('.price').innerHTML)
        product.style.display = (price >= range[0] && price <= range[1]) ? 'block' : 'none'
    })
}

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