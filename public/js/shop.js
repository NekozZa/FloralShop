const products = document.querySelectorAll(".product")
const priceFilters = document.querySelectorAll("input[id*='price-']")
let limit = 10

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

function setLimit(limit) {
    limit = limit

    products.forEach((product, index) => {
        product.style.display = index < limit ? 'block' : 'none'
    })
}


function setSorting(sorting) {
    const params = new URLSearchParams(document.location.search)
    const curSorting = params.get('sorting')

    if (curSorting == null || curSorting != sorting) {
        window.location.href = `/views/shop.php?sorting=${sorting}`
    } else {
        window.location.href = `/views/shop.php`
    }
}