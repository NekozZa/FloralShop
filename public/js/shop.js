let numOfResult = document.getElementById('numOfResult');
let sortBox = document.querySelector('#sort')
let CategoryBox = document.querySelectorAll('.list-group-item[data-category-id]')
let selectedCategoryId = '';
let selectedSort = '';
const shopFlower = document.querySelector('.shop-box-inner')

if (shopFlower) {
    fetch('./controller/storage_controller.php', {method: 'GET'})
    .then(response => response.json())
    .then(data => {
        if (data.code == 0) {
            console.log(data)
            if(data.return.length > 0){
                numOfResult.innerHTML = `Showing all ${data.return.length} result`
                displayFlowers(data.return)
                listViewFlowers(data.return)
            }else{
                numOfResult.innerHTML = `No flowers found!`
            }         

        } else {
            console.error('Error fetching flowers:', data.message);
        }
    })
    .catch(err => console.error('Fetch error:', err));
}

CategoryBox.forEach(item => {
    item.addEventListener('click', function(e) {
        console.log(item.getAttribute('data-category-id'))
        e.preventDefault();
        selectedCategoryId = item.getAttribute('data-category-id');
        sortFilterFlowers(selectedCategoryId, selectedSort);
    });
});


sortBox.addEventListener('change', function() {
    selectedSort = sortBox.value;
    sortFilterFlowers(selectedCategoryId, selectedSort);
});

function sortFilterFlowers(categoryId = '', type ='', min_price='', max_price=''){
    fetch(`./controller/storage_controller.php?action=filter&category_id=${encodeURIComponent(categoryId)}&sort=${encodeURIComponent(type)}&min_price=${encodeURIComponent(min_price)}&max_price=${encodeURIComponent(max_price)}`)
    .then(response => response.json())
    .then(data => {
        numOfResult.innerHTML = `Showing all ${data.return.length} result`
        displayFlowers(data.return);
        listViewFlowers(data.return)
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
}

function displayFlowers(flowers){
    const flowerList = document.getElementById('flowerList');
    
    flowerList.innerHTML = '';
    
    flowers.forEach(flower => {
        const productDiv = document.createElement('div');
        productDiv.className = 'col-sm-6 col-md-6 col-lg-4 col-xl-4';
        productDiv.innerHTML = `
            <div class="products-single fix">
                <div class="cart-notification" id="cartNotification">
                    <div class="notification-content">
                        <i class="fas fa-check-circle"></i>
                        <span>Added Successfully!</span>
                    </div>
                </div>
                <div class="box-img-hover">
                    <div class="type-lb">
                        <p class="sale">Sale</p>
                    </div>
                    <img src="${flower.image_url}" class="img-fluid" alt="Image">
                    <div class="mask-icon">
                        <ul>
                            <li><a href="#" title="View"><i class="fas fa-eye"></i></a></li>
                            <li><a href="#" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                            <li><a href="#"  data-placement="right"  data-product-id="${flower.flower_id}" class ="add-to-wishlist">
                                <i class="far fa-heart"></i></a></li>
                        </ul>
                        <a class="cart add-to-cart" href="#" data-product-id="${flower.flower_id}">Add to Cart</a>
                    </div>
                </div>
                <div class="why-text full-width">
                    <h4>${flower.name}</h4>
                    <h5> <del>$ ${flower.price}</del> $ ${flower.price - 10000}</h5>
                </div>
            </div>
            
        `;
        flowerList.appendChild(productDiv);
    })
    
}

function listViewFlowers(flowers){
    const listView = document.querySelector('#list-view')
    listView.innerHTML = ''

    flowers.forEach(flower =>{
        const listViewBox = document.createElement('div')
        listViewBox.className = 'list-view-box'
        listViewBox.innerHTML = `<div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                        <div class="products-single fix">
                                            <div class="box-img-hover">
                                                <div class="type-lb">
                                                    <p class="new">New</p>
                                                </div>
                                                <img src="${flower.image_url}" class="img-fluid" alt="Image">
                                                <div class="mask-icon">
                                                    <ul>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                                        <li><a data-toggle="tooltip" data-placement="right" title="Add to Wishlist" data-product-id="${flower.flower_id}" class ="add-to-wishlist">
                                                            <i class="far fa-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-8 col-xl-8">
                                        <div class="why-text full-width">
                                            <h4>${flower.name}</h4>
                                            <h5> <del>$ ${flower.price}</del> $ ${flower.price - 10000}</h5>
                                            <p>${flower.description}</p>
                                            <a class="btn hvr-hover" href="#">Add to Cart</a>
                                        </div>
                                    </div>
                                </div>`
        
        listView.appendChild(listViewBox)
    })
}



$(function() {

    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 100000,
        values: [0, 100000],
        slide: function(event, ui) {
            $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
        }
    });

    $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));

    $("#price-filter-btn").on("click", function(e) {
        e.preventDefault();
        var minPrice = $("#slider-range").slider("values", 0);
        var maxPrice = $("#slider-range").slider("values", 1);
        
        sortFilterFlowers(selectedCategoryId, selectedSort, minPrice, maxPrice);
    });
});