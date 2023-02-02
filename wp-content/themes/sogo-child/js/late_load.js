jQuery(document).ready(function($){
    cities_array = '';
    $.ajax({
        url: sogo.ajaxurl,
        type: 'GET',
        dataType: 'json',
        data: {
            'action': 'sogo_load_cities'
        },
        success: function (result) {
            console.log(result);
            cities_array = result.data;
        }
    });
});