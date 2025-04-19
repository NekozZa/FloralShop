async function addItemByQuantity(productID) {
    const quantity = Number(document.querySelector('.input-group .quantity').value)

    const res = await fetch('/controller/cart.php', {
        method: 'POST',
        headers: {
            "Content-Type": 'application/json'
        },
        body: JSON.stringify({productID: productID, quantity: quantity})
    })

    const data = await res.json()
    
    if (data.action == 'Insert') {
        document.querySelectorAll('.item-count').forEach((itemCount) => {
            itemCount.innerHTML = `${Number(itemCount.innerHTML) + 1}`
        })
    }
}

let rating = 0

 async function addComment(productID) {
    const comment = document.querySelector('textarea')
    
    const res = await fetch('/controller/review.php', {
        method: 'POST',
        headers: { "Content-Type": 'application/json' },
        body: JSON.stringify({productID: productID, rating: rating, comment: comment.value})
    })

    location.reload()
}

function updateRating(e) {
    rating = e.target.value
    updateStars()
}

function updateStars() {
    for (let i = 1; i <= 5; i++) {
        const star = document.querySelector(`button[value='${i}']`)
        star.innerHTML = i <= rating ? '<i class="fas fa-star" style="pointer-events: none;"></i>' : '<i class="far fa-star" style="pointer-events: none;"></i>'
    }
}