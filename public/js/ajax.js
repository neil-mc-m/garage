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

                        $('#livesearch').html(response);



            }
        });
    }
}