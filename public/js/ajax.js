// the search function.
// ajax call to search the database for all matching rows
function showResult(str) {
    if (str.Length == 0) {
        document.getElementById("livesearch").innerHTML = "";
        $('.dropdown-content').hide();
    } else {
        $.ajax({
            url: '/search/' + str,
            type: 'GET',

            error: function (response) {
                $('#livesearch').html(response);
            },

            success: function (response) {
                $('.dropdown-content').show();
                $('#livesearch').html(response);
            }
        });
    }
}