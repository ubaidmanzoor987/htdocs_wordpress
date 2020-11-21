<?php
if(isset($_GET['ays_pb_tab'])){
    $ays_pb_tab = $_GET['ays_pb_tab'];
}else{
    $ays_pb_tab = 'tab1';
}

$args = array(
    'public'   => true
);
$all_post_types = get_post_types( $args, 'objects' );

$action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';
$heading = '';
$id = ( isset( $_GET['popupbox'] ) ) ? absint( intval( $_GET['popupbox'] ) ) : null;
$options = array(
    'enable_background_gradient'  => 'off',
    'background_gradient_color_1' => '#000',
    'background_gradient_color_2' => '#fff',
    'pb_gradient_direction'       => 'vertical',
    'except_types'                => '',
    'except_posts'                => '',
    'close_button_delay'          => '0',
    'enable_pb_sound'             => 'off',
    'overlay_color'               => '#000',
    'animation_speed'             => '1',
    'pb_mobile'                   => 'off',
    'close_button_text'           => 'x',
    'mobile_max_width'            => '',
    'show_only_once'              => 'off',
    'close_popup_esc'             => 'off',
    'enable_pb_fullscreen'        => 'off',
);
$popupbox = [
    "id"            	          => "",
    "title"         	          => "Demo Title",
    "description"   	          => "Demo Description",
    "autoclose"  		          => "20",
    "cookie"   			          => "0",
    "width"         	          => "400",
    "height"        	          => "500",
    "shortcode"			          => "",
    "bgcolor"        	          => "#ffffff",
    "header_bgcolor"   	          => "#ffffff",
    "textcolor"        	          => "#000000",
    "bordersize"      	          => "1",
    "bordercolor"     	          => "#ffffff",
    "border_radius"    	          => "4",
    "custom_class"                => "",
    "custom_css"                  => "",
    "custom_html"                 => "",
    "onoffswitch"                 => "On",
    "onoffoverlay"                => "On",
    "show_all"                    => "all",
    "delay"                       => "0",
    "scroll_top"                  => "0",
    "animate_in"                  => "fadeIn",
    "animate_out"                 => "fadeOut",
    "action_button"               => "",
    "view_place"                  => "",
    "action_button_type"          => "both",
    'users_role'                  => '',
    "modal_content"               => "custom_html",
    "view_type"                   => "default",
    "show_popup_title"            => "On",
    "show_popup_desc"             => "On",
    "close_button"                => "Off",
    "bg_image"                    => "",
    "log_user"                    => "On",
    "guest"                       => "On",
    'active_date_check'           => "off",
    'activeInterval'              => "",
    'deactiveInterval'            => "",
    'activeIntervalSec'           => "",
    'deactiveIntervalSec'         => "",
    'options'                     => json_encode($options),
];
switch( $action ) {
    case 'add':
        $heading = 'Add new PopupBox';
        break;
    case 'edit':
        $heading = 'Edit PopupBox';
        $popupbox = $this->popupbox_obj->get_popupbox_by_id($id);
        break;
    case 'duplicate':
        $heading = 'Duplicate PopupBox';
        $this->popupbox_obj->duplicate_popupbox($id);
        break;
}

$settings_options = $this->settings_obj->ays_get_setting('options');
if($settings_options){
    $settings_options = json_decode($settings_options, true);
}else{
    $settings_options = array();
}
$ays_pb_sound = (isset($settings_options['ays_pb_sound']) && $settings_options['ays_pb_sound'] != '') ? true : false;
$ays_pb_sound_status = false;
if($ays_pb_sound){
    $ays_pb_sound_status = true;
}

$options = (isset($popupbox['options']) && $popupbox['options'] != "") ? json_decode($popupbox['options'], true) : array();
// Custom class for quiz container
$custom_class = (isset($popupbox['custom_class']) && $popupbox['custom_class'] != "") ? $popupbox['custom_class'] : '';
$users_role   = (isset($popupbox['users_role']) && $popupbox['users_role'] != "") ? json_decode($popupbox['users_role'], true) : array();

if(isset($_POST["ays_submit"]) || isset($_POST["ays_submit_top"])){
    $_POST["id"] = $id;
    $this->popupbox_obj->add_or_edit_popupbox($_POST);
}

if(isset($_POST["ays_apply"]) || isset($_POST["ays_apply_top"])){
    $_POST["id"] = $id;
    $_POST["submit_type"] = 'apply';
    $this->popupbox_obj->add_or_edit_popupbox($_POST);
}
$options['enable_background_gradient'] = (!isset($options['enable_background_gradient'])) ? 'off' : $options['enable_background_gradient'];
$enable_background_gradient = (isset($options['enable_background_gradient']) && $options['enable_background_gradient'] == 'on') ? true : false;
$background_gradient_color_1 = (isset($options['background_gradient_color_1']) && $options['background_gradient_color_1'] != '') ? $options['background_gradient_color_1'] : '#000';
$background_gradient_color_2 = (isset($options['background_gradient_color_2']) && $options['background_gradient_color_2'] != '') ? $options['background_gradient_color_2'] : '#fff';
$pb_gradient_direction = (isset($options['pb_gradient_direction']) && $options['pb_gradient_direction'] != '') ? $options['pb_gradient_direction'] : 'vertical';


$close_button_delay =  (isset($options['close_button_delay']) && $options['close_button_delay'] != '') ? abs(intval($options['close_button_delay'])) : '0';

$image_text_bg   = __('Add Image', $this->plugin_name);
$style_bg   = "display: none;";

if (isset($popupbox['bg_image']) && !empty($popupbox['bg_image'])) {
    $style_bg      = "display: block;";
    $image_text_bg = __('Edit Image', $this->plugin_name);
}

$onoffswitch       = (isset($popupbox["onoffswitch"]) && $popupbox["onoffswitch"] != "") ? $popupbox["onoffswitch"] : "on" ;
$onoffoverlay      = (isset($popupbox["onoffoverlay"]) && $popupbox["onoffoverlay"] != "") ? $popupbox["onoffoverlay"] : "on";
$log_user          = (isset($popupbox["log_user"]) && $popupbox["log_user"] != "") ? $popupbox["log_user"] : "off";
$guest             = (isset($popupbox["guest"]) && $popupbox["guest"] != "") ? $popupbox["guest"] : "off";
$show_popup_title  = (isset($popupbox["show_popup_title"]) && $popupbox["show_popup_title"] != "") ? $popupbox["show_popup_title"] : "on";
$show_popup_desc   = (isset($popupbox["show_popup_desc"]) && $popupbox["show_popup_desc"] != "") ? $popupbox["show_popup_desc"] : "on";
$close_button      = (isset($popupbox["close_button"]) && $popupbox["close_button"] != "") ? $popupbox["close_button"] : "";

$id != null ? $view_place = explode( "***", $popupbox['view_place']) : $view_place = [];

// Border size
$border_size = (isset($popupbox['bordersize']) && $popupbox['bordersize'] != '') ? abs(intval($popupbox['bordersize'])) : '1';
$ays_pb_timer_position = (- absint(intval($border_size)) -40) . 'px';

// Box header background color
$header_bgcolor = (isset($popupbox['header_bgcolor']) && $popupbox['header_bgcolor'] != '') ? $popupbox['header_bgcolor'] : '#ffffff';

// Enable PopupBox sound option
$options['enable_pb_sound'] = isset($options['enable_pb_sound']) ? $options['enable_pb_sound'] : 'off';
$enable_pb_sound = (isset($options['enable_pb_sound']) && $options['enable_pb_sound'] == "on") ? true : false;

//Overlay Color
$overlay_color = (isset($options['overlay_color']) && $options['overlay_color'] != '') ? $options['overlay_color'] : '#000';
//Animation Speed
$animation_speed = (isset($options['animation_speed']) && $options['animation_speed'] != '') ? abs(intval($options['animation_speed'])) : 1;

//Hide popupbox on mobile
$ays_pb_mobile = (isset($options['pb_mobile']) && $options['pb_mobile'] == 'on') ? $options['pb_mobile'] : 'off';

//Close button text
$close_button_text = (isset($options['close_button_text']) && $options['close_button_text'] != '') ? $options['close_button_text'] : 'x';

// PopupBox max-width for mobile option
$mobile_max_width = (isset($options['mobile_max_width']) && $options['mobile_max_width'] != '') ? abs(intval($options['mobile_max_width'])) : '';

//Close Button Position on Container
$close_button_position = (isset($options['close_button_position']) && $options['close_button_position'] != '') ? $options['close_button_position'] : 'right-top';

//Show PopupBox only once
$show_only_once = (isset($options['show_only_once']) && $options['show_only_once'] == 'on') ? 'on' : 'off';

//Show on home page
$show_on_home_page = (isset($options['show_on_home_page']) && $options['show_on_home_page'] == 'on') ? 'on' : 'off';

//Close popup by ESC 
$close_popup_esc  = (isset($options['close_popup_esc']) && $options['close_popup_esc'] == 'on') ? 'on' : 'off';

//popup size by percentage
$popup_width_by_percentage_px = (isset($options['popup_width_by_percentage_px']) && $options['popup_width_by_percentage_px'] != '') ? $options['popup_width_by_percentage_px'] : 'pixels';

//close popup by clicking overlay
$close_popup_overlay = (isset($options['close_popup_overlay']) && $options['close_popup_overlay'] == 'on') ? $options['close_popup_overlay'] : 'off';

$title              = (isset($popupbox['title']) && $popupbox['title'] != "") ? $popupbox['title'] : "";
$description        = (isset($popupbox['description']) && $popupbox['description'] != "") ? $popupbox['description'] : "";
$show_all           = (isset($popupbox['show_all']) && $popupbox['show_all'] != "") ? $popupbox['show_all'] : "";
$modal_content      = (isset($popupbox['modal_content']) && $popupbox['modal_content'] != "") ? $popupbox['modal_content'] : "";
$shortcode          = (isset($popupbox['shortcode']) && $popupbox['shortcode'] != "") ? $popupbox['shortcode'] : "";
$custom_html        = (isset($popupbox['custom_html']) && $popupbox['custom_html'] != "") ? $popupbox['custom_html'] : "";
$action_button_type = (isset($popupbox['action_button_type']) && $popupbox['action_button_type'] != "") ? $popupbox['action_button_type'] : "";
$action_button      = (isset($popupbox['action_button']) && $popupbox['action_button'] != "") ? $popupbox['action_button'] : "";
$autoclose          = (isset($popupbox['autoclose']) && $popupbox['autoclose'] != "") ? $popupbox['autoclose'] : "";
$cookie             = (isset($popupbox['cookie']) && $popupbox['cookie'] != "") ? $popupbox['cookie'] : "";
$view_type          = (isset($popupbox['view_type']) && $popupbox['view_type'] != "") ? $popupbox['view_type'] : "";
$bgcolor            = (isset($popupbox['bgcolor']) && $popupbox['bgcolor'] != "") ? $popupbox['bgcolor'] : "";
$bg_image           = (isset($popupbox['bg_image']) && $popupbox['bg_image'] != "") ? $popupbox['bg_image'] : "";
$textcolor          = (isset($popupbox['textcolor']) && $popupbox['textcolor'] != "") ? $popupbox['textcolor'] : "";
$bordercolor        = (isset($popupbox['bordercolor']) && $popupbox['bordercolor'] != "") ? $popupbox['bordercolor'] : "";
$border_radius      = (isset($popupbox['border_radius']) && $popupbox['border_radius'] != "") ? abs(intval($popupbox['border_radius'])) : "";
$animate_in         = (isset($popupbox['animate_in']) && $popupbox['animate_in'] != "") ? $popupbox['animate_in'] : "";
$animate_out        = (isset($popupbox['animate_out']) && $popupbox['animate_out'] != "") ? $popupbox['animate_out'] : "";
$width              = (isset($popupbox['width']) && $popupbox['width'] != "") ? $popupbox['width'] : "";
$height             = (isset($popupbox['height']) && $popupbox['height'] != "") ? $popupbox['height'] : "";
$custom_css         = (isset($popupbox['custom_css']) && $popupbox['custom_css'] != "") ? $popupbox['custom_css'] : "";

//Schedule of Popup
$popupbox['active_date_check'] = isset($popupbox['active_date_check']) ? $popupbox['active_date_check'] : 'off';
$active_date_check = (isset($popupbox['active_date_check']) && $popupbox['active_date_check'] == 'on') ? true : false;
if ($active_date_check) {
    $activateTime    = strtotime($popupbox['activeInterval']);
    $activePopup     = date('Y-m-d H:i:s', $activateTime);
    $deactivateTime  = strtotime($popupbox['deactiveInterval']);
    $deactivePopup   = date('Y-m-d H:i:s', $deactivateTime);
} else {
    $activePopup   = current_time( 'mysql' );
    $deactivePopup = current_time( 'mysql' );

}

$posts = array();

$except_posts       = (isset($options['except_posts']) && $options['except_posts'] != "") ? ($options['except_posts']) : array();
$except_post_types  = (isset($options['except_post_types']) && $options['except_post_types'] != "") ? ($options['except_post_types']) : array();

if ($except_post_types) {
    $posts = get_posts(array(
        'post_type'   => $except_post_types,
        'post_status' => 'publish',
        'numberposts' => -1
    ));
}
//font-family option
$font_families = array(
    'arial'               => __('Arial', $this->plugin_name),
    'arial black'         => __('Arial Black', $this->plugin_name),
    'book antique'        => __('Book Antique', $this->plugin_name),
    'courier new'         => __('Courier New', $this->plugin_name),
    'cursive'             => __('Cursive', $this->plugin_name),
    'fantasy'             => __('Fantasy', $this->plugin_name),
    'georgia'             => __('Georgia', $this->plugin_name),
    'helvetica'           => __('Helvetia', $this->plugin_name),
    'impact'              => __('Impact', $this->plugin_name),
    'lusida console'      => __('Lusida Console', $this->plugin_name),
    'palatino linotype'   => __('Palatino Linotype', $this->plugin_name),
    'tahoma'              => __('Tahoma', $this->plugin_name),
    'times new roman'     => __('Times New Roman', $this->plugin_name),
);
$font_family_option = (isset($options['pb_font_family']) && $options['pb_font_family'] != '') ? $options['pb_font_family'] : '';

//open full screen
$ays_enable_pb_fullscreen = (isset($options['enable_pb_fullscreen']) && $options['enable_pb_fullscreen'] == 'on') ? 'on' : 'off';

//hide timer
$ays_pb_hide_timer = (isset($options['enable_hide_timer']) && $options['enable_hide_timer'] == 'on') ? 'on' : 'off';

if($ays_pb_hide_timer == 'on'){
    $ays_pb_timer_desc = "<p class='ays_pb_timer' style='visibility:hidden'>".__('This will close in',$this->plugin_name)." <span data-seconds='20'>20</span> ".__('seconds',$this->plugin_name)."</p>";
}else{
    $ays_pb_timer_desc = "<p class='ays_pb_timer' style='visibility:visible'>".__('This will close in',$this->plugin_name)." <span data-seconds='20'>20</span> ".__('seconds',$this->plugin_name)."</p>";
}

//Enable for selected user OS
$ays_users_os_array = array(
    '/windows nt 10/i'      =>  __('Windows 10', $this->plugin_name),
    '/windows nt 6.1/i'     =>  __('Windows 7', $this->plugin_name),
    '/macintosh|mac os x/i' =>  __('Mac OS X', $this->plugin_name),
    '/linux/i'              =>  __('Linux', $this->plugin_name),
);

//Enable for selected browser
$ays_users_browser_array = array(
    '/chrome/i'    => __('Chrome', $this->plugin_name),
    '/firefox/i'   => __('Firefox', $this->plugin_name),
    '/safari/i'    => __('Safari', $this->plugin_name),
    '/opera|OPR/i' => __('Opera', $this->plugin_name),
);

$disable_height = '';
$disable_width  = '';
if($ays_enable_pb_fullscreen == 'on'){
    $disable_height = 'readonly';
    $disable_width  = 'readonly';
}else{
    $disable_height = '';
    $disable_width  = '';
}

?>

<style>
    .ays_menu_badge{
    color: #fff;
    display: inline-block;
    font-size: 10px;

    text-align: center;
    background: #ca4a1f;
    margin-left: 5px;
    border-radius: 20px;
    padding: 2px 5px;
    }

    #adminmenu  a.toplevel_page_ays-pb div.wp-menu-image img {
    width: 32px;
    padding: 3px 0 0;
    transition: .3s ease-in-out;
    }

    .ays_fa-close-button:before{
        content: "<?php echo $close_button_text ?>";
    }

    .ays_image_window p.ays_pb_timer{
        bottom: <?php echo $ays_pb_timer_position; ?>;
    }

</style>
<?php 
// Getting all WP Roles
global $wp_roles;
$ays_users_roles = $wp_roles->roles;
 ?>
<div class="wrap">
    <div class="container-fluid">
        <form method="post" name="popup_attributes" id="ays_pb_form">
            <input type="hidden" name="ays_pb_tab" value="<?php echo $ays_pb_tab; ?>">
            <h1 class="wp-heading-inline">
                <?php
                echo $heading;
                $other_attributes = array();
                submit_button(__('Save Changes', $this->plugin_name), 'primary', 'ays_submit_top', false, $other_attributes);
                submit_button(__('Apply Changes', $this->plugin_name), '', 'ays_apply_top', false, $other_attributes);
                ?>
            </h1>
            <h2 class="ays-popup-box-menu-title"><?php echo __(get_admin_page_title()); ?></h2>
            <div class="nav-tab-wrapper">
                <a href="#tab1" data-tab="tab1" class="nav-tab <?php echo ($ays_pb_tab == 'tab1') ? 'nav-tab-active' : ''; ?>"><?php echo __("General", $this->plugin_name); ?></a>
                <a href="#tab2" data-tab="tab2" class="nav-tab <?php echo ($ays_pb_tab == 'tab2') ? 'nav-tab-active' : ''; ?>"><?php echo __("Settings", $this->plugin_name); ?></a>
                <a href="#tab3" data-tab="tab3" class="nav-tab <?php echo ($ays_pb_tab == 'tab3') ? 'nav-tab-active' : ''; ?>"><?php echo __("Styles", $this->plugin_name); ?></a>
                <a href="#tab4" data-tab="tab4" class="nav-tab <?php echo ($ays_pb_tab == 'tab4') ? 'nav-tab-active' : ''; ?>"><?php echo __("Limitation Users", $this->plugin_name); ?></a>
            </div>
            <div id="tab1" class="ays-pb-tab-content  <?php echo ($ays_pb_tab == 'tab1') ? 'ays-pb-tab-content-active' : ''; ?>">
                <p class="ays-subtitle"><?php echo  __('General Settings', $this->plugin_name) ?></p>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-onoffswitch">
                            <span><?php echo __('Enable popup', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Turn on the popup for the website based on your configured options.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="<?php echo $this->plugin_name; ?>[onoffswitch]" class="onoffswitch-checkbox" id="<?php echo $this->plugin_name; ?>-onoffswitch" <?php if($onoffswitch == 'On'){ echo 'checked';} else { echo '';} ?> />
                        </p>
                    </div>
                </div>
                <hr/> 
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-popup_title">
                            <span><?php echo __('Popup title', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?= __('Define a name for your popup which will be shown as a headline inside the popup.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="<?php echo $this->plugin_name; ?>-popup_title"  class="ays-text-input" name="<?php echo $this->plugin_name; ?>[popup_title]" value="<?php echo htmlentities($title); ?>" />
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-show_all_yes">
                            <span><?php echo __('Show on ', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?= __('Select on which pages of your website you need the popup to be loaded. For the Except and Selected options, you can choose specific posts and post types.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <label for="<?php echo $this->plugin_name; ?>-show_all_yes"><?php echo __("All pages", $this->plugin_name); ?>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-show_all_yes"  class="" name="<?php echo $this->plugin_name; ?>[show_all]" value="all" <?php if($show_all == 'yes' || $show_all == 'all'){ echo 'checked';} else { echo '';} ?> />
                        </label>
                        <label for="<?php echo $this->plugin_name; ?>-show_all_except"><?php echo __("Except", $this->plugin_name); ?>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-show_all_except"  class="" name="<?php echo $this->plugin_name; ?>[show_all]" value="except" <?php if($show_all == 'except'){ echo 'checked';} else { echo '';} ?>/>
                        </label>
                        <label for="<?php echo $this->plugin_name; ?>-show_all_selected"><?php echo __("Selected", $this->plugin_name); ?>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-show_all_selected"  class="" name="<?php echo $this->plugin_name; ?>[show_all]" value="selected" <?php if($show_all == 'selected' || $show_all == 'no'){ echo 'checked';} else { echo '';} ?>/>
                        </label>
                    </div>
                </div>
                <div class="ays_pb_view_place_tr ays-field">
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_pb_post_types"><?= __("Post type", $this->plugin_name); ?></label>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?= __('Select post types.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <select name="ays_pb_except_post_types[]" id="ays_pb_post_types" class="form-control"
                                    multiple="multiple">
                                <?php
                                    foreach ($all_post_types as $post_type) {
                                        if($except_post_types) {
                                            $checked = (in_array($post_type->name, $except_post_types)) ? "selected" : "";
                                        }else{
                                            $checked = "";
                                        }
                                        echo "<option value='{$post_type->name}' {$checked}>{$post_type->label}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_pb_posts"><?= __("Posts", $this->plugin_name); ?></label>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?= __('Select posts.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <select name="ays_pb_except_posts[]" id="ays_pb_posts" class="form-control"
                                    multiple="multiple">
                                <?php
                                    foreach ( $posts as $post ) {
                                       
                                        $checked = (is_array($except_posts) && in_array($post->ID, $except_posts)) ? "selected" : "";
                                        echo "<option value='{$post->ID}' {$checked}>{$post->post_title}</option>";
                                    }

                                    if (!empty($view_place)) {
                                        $args = array(
                                            'post_type' => array('post', 'page'),
                                            'nopaging'  => true
                                        );
                                        // Custom query.
                                        $query = new WP_Query( $args );

                                        if($query->have_posts()){
                                            foreach ($query->posts as $key => $post){
                                                if(in_array($post->ID, $view_place)):
                                                    ?>
                                                    <option selected value="<?php echo $post->ID; ?>"><?php echo __(get_the_title($post->ID), $this->plugin_name); ?></option> 
                                                <?php
                                                endif;
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <input type='hidden' id="ays_pb_except_posts_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_pb_show_on_home_page">
                                <span><?php echo __('Show on Home page', $this->plugin_name); ?></span>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('If the checkbox is ticked, then the popup will be loaded on the Home page too, in addition to the values given above.', $this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <p class="onoffswitch">
                                <input type="checkbox" name="ays_pb_show_on_home_page" class="onoffswitch-checkbox" id="ays_pb_show_on_home_page" <?php echo ($show_on_home_page == 'on') ? 'checked' : '' ?> >
                            </p>
                        </div>
                     </div>
                    <hr/>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-modal_content_shortcode">
                            <span><?php echo  __('Popup content',$this->plugin_name) ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('The main content, which will be shown inside the popup.', $this->plugin_name); ?>">
                               <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <label>
                            <?php echo __('Shortcode', $this->plugin_name) ?>
                            <input id="<?php echo $this->plugin_name; ?>-modal_content_shortcode" type="radio" name="<?php echo $this->plugin_name; ?>[modal_content]" value="shortcode" <?php
                            if(($modal_content) == '' || $modal_content == null){
                                echo 'checked';
                            }
                            if(isset($modal_content) && $modal_content == 'shortcode')
                            { echo 'checked';}
                            else
                            { echo '';} ?>>
                        </label>
                        <label>
                            <?php echo  __('Custom Content', $this->plugin_name) ?>
                            <input id="<?php echo $this->plugin_name; ?>-modal_content_custom_html" type="radio" name="<?php echo $this->plugin_name; ?>[modal_content]" value="custom_html" <?php if($modal_content == 'custom_html'){ echo 'checked';} else { echo '';} ?>>
                        </label>
                    </div>
                </div>
                <hr/>
                <div class="form-group row" id="ays_shortcode">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-shortcode">
                            <span><?php echo __('Shortcode ', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Copy and paste the shortcode created by any other plugins (for ex: Contact form, Subscribe, Login, Poll and etc). ', $this->plugin_name); ?>">
                               <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="<?php echo $this->plugin_name; ?>-shortcode" name="<?php echo $this->plugin_name; ?>[shortcode]"  class="ays-text-input" value="<?php echo htmlentities($shortcode); ?>" />
                    </div>
                </div>
                <div class="ays-field" id="ays_custom_html">
                    <label>
                        <span>
                            <span><?php echo __('Custom Content', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Write your own content with the help of the HTML.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </span>
                    </label>
                    <?php
                    $content = stripslashes(($custom_html));
                    $editor_id = 'custom-html';
                    $settings = array('editor_height'=>'150','textarea_name'=> $this->plugin_name.'[custom_html]', 'editor_class'=>'ays-textarea', 'media_buttons' => true);
                    wp_editor($content,$editor_id,$settings);
                    ?>
                </div>
                <hr/>
                <div class="ays-field">
                    <label for="<?php echo $this->plugin_name; ?>-popup_description">
                        <span><?php echo __('Popup description', $this->plugin_name); ?></span>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Provide more information about the popup. It will be shown below the title.", $this->plugin_name); ?>">
                            <i class="ays_fa ays_fa-info-circle"></i>
                        </a>
                    </label>

                    <?php
                    $content = stripslashes(($description));
                    $editor_id = 'popup_description';
                    $settings = array('editor_height'=>'150','textarea_name'=> $this->plugin_name.'[popup_description]', 'editor_class'=>'ays-textarea', 'media_buttons' => true);
                    wp_editor($content,$editor_id,$settings);
                    ?>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-action_button_type">
                            <span> <?php echo __('Popup trigger', $this->plugin_name); ?></span>
                                <a class="ays_help" data-toggle="tooltip" data-html="true"
                                title="<?php
                                    echo __('Choose when to show the popup on the website.',$this->plugin_name) .
                                    "<ul style='list-style-type: circle;padding-left: 20px;'>".
                                        "<li>". __('Both – popup will be shown both on page load and click.',$this->plugin_name) ."</li>".
                                        "<li>". __('On page load - popup will be shown as soon as the page is loaded.',$this->plugin_name) ."</li>".
                                        "<li>". __('On click – popup will be shown when the user clicks on the assigned CSS element(s). Select CSS element with the help of CSS selector(s) option.',$this->plugin_name) ."</li>".
                                    "</ul>";
                                ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <select id="<?php echo $this->plugin_name; ?>-action_button_type" class="ays-text-input" name="<?php echo $this->plugin_name; ?>[action_button_type]">
                            <option <?php if(!isset($action_button_type)){ echo 'selected'; } echo 'both' == $action_button_type ? 'selected' : ''; ?> value="both"><?php echo __('Both'); ?></option>
                            <option <?php echo 'pageLoaded' == $action_button_type ? 'selected' : ''; ?> value="pageLoaded"><?php echo __('On page load'); ?></option>
                            <option <?php echo 'clickSelector' == $action_button_type ? 'selected' : ''; ?> value="clickSelector"><?php echo __('On click'); ?></option>
                        </select>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-action_button">
                    <span>
                        <?php echo __('CSS selector(s) for trigger click', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Add your preferred CSS selector(s) if you have given “On click” or “Both” value to the “Popup trigger” option. For example #mybutton or .mybutton.", $this->plugin_name); ?>">
                            <i class="ays_fa ays_fa-info-circle"></i>
                        </a>
                    </span>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="<?php echo $this->plugin_name; ?>-action_button" name="<?php echo $this->plugin_name; ?>[action_button]"  class="ays-text-input" value="<?php echo htmlentities($action_button); ?>" placeholder="#myButtonId, .myButtonClass, .myButton" />
                    </div>
                </div>
                <div class="pb_position_block form-group row" style="padding: 10px 0;">
                    <div class="col-sm-12 only_pro" style="padding: 10px;">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row" style="align-items: center;">
                            <div class="col-sm-3">
                                <label for="<?php echo $this->plugin_name; ?>-position">
                                    <span><?php echo __('Popup position', $this->plugin_name); ?></span>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the position of the popup on the screen.", $this->plugin_name); ?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <select id="<?php echo $this->plugin_name; ?>-position" class="ays-text-input">
                                    <option id="pb_position_center" selected value="center-center"><?php echo __('Center Center'); ?></option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <table id="ays-pb-position-table">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="background-color: #a2d6e7"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="<?php echo $this->plugin_name; ?>-pb_margin">
                                    <span><?php echo __('Popup margin(px)', $this->plugin_name); ?></span>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the popup margin in pixels. It accepts only numerical values.", $this->plugin_name); ?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" id="<?php echo $this->plugin_name; ?>-pb_margin" class="ays-text-input-short" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab2" class="ays-pb-tab-content  <?php echo ($ays_pb_tab == 'tab2') ? 'ays-pb-tab-content-active' : ''; ?>">
                <p class="ays-subtitle"><?php echo  __('Popup Settings', $this->plugin_name) ?></p>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label>
                            <?php echo __("Show popup head information", $this->plugin_name);?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Enable to show the title and(or) the description inside the popup.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <label><?php echo __("Show title", $this->plugin_name);?>
                            <input type="checkbox" class="" name="show_popup_title" <?php if($show_popup_title == 'On'){ echo 'checked';} else { echo '';} ?>/>
                        </label>
                        <label><?php echo __("Show description", $this->plugin_name);?>
                            <input type="checkbox" class="" name="show_popup_desc" <?php if($show_popup_desc == 'On'){ echo 'checked';} else { echo '';} ?>/>
                        </label>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-onoffoverlay">
                            <span><?php echo __('Enable Overlay', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Enable to show the overlay outside of the popup.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="<?php echo $this->plugin_name; ?>[onoffoverlay]" class="onoffswitch-checkbox" id="<?php echo $this->plugin_name; ?>-onoffoverlay" <?php if($onoffoverlay == 'On'){ echo 'checked';} else { echo '';} ?> >
                        </p>
                    </div>
                </div>
                <hr/>
                <!-- close poopup by clicking on the overlay -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_close_popup_overlay">
                            <span><?php echo __('Close by clicking outside the box', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("If the option is enabled, the user can close the popup by clicking on the outside of the box. It works only when the 'Enable Overlay' option is enabled.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="close_popup_overlay" class="onoffswitch-checkbox" id="ays_close_popup_overlay" <?php if($close_popup_overlay == 'off'){ echo '';} else { echo 'checked';} ?>/>
                        </p>
                    </div>
                </div>
                <hr/>
                <!-- close popup by scroll -->
                <div class="col-sm-12 only_pro">
                    <div class="pro_features">
                        <div>
                            <p>
                                <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                                <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_close_popup_scroll" style="line-height: 50px;">
                                <span><?php echo __('Close popup by scroll down', $this->plugin_name); ?></span>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose the certain point on the page by pixels, and when the user gets to that specific point by scrolling down, the popup will be closed.", $this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9" style="padding:10px 0;">
                                <input type="text" name="close_popup_scroll" class="onoffswitch-checkbox" id="ays_close_popup_scroll" value=""/>
                        </div>
                    </div>
                </div>
                <hr/>
                <!-- close popup by clicking submit btn by classname -->
                <div class="col-sm-12 only_pro">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                                </p>
                            </div>
                        </div>
                    <div class="form-group row ays_toggle_parent" style="padding: 10px 0;">
                        <div class="col-sm-3">
                            <label for="ays_close_popup_by_classname">
                                <?php echo __('Close popup by classname', $this->plugin_name)?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Copy the class name, paste it in the content(description, custom content and etc) of the Popup, and create your preferred action by clicking on that specific class.',$this->plugin_name)?>">
                                    <i class="ays_fa ays_fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-1">
                            <input type="checkbox" name="ays_enable_close_by_classname" class="onoffswitch-checkbox ays-enable-timer1 ays_toggle_checkbox" id="ays_close_popup_by_classname" checked/>
                        </div>
                        <div class="col-sm-8 ays_toggle_target ays_divider_left">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="text" name="ays_pb_close_by_classname_".$id id="ays_pb_close_by_classname" class="ays-enable-timerl ays-text-input" value="<?php echo "ays_pb_close_by_classname_".$id ;?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <!-- close overlay by esc key start -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_close_popup_esc">
                            <span><?php echo __('Close by pressing ESC', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("If the option is enabled, the user can close the popup by pressing the ESC button from the keyboard.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="close_popup_esc" class="onoffswitch-checkbox" id="ays_close_popup_esc" <?php if($close_popup_esc == 'off'){ echo '';} else { echo 'checked';} ?>/>
                        </p>
                    </div>
                </div>
                <!-- close overlay by esc key end -->
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-close-button">
                            <span> <?php echo __('Hide close button', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("If the option is enabled, the close button of the popup will be disappeared. ", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-close-button"  name="<?php echo $this->plugin_name; ?>[close_button]" class="onoffswitch-checkbox" <?php if($close_button == 'on'){ echo 'checked';} else { echo '';} ?> />
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays-pb-close-button-position">
                            <span> <?php echo __('Close button position', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Select the position of the close button of the popup. It works with following themes: “Default”, “Red”, “Modern”, “Sale”.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <select id="ays-pb-close-button-position" name="ays_pb_close_button_position" class="ays-text-input-short">
                            <option <?php echo ($close_button_position == 'right-top') ? 'selected' : ''; ?> value="right-top"><?php echo __('Right Top', $this->plugin_name); ?></option>
                            <option <?php echo ($close_button_position == 'left-top') ? 'selected' : ''; ?> value="left-top"><?php echo __('Left Top', $this->plugin_name); ?></option>
                            <option <?php echo ($close_button_position == 'left-bottom') ? 'selected' : ''; ?> value="left-bottom"><?php echo __('Left Bottom', $this->plugin_name); ?></option>
                            <option <?php echo $close_button_position == 'right-bottom' ? 'selected' : ''; ?> value="right-bottom"><?php echo __('Right Bottom', $this->plugin_name); ?></option>
                        </select>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays-pb-close-button-text">
                            <span><?php echo __('Close button text', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Define the text of the close button. The default value is “x”. It will not work with following themes: “MacOS window”, “Ubuntu”, “Windows XP”, “Command prompt”.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="text" id="ays-pb-close-button-text" name="ays_pb_close_button_text" class="ays-text-input-short" value="<?php echo $close_button_text; ?>" />
                            </div>
                        </div>
                    </div> 
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-autoclose">
                            <span><?php echo __('Autoclose Delay (in seconds)', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Close the popup after a specified time delay (in seconds). Leave it empty or set it 0 for disabling the option.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="number" id="<?php echo $this->plugin_name; ?>-autoclose" name="<?php echo $this->plugin_name; ?>[autoclose]" class="ays-text-input-short" value="<?php echo $autoclose; ?>" />
                            </div>
                            <div class="col-sm-9"><div class="ays-auto-close-disable-small-box"><p class="ays-auto-close-disable">Set 0 for disabling</p></div></div>
                        </div>
                    </div> 
                </div>
                <hr/>
                <!-- hide timer -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_pb_hide_timer">
                            <?php echo __('Hide timer', $this->plugin_name); ?>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Hide the timer when the Autoclose Delay option is enabled.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input id="ays_pb_hide_timer" type="checkbox" class="ays_pb_hide_timer" name="ays_pb_hide_timer" <?php echo ($ays_pb_hide_timer == 'on' )? 'checked' : '' ?> value="on"/>
                    </div>
                </div>
                <!-- hide timer -->
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-delay">
                            <span><?php echo __('Open Delay (in milliseconds) ', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Open the popup after a specified time delay (in milliseconds). Leave it empty or set it 0 for disabling the option.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" id="<?php echo $this->plugin_name; ?>-delay" name="<?php echo $this->plugin_name; ?>[delay]"  class="ays-text-input-short"  value="<?php echo !isset($popupbox['delay']) ? '' : abs(intval($popupbox['delay'])); ?>" />
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-ays_pb_cookie">
                            <span style="font-size: 15px;"><?php echo __("Show once per session", $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Specify the period of time of one session in minutes and the popup will be shown once in that period (for every user). To reset the cookie, set 0.Example: set it  86400 to show the popup once a day for every user
                            ', $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" id="<?php echo $this->plugin_name; ?>-ays_pb_cookie" name="<?php echo $this->plugin_name; ?>[cookie]" class="ays-text-input-short" value="<?php echo $cookie; ?>" />
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-close_button_delay">
                            <span><?php echo __('Close button appearing delay (milliseconds) ', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Set a delay of the display of the close button inside the popup in milliseconds. Leave it empty or set it 0 for disabling the option.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" id="<?php echo $this->plugin_name; ?>-close_button_delay" name="ays_pb_close_button_delay"  class="ays-text-input-short"  value="<?php echo $close_button_delay; ?>" />
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-scroll_top">
                            <span><?php echo __('Scroll from top(px) ', $this->plugin_name); ?></span>
                             <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Pop-up will be shown as the page has been scrolled by certain pixels. Leave it empty or set it 0 for disabling the option.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" id="<?php echo $this->plugin_name; ?>-scroll_top" name="<?php echo $this->plugin_name; ?>[scroll_top]"  class="ays-text-input-short"  value="<?php echo !isset($popupbox['scroll_top']) ? '' : $popupbox['scroll_top']; ?>" />
                    </div>
                </div>
                <hr/>
                <div class="form-group row ays_toggle_parent">
                    <div class="col-sm-3" style="padding-right: 0px;">
                        <label for="ays_enable_pb_sound">
                            <?php echo __('Enable popup sound',$this->plugin_name)?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('This option will work only when Popup Trigger option is selected as the On click or Both. Please choose sound from General Settings page.',$this->plugin_name)?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-1">
                        <input type="checkbox" id="ays_enable_pb_sound"
                               name="ays_pb_enable_sounds" class="ays_toggle_checkbox"
                               value="on" <?php echo $enable_pb_sound ? 'checked' : ''; ?>/>
                    </div>
                    <div class="col-sm-7 ays_toggle_target ays_divider_left" style="<?php echo $enable_pb_sound ? '' : 'display:none;' ?>">
                        <?php if($ays_pb_sound_status): ?>
                        <blockquote class=""><?php echo __('Sounds are selected. For change sounds go to', $this->plugin_name); ?> <a href="?page=ays-pb-settings" target="_blank"><?php echo __('General Settings', $this->plugin_name); ?></a> <?php echo __('page', $this->plugin_name); ?></blockquote>
                        <?php else: ?>
                        <blockquote class=""><?php echo __('Sounds are not selected. For selecting sounds go to', $this->plugin_name); ?> <a href="?page=ays-pb-settings" target="_blank"><?php echo __('General Settings', $this->plugin_name); ?></a> <?php echo __('page', $this->plugin_name); ?></blockquote>
                        <?php endif; ?>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="active_date_check">
                            <?php echo __('Schedule the popup', $this->plugin_name); ?>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('The period of time when the popup will be active.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9 ays_toggle_parent">
                        <div class="row">
                            <div class="col-sm-3">
                                <input id="active_date_check" type="checkbox" class="active_date_check ays_toggle_checkbox"
                                       name="active_date_check" <?php echo $active_date_check ? 'checked' : '' ?>>
                            </div>
                            <div class="col-sm-9 ays_toggle_target ays_divider_left active_date <?php echo $active_date_check ? '' : 'display_none' ?>">
                                <!-- --Aro Start--- -->
                                <!-- -1- -->
                                <div class="form-group">
                                     <div class="row"> 
                                        <div class="col-sm-3">
                                            <label class="form-check-label" for="ays-active"> <?php echo __('Start date:', $this->plugin_name); ?> </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" class="ays-text-input ays-text-input-short ays_actDect ays_pb_act_dect" id="ays-active" name="ays-active"
                                                   value="<?php echo $activePopup; ?>" placeholder="<?php echo current_time( 'mysql' ); ?>">
                                                <div class="input-group-append">
                                                    <label for="ays-active" class="input-group-text">
                                                        <span><i class="ays_fa ays_fa_calendar"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- -2- -->
                                <div class="form-group">
                                     <div class="row"> 
                                        <div class="col-sm-3">
                                            <label class="form-check-label" for="ays-deactive"> <?php echo __('End date:', $this->plugin_name); ?> </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" class="ays-text-input ays-text-input-short ays_actDect ays_pb_act_dect" id="ays-deactive" name="ays-deactive"
                                                   value="<?php echo $deactivePopup; ?>" placeholder="<?php echo current_time( 'mysql' ); ?>">
                                                <div class="input-group-append">
                                                    <label for="ays-deactive" class="input-group-text">
                                                        <span><i class="ays_fa ays_fa_calendar"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <!-- --Aro End--- -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="pro_features">
                        <div>
                            <p>
                                <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                                <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row" style="padding: 10px 0;">
                    <div class="col-sm-3">
                        <label for="active_date_check">
                            <?php echo __('Schedule the PopupBox', $this->plugin_name); ?>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('The period of time when Popup will be active', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9 ays_toggle_parent">
                        <div class="active_date_check_header">
                            <input id="active_date_check" type="checkbox" class="active_date_check ays_toggle_checkbox" checked>
                            <a href="javascript:void(0)" class="ays_pb_plus_schedule ays_toggle_target ays_divider_left active_date">
                                <i class="ays_fa ays_fa_plus_square" aria-hidden="true"></i>
                            </a>
                       </div>
                        <div class="form-group ays_toggle_target ays_divider_left active_date">
                            <div class="row">
                                <div class="col-sm-12 ays_schedule_parent">
                                    <div class="form-group ays_schedule_form">
                                        <label class="form-check-label active_deactive_date" for="ays_active"> 
                                            <?php echo __('Start date:', $this->plugin_name); ?> 
                                            <div class="input-group-append">
                                                <input type="text"class="ays_pb_act_dect">           
                                                <label style="padding: 0 12px;" class="input-group-text">
                                                    <span><i class="ays_fa ays_fa_calendar"></i></span>
                                                </label>
                                            </div>
                                        </label>
                                        <label class="form-check-label active_deactive_date"> 
                                            <?php echo __('End date:', $this->plugin_name); ?> 
                                            <div class="input-group-append">
                                                <input type="text" class="ays_pb_act_dect">
                                                <label style="padding: 0 12px;" class="input-group-text">
                                                    <span><i class="ays_fa ays_fa_calendar"></i></span>
                                                </label>
                                            </div>
                                        </label>
                                        <a href="javascript:void(0)" class="ays_pb_delete_schedule">
                                            <i class="ays_fa ays_fa_times" aria-hidden="true"></i>
                                        </a>                                        
                                    </div>
                                    <div class="form-group ays_schedule_form">
                                        <label class="form-check-label active_deactive_date" for="ays_active"> 
                                            <?php echo __('Start date:', $this->plugin_name); ?> 
                                            <div class="input-group-append">
                                                <input type="text"class="ays_pb_act_dect">           
                                                <label style="padding: 0 12px;" class="input-group-text">
                                                    <span><i class="ays_fa ays_fa_calendar"></i></span>
                                                </label>
                                            </div>
                                        </label>
                                        <label class="form-check-label active_deactive_date"> 
                                            <?php echo __('End date:', $this->plugin_name); ?> 
                                            <div class="input-group-append">
                                                <input type="text" class="ays_pb_act_dect">
                                                <label style="padding: 0 12px;" class="input-group-text">
                                                    <span><i class="ays_fa ays_fa_calendar"></i></span>
                                                </label>
                                            </div>
                                        </label>
                                        <a href="javascript:void(0)" class="ays_pb_delete_schedule">
                                            <i class="ays_fa ays_fa_times" aria-hidden="true"></i>
                                        </a>                                        
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                </div>
                <hr>
                <!-- Action on popup content click -->
                <div class="col-sm-12 only_pro">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                                </p>
                            </div>
                        </div>
                    <div class="form-group row ays_toggle_parent" style="padding: 10px 0;">
                        <div class="col-sm-3">
                            <label for="ays_content_click">
                                <?php echo __(' Actions while clicking on the popup',$this->plugin_name)?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Enable closing the popup and/or redirecting to the custom URL while the user clicks on any area of the popup.',$this->plugin_name)?>">
                                    <i class="ays_fa ays_fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-1">
                            <input type="checkbox" id="ays_content_click" name="enable_content_click" class="ays_toggle_checkbox"
                                value="on" checked/>
                        </div>
                        <!-- close and redirect -->
                        <div class="col-sm-8 ays_toggle_target" style="display:block">
                            <!-- close -->
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <label for="ays_close_pb_content_click">
                                            <?php echo __('Enable closing',$this->plugin_name)?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('If the option is enabled, then the popup will be closed if the user clicks on any area inside it.',$this->plugin_name)?>">
                                                <i class="ays_fa ays_fa-info-circle"></i>
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="checkbox" id="ays_close_pb_content_click" name="enable_close_content_click"
                                            value="on" checked/>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <!-- redirect -->
                            <div class="col-sm-8 ays_toggle_parent_redirect">
                                <div class="form-group row">
                                    <div class="col-sm-5">
                                        <label for="ays_redirect_content_click">
                                            <?php echo __('Enable redirection',$this->plugin_name)?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Enable redirection to the custom URL when the user clicks on any area inside the popup.',$this->plugin_name)?>">
                                                <i class="ays_fa ays_fa-info-circle"></i>
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="checkbox" id="ays_redirect_content_click" name="enable_redirect_content_click"  class="ays_toggle_checkbox_redirect" value="on" checked/>
                                    </div>
                                    <div class="col-sm-6 ays_toggle_redirect" style="display:block;">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="ays_redirect_url_content_click"> <?php echo __('Redirection URL',$this->plugin_name)?>
                                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Provide the redirection URL.',$this->plugin_name)?>">
                                                        <i class="ays_fa ays_fa-info-circle"></i>
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" id="ays_redirect_url_content_click" name="redirect_url_content_click" value=""/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="ays_new_tab_content_click"> <?php echo __('Open in new tab',$this->plugin_name)?>
                                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('If the option is enabled, then the system will redirect the URL in a separate new tab.',$this->plugin_name)?>">
                                                        <i class="ays_fa ays_fa-info-circle"></i>
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="checkbox" id="ays_new_tab_content_click" name="enable_new_tab_content_click" value="on" checked/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- action click end -->
            </div>
            <div id="tab3" class="ays-pb-tab-content  <?php echo ($ays_pb_tab == 'tab3') ? 'ays-pb-tab-content-active' : ''; ?>">
                <p class="ays-subtitle"><?php echo  __('Popup Styles', $this->plugin_name) ?></p>
                <hr/>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="<?php echo $this->plugin_name; ?>-view_type">
                                <span>
                                    <?php echo __('Theme', $this->plugin_name); ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose your preferred template from suggested ready-to-use popup themes and customize it with options.", $this->plugin_name); ?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </span>
                                </label>
                            </div>
                            <div class="col-sm-10">
                                <div class="row pb_theme_img_box">
                                    <div class="pb_theme_image_div col">
                                        <label <?= ('default' == $view_type) ? 'class="apm_active_theme"' : '' ?>>
                                            <p><?= __('Default', $this->plugin_name) ?></p>
                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                   value="default" <?= ('default' == $view_type) ? 'checked' : '' ?>>
                                            <img src="<?= AYS_PB_ADMIN_URL . '/images/themes/default_theme.PNG' ?>"
                                                 alt="<?= __('Default', $this->plugin_name) ?>">
                                        </label>
                                    </div>
                                    <div class="pb_theme_image_div col">
                                        <label <?= ('red' == $view_type) ? 'class="apm_active_theme"' : '' ?>>
                                            <p><?= __('Red', $this->plugin_name) ?></p>
                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                   value="lil" <?= ('lil' == $view_type) ? 'checked' : '' ?>>
                                            <img src="<?= AYS_PB_ADMIN_URL . '/images/themes/lil_window.png' ?>"
                                                 alt="<?= __('Red', $this->plugin_name) ?>">
                                        </label>
                                    </div>
                                    <div class="pb_theme_image_div col">
                                        <label <?= ( 'image' == $view_type) ? 'class="apm_active_theme"' : '' ?>>
                                            <p><?= __('Modern', $this->plugin_name) ?></p>
                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                   value="image" <?= ('image' == $view_type) ? 'checked' : '' ?>>
                                            <img src="<?= AYS_PB_ADMIN_URL . '/images/themes/image_theme.png' ?>"
                                                 alt="<?= __('Modern', $this->plugin_name) ?>">
                                        </label>
                                    </div>
                                    <div class="pb_theme_image_div col">
                                        <label <?= ( 'template' == $view_type) ? 'class="apm_active_theme"' : '' ?>>
                                            <p><?= __('Sale', $this->plugin_name) ?></p>
                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                   value="template" <?= ('template' == $view_type) ? 'checked' : '' ?>>
                                            <img src="<?= AYS_PB_ADMIN_URL . '/images/themes/template_theme.png' ?>"
                                                 alt="<?= __('Sale', $this->plugin_name) ?>">
                                        </label>
                                    </div>
                                    <div class="pb_theme_image_div col">
                                        <label <?= ('mac' == $view_type) ? 'class="apm_active_theme"' : '' ?>>
                                            <p><?= __('MacOS window', $this->plugin_name) ?></p>
                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                   value="mac" <?= ('mac' == $view_type) ? 'checked' : '' ?>>
                                            <img src="<?= AYS_PB_ADMIN_URL . '/images/themes/MacOS_theme.PNG' ?>"
                                                 alt="<?= __('MacOS ', $this->plugin_name) ?>">
                                        </label>
                                    </div>
                                    <div class="pb_theme_image_div col">
                                        <label <?= ('ubuntu' == $view_type) ? 'class="apm_active_theme"' : '' ?>>
                                            <p><?= __('Ubuntu', $this->plugin_name) ?></p>
                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                   value="ubuntu" <?= ('ubuntu' == $view_type) ? 'checked' : '' ?>>
                                            <img src="<?= AYS_PB_ADMIN_URL . '/images/themes/Ubuntu_theme.PNG' ?>"
                                                 alt="<?= __('Ubuntu', $this->plugin_name) ?>">
                                        </label>
                                    </div>
                                    <div class="pb_theme_image_div col">
                                        <label <?= ('win98' == $view_type) ? 'class="apm_active_theme"' : '' ?>>
                                            <p><?= __('Windows XP', $this->plugin_name) ?></p>
                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                   value="winXP" <?= ('winXP' == $view_type) ? 'checked' : '' ?>>
                                            <img src="<?= AYS_PB_ADMIN_URL . '/images/themes/WindowsXP_theme.PNG' ?>"
                                                 alt="<?= __('Windows XP', $this->plugin_name) ?>">
                                        </label>
                                    </div>
                                    <div class="pb_theme_image_div col">
                                        <label  <?= ('win98' == $view_type) ? 'class="apm_active_theme"' : '' ?>>
                                            <p><?= __('Windows 98', $this->plugin_name) ?></p>
                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                   value="win98" <?= ('win98' == $view_type) ? 'checked' : '' ?>>
                                            <img src="<?= AYS_PB_ADMIN_URL . '/images/themes/Windows98_theme.PNG' ?>"
                                                 alt="<?= __('Windows 98', $this->plugin_name) ?>">
                                        </label>

                                    </div>
                                    <div class="pb_theme_image_div col">
                                        <label <?= ('cmd' == $view_type) ? 'class="apm_active_theme"' : '' ?>>
                                            <p><?= __('Command prompt', $this->plugin_name) ?></p>
                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                   value="cmd" <?= ('cmd' ==$view_type) ? 'checked' : '' ?>>
                                            <img src="<?= AYS_PB_ADMIN_URL . '/images/themes/cmd_theme.PNG' ?>"
                                                 alt="<?= __('Command prompt', $this->plugin_name) ?>">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="<?php echo $this->plugin_name; ?>-bgcolor">
                                    <span>
                                        <?php echo __('Background color', $this->plugin_name); ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the background color of the popup.", $this->plugin_name); ?>">
                                            <i class="ays_fa ays_fa-info-circle"></i>
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="<?php echo $this->plugin_name; ?>-bgcolor"  data-alpha="true" class="ays_pb_color_input ays_pb_bgcolor_change" name="<?php echo $this->plugin_name; ?>[bgcolor]" value="<?php echo $bgcolor; ?>"  data-default-color="#FFFFFF"/>
                            </div>
                        </div>
                        <hr/>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for='ays-pb-bg-image'>
                                    <?= __('Background Image', $this->plugin_name); ?>
                                    <a class="ays_help" data-toggle="tooltip" data-placement="top"
                                       title="<?= __("Add a background image to the popup. ", $this->plugin_name); ?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <a href="javascript:void(0)" class="button ays-pb-add-bg-image">
                                    <?= $image_text_bg; ?>
                                    <a class="ays_help" data-toggle="tooltip" data-placement="top"
                                       title="<?= __(" If you add a background image, background color will not be applied. Remove the image or don't add it, if you want to apply background color.", $this->plugin_name); ?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-8" style="<?= $style_bg; ?>">
                            <div class="ays-pb-bg-image-container">
                                <span class="ays-remove-bg-img"></span>
                                <img src="<?= $bg_image ; ?>" id="ays-pb-bg-img"/>
                                <input type="hidden" name="ays_pb_bg_image" id="ays-pb-bg-image"
                                       value="<?= isset($bg_image ) ? $bg_image  : ""; ?>"/>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="<?php echo $this->plugin_name; ?>-header_bgcolor">
                                    <span>
                                        <?php echo __('Header background color', $this->plugin_name); ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the background color of the box’s header. It works with the following themes: Red, Sale.", $this->plugin_name); ?>">
                                            <i class="ays_fa ays_fa-info-circle"></i>
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="<?php echo $this->plugin_name; ?>-header_bgcolor"  data-alpha="true" class="ays_pb_color_input ays_pb_header_bgcolor_change" name="<?php echo $this->plugin_name; ?>[header_bgcolor]" value="<?php echo $header_bgcolor; ?>"  Fdata-default-color="#FFFFF"/>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="<?php echo $this->plugin_name; ?>-ays_pb_textcolor">
                                    <span>
                                        <?php echo  __('Text color',$this->plugin_name) ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the color of the text written inside the popup.", $this->plugin_name); ?>">
                                            <i class="ays_fa ays_fa-info-circle"></i>
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input id="<?php echo $this->plugin_name; ?>-ays_pb_textcolor" type="text" class="ays_pb_color_input ays_pb_textcolor_change" name="<?php echo $this->plugin_name; ?>[ays_pb_textcolor]" value="<?php echo wp_unslash($textcolor); ?>" data-default-color="#000000" data-alpha="true">
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="<?php echo $this->plugin_name; ?>-ays_pb_overlay_color">
                                    <span>
                                        <?php echo  __('Overlay color',$this->plugin_name) ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the color of the overlay.", $this->plugin_name); ?>">
                                            <i class="ays_fa ays_fa-info-circle"></i>
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input id="<?php echo $this->plugin_name; ?>-overlay_color" type="text" data-alpha = "true" class="color-picker ays_pb_color_input ays_pb_overlay_color_change" name="ays_pb_overlay_color" value="<?php echo $overlay_color; ?>" data-default-color="#000">
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="<?php echo $this->plugin_name; ?>-ays_pb_bordersize">
                        <span>
                            <?php echo  __('Border size',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the size of the border of the popup in pixels.", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input id="<?php echo $this->plugin_name; ?>-ays_pb_bordersize" type="number" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[ays_pb_bordersize]" value="<?php echo wp_unslash($border_size); ?>">
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="<?php echo $this->plugin_name; ?>-ays_pb_bordercolor">
                                    <span>
                                        <?php echo  __('Border color',$this->plugin_name) ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the color of the border of the popup.", $this->plugin_name); ?>">
                                            <i class="ays_fa ays_fa-info-circle"></i>
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input id="<?php echo $this->plugin_name; ?>-ays_pb_bordercolor" class="ays_pb_color_input ays_pb_bordercolor_change" type="text" name="<?php echo $this->plugin_name; ?>[ays_pb_bordercolor]" value="<?php echo wp_unslash($bordercolor); ?>" data-default-color="#FFFFFF" data-alpha="true">
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="<?php echo $this->plugin_name; ?>-ays_pb_border_radius">
                                    <span>
                                        <?php echo  __('Border radius',$this->plugin_name) ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the radius of the border. Allows adding rounded corners to the popup. ", $this->plugin_name); ?>">
                                            <i class="ays_fa ays_fa-info-circle"></i>
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input id="<?php echo $this->plugin_name; ?>-ays_pb_border_radius" type="number" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[ays_pb_border_radius]" value="<?php echo wp_unslash($border_radius); ?>">
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row" >
                            <div class="col-sm-6">
                                <label for="<?php echo $this->plugin_name; ?>-animate_in">
                        <span>
                            <?php echo  __('Show-in effect',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose the animation effect from a variety of variants suggested, for the popup opening. ", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <select id="<?php echo $this->plugin_name; ?>-animate_in" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[animate_in]">
                                    <optgroup label="Fading Entrances">
                                        <option <?php echo 'fadeIn' == $animate_in ? 'selected' : ''; ?> value="fadeIn">Fade In</option>
                                        <option <?php echo 'fadeInDown' == $animate_in ? 'selected' : ''; ?> value="fadeInDown">Fade In Down</option>
                                        <option <?php echo 'fadeInDownBig' == $animate_in ? 'selected' : ''; ?> value="fadeInDownBig">Fade In Down Big</option>
                                        <option <?php echo 'fadeInLeft' == $animate_in ? 'selected' : ''; ?> value="fadeInLeft">Fade In Left</option>
                                        <option <?php echo 'fadeInLeftBig' == $animate_in ? 'selected' : ''; ?> value="fadeInLeftBig">Fade In Left Big</option>
                                        <option <?php echo 'fadeInRight' == $animate_in ? 'selected' : ''; ?> value="fadeInRight">Fade In Right</option>
                                        <option <?php echo 'fadeInRightBig' == $animate_in ? 'selected' : ''; ?> value="fadeInRightBig">Fade In Right Big</option>
                                        <option <?php echo 'fadeInUp' == $animate_in ? 'selected' : ''; ?> value="fadeInUp">Fade In Up</option>
                                        <option <?php echo 'fadeInUpBig' == $animate_in ? 'selected' : ''; ?> value="fadeInUpBig">Fade In Up Big</option>
                                    </optgroup>
                                    <optgroup label="Bouncing Entrances">
                                        <option <?php echo 'bounceIn' == $animate_in ? 'selected' : ''; ?> value="bounceIn">Bounce In</option>
                                        <option <?php echo 'bounceInDown' == $animate_in ? 'selected' : ''; ?> value="bounceInDown">Bounce In Down</option>
                                        <option <?php echo 'bounceInLeft' == $animate_in ? 'selected' : ''; ?> value="bounceInLeft">Bounce In Left</option>
                                        <option <?php echo 'bounceInRight' == $animate_in ? 'selected' : ''; ?> value="bounceInRight">Bounce In Right</option>
                                        <option <?php echo 'bounceInUp' == $animate_in ? 'selected' : ''; ?> value="bounceInUp">Bounce In Up</option>
                                    </optgroup>
                                    <optgroup label="Sliding Entrances">
                                        <option <?php echo 'slideInUp' == $animate_in ? 'selected' : ''; ?> value="slideInUp">Slide In Up</option>
                                        <option <?php echo 'slideInDown' == $animate_in ? 'selected' : ''; ?> value="slideInDown">Slide In Down</option>
                                        <option <?php echo 'slideInLeft' == $animate_in ? 'selected' : ''; ?> value="slideInLeft">Slide In Left</option>
                                        <option <?php echo 'slideInRight' == $animate_in ? 'selected' : ''; ?> value="slideInRight">Slide In Right</option>
                                    </optgroup>
                                    <optgroup label="Zoom Entrances">
                                        <option <?php echo 'zoomIn' == $animate_in ? 'selected' : ''; ?> value="zoomIn">Zoom In</option>
                                        <option <?php echo 'zoomInDown' == $animate_in ? 'selected' : ''; ?> value="zoomInDown">Zoom In Down</option>
                                        <option <?php echo 'zoomInLeft' == $animate_in ? 'selected' : ''; ?> value="zoomInLeft">Zoom In Left</option>
                                        <option <?php echo 'zoomInRight' == $animate_in ? 'selected' : ''; ?> value="zoomInRight">Zoom In Right</option>
                                        <option <?php echo 'zoomInUp' == $animate_in ? 'selected' : ''; ?> value="zoomInUp">Zoom In Up</option>
                                    </optgroup>
                                    <optgroup label="Rotating Entrances">
                                        <option <?php echo 'rotateIn' == $animate_in ? 'selected' : ''; ?> value="rotateIn">Rotating In</option>
                                        <option <?php echo 'rotateInDownLeft' == $animate_in ? 'selected' : ''; ?> value="rotateInDownLeft">Rotating In Down Left</option>
                                        <option <?php echo 'rotateInDownRight' == $animate_in ? 'selected' : ''; ?> value="rotateInDownRight">Rotating In Down Right</option>
                                        <option <?php echo 'rotateInUpLeft' == $animate_in ? 'selected' : ''; ?> value="rotateInUpLeft">Rotating In Up Left</option>
                                        <option <?php echo 'rotateInUpRight' == $animate_in ? 'selected' : ''; ?> value="rotateInUpRight">Rotating In Up Right</option>
                                    </optgroup>
                                    <optgroup label="Fliping Entrances">
                                        <option <?php echo 'flipInY' == $animate_in ? 'selected' : ''; ?> value="flipInY">Flip In Y</option>
                                        <option <?php echo 'flipInX' == $animate_in ? 'selected' : ''; ?> value="flipInX">Flip In X</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="<?php echo $this->plugin_name; ?>-animate_out">
                        <span>
                            <?php echo  __('Hide effect',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose the animation effect from a variety of variants suggested, for the popup closing. ", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <select id="<?php echo $this->plugin_name; ?>-animate_out" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[animate_out]">
                                    <optgroup label="Fading Exits">
                                        <option <?php echo  $animate_out == 'fadeOut' ? 'selected' : ''; ?> value="fadeOut">Fade Out</option>
                                        <option <?php echo  $animate_out == 'fadeOutDown' ? 'selected' : ''; ?> value="fadeOutDown">Fade Out Down</option>
                                        <option <?php echo  $animate_out == 'fadeOutDownBig' ? 'selected' : ''; ?> value="fadeOutDownBig">Fade Out Down Big</option>
                                        <option <?php echo  $animate_out == 'fadeOutLeft' ? 'selected' : ''; ?> value="fadeOutLeft">Fade Out Left</option>
                                        <option <?php echo  $animate_out == 'fadeOutLeftBig' ? 'selected' : ''; ?> value="fadeOutLeftBig">Fade Out Left Big</option>
                                        <option <?php echo  $animate_out == 'fadeOutRight' ? 'selected' : ''; ?> value="fadeOutRight">Fade Out Right</option>
                                        <option <?php echo  $animate_out == 'fadeOutRightBig' ? 'selected' : ''; ?> value="fadeOutRightBig">Fade Out Right Big</option>
                                        <option <?php echo  $animate_out == 'fadeOutUp' ? 'selected' : ''; ?> value="fadeOutUp">Fade Out Up</option>
                                        <option <?php echo  $animate_out == 'fadeOutUpBig' ? 'selected' : ''; ?> value="fadeOutUpBig">Fade Out Up Big</option>
                                    </optgroup>
                                    <optgroup label="Bouncing Exits">
                                        <option <?php echo 'bounceOut' == $animate_out ? 'selected' : ''; ?> value="bounceOut">Bounce Out</option>
                                        <option <?php echo 'bounceOutDown' == $animate_out ? 'selected' : ''; ?> value="bounceOutDown">Bounce Out Down</option>
                                        <option <?php echo 'bounceOutLeft' == $animate_out ? 'selected' : ''; ?> value="bounceOutLeft">Bounce Out Left</option>
                                        <option <?php echo 'bounceOutRight' == $animate_out ? 'selected' : ''; ?> value="bounceOutRight">Bounce Out Right</option>
                                        <option <?php echo 'bounceOutUp' == $animate_out ? 'selected' : ''; ?> value="bounceOutUp">Bounce Out Up</option>
                                    </optgroup>
                                    <optgroup label="Sliding Exits">
                                        <option <?php echo 'slideOutUp' == $animate_out ? 'selected' : ''; ?> value="slideOutUp">Slide Out Up</option>
                                        <option <?php echo 'slideOutDown' == $animate_out ? 'selected' : ''; ?> value="slideOutDown">Slide Out Down</option>
                                        <option <?php echo 'slideOutLeft' == $animate_out ? 'selected' : ''; ?> value="slideOutLeft">Slide Out Left</option>
                                        <option <?php echo 'slideOutRight' == $animate_out ? 'selected' : ''; ?> value="slideOutRight">Slide Out Right</option>
                                    </optgroup>
                                    <optgroup label="Zoom Exits">
                                        <option <?php echo 'zoomOut' == $animate_out ? 'selected' : ''; ?> value="zoomOut">Zoom Out</option>
                                        <option <?php echo 'zoomOutDown' == $animate_out ? 'selected' : ''; ?> value="zoomOutDown">Zoom Out Down</option>
                                        <option <?php echo 'zoomOutLeft' == $animate_out ? 'selected' : ''; ?> value="zoomOutLeft">Zoom Out Left</option>
                                        <option <?php echo 'zoomOutRight' == $animate_out ? 'selected' : ''; ?> value="zoomOutRight">Zoom Out Right</option>
                                        <option <?php echo 'zoomOutUp' == $animate_out ? 'selected' : ''; ?> value="zoomOutUp">Zoom Out Up</option>
                                    </optgroup>
                                    <optgroup label="Rotating Exits">
                                        <option <?php echo 'rotateOut' == $animate_out ? 'selected' : ''; ?> value="rotateOut">Rotating Out</option>
                                        <option <?php echo 'rotateOutDownLeft' == $animate_out ? 'selected' : ''; ?> value="rotateOutDownLeft">Rotating Out Down Left</option>
                                        <option <?php echo 'rotateOutDownRight' == $animate_out ? 'selected' : ''; ?> value="rotateOutDownRight">Rotating Out Down Right</option>
                                        <option <?php echo 'rotateOutUpLeft' == $animate_out ? 'selected' : ''; ?> value="rotateOutUpLeft">Rotating Out Up Left</option>
                                        <option <?php echo 'rotateOutUpRight' == $animate_out ? 'selected' : ''; ?> value="rotateOutUpRight">Rotating Out Up Right</option>
                                    </optgroup>
                                    <optgroup label="Fliping Exits">
                                        <option <?php echo 'flipOutY' == $animate_out ? 'selected' : ''; ?> value="flipOutY">Flip Out Y</option>
                                        <option <?php echo 'flipOutX' == $animate_out ? 'selected' : ''; ?> value="flipOutX">Flip Out X</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <hr/>
                        
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="ays_pb_animation_speed">
                                    <span>
                                        <?php echo  __('Animation speed',$this->plugin_name) ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the animation speed of the popup in seconds.", $this->plugin_name); ?>">
                                            <i class="ays_fa ays_fa-info-circle"></i>
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input id="ays_pb_animation_speed" type="number" class="ays-text-input-short" name="ays_pb_animation_speed" value="<?php echo $animation_speed; ?>">
                            </div>
                        </div>
                        <hr/>
                        <!-- popup width with percentage -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for='<?php echo $this->plugin_name; ?>-width'>
                                    <?php echo __('Width', $this->plugin_name); ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Specify the width of the popup in pixels. If you put 0 or leave it blank, the width will be 100%. It accepts only numerical values and you choose whether to define the value by percentage or in pixels.',$this->plugin_name)?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays-display-flex">
                                <div>   
                                <input type="number" id="<?php echo $this->plugin_name; ?>-width"  class="ays-text-input-short ays_pb_width"  name="<?php echo $this->plugin_name; ?>[width]" value="<?php echo $width; ?>" <?php echo $disable_width; ?>/>
                                    <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __("For 100% leave blank", $this->plugin_name);?></span>
                                </div>
                                <div class="ays_pb_width_by_percentage_px_box">
                                    <select name="ays_popup_width_by_percentage_px" id="ays_popup_width_by_percentage_px">
                                        <option value="pixels" <?php echo $popup_width_by_percentage_px == "pixels" ? "selected" : ""; ?>>
                                            <?php echo __( "px", $this->plugin_name ); ?>
                                        </option>
                                        <option value="percentage" <?php echo $popup_width_by_percentage_px == "percentage" ? "selected" : ""; ?>>
                                            <?php echo __( "%", $this->plugin_name ); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- popuop width with percentage end -->
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="ays-pb-mobile-max-width">
                                    <?php echo  __('Max-width for mobile',$this->plugin_name) ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("PopupBox container max-width for mobile in percentage. This option will work for the screens with less than 640 pixels width.", $this->plugin_name); ?>">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input id="ays-pb-mobile-max-width" class="ays-text-input-short" name="ays_pb_mobile_max_width" type="number" style="display:inline-block;" value="<?php echo $mobile_max_width; ?>" /> %
                                 <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __("For 100% leave blank", $this->plugin_name);?></span>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="<?php echo $this->plugin_name; ?>-height">
                                    <span><?php echo __('Height', $this->plugin_name); ?></span>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Specify the height of the popup in pixels. If you put 0 or leave it blank, the height will be the default values of the selected theme.',$this->plugin_name)?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input type="number" id="<?php echo $this->plugin_name; ?>-height"  class="ays-text-input-short ays_pb_height" name="<?php echo $this->plugin_name; ?>[height]" value="<?php echo $height; ?>" <?php echo $disable_height ;?>/>
                            </div>
                        </div>
                        <hr/>
                        <!-- open popup full screen -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="open_pb_fullscreen">
                                    <span><?php echo __('Open full screen', $this->plugin_name); ?></span>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('If the option is enabled, then the popup will be displayed on a full screen.',$this->plugin_name)?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input type="checkbox" id="open_pb_fullscreen" class="ays-text-input-short" name="enable_pb_fullscreen"  <?php echo $ays_enable_pb_fullscreen == 'on' ? 'checked' : ''; ?> />
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="ays_pb_font_family">
                                    <?php echo  __('Font family',$this->plugin_name) ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose your preferred font family from the suggested variants for the PopupBox.", $this->plugin_name); ?>">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <select id="ays_pb_font_family" class="" name="ays_pb_font_family">
                                <?php
                                    $selected  = "";
                                    foreach ($font_families as $key => $pb_font_family) {
                                        if(is_array($pb_font_family)){
                                            if (in_array($font_family_option,$pb_font_family)) {
                                               $selected = "selected";
                                            }
                                            else{
                                                $selected = "";
                                            }
                                        }else{
                                            if($pb_font_family == $font_family_option){
                                                $selected = "selected";
                                            }else{
                                                $selected = "";
                                            }
                                        }
                                    
                                ?>
                                    <option value="<?php echo $pb_font_family ;?>" <?php echo $selected ;?>>
                                        <?php echo $pb_font_family; ?>
                                    </option>

                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <hr/>
                        <!-- TP Changes  -->
                        <!--  -->
                        <div class="form-group row">
                                <div class="col-sm-5">
                                    <label for="ays-enable-background-gradient">
                                        <?php echo __('Background gradient',$this->plugin_name)?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Add background gradient for the popup. Moreover, you can choose Color 1, Color 2 and the direction of the gradient.',$this->plugin_name)?>">
                                            <i class="ays_fa ays_fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-7 ays_divider_left">
                                    <input type="checkbox" class="ays_toggle ays_toggle_slide"
                                           id="ays-enable-background-gradient"
                                           name="ays_enable_background_gradient"
                                            <?php echo ($enable_background_gradient) ? 'checked' : ''; ?>/>
                                    <label for="ays-enable-background-gradient" class="ays_switch_toggle">Toggle</label>
                                    <div class="row ays_toggle_target" style="margin: 10px 0 0 0; padding-top: 10px; <?php echo ($enable_background_gradient) ? '' : 'display:none;' ?>">
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for='ays-background-gradient-color-1'>
                                                <?php echo __('Color 1', $this->plugin_name); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Color 1 of the PopupBox background gradient',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input type="text" class="ays-text-input" id='ays-background-gradient-color-1' data-alpha="true" name='ays_background_gradient_color_1' value="<?php echo $background_gradient_color_1; ?>"/>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for='ays-background-gradient-color-2'>
                                                <?php echo __('Color 2', $this->plugin_name); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Color 2 of the PopupBox background gradient',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input type="text" class="ays-text-input" id='ays-background-gradient-color-2' data-alpha="true" name='ays_background_gradient_color_2' value="<?php echo $background_gradient_color_2; ?>"/>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for="ays_pb_gradient_direction">
                                                <?php echo __('Gradient direction',$this->plugin_name)?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('The direction of the color gradient',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <select id="ays_pb_gradient_direction" name="ays_pb_gradient_direction" class="ays-text-input">
                                                <option <?php echo ($pb_gradient_direction == 'vertical') ? 'selected' : ''; ?> value="vertical"><?php echo __( 'Vertical', $this->plugin_name); ?></option>
                                                <option <?php echo ($pb_gradient_direction == 'horizontal') ? 'selected' : ''; ?> value="horizontal"><?php echo __( 'Horizontal', $this->plugin_name); ?></option>
                                                <option <?php echo ($pb_gradient_direction == 'diagonal_left_to_right') ? 'selected' : ''; ?> value="diagonal_left_to_right"><?php echo __( 'Diagonal left to right', $this->plugin_name); ?></option>
                                                <option <?php echo ($pb_gradient_direction == 'diagonal_right_to_left') ? 'selected' : ''; ?> value="diagonal_right_to_left"><?php echo __( 'Diagonal right to left', $this->plugin_name); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                        <!--  -->
                        <!-- title styles start -->
                        <div class="col-sm-12 only_pro">
                            <div class="pro_features">
                                <div>
                                    <p>
                                        <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row" style="padding: 10px 0;">
                                <div class="col-sm-5">
                                    <label for="ays_enable_title_styles">
                                        <?php echo __('Title style',$this->plugin_name)?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Enable the option in order to customize the style of the popup title.',$this->plugin_name)?>">
                                            <i class="ays_fa ays_fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-7 ays_divider_left">
                                    <input type="checkbox" class="ays_toggle ays_toggle_slide" id="ays_enable_title_styles"
                                        name="enable_title_styles" checked/>
                                    <label for="ays_enable_title_styles" class="ays_switch_toggle">Toggle</label>
                                    <div class="row ays_toggle_target" style="margin: 10px 0 0 0; padding-top: 10px;display:block">
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for='ays_title_font_family'>
                                                <?php echo __('Font family', $this->plugin_name); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Choose your preferred font family from the suggested variants for the popup title.',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <select name="title_font_family" id="ays_title_font_family">
                                                <option value="Arial">Arial</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for='ays_title_font_weight'>
                                                <?php echo __('Font weight', $this->plugin_name); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Define the boldness of the popup title.',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <select name="title_font_weight" id="ays_title_font_weight">
                                                <option value="">Bold</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for='ays_title_font_size'>
                                                <?php echo __('Font size(px)', $this->plugin_name); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Define the font size of the popup title in pixels.',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input type="number" id="ays_title_font_size" name="title_font_size" value=''/> 
                                        </div>
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for='ays_title_letter_spacing'>
                                                <?php echo __('Letter spacing(px)', $this->plugin_name); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Define the space between characters in a text of the popup title in pixels.',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input type="number" id="ays_title_letter_spacing" name="title_letter_spacing" value=''/> 
                                        </div>
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for='ays_title_line_height'>
                                                <?php echo __('Line height', $this->plugin_name); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Define the height of a line of the popup title.',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input type="number" id="ays_title_line_height" name="title_line_height" value=""/> 
                                        </div>
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for='ays_title_text_alignment'>
                                                <?php echo __('Text alignment', $this->plugin_name); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Choose the horizontal alignment of the text of the popup title.',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <select name="title_text_alignment" id="ays_title_text_alignment">
                                                <option value="center">Center</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for='ays_title_text_transform'>
                                                <?php echo __('Text transform', $this->plugin_name); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Choose the capitalization of the text of the popup title. none - No capitalization. The text renders as it is.capitalize - Transforms the first character of each word to uppercase.	uppercase - Transforms all characters to uppercase.lowercase - Transforms all characters to lowercase.	',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <select name="title_text_transform" id="ays_title_text_transform">
                                                <option value="Upercase">Upercase</option>

                                            </select>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                            <label for='ays_title_text_transform'>
                                                <?php echo __('Text decoration', $this->plugin_name); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Choose the kind of decoration added to text of the popup title.',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <select name="title_text_decoration" id="ays_title_text_decoration">
                                                <option value="UnderLine">UnderLine</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- title styles end -->
                        <hr/> 
                        <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="custom_class">
                                        <?php echo __('Custom class for Popup container ',$this->plugin_name)?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Use your custom HTML class for adding your custom styles to popup container.',$this->plugin_name)?>">
                                            <i class="ays_fa ays_fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[custom-class]" id="custom_class" placeholder="myClass myAnotherClass..." value="<?php echo $custom_class; ?>">
                                    <!-- ays-text-input  - input Class -->
                                    <!--  ays_divider_left  - input-i Div-i Class left border-i hamar-->
                                </div>
                            </div>
                            <hr>
                            <div class="ays-field">
                                <label for="<?php echo $this->plugin_name; ?>-custom-css">
                                    <span><?php echo __('Custom CSS', $this->plugin_name); ?></span>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Field for entering your own CSS code.',  $this->plugin_name)?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </label>
                                <textarea id="<?php echo $this->plugin_name; ?>-custom-css"  class="ays-textarea" name="<?php echo  $this->plugin_name; ?>[custom-css]"><?php echo htmlentities($custom_css); ?></textarea>
                            </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="popup_preview" >
                            <p style="font-weight: normal; font-style: italic; font-size: 14px; color: grey; margin:0; padding:0;"><?php echo __("See PopupBox in live preview", $this->plugin_name); ?></p>
                            <div class='ays-pb-modals'>
                                <input type='hidden' id='ays_pb_modal_animate_in'>
                                <input type='hidden' id='ays_pb_modal_animate_out'>
                                <input id='ays-pb-modal-checkbox' class='ays-pb-modal-check' type='checkbox' checked/>
                                <div class='ays-pb-modal ays-pb-live-container ays_bg_image_box' id="ays-pb-live-container">
                                    <label class='ays-pb-modal-close ays-close-button-on-off'>
                                        <?php 
                                            if ($close_button_text === 'x') {
                                                echo " <i class='fa fa-times fa-2x ays-close-button-text'></i>";
                                            }else{
                                                echo " <i class='fa fa-2x ays_fa-close-button ays-close-button-text'></i>";
                                            }
                                         ?>
                                    </label>

                                    <h2 class="ays_title"></h2>
                                    <p class="desc"></p>
                                    <hr />
                                    <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", $this->plugin_name); ?></span></div>
                                    <?php echo $ays_pb_timer_desc; ?>
                                </div>
                                <div class='ays-pb-live-container ays_window ays_bg_image_box'>
                                    <div class='ays_topBar'>
                                        <label class='ays-pb-modal-close ays_close ays-close-button-on-off'><i class='fa fa-times fa-2x'></i></label>
                                        <a class='ays_hide'></a>
                                        <a class='ays_fullScreen'></a>
                                        <h2 class="ays_title"></h2>
                                    </div>
                                    <hr />
                                    <div class='ays_text'>
                                        <div class='ays_text-inner'>
                                            <p class="desc"></p>
                                            <hr />
                                            <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", $this->plugin_name); ?></span></div>
                                        </div>
                                    </div>
                                    <?php echo $ays_pb_timer_desc; ?>
                                </div>
                                <div class='ays-pb-live-container ays_cmd_window ays_bg_image_box'>
                                    <header class='ays_cmd_window-header'>
                                        <div class='ays_cmd_window_title'><h2 class="ays_title"></h2></div>
                                        <nav class='ays_cmd_window-controls'>
                                            <span class='ays_cmd_control-item ays_cmd_control-minimize ays_cmd_js-minimize'>‒</span>
                                            <span class='ays_cmd_control-item ays_cmd_control-maximize ays_cmd_js-maximize'>□</span>
                                            <label for='ays-pb-modal-checkbox' class='ays_cmd_control-item ays_cmd_control-close ays-close-button-on-off'><span class='ays_cmd_control-close ays_cmd_js-close'>˟</span></label>
                                        </nav>
                                    </header>
                                    <div class='ays_cmd_window-cursor'>
                                        <span class='ays_cmd_i-cursor-indicator'>></span>
                                        <span class='ays_cmd_i-cursor-underscore'></span>
                                        <input type='text' disabled class='ays_cmd_window-input ays_cmd_js-prompt-input' />
                                    </div>
                                    <main class='ays_cmd_window-content'>
                                        <div class='ays_text'>
                                            <div class='ays_text-inner'>
                                                <p class="desc"></p>
                                                <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", $this->plugin_name); ?></span></div>
                                            </div>
                                        </div>
                                        <?php echo $ays_pb_timer_desc; ?>
                                    </main>
                                </div>
                                <div class='ays-pb-live-container ays_ubuntu_window ays_bg_image_box'>
                                    <div class='ays_ubuntu_topbar'>
                                        <div class='ays_ubuntu_icons'>
                                            <div class='ays_ubuntu_close ays-close-button-on-off'></div>
                                            <div class='ays_ubuntu_hide'></div>
                                            <div class='ays_ubuntu_maximize'></div>
                                        </div>
                                        <h2 class="ays_title"></h2>
                                    </div>
                                    <div class='ays_ubuntu_tools'>
                                        <ul>
                                            <li><span>File</span></li>
                                            <li><span>Edit</span></li>
                                            <li><span>Go</span></li>
                                            <li><span>Bookmarks</span></li>
                                            <li><span>Tools</span></li>
                                            <li><span>Help</span></li>
                                        </ul>
                                    </div>
                                    <div class='ays_ubuntu_window_content'>
                                        <p class="desc"></p>
                                        <hr />
                                        <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", $this->plugin_name); ?></span></div>
                                    </div>
                                    <div class='ays_ubuntu_folder-info'>
                                    <?php echo $ays_pb_timer_desc; ?>
                                    </div>
                                </div>
                                <div class=' ays_winxp_window '>
                                    <div class='ays_winxp_title-bar'>
                                        <div class='ays_winxp_title-bar-title'>
                                            <h2 class="ays_title"></h2>
                                        </div>
                                        <div class='ays_winxp_title-bar-close ays-close-button-on-off'>
                                            <label for='ays-pb-modal-checkbox' class='ays_winxp_close ays-pb-modal-close'></label>
                                        </div>
                                        <div class='ays_winxp_title-bar-max'></div>
                                        <div class='ays_winxp_title-bar-min'></div>
                                    </div>
                                    <div class='ays_winxp_content ays-pb-live-container ays_bg_image_box'>
                                        <p class="desc"></p>
                                        <hr />
                                        <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", $this->plugin_name); ?></span></div>
                                        <?php echo $ays_pb_timer_desc; ?>
                                    </div>
                                </div>
                                <div class='ays-pb-live-container ays_win98_window ays_bg_image_box'>
                                    <header class='ays_win98_head'>
                                        <div class='ays_win98_header'>
                                            <div class='ays_win98_title'>
                                                <h2 class="ays_title"></h2>
                                            </div>
                                            <div class='ays_win98_btn-close ays-close-button-on-off'><label for='ays-pb-modal-checkbox' class='ays-pb-modal-close'><span class="ays-close-button-text"><?php echo $close_button_text ?></span></label></div>
                                        </div>
                                    </header>
                                    <div class='ays_win98_main '>
                                        <div class='ays_win98_content'>
                                            <p class="desc"></p>
                                            <hr />
                                            <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", $this->plugin_name); ?></span></div>
                                            <?php echo $ays_pb_timer_desc; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class='ays-pb-live-container ays_lil_window'>
                                    <header class='ays_lil_head'>
                                        <label for='ays-pb-modal-checkbox' ><a class="close-lil-btn ays-close-button-take-text-color ays-close-button-on-off ays-close-button-text <?php echo ($close_button_text === 'x') ? '' : 'close-lil-btn-text' ?>"><?php echo $close_button_text ?></a></label>
                                        <h2 class="ays_title_lil ays_title"></h2>
                                        <p class="desc" style="margin: 0"></p>
                                    </header>
                                    <div class='ays_lil_content ays_bg_image_box'>
                                        <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", $this->plugin_name); ?></span></div>
                                        <?php echo $ays_pb_timer_desc; ?>
                                    </div>
                                </div>
                                <div class='ays-pb-live-container ays_image_window ays_bg_image_box' id="ays-image-window">
                                    <header class='ays_image_head'>
                                        <label for='ays-pb-modal-checkbox' ><a class="close-image-btn ays-close-button-on-off ays-close-button-text"><?php echo $close_button_text ?></a></label>
                                        <h2 class="ays_title_image ays_title"></h2>
                                        <p class="desc" style="margin: 0"></p>
                                    </header>
                                    <div class='ays_image_content '>
                                        <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", $this->plugin_name); ?></span></div>
                                        <?php echo $ays_pb_timer_desc; ?>
                                    </div>
                                </div>
                                <div class='ays-pb-live-container ays_template_window '>
                                    <header class='ays_template_head'>
                                        <label for='ays-pb-modal-checkbox' ><a class="close-template-btn ays-close-button-on-off ays-close-button-text"><?php echo $close_button_text ?></a></label>
                                        <h2 class="ays_title_template ays_title"></h2>
                                    </header>
                                    <footer class='ays_template_footer'>
                                        <div class="ays_bg_image_box"></div>
                                        <div class='ays_template_content '>
                                            <p class="desc" style="margin: 0"></p>
                                            <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", $this->plugin_name); ?></span></div>
                                            <?php echo $ays_pb_timer_desc; ?>
                                        </div>
                                    </footer>
                                </div>

                                <div id='ays-pb-screen-shade'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Limitation user start -->
            <div id="tab4" class="ays-pb-tab-content  <?php echo ($ays_pb_tab == 'tab4') ? 'ays-pb-tab-content-active' : ''; ?>">
                <p class="ays-subtitle"><?php echo  __('Limitation of Users', $this->plugin_name) ?></p>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_pb_show_only_once">
                            <span><?php echo __('Show Popup only once', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('By enabling the option, the popup will be shown  only once  per visitor. ', $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="ays_pb_show_only_once" class="onoffswitch-checkbox" id="ays_pb_show_only_once" <?php echo ($show_only_once == 'on') ? 'checked' : '' ?> >
                        </p>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-log-user">
                            <span><?php echo __('Enable for logged in users', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('By enabling the option, the popup will be shown to logged-in users.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="<?php echo $this->plugin_name; ?>[log_user]" class="onoffswitch-checkbox" id="<?php echo $this->plugin_name; ?>-log-user" <?php if($log_user == 'On'){ echo 'checked';} else { echo '';} ?> />
                        </p>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-guest">
                            <span><?php echo __('Enable for guests', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('By enabling the option, the popup will be shown to guest visitors.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="<?php echo $this->plugin_name; ?>[guest]" class="onoffswitch-checkbox" id="<?php echo $this->plugin_name; ?>-guest" <?php if($guest == 'On'){ echo 'checked';} else { echo '';} ?> />
                        </p>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays-pb-mobile">
                            <span><?php echo __('Hide popup on mobile', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Disable the popup on mobile devices.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="ays_pb_mobile" class="onoffswitch-checkbox" id="ays-pb-mobile" value='on' <?php if($ays_pb_mobile == 'on'){ echo 'checked';} else { echo '';} ?> />
                        </p>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-12 only_pro">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-top:1rem;"> 
                            <div class="col-sm-3">
                                <label for="ays_enable_tackers_count">
                                    <?php echo __('Limitation count of viewers', $this->plugin_name)?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Disable the popup after certain views.',$this->plugin_name)?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-1">
                                <input type="checkbox" class="ays-enable-timer1 ays_toggle_checkbox" id="ays_enable_tackers_count" checked/>
                            </div>
                            <div class="col-sm-8 ays_toggle_target ays_divider_left">
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="ays_tackers_count">
                                            <?php echo __('Count',$this->plugin_name)?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Specify the count of views.',$this->plugin_name)?>">
                                                <i class="ays_fa ays_fa-info-circle"></i>
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="number" id="ays_tackers_count" class="ays-enable-timerl ays-text-input">
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>    
                </div>
                <hr/>
                 <!-- Tigran -->
                 <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-users_role">
                            <span><?php echo __('Enable for certain user role', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?= __('Show the popup only to certain user role(s) mentioned in the list. Leave it blank for showing the popup to all user roles.', $this->plugin_name) ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9 ays-pb-users-roles ays_pb_users_roles">
                        <select name="<?php echo $this->plugin_name; ?>[ays_users_roles][]" id="ays_users_roles" multiple>
                            <?php
                            foreach ($ays_users_roles as $key => $user_role) {
                                $selected_role = "";
                                if(is_array($users_role)){
                                    if(in_array($user_role['name'], $users_role)){
                                        $selected_role = 'selected';
                                    }else{
                                        $selected_role = '';
                                    }
                                }else{
                                    if($users_role == $user_role['name']){
                                        $selected_role = 'selected';
                                    }else{
                                        $selected_role = '';
                                    }
                                }
                                echo "<option value='" . $user_role['name'] . "' " . $selected_role . ">" . $user_role['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <hr/>

                <!-- Tigran -->
                <div class="form-group row">
                    <div class="col-sm-12 only_pro">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-top: 1rem;">
                            <div class="col-sm-3">
                                <label for="ays-pb-users-os">
                                    <span><?php echo __('Enable for certain OS', $this->plugin_name); ?></span>
                                    <a class="ays_help" data-toggle="tooltip"
                                       title="<?= __('Show the popup only to visitors using certain Operation system(s) mentioned in the list. Leave it blank for showing the popup to all OS users.', $this->plugin_name) ?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-9 ays-pb-users-roles">
                                <select id="ays-pb-users-os" multiple>
                                    <?php
                                    foreach ($ays_users_os_array as $key => $user_os) {
                                        echo "<option value='" . $user_os . "' selected>" . $user_os . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="ays-pb-users-browser">
                                    <span><?php echo __('Enable for certain browser', $this->plugin_name); ?></span>
                                    <a class="ays_help" data-toggle="tooltip"
                                       title="<?= __('Show the popup only to visitors using certain browser(s) mentioned in the list. Leave it blank for showing the popup to all browsers users.', $this->plugin_name) ?>">
                                        <i class="ays_fa ays_fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-9 ays-pb-users-roles">
                                <select id="ays-pb-users-browser" multiple>
                                    <?php
                                    foreach ($ays_users_browser_array as $key => $user_browser) {
                                        echo "<option value='" . $user_browser . "' selected>" . $user_browser . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
            </div>
            </div>
           <!-- Limitation user end -->
            <div style="clear:both;" ></div>
            <hr/>
            <?php
            wp_nonce_field('pb_action', 'pb_action');
            $other_attributes = array();
            submit_button(__('Save Changes', $this->plugin_name), 'primary', 'ays_submit', true, $other_attributes);
            submit_button(__('Apply Changes', $this->plugin_name), '', 'ays_apply', true, $other_attributes);
            ?>
        </form>
    </div>

    <script>
        jQuery(document).ready(function(){
            jQuery(document).find('.disabled_textarea').attr('disabled', 'disabled');
            if(jQuery("#<?php echo $this->plugin_name; ?>-show_all_no").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-show_all_no").prop('checked')){
                jQuery('.ays_pb_view_place_tr').show(250);
            }
            if(jQuery("#<?php echo $this->plugin_name; ?>-show_all_yes").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-show_all_yes").prop('checked')){
                jQuery('.ays_pb_view_place_tr').hide(250);
            }
            if(jQuery("#<?php echo $this->plugin_name; ?>-modal_content_custom_html").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-modal_content_custom_html").prop('checked')){
                jQuery('#ays_custom_html').show();
                jQuery('#ays_shortcode').hide();
            }
            if(jQuery("#<?php echo $this->plugin_name; ?>-modal_content_shortcode").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-modal_content_shortcode").prop('checked')){
                jQuery('#ays_custom_html').hide();
                jQuery('#ays_shortcode').show();
            }
        });
        jQuery("#<?php echo $this->plugin_name; ?>-modal_content_custom_html").on('click', function(){
            jQuery('#ays_shortcode').hide(150);
            jQuery('#ays_custom_html').show(500)
        });
        jQuery("#<?php echo $this->plugin_name; ?>-modal_content_shortcode").on('click', function(){
            jQuery('#ays_custom_html').hide(150);
            jQuery('#ays_shortcode').show(500);
        });
        jQuery("#<?php echo $this->plugin_name; ?>-show_all_except").on('click', function(){
            jQuery('.ays_pb_view_place_tr').show(250);
        });
        jQuery("#<?php echo $this->plugin_name; ?>-show_all_selected").on('click', function(){
            jQuery('.ays_pb_view_place_tr').show(250);
        });
        jQuery("#<?php echo $this->plugin_name; ?>-show_all_yes").on('click', function(){
            jQuery('.ays_pb_view_place_tr').hide(250);
        });
    </script>
    <script>
        (function ($) {
            $(document).ready(function () {
                var a = $('.ays_help_desc');
                var ays_pb_view_type;
                var default_template_img;
                var checked = $(document).find('input#ays-enable-background-gradient').prop('checked');
                let pb_gradient_direction = $(document).find('#ays_pb_gradient_direction').val();
                var bg_img_val = '';
                if($(document).find('input#ays-pb-bg-image').val() == '') {
                    if(checked){
                        bg_img_val = $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
                    }else{
                        bg_img_val = $(document).find('.ays-pb-live-container').css({'background-image': "none"});
                    }
                }else{
                    bg_img_val = $(document).find('.ays-pb-live-container').css({'background-image': 'url('+$("#<?php echo $this->plugin_name; ?>-bg-image").val()+ ')'});
                }
                switch ($("input[name='<?php echo $this->plugin_name; ?>[view_type]']:checked").val()) {
                    case 'default':
                        $(document).find(".ays-pb-modal").css('display', 'block');
                        $(document).find(".ays-pb-modal").addClass('ays_active');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : 'cover',
                            'background-position' : 'center center'
                        });
                        changeCloseButtonPosition();
                        ays_pb_view_type = '.ays-pb-modal';
                        break;
                    case 'mac':
                        $(document).find(".ays_window").css('display', 'block');
                        $(document).find(".ays_window").addClass('ays_active');;
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : 'cover',
                            'background-position' : 'center center'
                        });
                        ays_pb_view_type = '.ays_window';
                        break;
                    case 'cmd':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'block');
                        $(document).find(".ays_cmd_window").addClass('ays_active');;
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : 'cover',
                            'background-position' : 'center center'
                        });
                        ays_pb_view_type = '.ays_cmd_window';
                        break;
                    case 'ubuntu':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'block');
                        $(document).find(".ays_ubuntu_window").addClass('ays_active');;
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : 'cover',
                            'background-position' : 'center center'
                        });
                        ays_pb_view_type = '.ays_ubuntu_window';
                        break;
                    case 'winXP':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'block');
                        $(document).find(".ays_winxp_window").addClass('ays_active');;
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : 'cover',
                            'background-position' : 'center center'
                        });
                        $(document).find('.ays_winxp_content').css({
                            'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val()
                        });
                        ays_pb_view_type = '.ays_winxp_window';
                        break;
                    case 'win98':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'block');
                        $(document).find(".ays_win98_window").addClass('ays_active');;
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : 'cover',
                            'background-position' : 'center center'
                        });
                        ays_pb_view_type = '.ays_win98_window';
                        break;
                    case 'lil':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'block');
                        $(document).find(".ays_lil_window").addClass('ays_active');;
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        ays_pb_view_type = '.ays_lil_window';
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : 'cover',
                            'background-position' : 'center center'
                        });
                        $(document).find('.ays_lil_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + ' !important');
                        $(document).find('.ays-close-button-take-text-color').css('color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + " !important");
                        $(document).find('.ays-close-button-take-text-color').css('background-color', $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important');
                        changeCloseButtonPosition();
                        break;
                    case 'image':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'block');
                        $(document).find(".ays_image_window").addClass('ays_active');;
                        $(document).find(".ays_template_window").css('display', 'none');
                        ays_pb_view_type = '.ays_image_window';
                        if ($("#<?php echo $this->plugin_name; ?>-bg-image").val() == '') {
                            default_template_img = 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg")';
                        }else{
                            default_template_img = 'url(' + $("#<?php echo $this->plugin_name; ?>-bg-image").val() + ')';
                        }
                        $(document).find('.ays_bg_image_box').css({
                            'background-image' : default_template_img,
                            'background-repeat' : 'no-repeat',
                            'background-size' : 'cover',
                            'background-position' : 'center center'
                        });
                        changeCloseButtonPosition();
                        break;
                    case 'template':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'block');
                        $(document).find(".ays_template_window").addClass('ays_active');;
                        ays_pb_view_type = '.ays_template_window';
                        $(document).find('.ays_template_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + ' !important');
                        if ($("#<?php echo $this->plugin_name; ?>-bg-image").val() == '') {
                            default_template_img = 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/girl-scaled.jpg")';
                        }else{
                            default_template_img = 'url(' + $("#<?php echo $this->plugin_name; ?>-bg-image").val() + ')';
                        }
                        $(document).find('.ays_bg_image_box').css({
                            'background-image' : default_template_img,
                            'background-repeat' : 'no-repeat',
                            'background-size' : 'cover',
                            'background-position' : 'center center'
                        });
                        changeCloseButtonPosition();
                        break;
                    default:
                        $(document).find(".ays-pb-modal").css('display', 'block');
                        $(document).find(".ays-pb-modal").addClass('ays_active');;
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : 'cover',
                            'background-position' : 'center center'
                        });
                        changeCloseButtonPosition();
                        ays_pb_view_type = '.ays-pb-modal';
                        break;
                }
                $(document).find("input[name='<?php echo $this->plugin_name; ?>[view_type]']").on('change',function () {
                    var bgImage = $("#<?php echo $this->plugin_name; ?>-bg-image").val();
                    var bgGradient = $("#ays-enable-background-gradient").prop('checked');
                    var bg_image_css = '';
                    if(bgImage != ''){
                        bg_image_css ='url(' + bgImage + ')';
                    }else if (bgGradient) {
                        var bgGradientColor1 = $("#ays-background-gradient-color-1").val();
                        var bgGradientColor2 = $("#ays-background-gradient-color-2").val();
                        var bgGradientDir = $("#ays-background-gradient-color-2").val();
                        var pb_gradient_direction;
                        switch(bgGradientDir) {
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
                        bg_image_css = 'linear-gradient('+pb_gradient_direction+', '+bgGradientColor1+', '+bgGradientColor2;
                    }
                    switch ($("input[name='<?php echo $this->plugin_name; ?>[view_type]']:checked").val()) {
                        case 'default':
                            $(document).find(".ays-pb-modal").css('display', 'block');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            ays_pb_view_type = '.ays-pb-modal';

                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px',
                                'font-family': $('#ays_pb_font_family').val(),
                            });
                            changeCloseButtonPosition();
                            break;
                        case 'mac':
                            $(document).find(".ays_window").css('display', 'block');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none')
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            ays_pb_view_type = '.ays_window';
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            break;
                        case 'cmd':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'block');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            ays_pb_view_type = '.ays_cmd_window';
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            break;
                        case 'ubuntu':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'block');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            ays_pb_view_type = '.ays_ubuntu_window';
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            break;
                        case 'winXP':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'block');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            ays_pb_view_type = '.ays_winxp_window';
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                            $(ays_pb_view_type + ' .ays_winxp_content').css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val()
                            });
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            $(ays_pb_view_type).css({
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            break;
                        case 'win98':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'block');
                            $(document).find(".ays_template_window").css('display', 'none');
                            ays_pb_view_type = '.ays_win98_window';
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            break;
                        case 'lil':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'block');
                            ays_pb_view_type = '.ays_lil_window';
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : 'url(' + $("#<?php echo $this->plugin_name; ?>-bg-image").val() + ')',
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            $(document).find('.ays_lil_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + ' !important');
                            $(document).find('.ays-close-button-take-text-color').css('background-color', $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important');
                            $(document).find('.ays-close-button-take-text-color').css('color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + " !important");
                            changeCloseButtonPosition();
                            break;
                        case 'image':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'block');
                            $(document).find(".ays_template_window").css('display', 'none');
                            ays_pb_view_type = '.ays_image_window';
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                // 'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            // var bg_img_default = $("#<?php //echo $this->plugin_name; ?>-bg-image").val();
                            // if(!bg_img_default)
                                bg_img_default="https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg";
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : 'url('+ bg_img_default +')',
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            changeCloseButtonPosition();
                            break;
                        case 'template':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'block');
                            ays_pb_view_type = '.ays_template_window';
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            $(document).find('.ays_template_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + ' !important');
                            var bg_img_default = $("#<?php echo $this->plugin_name; ?>-bg-image").val();
                            if(!bg_img_default)
                                bg_img_default="https://quiz-plugin.com/wp-content/uploads/2020/02/girl-scaled.jpg";
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : 'url(' + bg_img_default + ')',
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            changeCloseButtonPosition();
                            break;
                        default:
                            $(document).find(".ays-pb-modal").css('display', 'block');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : 'url(' + $("#<?php echo $this->plugin_name; ?>-bg-image").val() + ')',
                                'background-repeat' : 'no-repeat',
                                'background-size' : 'cover',
                                'background-position' : 'center center'
                            });
                            ays_pb_view_type = '.ays-pb-modal';
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            changeCloseButtonPosition();
                            break;
                    }
                });
                $('[data-toggle="tooltip"]').tooltip();
                $(ays_pb_view_type).css({
                    'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                    'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                    'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                    'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px',
                    'font-family': $('#ays_pb_font_family').val(),
                });

                $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                $(document).find(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());

                $(document).find("#<?php echo $this->plugin_name; ?>-popup_title").on('change', function () {
                    $(ays_pb_view_type + ' .ays_title').html($("#<?php echo $this->plugin_name; ?>-popup_title").val());
                });
                $(document).find("#<?php echo $this->plugin_name; ?>-popup_description").on('change', function () {
                    $(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                });
                $(document).find("#ays-pb-close-button-text").on('change', function () {
                    let $this      = $(document).find('.ays-pb-modal .ays-close-button-text');
                    let buttonText = $(this).val();
                    if (buttonText == '') {
                        buttonText = 'x'
                    }
                    $(document).find('.ays-close-button-text').html(buttonText);
                    if ($this.hasClass('fa-2x')) {
                        if (buttonText == 'x' || buttonText == '') {
                            if ($this.hasClass('ays_fa-close-button')) {
                                $this.removeClass('ays_fa-close-button');
                            }
                            setTimeout(function(){
                                $(document).find('.ays-pb-modal .ays-close-button-text').html('');
                            },500);
                            $this.addClass('fa-times');
                        }else{
                            $this.removeClass('ays_fa-close-button fa-times');
                        }
                    }
                    if ((buttonText == 'x' || buttonText == '') && $(document).find('a.close-lil-btn').hasClass('close-lil-btn-text')) {
                        $(document).find('a.close-lil-btn').removeClass('close-lil-btn-text');
                    }
                    else if (!$(document).find('a.close-lil-btn').hasClass('close-lil-btn-text')){
                        if (buttonText != '') {
                            $(document).find('a.close-lil-btn').addClass('close-lil-btn-text');
                        }
                    }
                });

                $(document).find("#ays-pb-close-button-position").on('change',function(){
                    changeCloseButtonPosition()
                });

                function changeCloseButtonPosition(){
                    let position = $(document).find('#ays-pb-close-button-position').val();
                    let ays_pb_radius = Math.abs($(document).find('#ays-pb-ays_pb_bordersize').val());
                    let checkedTheme = $(document).find("input[name='<?php echo $this->plugin_name; ?>[view_type]']:checked").val();
                    let tb,tb_value,rl,rl_value,auto_1,auto_2,res;
                    let ays_pb_checked_theme_class = '';
                    switch(checkedTheme){
                        case "lil": //top 3 right 3 
                            ays_pb_checked_theme_class = ".ays_lil_window .close-lil-btn";
                            switch(position){
                                case "left-top":
                                    tb = "top"; tb_value = "10px";
                                    rl = "left"; rl_value = "10px";
                                    auto_1 = 'bottom'; auto_2 = 'right';
                                    break;
                                case "left-bottom":
                                    tb = "bottom"; tb_value = "10px";
                                    rl = "left"; rl_value = "10px";
                                    auto_1 = 'top'; auto_2 = 'right';
                                    break;
                                case "right-bottom":
                                    tb = "bottom"; tb_value = "10px";
                                    rl = "right"; rl_value = "10px";
                                    auto_1 = 'top'; auto_2 = 'left';
                                    break;
                                default:
                                    tb = "top"; tb_value = "10px";
                                    rl = "right"; rl_value = "10px";
                                    auto_1 = 'bottom'; auto_2 = 'left';
                            }
                            break;
                        case "image"://top -20px right 0
                            ays_pb_checked_theme_class = ".ays_image_window .close-image-btn";
                             switch(position){
                                case "left-top":
                                    res = -20 - ays_pb_radius;
                                    tb = "top"; tb_value = res+"px";
                                    rl = "left"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'bottom'; auto_2 = 'right';
                                    break;
                                case "left-bottom":
                                    res = -20 - ays_pb_radius;
                                    tb = "bottom"; tb_value = res+"px";
                                    rl = "left"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'top'; auto_2 = 'right';
                                    break;
                                case "right-bottom":
                                    res = -20 - ays_pb_radius;
                                    tb = "bottom"; tb_value = res+"px";
                                    rl = "right"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'top'; auto_2 = 'left';
                                    break;
                                default:
                                    res = -20 - ays_pb_radius;
                                    tb = "top"; tb_value = res+"px";
                                    rl = "right"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'bottom'; auto_2 = 'left';
                            }
                            break;
                        case "template"://top 0 right 7px 
                            ays_pb_checked_theme_class = ".ays_template_window .close-template-btn";
                            switch(position){
                                case "left-top":
                                    tb = "top"; tb_value = "14px";
                                    rl = "left"; rl_value = "14px";
                                    auto_1 = 'bottom'; auto_2 = 'right';
                                    break;
                                case "left-bottom":
                                    tb = "bottom"; tb_value = "7px";
                                    rl = "left"; rl_value = "14px";
                                    auto_1 = 'top'; auto_2 = 'right';
                                    break;
                                case "right-bottom":
                                    tb = "bottom"; tb_value = "7px";
                                    rl = "right"; rl_value = "14px";
                                    auto_1 = 'top'; auto_2 = 'left';
                                    break;
                                default:
                                    tb = "top"; tb_value = "14px";
                                    rl = "right"; rl_value = "14px";
                                    auto_1 = 'bottom'; auto_2 = 'left';
                            }
                            break;
                        case "default"://top 0 right 10px 
                            ays_pb_checked_theme_class = ".ays-pb-modal .ays-pb-modal-close";
                            switch(position){
                                case "left-top":
                                    tb = "top"; tb_value = "0";
                                    rl = "left"; rl_value = "10px";
                                    auto_1 = 'bottom'; auto_2 = 'right';
                                    break;
                                case "left-bottom":
                                    tb = "bottom"; tb_value = "10px";
                                    rl = "left"; rl_value = "10px";
                                    auto_1 = 'top'; auto_2 = 'right';
                                    break;
                                case "right-bottom":
                                    tb = "bottom"; tb_value = "10px";
                                    rl = "right"; rl_value = "10px";
                                    auto_1 = 'top'; auto_2 = 'left';
                                    break;
                                default:
                                    tb = "top"; tb_value = "0";
                                    rl = "right"; rl_value = "10px";
                                    auto_1 = 'bottom'; auto_2 = 'left';
                            }
                            break;
                        default:
                            ays_pb_checked_theme_class = '';
                            tb = "top"; tb_value = "0";
                            rl = "right"; rl_value = "0";
                            auto_1 = 'bottom'; auto_2 = 'left';
                    }
                    $(document).find(ays_pb_checked_theme_class).css(tb,tb_value).css(rl,rl_value).css(auto_1,'auto').css(auto_2,'auto');
                }

                var optionsForBgColor = {
                    change: function (e) {
                        if (ays_pb_view_type == '.ays_winxp_window') {
                            $(ays_pb_view_type + ' .ays_winxp_content').css('background-color', e.target.value);
                        } else {
                            $(ays_pb_view_type).css('background-color', e.target.value);
                        }
                    }
                }

                var optionsForTextColor = {
                    change: function (e) {
                        $(document).find('.ays-close-button-take-text-color').css('background-color', e.target.value + " !important");
                        $(ays_pb_view_type).css('color', e.target.value + " !important");
                    }
                }

                var optionsForBorderColor = {
                    change: function (e) {
                        $(ays_pb_view_type).css('border-color', e.target.value);
                    }
                }

                var optionsForOverlayColor = {
                    change: function (e) {
                            $(document).find('.ays-pb-modals').css('background-color', e.target.value + " !important");
                    }
                }

                var optionsForBgHeader = {
                    change: function (e) {
                        $(document).find('.ays_lil_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val()+ " !important");
                        $(document).find('.ays_template_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val()+ " !important");
                        $(document).find('.ays-close-button-take-text-color').css('color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + " !important");
                    }
                }

                $(document).find('.ays_pb_bgcolor_change').wpColorPicker(optionsForBgColor);
                $(document).find('.ays_pb_textcolor_change').wpColorPicker(optionsForTextColor);
                $(document).find('.ays_pb_bordercolor_change').wpColorPicker(optionsForBorderColor);
                $(document).find('.ays_pb_overlay_color_change').wpColorPicker(optionsForOverlayColor);
                $(document).find('#<?php echo $this->plugin_name; ?>-header_bgcolor').wpColorPicker(optionsForBgHeader);

                $(document).find("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").on('change', function () {
                    $(ays_pb_view_type).css('color', $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important');
                });

                $(document).find("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").on('change', function () {
                    let ays_pb_radius = Math.abs($(this).val());
                    let ays_pb_bottom = (-40 - ays_pb_radius);
                    let closeBtnPosition = $(document).find('#ays-pb-close-button-position').val();
                    let tb,tb_value,rl,rl_value,auto_1,auto_2,res;
                    $(ays_pb_view_type).css('border', $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val());
                    $(document).find('.ays-pb-live-container.ays_image_window .ays_pb_timer').css('bottom', ays_pb_bottom+'px');
                    switch(closeBtnPosition){
                         case "left-top":
                            res = -20 - ays_pb_radius;
                            tb = "top"; tb_value = res+"px";
                            rl = "left"; rl_value = -ays_pb_radius+"px";
                            auto_1 = 'bottom'; auto_2 = 'right';
                            break;
                        case "left-bottom":
                            res = -20 - ays_pb_radius;
                            tb = "bottom"; tb_value = res+"px";
                            rl = "left"; rl_value = -ays_pb_radius+"px";
                            auto_1 = 'top'; auto_2 = 'right';
                            break;
                        case "right-bottom":
                            res = -20 - ays_pb_radius;
                            tb = "bottom"; tb_value = res+"px";
                            rl = "right"; rl_value = -ays_pb_radius+"px";
                            auto_1 = 'top'; auto_2 = 'left';
                            break;
                        default:
                            res = -20 - ays_pb_radius;
                            tb = "top"; tb_value = res+"px";
                            rl = "right"; rl_value = -ays_pb_radius+"px";
                            auto_1 = 'bottom'; auto_2 = 'left';
                    }
                    $(document).find('.ays-pb-live-container .close-image-btn').css(tb,tb_value).css(rl,rl_value).css(auto_1,'auto').css(auto_2,'auto');

                });
                $(document).find("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").on('change', function () {
                    $(ays_pb_view_type).css('border-radius', $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px');
                });
                $(document).find("#<?php echo $this->plugin_name; ?>-animate_in").on('change', function () {
                    let animation_speed = Math.abs($(document).find('#ays_pb_animation_speed').val() ) +"s";
                    $(ays_pb_view_type).css('animation', $("#<?php echo $this->plugin_name; ?>-animate_in").val() + " " + animation_speed);
                });
                $(document).find("#<?php echo $this->plugin_name; ?>-animate_out").on('change', function () {
                    let animation_speed = Math.abs($(document).find('#ays_pb_animation_speed').val() ) +"s";
                    $(ays_pb_view_type).css('animation', $("#<?php echo $this->plugin_name; ?>-animate_out").val() + " " + animation_speed);
                });
                $(document).find("#ays_pb_font_family").on('change', function () {
                    $(ays_pb_view_type).css('font-family', $('#ays_pb_font_family').val());
                });
                $(document).find("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").on('change', function () {
                    $(ays_pb_view_type).css('border', $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px solid " + $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val());
                });
                $(document).find("#ays-active ,#ays-deactive").on('click',function(){
                    $(document).find("#ui-datepicker-div").css('z-index', '10010');
                });
                <?php if ($close_button == "on"){
                    echo  '$(document).find(".ays-close-button-on-off").css("display","none")' ;
                } ?>
            });
        })(jQuery);
    </script>