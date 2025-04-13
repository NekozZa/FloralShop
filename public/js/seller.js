function editProduct(id, name, description, price, quantity, categoryID){
    const idField = document.querySelector('#idProduct')
    const nameField = document.querySelector('#nameProduct')
    const desField = document.querySelector('#description')
    const priceField = document.querySelector('#price')
    const quantityField = document.querySelector('#quantity')
    const categoryIDField = document.querySelector('#categoryID')

    if (id != null && description != null && name != null && price != null && quantity != null && categoryID != null) {
        idField.value = id;
        nameField.value = name;
        desField.value = description;
        priceField.value = price;
        quantityField.value = quantity;
        categoryIDField.value = categoryID; 
    }
}

function updateProduct(shopID) {
    const idField = document.querySelector('#productID')
    const nameField = document.querySelector('#name')
    const desField = document.querySelector('#description')
    const priceField = document.querySelector('#price')
    const quantityField = document.querySelector('#quantity')
    const categoryIDField = document.querySelector('#categoryID')
    
    
    fetch('/controller/seller.php', {
        method: 'PUT',
        headers: { "Content-Type": 'application/json' },
        body: JSON.stringify({
            productID: idField.value,
            categoryID: categoryIDField.value,
            name: nameField.value,
            description: desField.value,
            price: priceField.value,
            stockQuantity: quantityField.value
        })
    })
    .then(res => res.json())
    .then(data => {
        window.location.href = `/views/seller.php?shopID=${shopID}`
    })    
}

function removeProduct(productID) {
    fetch('/controller/seller.php', {
        method: 'DELETE',
        headers: { "Content-Type": 'application/json' },
        body: JSON.stringify({productID: productID})
    })
    .then(res => res.json())
    .then(data => {
        const product = document.querySelector(`.product-${productID}`)
        product.remove()
    })
}

function addProduct(shopID) {
    const nameField = document.querySelector('#newName')
    const descriptionField = document.querySelector('#newDescription')
    const priceField = document.querySelector('#newPrice')
    const stockQuantityField = document.querySelector('#newStockQuantity')
    const categoryIDField = document.querySelector('#newCategoryID')

    console.log({
        name: nameField.value,
        description: descriptionField.value,
        price: priceField.value,
        stockQuantity: stockQuantityField.value,
        categoryID: categoryIDField.value,
        shopID: shopID
    })

    fetch('/controller/seller.php', {
        method: 'POST',
        headers: { "Content-Type": 'application/json' },
        body: JSON.stringify({
            name: nameField.value,
            description: descriptionField.value,
            price: priceField.value,
            stockQuantity: stockQuantityField.value,
            categoryID: categoryIDField.value,
            shopID: shopID
        })
    })
    .then(res => res.json())
    .then(data => {
        window.location.href = `/views/seller.php?shopID=${shopID}`
    })   
}
