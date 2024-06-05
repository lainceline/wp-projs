jQuery(document).ready(function($) {
    // Filtering functionality
    $('.portfolio-filter').on('click', 'button', function() {
        var filterValue = $(this).attr('data-filter');
        $('.portfolio-item').hide();
        if (filterValue == '*') {
            $('.portfolio-item').show();
        } else {
            $('.portfolio-item.' + filterValue).show();
        }
        $('.portfolio-filter button').removeClass('active');
        $(this).addClass('active');
    });

    // Sorting functionality
    $('#portfolio-sort').on('change', function() {
        var sortValue = $(this).val();
        var portfolioItems = $('.portfolio-item').get();

        portfolioItems.sort(function(a, b) {
            if (sortValue == 'title') {
                return $(a).find('.portfolio-title').text().localeCompare($(b).find('.portfolio-title').text());
            } else if (sortValue == 'date') {
                return new Date($(a).data('date')) - new Date($(b).data('date'));
            }
        });

        $.each(portfolioItems, function(index, item) {
            $('.portfolio-items').append(item);
        });
    });
});
