/**
 * Created by neil on 05/10/2016.
 */

$(document).ready(function(){
    $('.delete-image').on('click', function(event){
        event.preventDefault();
        var result = $(event.target).closest('button').data('imageid');
        var block = $(this).parent().parent();

//                var id = result.data('carid');
        console.log(block);
        $.ajax({
            url: '/admin/delete-image/'+result ,
            type: "GET",

            error: function () {
                $('#message').html('<p>An error occurred with the request</p>');
            },
            success: function (response) {

                console.log(response);
                $(block).fadeOut(300);
                $("#message").slideDown(50).delay(5000);
                $('#message').html('<p>' + response + '</p>');
                $("#message").slideUp(50).delay(5000);
            }
        });
    });
}) ;

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
                $('#message').html('<p>' + response + '</p>');
            },
            success: function (response) {

                console.log(response);
                $("#message").slideDown(50).delay(5000);
                $('#message').html('<p>' + response + '</p>');
                $("#message").slideUp(50).delay(5000);
            }
        });
    });
}) ;

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

                $('#message').html('<p>' + response + '</p>');
            }
        });
    });
}) ;
