<div class="bg-light p-0 flex-fill" style="">
    <nav class='bg-white shadow d-flex align-items-center justify-content-between' style='height: 10%'>
        <span class="ms-3">Order Management</span>
        <button class="btn btn-outline-danger me-3" onclick="logOut()">Log out</button>
    </nav>

    <div class="container p-5" style='height: 90%'>
        <div class="mb-4 d-flex justify-content-end">
            <button class="btn btn-success" onclick="openAddModal()">Add New Product</button>
        </div>
        <div id="product-list" class="row">
           
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure to delete <span id="delete-product-name" class="fw-bold"></span> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirm-delete" >Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Update Modal -->

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="update-product-form">
        <input type="hidden" id="update-flower-id">
        <div class="mb-3">
            <label for="update-name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="update-name" required>
        </div>
        <div class="mb-3">
            <label for="update-price" class="form-label">Price</label>
            <input type="number" class="form-control" id="update-price" min="0" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="update-quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="update-quantity" min="0" step="1" required>
          </div>
        <div class="mb-3">
            <label for="update-desc" class="form-label">Product Description</label>
            <input type="text" class="form-control" id="update-desc" required>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirm-update">Update</button>
      </div>
    </div>
  </div>
</div>
<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="add-product-form">
        <div class="mb-3">
            <label for="add-name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="add-name" required>
        </div>
        <div class="mb-3">
            <label for="add-price" class="form-label">Price</label>
            <input type="number" class="form-control" id="add-price" min="0" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="add-quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="add-quantity" min="0" step="1" required>
        </div>
        <div class="mb-3">
            <label for="add-desc" class="form-label">Product Description</label>
            <input type="text" class="form-control" id="add-desc" required>
        </div>
        <div class="mb-3">
            <label for="add-image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="add-image" accept="image/*" required>
            <small class="form-text text-muted">Select an image file</small>
        </div>
        <div class="mb-3">
            <label for="add-category" class="form-label">Category</label>
            <select class="form-select" id="add-category" name="category_id" required>
                <option value="">Select category</option>
                <option value="1">Fresh Flowers</option>
                <option value="2">Flower Bouquets</option>
                <option value="3">Flower Baskets</option>
                <option value="4">Flower Stands</option>
                <option value="5">Indoor Plants</option>
                <option value="6">Floral Accessories</option>
                <option value="7">Gifts & Add-ons</option>
            </select>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button onclick="addProduct()" type="button" class="btn btn-success" id="confirm-add">Add Product</button>
      </div>
    </div>
  </div>
</div>

<script>
let productData = [];
let currentProductId = null;
let categoryData = [];

async function fetchProducts(){
    let items;
    const res = await fetch('./controller/storage_controller.php',{
        method: 'GET'
    })
    const data = await res.json();
    if(data.code === 0){
        items = data.return;
        productData = items;
        loadProducts(data.return);
        // console.log(items);
        return items;
    }
    else{
        alert(data.message);
    }
}

function loadProducts(products){
    const productList = document.getElementById('product-list');
    productList.innerHTML = '';
    products.forEach(product => {
        const productBox = document.createElement('div');
        productBox.className = 'col-md-4 mb-4'; 

        productBox.innerHTML =`
        <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">Price: $${product.price}</p>
                    <p class="card-text">Quantity: ${product.stock_quantity}</p>
                    <p class="card-text">${product.description}</p>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-sm" onclick="openUpdateModal(${product.flower_id})">Update</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal(${product.flower_id})">Delete</button>
                    </div>
                </div>
            </div>
        `;
             
        productList.appendChild(productBox);
    });
}

// Deleteting
function openDeleteModal(id) {
    currentProductId = id;
    const product = productData.find(p => p.flower_id == id);
    
    if (product) {
        document.getElementById('delete-product-name').textContent = product.name;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
}
function deleteProduct(id){
    fetch(`./controller/storage_controller.php?action=delete&flower_id=${id}`, {
        method: 'DELETE'
    })
    .then(res => res.json())
    .then(data => {
        if(data.code === 0){
            alert('Product deleted successfully');
            fetchProducts();
        } 
        else{
            alert(data.message);
        }
    })
}

function openDeleteModal(id) {
    currentProductId = id;
    const product = productData.find(p => p.flower_id == id);
    
    if (product) {
        document.getElementById('delete-product-name').textContent = product.name;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
}

//Updating
function updateProduct(id){
    const formData = new FormData();
    formData.append('flower_id', id);
    formData.append('name', document.getElementById('update-name').value);
    formData.append('description', document.getElementById('update-desc').value);
    formData.append('price', document.getElementById('update-price').value);
    formData.append('stock_quantity', document.getElementById('update-quantity').value);

    fetch(`./controller/storage_controller.php?action=update&flower_id=${id}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.code === 0){
            alert('Product updated successfully');
            fetchProducts();
        } else {
            alert(data.message);
        }
    })
}

function openUpdateModal(id) {
    currentProductId = id;
    const product = productData.find(p => p.flower_id == id);
    
    if (product) {
        document.getElementById('update-name').value = product.name;
        document.getElementById('update-price').value = product.price;
        document.getElementById('update-quantity').value = product.stock_quantity;
        document.getElementById('update-desc').value = product.description;

        const updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
        updateModal.show();
    }
}

// add
function openAddModal() {
    document.getElementById('add-product-form').reset();
    const addModal = new bootstrap.Modal(document.getElementById('addModal'));
    addModal.show();
}

function addProduct(){
    const name = document.getElementById('add-name').value;
    const description = document.getElementById('add-desc').value;
    const price = document.getElementById('add-price').value;
    const stock_quantity = document.getElementById('add-quantity').value;
    const category_id = document.getElementById('add-category').value;

    if(!name || !description || !price || !stock_quantity || !category_id){
        alert('Please fill in all fields');
        return;
    }
    if (price < 0 || stock_quantity < 0) {
        alert('Price and quantity must be greater than zero');
        return;
    }
    const formData = new FormData();
    formData.append('name', name);
    formData.append('description', description);
    formData.append('price', price);
    formData.append('stock_quantity', stock_quantity);
    formData.append('category_id', category_id);
    const imageFile = document.getElementById('add-image').files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }
    fetch(`./controller/storage_controller.php?action=add`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.code === 0){
            alert('Product added successfully');
            fetchProducts();
            const addModal =  bootstrap.Modal.getInstance(document.getElementById('addModal'));
            addModal.hide();
        } else {
            alert(data.message);
        }
    })
}



document.addEventListener('DOMContentLoaded', function(){
    fetchProducts().then(products => {
        loadProducts(products);
    });
})

document.getElementById('confirm-delete').addEventListener('click', function() {
    deleteProduct(currentProductId);
    const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
    deleteModal.hide();
});
document.getElementById('confirm-update').addEventListener('click', function() {
    updateProduct(currentProductId);
    const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
    deleteModal.hide();
});
</script>