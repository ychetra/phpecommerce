<?php
require_once 'include/db.php';

function getAllProducts() {
    global $pdo;
    $stmt = $pdo->query("SELECT p.*, c.name as category_name 
                         FROM products p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         ORDER BY p.id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function saveProduct($data, $file) {
    global $pdo;
    $image_path = null;
    
    if(isset($file['image']) && $file['image']['error'] == 0) {
        $upload_dir = 'uploads/products/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $filename = uniqid() . '.' . pathinfo($file['image']['name'], PATHINFO_EXTENSION);
        $filepath = $upload_dir . $filename;
        
        if(move_uploaded_file($file['image']['tmp_name'], $filepath)) {
            $image_path = $filepath;
        }
    }

    if(!empty($data['id'])) {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, image_path = ? WHERE id = ?");
        $stmt->execute([$data['name'], $data['description'], $data['price'], $data['category_id'], $image_path, $data['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category_id, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data['name'], $data['description'], $data['price'], $data['category_id'], $image_path]);
    }
}

function deleteProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}
?> 