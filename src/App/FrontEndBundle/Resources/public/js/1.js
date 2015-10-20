

$(document).ready(function()
{

    $('.advantage').hide();

    $('.advsearch').on('click',function(){
        $('.advantage').toggle();
    });

    $('#bundles_storebundle_user2_email').blur(function()
        {
            console.log($('#bundles_storebundle_user2_email').val().length);
            //alert($('#bundles_storebundle_user2_email').value);
            if($('#bundles_storebundle_user2_email').val().length>6)
            {
                 var email = $('#bundles_storebundle_user2_email').val();
               //  alert($('#bundles_storebundle_user2_email').val());
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
          //  alert($('#user_email').val())

                var email = $('#user_email').val();
                 //alert($('#user_email').val());
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
    )



})
