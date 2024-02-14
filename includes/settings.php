<?php
// settings-page.php

// Function to add top-level menu item
function random_quote_footer_settings_menu() {
    add_menu_page('Random Quote Settings', 'Random Quote', 'manage_options', 'random-quote-footer-settings', 'random_quote_footer_settings_page', '', 100);
}
add_action('admin_menu', 'random_quote_footer_settings_menu');

// Function to display the main settings page
function random_quote_footer_settings_page() {
    ?>
    <div class="wrap">
        <h1>Random Quote Settings</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=random-quote-footer-settings" class="nav-tab nav-tab-active">General Settings</a>
            <a href="?page=random-quote-footer-settings&tab=subtab1" class="nav-tab">Manage Quotes</a>
            <a href="?page=random-quote-footer-settings&tab=import-export" class="nav-tab">Import/Export</a>
        </h2>
        <?php
        // Check for the current tab
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';

        // Display content based on current tab
        if ($current_tab === 'subtab1') {
            include_once('manage-quotes.php'); // Load manage quotes settings
        } elseif ($current_tab === 'import-export') {
            include_once('import-export.php'); // Load import/export settings
        } else {
            include_once('general-settings.php'); // Load general settings
        }
        ?>
    </div>
    <?php
}
?>
