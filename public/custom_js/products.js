$(document).ready(function () {
    var applyFilters = function () {
        var city = $('#cities').val(),
            rest = $('#restaurants').val();
        if (city) {
            $('#restaurants option').hide();
            $('#restaurants option[data-city=' + city + ']').show();
        }
        if (rest) {
            $('#categories option').hide();
            $('#categories option[data-restaurant=' + rest + ']').show();
        }
    };
    $('#cities').change(function () {
        $('#restaurants').val('');
        $('#categories').val('');
        applyFilters();
    });
    $('#restaurants').change(function () {
        $('#categories').val('');
        applyFilters(); 
    });
    applyFilters();
});