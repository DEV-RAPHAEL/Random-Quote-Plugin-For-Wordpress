// popup.js

document.addEventListener('DOMContentLoaded', function () {
    // Show popup when Add New Quote button is clicked
    document.getElementById('addNewQuoteBtn').addEventListener('click', function () {
        document.getElementById('addNewQuotePopup').style.display = 'block';
    });

    // Hide popup when Save Quote button is clicked
    document.getElementById('saveNewQuoteBtn').addEventListener('click', function () {
        // Get the quote text from the WYSIWYG editor
        var newQuote = document.getElementById('newQuoteEditor').value;
        // You can now save the new quote using AJAX or any other method
        // For simplicity, this example does not include the saving logic
        // After saving, you may want to reload the quotes table to display the updated list
        document.getElementById('addNewQuotePopup').style.display = 'none';
    });

    // JavaScript to handle selecting/deselecting all checkboxes
    document.getElementById('select_all').addEventListener('change', function () {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = this.checked;
        });
    });
});
