// the search function.
// ajax call to search the database for all matching rows
function showResult(str) {
    if (str.length == 0) {
        document.getElementById("livesearch").innerHTML = " ";

    } else {
        var http_request = new XMLHttpRequest();
        http_request.onreadystatechange = function () {
            if (http_request.readyState == 4 && http_request.status == 200) {
                var result = JSON.parse(http_request.responseText);
                console.log(result);
                for (i=0; i<result.length; i++){
                    var counter = result[i];
                    console.log(counter.id);

                     document.getElementById("livesearch").innerHTML = counter.make + " " + counter.model;

                }

            }
        };
        http_request.open("GET", "/search/" + str, true);
        http_request.send();
    }
}