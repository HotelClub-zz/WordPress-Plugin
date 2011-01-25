jQuery(document).ready(function($) {
    if (typeof ajaxurl !== 'undefined') {
        $('#hotelclub_country_id').change(function() {
            $.get(ajaxurl, {
                action: 'hotelclub_get_cities',
                country_id: $(this).val()
            },
            function(data) {
                $('#hotelclub_city_id').html(data);
            });
        });
    }
    if (jQuery().datepicker) {
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    }
});