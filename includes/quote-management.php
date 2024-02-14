<?php
// manage-quotes.php

// Function to display content for Sub Tab 1
function random_quote_sub_tab_1_content() {
    ?>
    <h2>Manage Quotes</h2>
    <!-- Button to trigger popup -->
    <button id="addNewQuoteBtn" class="button">Add New Quote</button>

    <!-- Popup for adding new quote -->
    <div id="addNewQuotePopup" style="display: none;">
        <!-- WYSIWYG editor for quote -->
        <textarea id="newQuoteEditor"></textarea>
        <button id="saveNewQuoteBtn" class="button-primary">Save Quote</button>
    </div>

    <!-- Existing quotes table -->
    <form method="post" action="">
        <table class="widefat">
            <!-- Table headers -->
            <thead>
                <tr>
                    <th scope="col" class="manage-column check-column"><input type="checkbox" id="select_all"></th>
                    <th>ID</th>
                    <th>Quote</th>
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
                        <td><input type="checkbox" name="selected_quotes[]" value="<?php echo $quote['id']; ?>"></td>
                        <td><?php echo $quote['id']; ?></td>
                        <td><?php echo $quote['quote']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <!-- Add the bulk action dropdown -->
        <select name="bulk_action">
            <option value="">Bulk Actions</option>
            <option value="delete">Delete Selected</option>
        </select>
        <input type="submit" name="submit_bulk_action" value="Apply">
    </form>

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

        // JavaScript to handle selecting/deselecting all checkboxes
        document.getElementById('select_all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            });
        });
    </script>
    <?php
}

// Function to handle actions in Sub Tab 1
function random_quote_sub_tab_1_actions() {
    // Handle actions here if needed
}

// Hook into the admin_init action to handle actions
add_action('admin_init', 'random_quote_sub_tab_1_actions');

// Display content for Sub Tab 1
random_quote_sub_tab_1_content();
?>
