jQuery(document).ready(function($) {
    // Function to fetch and display random quote
    function displayRandomQuote() {
        // Ajax request to fetch the random quote
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'get_random_quote_footer' // Action to retrieve random quote
            },
            success: function(response) {
                // Append the quote to the footer
                $('footer').append(response);
            }
        });
    }

    // Call the function to display random quote
    displayRandomQuote();
});
