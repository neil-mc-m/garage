/**
 * Ajax call to delete an image.
 * The response is
*/

$(document).ready(function(){
    $('.delete-image').on('click', function(event){
        event.preventDefault();
        var result = $(event.target).closest('button').data('imageid');
        var block = $(this).parent().parent();

        console.log(block);
        $.ajax({
            url: '/admin/delete-image/'+result ,
            type: "GET",

            error: function () {
                $('#message').html('<p>An error occurred with the request</p>');
            },
            success: function (response) {

                console.log(response);
                $(block).fadeOut(100);
                UIkit.notify(response, {status:'info'});
            }
        });
    });
}) ;
/**
 * Ajax call to make an image a lead image for the sales page.
 * As only one image can be used as a lead image, this function
 * adds the image to the car table.
 */
$(document).ready(function(){
    $('.main-image').on('click', function(event){
        event.preventDefault();
        var imageid = $(event.target).closest('a').data('imageid');
        var carid = $(event.target).closest('a').data('carid');

        console.log(imageid);

        $.ajax({
            url: '/admin/lead-image/'+carid+'/'+imageid ,
            type: "POST",

            error: function (response) {
                UIkit.notify({
                    message : response,
                    status : 'danger',
                    pos : 'top-center'
                });

            },
            success: function (response) {

                console.log(response);
                UIkit.notify(response, {status:'info'});

            }
        });
    });
}) ;
/**
 * Ajax call to add an image to a car.
 */
$(document).ready(function(){
    $('.add-image').on('click', function(event){
        event.preventDefault();
        var carid = $(event.target).closest('a').data('carid');
        var imageid = $(event.target).closest('a').data('imageid');
        console.log(carid);
        console.log(imageid);

        $.ajax({
            url: '/admin/add-image/'+carid+'/'+imageid ,
            type: "POST",

            error: function (response) {
                $('#message').html('<p>' + response + '</p>');
            },
            success: function (response) {

                console.log(response);
                UIkit.notify(response, {status:'info'});
                // $('#message').html('<p>' + response + '</p>');
            }
        });
    });
}) ;
