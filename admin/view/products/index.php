<?php
require_once 'view/products/crud.php';
require_once 'view/categories/crud.php';

if(isset($_POST['delete']) && isset($_POST['id'])) {
    deleteProduct($_POST['id']);
}

if(isset($_POST['save'])) {
    saveProduct($_POST, $_FILES);
}

$categories = getAllCategories();
$products = getAllProducts();
?>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">Products</h3>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add/Edit Product</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="product_id">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select class="form-control" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            <?php foreach($categories as $category): ?>
                                                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Product Image</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        <img id="image_preview" src="" style="max-width: 200px; margin-top: 10px; display: none;">
                                    </div>
                                    <button type="submit" name="save" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary" onclick="resetForm()">Clear</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Products List</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Category</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($products as $product): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($product['id']) ?></td>
                                                <td>
                                                    <?php if($product['image_path']): ?>
                                                        <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                                                             alt="Product Image" 
                                                             style="max-width: 50px;">
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($product['name']) ?></td>
                                                <td><?= htmlspecialchars($product['description']) ?></td>
                                                <td>$<?= htmlspecialchars(number_format($product['price'], 2)) ?></td>
                                                <td><?= htmlspecialchars($product['category_name']) ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" 
                                                            onclick="editProduct(<?= htmlspecialchars(json_encode($product)) ?>)">
                                                        <i class="ft-edit"></i>
                                                    </button>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                        <button type="submit" name="delete" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Are you sure?')">
                                                            <i class="ft-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function editProduct(product) {
    document.getElementById('product_id').value = product.id;
    document.getElementById('name').value = product.name;
    document.getElementById('description').value = product.description;
    document.getElementById('price').value = product.price;
    document.getElementById('category_id').value = product.category_id;
    
    if(product.image_path) {
        document.getElementById('image_preview').src = product.image_path;
        document.getElementById('image_preview').style.display = 'block';
    }
}

function resetForm() {
    document.getElementById('product_id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('description').value = '';
    document.getElementById('price').value = '';
    document.getElementById('category_id').value = '';
    document.getElementById('image').value = '';
    document.getElementById('image_preview').src = '';
    document.getElementById('image_preview').style.display = 'none';
}

document.getElementById('image').addEventListener('change', function(e) {
    if(e.target.files && e.target.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image_preview').src = e.target.result;
            document.getElementById('image_preview').style.display = 'block';
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script> 