<?php
require_once __DIR__ . '/../../config/Database.php';

function getSettings() {
    $database = new Database();
    $pdo = $database->getConnection();
    
    $stmt = $pdo->query("SELECT * FROM settings ORDER BY id DESC LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function saveSettings($data, $file) {
    $database = new Database();
    $pdo = $database->getConnection();
    
    $settings = getSettings();
    $image_path = $settings['site_logo'] ?? 'theme-assets/images/logo/logo.png';
    
    if(isset($file['site_logo']) && $file['site_logo']['error'] == 0) {
        $upload_dir = 'uploads/logo/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $filename = 'site_logo.' . pathinfo($file['site_logo']['name'], PATHINFO_EXTENSION);
        $filepath = $upload_dir . $filename;
        
        if(move_uploaded_file($file['site_logo']['tmp_name'], $filepath)) {
            $image_path = $filepath;
        }
    }

    if($settings) {
        $stmt = $pdo->prepare("UPDATE settings SET site_title = ?, site_logo = ? WHERE id = ?");
        $stmt->execute([$data['site_title'], $image_path, $settings['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO settings (site_title, site_logo) VALUES (?, ?)");
        $stmt->execute([$data['site_title'], $image_path]);
    }
}
?> 