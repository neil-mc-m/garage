// the search function.
// ajax call to search the database for all matching rows
function showResult(str) {
    if (str.length == 0) {
        document.getElementById("livesearch").innerHTML = " ";
        $('.dropdown-content').hide();

    } else {
        //     var http_request = new XMLHttpRequest();
        //     http_request.onreadystatechange = function () {
        //         if (http_request.readyState == 4 && http_request.status == 200) {
        //             var string  = JSON.stringify(http_request.responseText);
        //             console.log(string);
        //             var result = JSON.parse(string);
        //
        //             for (i=0; i<result.length; i++){
        //                 var counter = result[i];
        //                 console.log(counter.id);
        //
        //                  document.getElementById("livesearch").innerHTML = counter.make + " " + counter.model;
        //
        //             }
        //
        //         }
        //     };
        //     http_request.open("GET", "/search/" + str, true);
        //     http_request.send();
        //  }
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