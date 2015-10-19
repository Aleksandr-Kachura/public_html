

$(document).ready(function()
{


    $('.box-4').on('click',function(){
        var box4;
        box4 = new ajaxLoader(this, {classOveride: 'blue-loader', bgColor: '#000', opacity: '0.3'});
    });


    function ajaxLoader (el, options) {
        // Becomes this.options
        var defaults = {
            bgColor 		: '#fff',
            duration		: 800,
            opacity			: 0.7,
            classOveride 	: false
        }
        this.options 	= jQuery.extend(defaults, options);
        this.container 	= $(el);

        this.init = function() {
            var container = this.container;
            // Delete any other loaders
            this.remove();
            // Create the overlay
            var overlay = $('<div></div>').css({
                'background-color': this.options.bgColor,
                'opacity':this.options.opacity,
                'width':container.width(),
                'height':container.height(),
                'position':'absolute',
                'top':'0px',
                'left':'0px',
                'z-index':99999
            }).addClass('ajax_overlay');
            // add an overiding class name to set new loader style
            if (this.options.classOveride) {
                overlay.addClass(this.options.classOveride);
            }
            // insert overlay and loader into DOM
            container.append(
                overlay.append(
                    $('<div></div>').addClass('ajax_loader')
                ).fadeIn(this.options.duration)
            );
        };

        this.remove = function(){
            var overlay = this.container.children(".ajax_overlay");
            if (overlay.length) {
                overlay.fadeOut(this.options.classOveride, function() {
                    overlay.remove();
                });
            }
        }

        this.init();
    }


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
