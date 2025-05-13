window.addEventListener('load', async () => {
    const specialList = document.querySelector('.special-list')
    const res = await fetch('./controller/storage_controller.php?action=random', {method: 'GET'})
    const data = await res.json()

    data.return.forEach((flower) => {
        specialList.appendChild(createFlowerItem(flower))
    })
})

function createFlowerItem(flower) {
    const div = document.createElement('div')
    div.className = 'col-lg-3 col-md-6 special-grid best-seller'
    div.innerHTML = `
        <div class="products-single fix">
            <div class="box-img-hover">
                <div class="type-lb">
                    <p class="sale">Sale</p>
                </div>
                <img src="${flower.image_url}" class="img-fluid" alt="Image">
                <div class="mask-icon">
                    <ul>
                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                        <li>
                            <a 
                                href="#"  
                                data-placement="right"  
                                class ="add-to-wishlist"
                                onclick="addToWishlist(event, ${flower.flower_id})"   
                            >
                                <i class="far fa-heart"></i>
                            </a>
                        </li>
                    </ul>
                    
                    <a 
                        class="cart add-to-cart" 
                        href="#"
                        onclick="addToCart(event, ${flower.flower_id})" 
                    >
                        Add to Cart
                    </a>
                </div>
            </div>
            <div class="why-text">
                <h4>${flower.name}</h4>
                <h5>${flower.price}</h5>

            </div>
        </div>
    `
    return div
}