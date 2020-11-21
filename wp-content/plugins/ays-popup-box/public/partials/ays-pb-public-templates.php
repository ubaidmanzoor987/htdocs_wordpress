<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Ays_Pb
 * @subpackage Ays_Pb/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ays_Pb
 * @subpackage Ays_Pb/public/partials
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Ays_Pb_Public_Templates {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
    
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
    
    public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	
	public function ays_pb_template_default( $attr ){
        $id                             = $attr["id"];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= $attr["title"];
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= $attr["bgcolor"];
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : $attr["textcolor"];
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : $attr["bordercolor"];
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;
        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        if($ays_pb_close_button_val === 'x'){
            $ays_pb_close_button_text = "<i class='fa fa-times fa-2x'></i>";
        }else{
            $ays_pb_close_button_text = "<i class='fa ays_fa-close-button fa-2x'></i>";
        }

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
        switch($pb_gradient_direction) {
            case "horizontal":
                $pb_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $pb_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $pb_gradient_direction = "to bottom left";
                break;
            default:
                $pb_gradient_direction = "to bottom";
        }
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center center;';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }

        //popup full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';

        //Close button position
        $close_button_position = (isset($options->close_button_position) && $options->close_button_position != '') ? $options->close_button_position : 'right-top';
        switch($close_button_position) {
            case "left-top":
                $close_button_position = "top: 0; left: 10px;";
                $close_button_position_script = "";
                break;
            case "left-bottom":
                $close_button_position = "";
                $close_button_position_script = "
                setTimeout(function(){
                    var aysConteiner       = parseInt(".$ays_pb_height.");
                    var h2Height           = $(document).find('.ays-pb-modal_".$id." h2').outerHeight(true);
                    var hrHeight           = $(document).find('.ays-pb-modal_".$id." hr').outerHeight(true);
                    var descriptionHeight  = $(document).find('.ays-pb-modal_".$id." .ays_pb_description').outerHeight(true);
                    var timerHeight        = $(document).find('.ays-pb-modal_".$id." .ays_pb_timer_".$id."').outerHeight(true);
                    var customHtml         = $(document).find('.ays-pb-modal_".$id." .ays_pb_custom_html').outerHeight(true);
                    var aysConteinerHeight = (h2Height + descriptionHeight + timerHeight + customHtml + hrHeight + 50);
                    if(aysConteinerHeight < aysConteiner){
                        if('".$ays_pb_full_screen."' == 'on'){
                            aysConteinerHeight =  (aysConteiner + 75) + 'px';
                        }else{
                            aysConteinerHeight =  (aysConteiner - 50) + 'px';
                        }
                    }
                    $(document).find('.ays-pb-modal_".$id." .ays-pb-modal-close_".$id."').css({'top': aysConteinerHeight, 'left': '10px'});
                },200);";
                break;
            case "right-bottom":
                $close_button_position = "";
                $close_button_position_script = "
                setTimeout(function(){
                    var aysConteiner       = parseInt(".$ays_pb_height.");
                    var h2Height           = $(document).find('.ays-pb-modal_".$id." h2').outerHeight(true);
                    var hrHeight           = $(document).find('.ays-pb-modal_".$id." hr').outerHeight(true);
                    var descriptionHeight  = $(document).find('.ays-pb-modal_".$id." .ays_pb_description').outerHeight(true);
                    var timerHeight        = $(document).find('.ays-pb-modal_".$id." .ays_pb_timer_".$id."').outerHeight(true);
                    var customHtml         = $(document).find('.ays-pb-modal_".$id." .ays_pb_custom_html').outerHeight(true);
                    var aysConteinerHeight = (h2Height + descriptionHeight + timerHeight + hrHeight + customHtml + 50);
                    if(aysConteinerHeight < aysConteiner){
                        if('".$ays_pb_full_screen."' == 'on'){
                            aysConteinerHeight =  (aysConteiner + 75) + 'px';
                        }else{
                            aysConteinerHeight =  (aysConteiner - 50) + 'px';
                        }
                    }
                    $(document).find('.ays-pb-modal_".$id." .ays-pb-modal-close_".$id."').css({'top': aysConteinerHeight, 'right': '10px'});
                },200);";
                break;
            default:
                $close_button_position = "top: 0; right: 10px;";
                $close_button_position_script = "";
        }
        
        if($ays_pb_title != ''  && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if(intval($ays_pb_delay) == 0 && intval($ays_pb_scroll_top) == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        //popup width percentage
        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
            $pb_width = '100%';
            $ays_pb_height = 'auto';
        }else{
            $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
            $pb_height = $ays_pb_height . 'px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }

        $popupbox_view = "
                <div class='ays-pb-modal ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='{$ays_pb_bg_image};width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px solid $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};' >
                    $ays_pb_title
                    $ays_pb_description".
             (($show_desc !== "On" && $show_title !== "On") ?  '' :  '<hr/>')
                    ."<div class='ays_content_box'>".
                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                    ."</div>
                    $ays_pb_timer_desc
                    <label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close ".$closeButton." ays-pb-modal-close_".$id." ays-pb-close-button-delay ays_pb_pause_sound_".$id."' style='color: $ays_pb_textcolor !important; font-family:$ays_pb_font_family;{$close_button_position}'>". $ays_pb_close_button_text ."</label>
                </div>
                <script>
                    (function($){
                        ".$close_button_position_script."
                    })(jQuery);
                </script>";

		return $popupbox_view;
	}

    public function ays_pb_template_macos($attr){
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= $attr["title"];
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= $attr["bgcolor"];
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : $attr["textcolor"];
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : $attr["bordercolor"];
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;
        
        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }
        
        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
        switch($pb_gradient_direction) {
            case "horizontal":
                $pb_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $pb_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $pb_gradient_direction = "to bottom left";
                break;
            default:
                $pb_gradient_direction = "to bottom";
        }
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center center;';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        if($ays_pb_title != ''   && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }

        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }
        
        //popup width percentage
        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }

        $mac_view = "<div class='ays_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; {$ays_pb_bg_image}; background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px solid $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};'>
                         <div class='ays_topBar'>
                            <div class='".$closeButton."'>
                            <label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close ays_close ays-pb-modal-close_".$id." ays-pb-close-button-delay ays_pb_pause_sound_".$id."'></label>
                            </div>
                            <div>
                            <a class='ays_hide'></a>
                            </div>
                            <div>
                            <a class='ays_fullScreen'></a>
                            </div>
                            $ays_pb_title
                         </div> 
                            $ays_pb_description                   
                         <hr/>
                         <div class='ays_text'>
                            <div class='ays_text-inner'>
                            <div class='ays_content_box'>".
								(($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
							."</div>
                            </div>
                         </div>                         
                         $ays_pb_timer_desc
                    </div>
                <script>
                (function($){
                    $('.ays_hide').on('click', function() {
                      $('.ays_window').css({
                        height: '{$ays_pb_height}px',
                        width: '{$pb_width}'
                      });
                    });

                    $('.ays_fullScreen').on('click', function() {
                      $('.ays_window').css({
                        height: '100vh',
                        width: '100vw',
                      });
                    });
                })(jQuery);
                </script>";
        return $mac_view;
    }
    
    public function ays_pb_template_cmd($attr){        
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= $attr["title"];
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= $attr["bgcolor"];
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : $attr["textcolor"];
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : $attr["bordercolor"];
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;


        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
        switch($pb_gradient_direction) {
            case "horizontal":
                $pb_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $pb_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $pb_gradient_direction = "to bottom left";
                break;
            default:
                $pb_gradient_direction = "to bottom";
        }
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center center;';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        if($ays_pb_title != ''  && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }
        
        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }

        $cmd_view = "<div class='ays_cmd_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; {$ays_pb_bg_image};  color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px solid $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};'>
                        <header class='ays_cmd_window-header'>
                            <div class='ays_cmd_window_title'>$ays_pb_title</div>
                            <nav class='ays_cmd_window-controls'>
                                <!--<span class='ays_cmd_control-item ays_cmd_control-minimize ays_cmd_js-minimize'>‒</span>
                                <span class='ays_cmd_control-item ays_cmd_control-maximize ays_cmd_js-maximize'>□</span>
                                <label for='ays-pb-modal-checkbox_".$id."' class='ays_cmd_control-item ays_cmd_control-close ays-pb-modal-close_".$id."'><span class='ays_cmd_control-item ays_cmd_control-close ays_cmd_js-close'>˟</span></label>-->
                                <ul class='ays_cmd_window-controls-ul'>
                                    <li><span class='ays_cmd_control-item ays_cmd_control-minimize ays_cmd_js-minimize'>‒</span></li>
                                    <li><span class='ays_cmd_control-item ays_cmd_control-maximize ays_cmd_js-maximize'>□</span></li>
                                    <li><label for='ays-pb-modal-checkbox_".$id."' class='ays_cmd_control-item ".$closeButton." ays_cmd_control-close ays-pb-modal-close_".$id." ays-pb-close-button-delay'><span class='ays_cmd_control-item ays_cmd_control-close ays_cmd_js-close ays_pb_pause_sound_".$id."'>x</span></label></li>
                                </ul>
                            </nav>
                        </header>
                        <div class='ays_cmd_window-cursor'>
                            <span class='ays_cmd_i-cursor-indicator'>></span>
                            <span class='ays_cmd_i-cursor-underscore'></span>
                            <input type='text' disabled class='ays_cmd_window-input ays_cmd_js-prompt-input' />
                        </div>
                        $ays_pb_description
                        <main class='ays_cmd_window-content'>
                            <div class='ays_text'>
                                <div class='ays_text-inner'>
                                <div class='ays_content_box'>".
                                    (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                ."</div>
                                </div>
                             </div>                         
                             $ays_pb_timer_desc
                        </main>
                    </div>
                    <script>
                        (function($){
                            var prompt = {
                                window: $('.ays_cmd_window'),
                                shortcut: $('.ays_cmd_prompt-shortcut'),
                                input: $('.ays_cmd_js-prompt-input'),

                                init: function() {
                                    $('.ays_cmd_js-minimize').click(prompt.minimize);
                                    $('.ays_cmd_window_title').click(prompt.minimize);
                                    $('.ays_cmd_js-maximize').click(prompt.maximize);
                                    $('.ays_cmd_js-close').click(prompt.close);
                                    $('.ays_cmd_js-open').click(prompt.open);
                                    prompt.input.focus();
                                    prompt.input.blur(prompt.focus);
                                },
                                    focus: function() {
                                    prompt.input.focus();
                                },
                                minimize: function() {        
                                    prompt.window.removeClass('ays_cmd_window--maximized');
                                    prompt.window.toggleClass('ays_cmd_window--minimized');
                                },
                                maximize: function() {
                                    prompt.window.removeClass('ays_cmd_window--minimized');
                                    prompt.window.toggleClass('ays_cmd_window--maximized');
                                    prompt.focus();
                                },
                                close: function() {
                                    prompt.window.addClass('ays_cmd_window--destroyed');
                                    prompt.window.removeClass('ays_cmd_window--maximized ays_cmd_window--minimized');
                                    prompt.shortcut.removeClass('ays_cmd_hidden');
                                    prompt.input.val('');
                                },
                                open: function() {
                                    prompt.window.removeClass('ays_cmd_window--destroyed');
                                    prompt.shortcut.addClass('ays_cmd_hidden');
                                    prompt.focus();
                                }
                            };
                            $(document).ready(prompt.init);
                        })(jQuery);
                    </script>";
        return $cmd_view;
    }   

    public function ays_pb_template_ubuntu($attr){        
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= $attr["title"];
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= $attr["bgcolor"];
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : $attr["textcolor"];
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : $attr["bordercolor"];
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;


        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
        switch($pb_gradient_direction) {
            case "horizontal":
                $pb_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $pb_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $pb_gradient_direction = "to bottom left";
                break;
            default:
                $pb_gradient_direction = "to bottom";
        }
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center center;';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }
        
        $ubuntu_view = "<div class='ays_ubuntu_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; {$ays_pb_bg_image};  background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px solid $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};'>
                      <div class='ays_ubuntu_topbar'>
                        <div class='ays_ubuntu_icons'>
                          <div class='ays_ubuntu_close  ".$closeButton." ays-pb-close-button-delay'>
                            <label for='ays-pb-modal-checkbox_".$id."' class='ays_ubuntu_close ays-pb-modal-close_".$id." ays_pb_pause_sound_".$id."'></label>
                          </div>
                          <div class='ays_ubuntu_hide'></div>
                          <div class='ays_ubuntu_maximize'></div>
                        </div>
                        $ays_pb_title
                      </div>
                      <div class='ays_ubuntu_tools'>
                        <ul>
                            <li>".__("File")."</li>
                            <li>".__("Edit", $this->plugin_name)."</li>
                            <li>".__("Go", $this->plugin_name)."</li>
                            <li>".__("Bookmarks", $this->plugin_name)."</li>
                            <li>".__("Tools", $this->plugin_name)."</li>
                            <li>".__("Help", $this->plugin_name)."</li>
                        </ul>
                      </div>
                      
                      <div class='ays_ubuntu_window_content'>
                            $ays_pb_description".
            (($show_desc !== "On") ?  '' :  '<hr/>')
                            ."<div class='ays_content_box'>".
                                (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                            ."</div>
                      </div>
                      <div class='ays_ubuntu_folder-info ays_pb_timer_".$id."'>
                      $ays_pb_timer_desc
                      </div>
                    </div>
                    <script>
                        (function($){
                            var prompt = {
                                window: $('.ays_ubuntu_window'),

                                init: function() {
                                    $('.ays_ubuntu_hide').click(prompt.minimize);
                                    $('.ays_ubuntu_maximize').click(prompt.maximize);
                                },
                                minimize: function() {        
                                    prompt.window.removeClass('ays_ubuntu_window--maximized');
                                    prompt.window.toggleClass('ays_ubuntu_window--minimized');
                                },
                                maximize: function() {
                                    prompt.window.removeClass('ays_ubuntu_window--minimized');
                                    prompt.window.toggleClass('ays_ubuntu_window--maximized');
                                }
                            };
                            $(document).ready(prompt.init);
                        })(jQuery);
                    </script>";
        return $ubuntu_view;
    }   

    public function ays_pb_template_winxp($attr){
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= $attr["title"];
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= $attr["bgcolor"];
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : $attr["textcolor"];
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : $attr["bordercolor"];
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
        switch($pb_gradient_direction) {
            case "horizontal":
                $pb_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $pb_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $pb_gradient_direction = "to bottom left";
                break;
            default:
                $pb_gradient_direction = "to bottom";
        }
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center center;';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        if($ays_pb_title != '' && $show_title == "On"){
           // $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;'>$ays_pb_title</h2>";
            $ays_pb_title = "<h2 style='color: white !important;font-family:$ays_pb_font_family;'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }
        
        $ubuntu_view = "<div class='ays_winxp_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px solid $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};'>
                            <div class='ays_winxp_title-bar'>
                                <div class='ays_winxp_title-bar-title'>
                                    $ays_pb_title
                                </div>
                                <div class='ays_winxp_title-bar-close ".$closeButton." ays-pb-close-button-delay'>
                                    <label for='ays-pb-modal-checkbox_".$id."' class='ays_winxp_close  ays-pb-modal-close_".$id." ays_pb_pause_sound_".$id."'><i class='ays_pb_fa fas fa-times'></i></label>
                                </div>
                                <div class='ays_winxp_title-bar-max ays_pb_fa ays_pb_far far fa-window-maximize fa-xs' aria-hidden='true'></div>
                                <div class='ays_winxp_title-bar-min'></div>
                            </div>
                            <div class='ays_winxp_content' style='background-color: $ays_pb_bgcolor; {$ays_pb_bg_image}; '>
                                <div>
                                    $ays_pb_description".
            (($show_title !== "On") ?  '' :  '<hr/>')
                                ."</div>
                                <div class='ays_content_box'>".
                                    (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                ."</div>
                                $ays_pb_timer_desc
                            </div>
                      </div>
                    <script>
                        (function($){
                            var prompt = {
                                window: $('.ays_winxp_window'),

                                init: function() {
                                    $('.ays_winxp_title-bar-min').click(prompt.minimize);
                                    $('.ays_winxp_title-bar-max').click(prompt.maximize);
                                },
                                minimize: function() {        
                                    prompt.window.removeClass('ays_winxp_window--maximized');
                                    prompt.window.toggleClass('ays_winxp_window--minimized');
                                },
                                maximize: function() {
                                    prompt.window.removeClass('ays_winxp_window--minimized');
                                    prompt.window.toggleClass('ays_winxp_window--maximized');
                                }
                            };
                            $(document).ready(prompt.init);
                        })(jQuery);
                    </script>";
        return $ubuntu_view;
    }  

    public function ays_pb_template_win98($attr){        
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= $attr["title"];
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= $attr["bgcolor"];
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : $attr["textcolor"];
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : $attr["bordercolor"];
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        if($ays_pb_close_button_val === 'x'){
            $ays_pb_close_button_text = 'x';
        }else{
            $ays_pb_close_button_text = $ays_pb_close_button_val;
        }

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
        switch($pb_gradient_direction) {
            case "horizontal":
                $pb_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $pb_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $pb_gradient_direction = "to bottom left";
                break;
            default:
                $pb_gradient_direction = "to bottom";
        }
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center center;';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: white !important;'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }
        
        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }

        $ubuntu_view = "<div class='ays_win98_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; {$ays_pb_bg_image};  color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px solid $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};'>
                            <header class='ays_win98_head' style='background-color: $ays_pb_bgcolor;'>
                                <div class='ays_win98_header'>
                                    <div class='ays_win98_title'>
                                        $ays_pb_title
                                    </div>
                                    <div class='ays_win98_btn-close ".$closeButton." ays-pb-close-button-delay'><label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close_".$id." ays_pb_pause_sound_".$id."'><span>". $ays_pb_close_button_text ."</span></label></div>
                                </div>
                            </header>
                            <div class='ays_win98_main'>
                                <div class='ays_win98_content'>
                                    $ays_pb_description".
            (($show_title !== "On") ?  '' :  '<hr/>')
            ."                               
                                    <div class='ays_content_box'>".
                                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                    ."</div>
                                    $ays_pb_timer_desc
                                </div>
                            </div>
                        </div>";
        return $ubuntu_view;
    }

    public function ays_pb_template_lil($attr){

        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= $attr["title"];
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= $attr["bgcolor"];
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : $attr["textcolor"];
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : $attr["bordercolor"];
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        if($ays_pb_close_button_val === 'x'){
            $ays_pb_close_button_text = 'x';
            $close_lil_btn_class = '';
        }else{
            $ays_pb_close_button_text = $ays_pb_close_button_val;
            $close_lil_btn_class = 'close-lil-btn-text';
        }

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
        switch($pb_gradient_direction) {
            case "horizontal":
                $pb_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $pb_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $pb_gradient_direction = "to bottom left";
                break;
            default:
                $pb_gradient_direction = "to bottom";
        }
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center center;';
        }elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        else{
            $ays_pb_bg_image = '';
        }

        //popup full screen 
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';

        //Close button position
        $close_button_position = (isset($options->close_button_position) && $options->close_button_position != '') ? $options->close_button_position : 'right-top';
        switch($close_button_position) {
            case "left-top":
                $close_button_position = "top: 10px; left: 10px;";
                break;
            case "left-bottom":
                if($ays_pb_full_screen == 'on'){

                    $close_button_top = absint(intval($ays_pb_height)) + 58 + (2 * absint(intval($ays_pb_bordersize)));
                }else{
                    
                    $close_button_top = absint(intval($ays_pb_height)) - 38 - (2 * absint(intval($ays_pb_bordersize)));
                }
                $close_button_position = "top: ". $close_button_top ."px; left: 10px;";
                break;
            case "right-bottom":
                if($ays_pb_full_screen == 'on'){
                    $close_button_top = absint(intval($ays_pb_height)) + 58 + (2 * absint(intval($ays_pb_bordersize)));
                }else{
                    $close_button_top = absint(intval($ays_pb_height)) - 38 - (2 * absint(intval($ays_pb_bordersize)));
                }
                $close_button_position = "top: ". $close_button_top ."px; right: 10px; bottom: auto; left: auto;";
                break;
            default:
                $close_button_position = "top: 10px; right: 10px;";
        }


        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
            if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            }
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        $lil_close_color = (($show_title !== "On") ?  "$ays_pb_bgcolor" :  "$ays_pb_header_bgcolor");

        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }
        
        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }

        $ubuntu_view = "    <div class='ays_lil_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px solid $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};'>
                                 <header class='ays_lil_head' style='background-color: ".(($show_title !== "On") ?  "" :  "$ays_pb_header_bgcolor").";'>
                                    <div class='ays_lil_header'>
                                        <div class='ays_lil_title'>
                                            $ays_pb_title
                                        </div>
                                        <div class='ays_lil_btn-close ".$closeButton." ays-pb-close-button-delay'><label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close_".$id."' ><a class='close-lil-btn ays_pb_pause_sound_".$id." ".$close_lil_btn_class."' style='background-color:".$ays_pb_textcolor." !important; color: ".$lil_close_color." ; font-family:{$ays_pb_font_family};{$close_button_position}'>". $ays_pb_close_button_text ."</a></label></div>
                                    </div>
                                </header>
                                <div class='ays_lil_main' style='{$ays_pb_bg_image}'>
                                    <div class='ays_lil_content'>
                                        $ays_pb_description                           
                                        <div class='ays_content_box'>".
                                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                        ."</div>
                                        $ays_pb_timer_desc
                                    </div>
                                </div>
                            </div>";
        return $ubuntu_view;
    }

    public function ays_pb_template_image($attr){

        $ays_pb_bg_image_image_default = 'background-image: url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg");
                                          background-repeat: no-repeat;
                                          background-size: cover;
                                          background-position: center center;';

        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= $attr["title"];
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= $attr["bgcolor"];
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : $attr["textcolor"];
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : $attr["bordercolor"];
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : $ays_pb_bg_image_image_default;
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        if($ays_pb_close_button_val === 'x'){
            $ays_pb_close_button_text = 'x';
        }else{
            $ays_pb_close_button_text = $ays_pb_close_button_val;
        }

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
        switch($pb_gradient_direction) {
            case "horizontal":
                $pb_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $pb_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $pb_gradient_direction = "to bottom left";
                break;
            default:
                $pb_gradient_direction = "to bottom";
        }
        if($ays_pb_bg_image !== '' && $ays_pb_bg_image != $ays_pb_bg_image_image_default){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center center;';
        }else if ($background_gradient == 'on' && $ays_pb_bg_image == $ays_pb_bg_image_image_default) {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }else{
            $ays_pb_bg_image = $ays_pb_bg_image_image_default;
        }

        //popup full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';

        //Close button position
        $close_button_position = (isset($options->close_button_position) && $options->close_button_position != '') ? $options->close_button_position : 'right-top';
        switch($close_button_position) {
            case "left-top":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "right:97% !important;";
                }else{
                    $close_button_position = "top: ". (-25 - $ays_pb_bordersize) ."px; left: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            case "left-bottom":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "top: 95% !important; right: 97% !important;";
                }else{
                    $close_btn_pos = -35 - absint(intval($ays_pb_bordersize));
                    $close_button_position = "bottom: ".$close_btn_pos."px; left: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            case "right-bottom":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "top: 95% !important; right: ".(-$ays_pb_bordersize)."px;";
                }else{
                    $close_btn_pos = -35 - absint(intval($ays_pb_bordersize));
                    $close_button_position = "bottom: ".$close_btn_pos."px; right: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            default:
                $close_button_position = "top: ". (-25 - $ays_pb_bordersize) ."px; right: ".(-$ays_pb_bordersize)."px;";
        }

        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
            if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            }
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        $image_header_height = (($show_title !== "On") ?  "height: 0% !important" :  "");
        $image_content_height = (($image_header_height !== "") ?  "max-height: 98% !important" :  "");

        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }
        $ubuntu_view = "";
        
        //pb full screen
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
            $pb_width = '100%';
            $ays_pb_height = 'auto';
            $ubuntu_view .= "
                <style>
                    .ays_image_window .ays_image_main .ays_image_content>p:last-child {
                        bottom: 65px !important;
                    }
                    .close-image-btn {
                        top: 9px !important;
                        right: 20px !important;
                    }
                </style>
           ";
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }

        $ubuntu_view .= "   <div class='ays_image_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important;font-family:{$ays_pb_font_family}; border: {$ays_pb_bordersize}px solid $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px; {$ays_pb_bg_image};'>
                                 <header class='ays_image_head' style='{$image_header_height}'>
                                    <div class='ays_image_header'>
                                        <div class='ays_popup_image_title'>
                                            $ays_pb_title
                                        </div>
                                        <div class='ays_image_btn-close ".$closeButton."'><label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close_".$id." ays-pb-close-button-delay' ><label class='close-image-btn ays_pb_pause_sound_".$id."' style='color: ".$ays_pb_textcolor." ; font-family:{$ays_pb_font_family};{$close_button_position}'>". $ays_pb_close_button_text ."</label></label></div>
                                    </div>
                                </header>
                                <div class='ays_image_main' style='{$image_content_height}' >
                                    <div class='ays_image_content'>
                                        $ays_pb_description                           
                                        <div class='ays_content_box'>".
                                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                        ."</div>
                                        $ays_pb_timer_desc
                                    </div>
                                </div>
                            </div>";
        return $ubuntu_view;
    }

    public function ays_pb_template_template($attr){

        $ays_pb_bg_image_template_default = 'background-image: url("https://quiz-plugin.com/wp-content/uploads/2020/02/girl-scaled.jpg");
                                             background-repeat: no-repeat;
                                             background-size: cover;
                                             background-position: center center;';

        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= $attr["title"];
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= $attr["bgcolor"];
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : $attr["textcolor"];
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : $attr["bordercolor"];
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" )? $attr["bg_image"] : $ays_pb_bg_image_template_default;
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        if($ays_pb_close_button_val === 'x'){
            $ays_pb_close_button_text = 'x';
        }else{
            $ays_pb_close_button_text = $ays_pb_close_button_val;
        }

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
        switch($pb_gradient_direction) {
            case "horizontal":
                $pb_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $pb_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $pb_gradient_direction = "to bottom left";
                break;
            default:
                $pb_gradient_direction = "to bottom";
        }
        if($ays_pb_bg_image !== '' && $ays_pb_bg_image != $ays_pb_bg_image_template_default){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center center;';
        }

        //Close button position
        $close_button_position = (isset($options->close_button_position) && $options->close_button_position != '') ? $options->close_button_position : 'right-top';
        switch($close_button_position) {
            case "left-top":
                $close_button_position = "top: 14px; left: 14px;";
                break;
            case "left-bottom":
                $close_button_position = "bottom: 0; left: 14px;";
                break;
            case "right-bottom":
                $close_button_position = "bottom: 0; right: 14px;";
                break;
            default:
                $close_button_position = "top: 14px; right: 14px;";
        }

        if ($background_gradient == 'on') {
            $bg_gradient_container = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
            $ays_pb_bgcolor = "transparent";
        } else {
            $bg_gradient_container = "unset";
        }

        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }
        
        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
            if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            }
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        $header_height = (($show_title !== "On") ?  "height: 20px !important" :  "");
        $calck_template_fotter = (($show_title !== "On") ? "height: calc(100% - 20px);" :  "");

        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", $this->plugin_name)."<span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", $this->plugin_name)."</p>";
        }

        $ubuntu_view = "   <div class='ays_template_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width};  height: {$pb_height}; color: $ays_pb_textcolor !important; font-family:{$ays_pb_font_family};border: {$ays_pb_bordersize}px solid $ays_pb_bordercolor;{$bg_gradient_container} border-radius: {$ays_pb_border_radius}px; '>
                                 <header class='ays_template_head' style='{$header_height};background-color: {$ays_pb_header_bgcolor}'>
                                    <div class='ays_template_header'>
                                        <div class='ays_template_title'>
                                            $ays_pb_title
                                        </div>
                                        <div class='ays_template_btn-close ".$closeButton." '>
                                            <label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close_".$id." ays-pb-close-button-delay' >
                                                <label class='close-template-btn ays_pb_pause_sound_".$id."' style='color: ".$ays_pb_textcolor." ;font-family:{$ays_pb_font_family}; {$close_button_position}'>". $ays_pb_close_button_text ."</label>
                                            </label>
                                        </div>
                                    </div>
                                </header>
                                <footer class='ays_template_footer ' style='background-color: $ays_pb_bgcolor; {$calck_template_fotter} '>
                                    <div class='ays_bg_image_box' style='{$ays_pb_bg_image}'></div>
                                    <div class='ays_template_content ' style=''>
                                        $ays_pb_description 
                                        <div class='ays_content_box ays_template_main'>".
                                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                        ."</div>
                                        $ays_pb_timer_desc
                                        </div>
                                </footer>
                            </div>";
        return $ubuntu_view;
    }
}
