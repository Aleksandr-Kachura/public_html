

$(document).ready(function()
{
	$('img').on('click',function()
    {
		var src = $(this).attr('src');
		var img = '<img src="' + src + '" class="img-responsive"/>';
		//start of new code new code

		var html = '';
		html += img;                
		html += '<div style="height:25px;clear:both;display:block;mod">';
		html += '</div>';

		$('#myModal').modal();
		$('#myModal').on('shown.bs.modal', function(){
			$('#myModal .modal-body').html(html);
			//new code
			$('a.controls').trigger('click');
		})
		$('#myModal').on('hidden.bs.modal', function(){
			$('#myModal .modal-body').html('');
		});
    });

    $('select').on('click',function()
    {
       ///  alert($(this).attr('name'));
      //  console.log($(this).val())
        var access = $(this).val();
        var id = $(this).attr('name');
       // console.log($(this).attr('name'));
        $.ajax({
            type: "GET",
            url: pathajax,
            data: {id : id, access : access },
            success: function(data)
            {

            }
        });
     });




})
