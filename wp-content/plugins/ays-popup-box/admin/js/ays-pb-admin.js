(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
     $(document).ready(function (){
        $('.apm-pro-feature-link').on('click', goToPro);
        $(document).find('.nav-tab-wrapper a.nav-tab').on('click', function(e){            
            let elemenetID = $(this).attr('href');
            let active_tab = $(this).attr('data-tab');
            $(document).find('.nav-tab-wrapper a.nav-tab').each(function(){
            if( $(this).hasClass('nav-tab-active') ){
                $(this).removeClass('nav-tab-active');
            }
            });
            $(this).addClass('nav-tab-active');
                $(document).find('.ays-pb-tab-content').each(function(){
                if( $(this).hasClass('ays-pb-tab-content-active') )
                    $(this).removeClass('ays-pb-tab-content-active');
            });
            $(document).find("[name='ays_pb_tab']").val(active_tab);
            $('.ays-pb-tab-content' + elemenetID).addClass('ays-pb-tab-content-active');
            e.preventDefault();
        });
         
        $(document).find('.ays_pb_color_input').wpColorPicker();
         
        $(document).find('.ays-pb-tab-content select').select2();
        var ays_pb_view_place = $(document).find('#ays-pb-ays_pb_view_place').select2({
            placeholder: 'Select page',
            multiple: true,
            matcher: searchForPage
        });
         
        $(document).find('.ays_view_place_clear').on('click', function(){
            ays_pb_view_place.val(null).trigger('change');
        });
        
        $(document).on('click', '.ays-remove-bg-img', function () {
            $('img#ays-pb-bg-img').attr('src', '');
            $('input#ays-pb-bg-image').val('');
            $('.ays-pb-bg-image-container').parent().fadeOut();
            $('a.ays-pb-add-bg-image').text('Add Image');
            $('.box-apm').css('background-image', 'unset');
            $('.ays_bg_image_box').css('background-image', 'unset');
            if ($(document).find('#ays-enable-background-gradient').prop('checked')) {
                toggleBackgrounGradient();
            }
            if ($(document).find(".ays_template_window").is(":visible")) {
                var bg_img_default="https://quiz-plugin.com/wp-content/uploads/2020/02/girl-scaled.jpg";
                $(document).find('.ays_bg_image_box').css({
                    'background-image' : 'url(' + bg_img_default + ')',
                    'background-repeat' : 'no-repeat',
                    'background-size' : 'cover',
                    'background-position' : 'center center'
                });
            }
            if ($(document).find(".ays_image_window").is(":visible")) {
                var bg_img_default="https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg";
                $(document).find('.ays_bg_image_box').css({
                    'background-image' : 'url(' + bg_img_default + ')',
                    'background-repeat' : 'no-repeat',
                    'background-size' : 'cover',
                    'background-position' : 'center center'
                });
            }
        });

        var ays_pb_overlay_color = $(document).find('#ays-pb-overlay_color').val();
        $(document).find('.ays-pb-modals').css("background-color", ays_pb_overlay_color);

        let ays_pb_box_gradient_color1_picker = {
            change: function (e) {
                setTimeout(function () {
                    toggleBackgrounGradient();
                }, 1);
            }
        };
        let ays_pb_box_gradient_color2_picker = {
            change: function (e) {
                setTimeout(function () {
                    toggleBackgrounGradient();
                }, 1);
            }
        };
        $(document).find('#ays_pb_gradient_direction').on('change', function () {
            toggleBackgrounGradient();
        });

        $(document).find('#ays-background-gradient-color-1').wpColorPicker(ays_pb_box_gradient_color1_picker);
        $(document).find('#ays-background-gradient-color-2').wpColorPicker(ays_pb_box_gradient_color2_picker);

        $(document).find('input#ays-enable-background-gradient').on('change', function () {
            toggleBackgrounGradient()
        });
        toggleBackgrounGradient();
        function toggleBackgrounGradient() {
                let pb_gradient_direction = $(document).find('#ays_pb_gradient_direction').val();
                var checked = $(document).find('input#ays-enable-background-gradient').prop('checked');
                switch(pb_gradient_direction) {
                    case "horizontal":
                        pb_gradient_direction = "to right";
                        break;
                    case "diagonal_left_to_right":
                        pb_gradient_direction = "to bottom right";
                        break;
                    case "diagonal_right_to_left":
                        pb_gradient_direction = "to bottom left";
                        break;
                    default:
                        pb_gradient_direction = "to bottom";
                }
            if($(document).find('input#ays-pb-bg-image').val() == '') {
                if(checked){
                    $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
                }else{
                    if ($(document).find("#ays-image-window")){
                        $(document).find('#ays-image-window').css({'background-image': 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg'});
                    }else{
                        $(document).find('.ays-pb-live-container').css({'background-image': "none"});
                    }
                }
            } else {
                if (checked && $(document).find(".ays_template_window").hasClass("ays_active") ) {
                    $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
                }
            }
            // else if ($(document).find(".ays_template_window").hasClass("ays_active") 
            //     && $(document).find('input#ays-enable-background-gradient').attr('checked') == 'checked' 
            //     && $(document).find('input#ays-pb-bg-image').val() != '') {
            //      $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
     
            // }
        }


         
        $(document).on('change', '.ays_toggle', function (e) {
            let state = $(this).prop('checked');
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        $(this).parent().find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        $(this).parent().find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        $(this).parent().find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        $(this).parent().find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });

        $(document).on('change', '.ays_toggle_checkbox', function (e) {
            let state = $(this).prop('checked');
            let parent = $(this).parents('.ays_toggle_parent');
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });

        $(document).find('#ays_pb_posts').select2({
            placeholder: 'Select page',
            multiple: true,
            matcher: searchForPage
        });
        var ays_pb_post_types = $(document).find('#ays_pb_post_types').select2({
            placeholder: 'Select page',
            multiple: true,
            matcher: searchForPage
        });

        $(document).on('change', '#ays_pb_post_types', function () {

            var selected = $('.select2-selection__choice');
            var arr = pb.post_types;
            
            var types_arr = [];
            for (var i = 0; i < selected.length; i++) {
                var name = selected[i].innerText;
                name = name.substring(1, name.length);
                for (var j = 0; j < arr.length; j++) {
                    if (name == arr[j][1]) {
                        types_arr.push(arr[j][0])
                    }
                }
            }
            var get_hidden_val = $('#ays_pb_except_posts_id');
            var posts = $(document).find('#ays_pb_posts option:selected');
            var posts_ids = [];
            posts.each(function(){
                posts_ids.push($(this).attr('value'));
            });
            posts_ids = posts_ids.join(',');
            get_hidden_val.val(posts_ids);
            $.ajax({
                url: pb.ajax,
                method: 'post',
                dataType: 'text',
                data: {
                    action: 'get_selected_options_pb',
                    data: types_arr,
                },
                success: function (resp) {
                    var inp = $('#ays_pb_posts');
                    var data = JSON.parse(resp);
                    inp.html('');
                    inp.val(null).trigger('change');

                    var new_hidden_val = get_hidden_val.val();
                    var get_hidden_val_arr = new_hidden_val.split(',');

                    for (var i = 0; i < data.length; i++) {
                        inp.append("<option value='" + data[i][0] + "'>" + data[i][1] + "</option>");
                    }
                   
                    for(var k = 0; k < get_hidden_val_arr.length; k++){
                        inp.select2( "val", get_hidden_val_arr );
                    }
                },
            });

        });

        $(document).find('.ays_pb_act_dect').datetimepicker({
            controlType: 'select',
            oneLine: true,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss"
        });

        $(document).on('click', 'a.add-pb-bg-music', function (e) {
            openMusicMediaUploader(e, $(this));
        });     

        function openMusicMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload music',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: 'audio'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                element.next().attr('src', attachment.url);
                element.parent().find('input.ays_pb_bg_music').val(attachment.url);
            }).open();
            return false;
        }  


        $(document).find('#ays_popup_width_by_percentage_px').select2({
            minimumResultsForSearch: -1
        }) 

        $(document).find('#open_pb_fullscreen').on('click',function(){
            var inpFullScreenChecked = $(document).find('#open_pb_fullscreen').prop('checked');
            if(inpFullScreenChecked){
                $(document).find('.ays_pb_width').prop( "readonly", true );
                $(document).find('.ays_pb_height').prop( "readonly", true );
            }else{
                $(document).find('.ays_pb_width').prop( "readonly", false );
                $(document).find('.ays_pb_height').prop( "readonly", false );
            }
        })

        $(document).find('.ays_pb_hide_timer').on('click',function(){
            var inpHideTimer = $(document).find('.ays_pb_hide_timer').prop('checked');
            if(inpHideTimer){
                $(document).find('.ays_pb_timer').css( {"visibility":"hidden" });
            }else{
                $(document).find('.ays_pb_timer').css( {"visibility":"visible" });
            }
        })
    });
    $(document).on('click', 'a.ays-pb-add-bg-image', function (e) {
        openMediaUploaderBg(e, $(this));
    });

    $(document).on('change', '.ays_toggle_checkbox', function (e) {
        let state = $(this).prop('checked');
        let parent = $(this).parents('.ays_toggle_parent');

        if($(this).hasClass('ays_toggle_slide')){
            switch (state) {
                case true:
                    parent.find('.ays_toggle_target').slideDown(250);
                    break;
                case false:
                    parent.find('.ays_toggle_target').slideUp(250);
                    break;
            }
        }else{
            switch (state) {
                case true:
                    parent.find('.ays_toggle_target').show(250);
                    break;
                case false:
                    parent.find('.ays_toggle_target').hide(250);
                    break;
            }
        }
    });

    

    function openMediaUploaderBg(e, element) {
        e.preventDefault();
        let aysUploader = wp.media({
            title: 'Upload',
            button: {
                text: 'Upload'
            },
            library: {
                type: 'image'
            },
            multiple: false
        }).on('select', function () {
            let attachment = aysUploader.state().get('selection').first().toJSON();
            element.text('Edit Image');
            $('.ays-pb-bg-image-container').parent().fadeIn();
            $('img#ays-pb-bg-img').attr('src', attachment.url);
            $('input#ays-pb-bg-image').val(attachment.url);
            $('.box-apm').css('background-image', `url('${attachment.url}')`);
            $('.ays_bg_image_box').css({
                'background-image' : `url('${attachment.url} ')`,
                'background-repeat' : 'no-repeat',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
            ////
        }).open();
        return false;
    }

    function goToPro() {
        window.open(
            'https://ays-pro.com/wordpress/popup-box',
            '_blank'
        );
        return false;
    }

    function searchForPage(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
          return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
          return null;
        }
        var searchText = data.text.toLowerCase();
        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (searchText.indexOf(params.term) > -1) {
          var modifiedData = $.extend({}, data, true);
          modifiedData.text += ' (matched)';

          // You can return modified objects from here
          // This includes matching the `children` how you want in nested data sets
          return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    // Delete confirmation
    $(document).on('click', '.ays_pb_confirm_del', function(e){            
        e.preventDefault();
        var message = $(this).data('message');
        var confirm = window.confirm('Are you sure you want to delete '+message+'?');
        if(confirm === true){
            window.location.replace($(this).attr('href'));
        }
    });

})( jQuery );
