<?php
/*
Plugin Name: Random Quote on Site
Description: Display a random quote that helps your users see why they should use your service using a shortcode with customizable color and font.
Version: 3.0
Author: Ajayi Raphael Temitope
*/

// Function to get all quotes
function get_all_quotes() {
    $quotes = get_option('random_quotes', array());
    if (!empty($quotes)) {
        // Add an ID counter to each quote
        $id = 0;
        foreach ($quotes as &$quote) {
            $id++;
            $quote['id'] = $id;
        }
    }
    return $quotes;
}

// Function to get a random quote
function get_random_quote() {
    $quotes = get_all_quotes();
    if (empty($quotes)) {
        return 'No quotes available';
    }
    $index = array_rand($quotes);
    return $quotes[$index];
}

// Function to handle the normal shortcode without dynamic update
function display_random_quote() {
    $color = get_option('random_quote_color', '#000000');
    $font = get_option('random_quote_font', 'Arial');
    $quote = get_random_quote();
    return "<blockquote style='color: $color; font-family: $font;'>{$quote['quote']}</blockquote>";
}

// Register the normal shortcode
add_shortcode('random_quote', 'display_random_quote');

// Function to handle the dynamic shortcode with dynamic update
function display_random_quote_dynamic() {
    $color = get_option('random_quote_color', '#000000');
    $font = get_option('random_quote_font', 'Arial');
    ?>
    <blockquote id="random-quote" style="color: <?php echo $color; ?>; font-family: <?php echo $font; ?>"></blockquote>
    <script>
        // Function to fetch a new random quote from the server
        function fetchRandomQuote() {
            fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=get_random_quote')
                .then(response => response.json())
                .then(data => {
                    const quote = data.quote;
                    const quoteElement = document.getElementById('random-quote');
                    // Update quote text
                    quoteElement.innerHTML = quote;
                })
                .catch(error => console.error('Error fetching random quote:', error));
        }

        // Fetch a new random quote every 30 seconds
        setInterval(fetchRandomQuote, 30000);

        // Fetch a new random quote when the page is loaded
        document.addEventListener('DOMContentLoaded', fetchRandomQuote);
    </script>
    <?php
}

// Register the dynamic shortcode
add_shortcode('random_quote_dynamic', 'display_random_quote_dynamic');

// AJAX handler to get a random quote
add_action('wp_ajax_get_random_quote', 'get_random_quote_ajax');
add_action('wp_ajax_nopriv_get_random_quote', 'get_random_quote_ajax');

function get_random_quote_ajax() {
    $quote = get_random_quote();
    wp_send_json($quote);
}

// Function to add top-level menu item
function random_quote_footer_settings_menu() {
    add_menu_page('Random Quote Settings', 'Random Quote', 'manage_options', 'random-quote-footer-settings', 'random_quote_footer_settings', '', 100);
}
add_action('admin_menu', 'random_quote_footer_settings_menu');

// Function to import demo quotes
function import_demo_quotes() {
    // Get the default quotes (can be moved outside the function for better performance)
    $default_quotes = array(
        array("quote" => "A brand is the voice of a company. You have to make sure it speaks clearly and consistently. - Simon Sinek, Author & Speaker"),
        array("quote" => "Design is intelligence made visible. - Alina Wheeler, Design Consultant"),
        array("quote" => "Branding is the art of simplifying the idea of the business. - Marty Neumeier, Branding Expert"),
        array("quote" => "A strong brand is like a lighthouse - it cuts through the chaos and helps people find you. - David Brier, Marketing Consultant"),
        array("quote" => "People don't buy products, they buy stories. - Simon Sinek"),
        array("quote" => "Websites are the ultimate brochure - always open, always accessible, and always up-to-date. - Unknown"),
        array("quote" => "In the digital age, the best place to hide is the second page of Google search results. - Unknown"),
        array("quote" => "Your website is your digital storefront - make it inviting, user-friendly, and conversion-focused. - Neil Patel, Marketing Expert"),
        array("quote" => "The web is not a destination, it is a journey - make sure your website is part of the adventure. - Craig Sullivan, Google Search Quality Strategist"),
        array("quote" => "A website is like a handshake - it creates a first impression that can make or break a deal. - Anonymous"),
        array("quote" => "Content is king, but design is queen. Without the queen, the king is alone. - Steve Jobs"),
        array("quote" => "Great design is both beautiful and functional - it serves a purpose while delighting the user. - Dieter Rams, Industrial Designer"),
        array("quote" => "Design is not just how it looks and feels. It's how it works. - Steve Jobs"),
        array("quote" => "Visuals are a powerful tool - use them to tell your story, captivate your audience, and leave a lasting impression. - Unknown"),
        array("quote" => "Good design is like good storytelling - it resonates with emotion and inspires action. - Unknown"),
        array("quote" => "The internet is the world's largest marketplace - be there where your customers are searching. - Bill Gates"),
        array("quote" => "The biggest risk is not taking any risk. In a world that's changing really quickly, the only strategy that is guaranteed to fail is not taking risks. - Mark Zuckerberg"),
        array("quote" => "Don't wait for the perfect moment, take the moment and make it perfect. - Paulo Coelho, Author"),
        array("quote" => "The future belongs to those who believe in the beauty of their dreams. - Eleanor Roosevelt"),
        array("quote" => "The future belongs to those who believe in the beauty of their dreams. - Eleanor Roosevelt"),
    );

    // Merge with existing quotes (optional)
    $existing_quotes = get_option('random_quotes', array());
    $quotes = array_merge($existing_quotes, $default_quotes);

    // Update the option with the combined quotes
    update_option('random_quotes', $quotes);

    // Display a success message
    echo '<div class="updated"><p>Demo quotes imported successfully.</p></div>';
}

// Function to add sub-tab for settings page
function random_quote_footer_settings() {
    ?>
    <div class="wrap">
        <h1>Random Quote Settings</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=random-quote-footer-settings" class="nav-tab nav-tab-active">General Settings</a>
            <a href="?page=random-quote-footer-settings&tab=subtab1" class="nav-tab">Manage Quotes</a>
            <a href="?page=random-quote-footer-settings&tab=import-export-quotes" class="nav-tab">Import/Export Quotes</a>
        </h2>
        <?php
        // Check for the current tab
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';

        // Display content based on current tab
        if ($current_tab === 'subtab1') {
            random_quote_sub_tab_1_content(); // Call function to display Sub Tab 1 content
        } elseif ($current_tab === 'subtab2') {
            echo '<h2>Sub Tab 2 Content</h2>';
        } elseif ($current_tab === 'import-export-quotes') {
            import_export_quotes_content(); // Call function to display Import/Export Quotes content
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
                <h3>Shortcodes</h3>
                <p>Use These shortcodes to add Quotes to your site</p>
                <table>
                    <th scope="row">Static Display</th>
                    <code>[random_quote]</code>
                </table>
                <br>
                <table>
                    <th scope="row">Dynamic Display</th>
                    <code>[random_quote_dynamic]</code>
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
    <!-- Button to trigger popup -->
    <button id="addNewQuoteBtn" class="button">Add New Quote</button>

    <!-- Popup for adding new quote -->
    <div id="addNewQuotePopup" style="display: none;">
        <!-- WYSIWYG editor for quote -->
        <?php
        $content = '';
        $editor_id = 'newQuoteEditor';
        $settings = array(
            'textarea_name' => 'new_quote',
            'media_buttons' => false,
            'quicktags'     => false,
            'teeny'         => true,
        );
        wp_editor( $content, $editor_id, $settings );
        ?>
        <button id="saveNewQuoteBtn" class="button-primary">Save Quote</button>
    </div>

    <!-- Existing quotes table -->
    <table class="widefat">
        <!-- Table headers -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Quote</th>
                <th>Action</th>
            </tr>
        </thead>
        <!-- Table body to display existing quotes -->
        <tbody>
            <?php
            // Get all quotes
            $quotes = get_all_quotes();

            // Loop through each quote and display in a table row
            foreach ($quotes as $quote) {
                ?>
                <tr>
                    <td><?php echo $quote['id']; ?></td>
                    <td><?php echo $quote['quote']; ?></td>
                    <td>
                        <!-- Edit and delete actions -->
                        <a href="?page=random-quote-footer-settings&tab=subtab1&action=edit&id=<?php echo $quote['id']; ?>">Edit</a> |
                        <a href="?page=random-quote-footer-settings&tab=subtab1&action=delete&id=<?php echo $quote['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <!-- JavaScript to handle popup functionality -->
    <script>
        // Show popup when Add New Quote button is clicked
        document.getElementById('addNewQuoteBtn').addEventListener('click', function() {
            document.getElementById('addNewQuotePopup').style.display = 'block';
        });

        // Hide popup when Save Quote button is clicked
        document.getElementById('saveNewQuoteBtn').addEventListener('click', function() {
            // Get the quote text from the WYSIWYG editor
            var newQuote = document.getElementById('newQuoteEditor').value;
            // You can now save the new quote using AJAX or any other method
            // For simplicity, this example does not include the saving logic
            // After saving, you may want to reload the quotes table to display the updated list
            document.getElementById('addNewQuotePopup').style.display = 'none';
        });
    </script>
    <?php
}

// Function to handle actions in Sub Tab 1
function random_quote_sub_tab_1_actions() {
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $id = $_GET['id'];
        $quotes = get_all_quotes();

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
                            <td><textarea name="updated_quote"><?php echo $quotes[$id]['quote']; ?></textarea></td>
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
        $quotes = get_all_quotes();

        if ($action === 'add' && isset($_POST['new_quote'])) {
            // Handle add new quote action
            $new_quote = sanitize_textarea_field($_POST['new_quote']);
            $quotes[] = array('id' => count($quotes) + 1, 'quote' => $new_quote);
            update_option('random_quotes', $quotes);
            echo '<div class="updated"><p>New quote added successfully.</p></div>';
        } elseif ($action === 'update' && isset($_POST['id']) && isset($_POST['updated_quote'])) {
            // Handle update quote action
            $id = $_POST['id'];
            $updated_quote = sanitize_textarea_field($_POST['updated_quote']);
            $quotes[$id]['quote'] = $updated_quote;
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

// Function to display content for Import/Export Quotes tab
function import_export_quotes_content() {
    ?>
    <h2>Import/Export Quotes</h2>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data">
        <input type="hidden" name="action" value="import_quotes">
        <h3>Import Quotes</h3>
        <p>Select a CSV file containing quotes to import:</p>
        <input type="file" name="quote_csv_file">
        <?php submit_button('Import Quotes'); ?>
    </form>
    <br>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="export_quotes">
        <h3>Export Quotes</h3>
        <p>Export all existing quotes to a CSV file:</p>
        <?php submit_button('Export Quotes'); ?>
    </form>
    <br>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="import_demo_quotes">
        <h3>Import Demo Quotes</h3>
        <p>Click below to import demo quotes:</p>
        <button type="submit" name="import_demo_quotes" class="button">Import Demo Quotes</button>
    </form>
    <?php
}

// Function to handle CSV import
function import_quotes_handler() {
    if (isset($_FILES['quote_csv_file']) && !empty($_FILES['quote_csv_file']['name'])) {
        $file = $_FILES['quote_csv_file'];
        $csv = array_map('str_getcsv', file($file['tmp_name']));
        $quotes = array();
        foreach ($csv as $line) {
            if (isset($line[0])) {
                $quotes[] = array('quote' => $line[0]);
            }
        }
        // Merge with existing quotes (optional)
        $existing_quotes = get_option('random_quotes', array());
        $quotes = array_merge($existing_quotes, $quotes);
        // Update the option with the combined quotes
        update_option('random_quotes', $quotes);
        echo '<div class="updated"><p>Quotes imported successfully.</p></div>';
    }
    wp_redirect(admin_url('admin.php?page=random-quote-footer-settings&tab=import-export-quotes'));
    exit;
}

// Function to handle CSV export
function export_quotes_handler() {
    $quotes = get_all_quotes();
    $file = fopen('quotes.csv', 'w');
    foreach ($quotes as $quote) {
        fputcsv($file, array($quote['quote']));
    }
    fclose($file);
    // Force file download
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=quotes.csv');
    header('Content-Type: application/csv; charset=UTF-8');
    readfile('quotes.csv');
    exit;
}

// Hook into admin-post for handling import and export actions
add_action('admin_post_import_quotes', 'import_quotes_handler');
add_action('admin_post_export_quotes', 'export_quotes_handler');

