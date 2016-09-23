// the search function.
// ajax call to search the database for all matching rows
function showResult(str) {
    if (str.length == 0) {
        document.getElementById("livesearch").innerHTML = " ";
        $('.dropdown-content').hide();
    } else {
        $.ajax({
            url: '/search/' + str,
            type: 'GET',

            error: function () {
                $('#livesearch').html('<p>An error occurred</p>');
            },

            success: function (response) {
                $('.dropdown-content').show();
                var json_obj = $.parseJSON(response);
                console.log(json_obj);
                $(json_obj).each(function (i, val) {

                        $('#livesearch').html('<a href="/sales/{{ val.id }}" class="uk-contrast">'+val.make+' '+val.model+'</a>');

                });

            }
        });
    }
}