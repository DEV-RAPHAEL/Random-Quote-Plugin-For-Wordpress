<?php
/*
Plugin Name: Random Quote for Digital Agencies
Description: Display a random quote that helps your users see why they should use your service using a shortcode with customizable color and font.
Version: 3.0
Author: Ajayi Raphael Temitope
*/

// Function to get a random quote
function get_random_quote() {
    // Add your quotes here
    $quotes = array(
        "A brand is the voice of a company. You have to make sure it speaks clearly and consistently. - Simon Sinek, Author & Speaker",
        "Design is intelligence made visible. - Alina Wheeler, Design Consultant",
        "Branding is the art of simplifying the idea of the business. - Marty Neumeier, Branding Expert",
        "A strong brand is like a lighthouse - it cuts through the chaos and helps people find you. - David Brier, Marketing Consultant",
        "People don't buy products, they buy stories. - Simon Sinek",
        "Websites are the ultimate brochure - always open, always accessible, and always up-to-date. - Unknown",
        "In the digital age, the best place to hide is the second page of Google search results. - Unknown",
        "Your website is your digital storefront - make it inviting, user-friendly, and conversion-focused. - Neil Patel, Marketing Expert",
        "The web is not a destination, it is a journey - make sure your website is part of the adventure. - Craig Sullivan, Google Search Quality Strategist",
        "A website is like a handshake - it creates a first impression that can make or break a deal. - Anonymous",
        "Content is king, but design is queen. Without the queen, the king is alone. - Steve Jobs",
        "Great design is both beautiful and functional - it serves a purpose while delighting the user. - Dieter Rams, Industrial Designer",
        "Design is not just how it looks and feels. It's how it works. - Steve Jobs",
        "Visuals are a powerful tool - use them to tell your story, captivate your audience, and leave a lasting impression. - Unknown",
        "Good design is like good storytelling - it resonates with emotion and inspires action. - Unknown",
        "The internet is the world's largest marketplace - be there where your customers are searching. - Bill Gates",
        "The biggest risk is not taking any risk. In a world that's changing really quickly, the only strategy that is guaranteed to fail is not taking risks. - Mark Zuckerberg",
        "Don't wait for the perfect moment, take the moment and make it perfect. - Paulo Coelho, Author",
        "The future belongs to those who believe in the beauty of their dreams. - Eleanor Roosevelt",
        "The future belongs to those who believe in the beauty of their dreams. - Eleanor Roosevelt"
    );

    // Get a random index
    $index = array_rand($quotes);

    // Return the random quote
    return $quotes[$index];
}

// Function to handle the shortcode
function display_random_quote() {
    // Get user-defined color and font
    $color = get_option('random_quote_color', '#000000');
    $font = get_option('random_quote_font', 'Arial');

    // Get a random quote
    $quote = get_random_quote();

    // Output the styled quote
    return "<blockquote style='color: $color; font-family: $font;'>$quote</blockquote>";
}

// Register the shortcode
add_shortcode('random_quote', 'display_random_quote');

// Function to add top-level menu item
function random_quote_footer_settings_menu() {
    add_menu_page('Random Quote Settings', 'Random Quote', 'manage_options', 'random-quote-footer-settings', 'random_quote_footer_settings', '', 100);
}
add_action('admin_menu', 'random_quote_footer_settings_menu');

// Function to add sub-tab for settings page
function random_quote_footer_settings() {
    ?>
    <div class="wrap">
        <h1>Random Quote Settings</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=random-quote-footer-settings" class="nav-tab nav-tab-active">General Settings</a>
            <a href="?page=random-quote-footer-settings&tab=subtab1" class="nav-tab">Manage Quotes</a>
            <a href="?page=random-quote-footer-settings&tab=subtab2" class="nav-tab">Sub Tab 2</a>
        </h2>
        <?php
        // Check for the current tab
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';

        // Display content based on current tab
        if ($current_tab === 'subtab1') {
            random_quote_sub_tab_1_content(); // Call function to display Sub Tab 1 content
        } elseif ($current_tab === 'subtab2') {
            echo '<h2>Sub Tab 2 Content</h2>';
        } else {
            ?>
            <form method="post" action="options.php">
                <?php settings_fields('random_quote_footer_settings_group'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Quote Color</th>
                        <td><input type="color" name="random_quote_color" value="<?php echo get_option('random_quote_color', '#000000'); ?>"></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Quote Font</th>
                        <td><input type="text" name="random_quote_font" value="<?php echo get_option('random_quote_font', 'Arial'); ?>"></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
            <?php
        }
        ?>
    </div>
    <?php
}

// Function to display content for Sub Tab 1
function random_quote_sub_tab_1_content() {
    ?>
    <h2>Manage Quotes</h2>
    <table class="widefat">
        <thead>
            <tr>
                <th>ID</th>
                <th>Quote</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Get all quotes
            $quotes = get_option('random_quotes', array());

            // Loop through each quote and display in a table row
            foreach ($quotes as $id => $quote) {
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $quote; ?></td>
                    <td>
                        <a href="?page=random-quote-footer-settings&tab=subtab1&action=edit&id=<?php echo $id; ?>">Edit</a> |
                        <a href="?page=random-quote-footer-settings&tab=subtab1&action=delete&id=<?php echo $id; ?>">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <h2>Add New Quote</h2>
    <form method="post" action="?page=random-quote-footer-settings&tab=subtab1">
        <input type="hidden" name="action" value="add">
        <table class="form-table">
            <tr>
                <th scope="row">New Quote</th>
                <td><textarea name="new_quote"></textarea></td>
            </tr>
        </table>
        <?php submit_button('Add New Quote'); ?>
    </form>
    <?php
}

// Function to handle actions in Sub Tab 1
function random_quote_sub_tab_1_actions() {
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $id = $_GET['id'];

        // Get all quotes
        $quotes = get_option('random_quotes', array());

        if ($action === 'edit') {
            // Handle edit action
            if (isset($quotes[$id])) {
                // Display form to edit the quote
                ?>
                <h2>Edit Quote</h2>
                <form method="post" action="?page=random-quote-footer-settings&tab=subtab1">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <table class="form-table">
                        <tr>
                            <th scope="row">Quote</th>
                            <td><textarea name="updated_quote"><?php echo $quotes[$id]; ?></textarea></td>
                        </tr>
                    </table>
                    <?php submit_button('Update Quote'); ?>
                </form>
                <?php
            }
        } elseif ($action === 'delete') {
            // Handle delete action
            if (isset($quotes[$id])) {
                unset($quotes[$id]);
                update_option('random_quotes', $quotes);
                echo '<div class="updated"><p>Quote deleted successfully.</p></div>';
            }
        }
    } elseif (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Get all quotes
        $quotes = get_option('random_quotes', array());

        if ($action === 'add' && isset($_POST['new_quote'])) {
            // Handle add new quote action
            $new_quote = sanitize_textarea_field($_POST['new_quote']);
            $quotes[] = $new_quote;
            update_option('random_quotes', $quotes);
            echo '<div class="updated"><p>New quote added successfully.</p></div>';
        } elseif ($action === 'update' && isset($_POST['id']) && isset($_POST['updated_quote'])) {
            // Handle update quote action
            $id = $_POST['id'];
            $updated_quote = sanitize_textarea_field($_POST['updated_quote']);
            $quotes[$id] = $updated_quote;
            update_option('random_quotes', $quotes);
            echo '<div class="updated"><p>Quote updated successfully.</p></div>';
        }
    }
}

// Hook into the admin_init action to handle actions
add_action('admin_init', 'random_quote_sub_tab_1_actions');

// Function to register settings
function random_quote_footer_register_settings() {
    register_setting('random_quote_footer_settings_group', 'random_quote_color');
    register_setting('random_quote_footer_settings_group', 'random_quote_font');
}
add_action('admin_init', 'random_quote_footer_register_settings');
?>
