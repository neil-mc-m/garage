// the search function.
// ajax call to search the database for all matching rows

$(document).ready(function () {
    $('#searchbox').on('keyup', function () {
            var val = $('#searchbox').val();
            console.log(val);
            if (!this.value ) {
                $('.dropdown-content').hide();
                return;
            }
            else {
                $.ajax({
                    url: '/search/' + val,
                    type: 'GET',

                    error: function (response) {
                        $('#livesearch').html(response);
                    },

                    success: function (response) {
                        $('.dropdown-content').show();
                        $('#livesearch').html(response);
                    }
                })
            }
        }
    )
});