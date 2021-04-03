$(document).ready(function(){
//sliding form
    $('#signup').click(function(){
        $('#first_form').slideUp('slow', function(){
            $('#second_form').slideDown();
        })
    })


    $('#signin').click(function(){
        $('#second_form').slideUp('slow', function(){
            $('#first_form').slideDown()
        })
    })


    

})
