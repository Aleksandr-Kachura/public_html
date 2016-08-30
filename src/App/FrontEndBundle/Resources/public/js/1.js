

$(document).ready(function()
{

    $('.advantage').hide();

    $('.advsearch').on('click',function(){
        $('.advantage').toggle();
    });


    $("input[name='search[firstname]']").on('keyup',function()
    {
        if($("input[name='search[firstname]']").val().length>1)
        {
            var firstname = $("input[name='search[firstname]']").val();
            $.ajax(
                {
                    method : 'GET',
                    url : pathajax,
                    data : { firstname: firstname},
                    success:function(data)
                    {
                        console.log(data.firstnames);
                        $('#results').html('');
                        for(var key in data.firstnames)
                        {
                            $('#results').append('<div class="item">' + data.firstnames[key].firstname + '</div>');
                        }
                        $('.item').click(function() {
                            var text = $(this).html();
                            $("input[name='search[firstname]']").val(text);
                        })


                    }
                });

        }
        else {
            $('#results').html('');
        }
    });

    $("input[name='search[firstname]']").blur(function(){
        $("#results").fadeOut(500);
    })
        .focus(function() {
            $("#results").show();
        });


    $('#bundles_storebundle_user2_email').blur(function()
        {
            console.log($('#bundles_storebundle_user2_email').val().length);
            //alert($('#bundles_storebundle_user2_email').value);
            if($('#bundles_storebundle_user2_email').val().length>6)
            {
                var email = $('#bundles_storebundle_user2_email').val();
                $.ajax(
                    {
                        method : 'GET',
                        url : pathajax,
                        data : { email: email},
                        success:function(data)
                        {
                            console.log(data.message);

                            if(typeof data.message!== "undefined")
                            {
                                // console.log($(".bsu_message").value);
                                var str ="<div class='bsu_message' style='color: red'>"+data.message+"</div>";
                                // $(str).appendTo( "" );
                                $( ".bsu_message" ).replaceWith(str);
                            }
                            else
                            {
                                var str ="<div class='bsu_message'></div>";
                                //console.log("1111");
                                $( ".bsu_message" ).replaceWith(str);
                            }


                        }
                    });

            }
        }
    )


    $('#user_email').blur(function()
        {
            var email = $('#user_email').val();
            $.ajax(
                {
                    method : 'GET',
                    url : pathajax,
                    data : { email: email},
                    success:function(data)
                    {

                        if( typeof data.status != 'undefined' )
                        {
                            // console.log($(".bsu_message").value);
                            var user = "Not present user in db, please check email for correct"
                            var str ="<div class='bsu_message' style='color: red'>"+user+"</div>";
                            $( ".bsu_message" ).replaceWith(str);
                        }
                        else
                        {
                            var str ="<div class='bsu_message'></div>";
                            //console.log("1111");
                            $( ".bsu_message" ).replaceWith(str);
                        }


                    }
                });
        }
    )



})
