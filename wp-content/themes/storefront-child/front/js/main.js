
jQuery(document).ready(function($) {
    $('#city-search-input').on('input', function() {
        var search = $(this).val();

        $.ajax({
            url: citySearch.ajax_url,
            type: 'POST',
            data: {
                action: 'sb_search_cities',
                nonce: citySearch.nonce,
                search: search
            },
            success: function(response) {
                if (response.success) {
                    var $tbody = $('#cities-table tbody');
                    $tbody.empty();

                    $.each(response.data, function(index, city) {
                        $tbody.append(
                            '<tr>' +
                            '<td>' + city.city + '</td>' +
                            '<td>' + city.country + '</td>' +
                            '<td>' + city.temperature + '</td>' +
                            '</tr>'
                        );
                    });
                }
            }
        });
    });
});