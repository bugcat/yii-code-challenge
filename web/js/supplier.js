
jQuery(function ($) {
    // Check is selected all
    $('.supplier .select-on-check-all').change(function() {
        let $checkbox = $(this);
        let isChecked = $checkbox.prop('checked');
        if ( isChecked ) {
            // selected all rows
            let rows = $(".supplier input[name='selection[]']:checked");
            let number = rows.length;
            $('#suppliers-selected-number').html(number);
            $('.supplier .selected-page-all').show();
        } else {
            $('.supplier .selected-page-all').hide();
            $('.supplier .selected-search-all').hide();
            $('#suppliers-are-selected-all').val(0);
        }
    });

    // Select across all pages
    $('.supplier .to-select-search').click(function() {
        $('.supplier .selected-page-all').hide();
        $('.supplier .selected-search-all').show();
        $('#suppliers-are-selected-all').val(1);
    });

    // Cancel across all pages selected
    $('.supplier .clear-selected-search').click(function() {
        $('.supplier .selected-page-all').show();
        $('.supplier .selected-search-all').hide();
        $('#suppliers-are-selected-all').val(0);
    });

    // Export csv
    $('#exportModal .download-button').click(function() {
        $('#exportModal').modal('hide');
        // get rows
        let rows = $(".supplier input[name='selection[]']:checked");
        let number = rows.length;
        if ( 0 == number ) {
            alert('Please select at least one row of data.');
            return false;
        }
        let rowsArr = [];
        rows.each(function() {
            rowsArr.push($(this).val())
        });
        // submit form 
        let form = $('#supplier-export-form');
        let rowsInput = $("#supplier-export-form input[name='rows_str']");
        rowsInput.val(rowsArr);
        form.submit();
    });
});
