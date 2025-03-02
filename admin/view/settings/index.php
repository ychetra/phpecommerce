<?php
require_once 'view/settings/crud.php';

if(isset($_POST['save'])) {
    saveSettings($_POST, $_FILES);
}

$settings = getSettings();
?>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">Settings</h3>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Website Settings</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="site_title">Website Title</label>
                                        <input type="text" class="form-control" id="site_title" name="site_title" 
                                               value="<?= htmlspecialchars($settings['site_title'] ?? '') ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="site_logo">Website Logo</label>
                                        <input type="file" class="form-control" id="site_logo" name="site_logo" accept="image/*">
                                        <?php if(isset($settings['site_logo'])): ?>
                                            <div class="mt-2">
                                                <label>Current Logo:</label><br>
                                                <img src="<?= htmlspecialchars($settings['site_logo']) ?>" 
                                                     alt="Current Logo" 
                                                     style="max-width: 200px; margin-top: 10px;">
                                            </div>
                                        <?php endif; ?>
                                        <img id="logo_preview" src="" 
                                             style="max-width: 200px; margin-top: 10px; display: none;">
                                    </div>
                                    <button type="submit" name="save" class="btn btn-primary">Save Settings</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('site_logo').addEventListener('change', function(e) {
    if(e.target.files && e.target.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logo_preview').src = e.target.result;
            document.getElementById('logo_preview').style.display = 'block';
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script> 