<?php
ob_start();
class Ays_PopupBox_List_Table extends WP_List_Table {
    private $plugin_name;
    /** Class constructor */
    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
        parent::__construct( [
            "singular" => __( "PopupBox", $this->plugin_name ), //singular name of the listed records
            "plural"   => __( "PopupBoxes", $this->plugin_name ), //plural name of the listed records
            "ajax"     => false //does this table support ajax?
        ] );
        add_action( "admin_notices", array( $this, "popupbox_notices" ) );

    }


    /**
     * Retrieve customers data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    public static function get_ays_popupboxes( $per_page = 5, $page_number = 1 ) {

        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_pb";

        if ( ! empty( $_REQUEST["orderby"] ) ) {
            $sql .= " ORDER BY " . esc_sql( $_REQUEST["orderby"] );
            $sql .= ! empty( $_REQUEST["order"] ) ? " " . esc_sql( $_REQUEST["order"] ) : "DESC";
        }else {
			$sql .= ' ORDER BY id DESC';
		}

        $sql .= " LIMIT $per_page";
        $sql .= " OFFSET " . ( $page_number - 1 ) * $per_page;


        $result = $wpdb->get_results( $sql, "ARRAY_A" );

        return $result;
    }

    private function get_max_id() {
        global $wpdb;
        $pb_table = $wpdb->prefix."ays_pb";

        $sql = "SELECT max(id) FROM {$pb_table}";

        $result = $wpdb->get_var($sql);

        return $result;
    }

    public function publish_unpublish_popupbox( $id, $action ) {
        global $wpdb;
        $pb_table = $wpdb->prefix."ays_pb";
       
        if ($id == null) {
            return false;
        }
        if ($action == 'unpublish') {
            $onoffswitch = 'Off';
            $message = 'unpublished';
        }else{
            $onoffswitch = 'On';
            $message = 'published';
        }

        $pb_result = $wpdb->update(
                $pb_table,
                array(
                    "onoffswitch" => $onoffswitch
                ),
                array( "id" => $id ),
                array( "%s" ),
                array( "%d" )
            );

        $url = esc_url_raw( remove_query_arg(["action", "popupbox", "_wpnonce"]) ) . "&status=" . $message . "&type=success";
        wp_redirect( $url );
    }

    public function duplicate_popupbox( $id ){
        global $wpdb;
        $pb_table = $wpdb->prefix."ays_pb";
        $popup = $this->get_popupbox_by_id($id);

        $user_id = get_current_user_id();
        $user = get_userdata($user_id);
        $author = array(
            'id' => $user->ID,
            'name' => $user->data->display_name
        );

        $max_id = $this->get_max_id();

        $options = json_decode($popup['options'], true);

        $options['create_date'] = date("Y-m-d H:i:s");
        $options['author'] = $author;

        $result = $wpdb->insert(
            $pb_table,
            array(
                "title"         	            => "Copy - ".$popup['title'],
                "description"   	            => $popup['description'],
                "autoclose"  		            => intval($popup['autoclose']),
                "cookie"   			            => intval($popup['cookie']),
                "width"         	            => intval($popup['width']),
                "height"        	            => intval($popup['height']),
                "bgcolor"        	            => $popup['bgcolor'],
                "textcolor"        	            => $popup['textcolor'],
                "bordersize"      	            => abs(intval($popup['bordersize'])),
                "bordercolor"     	            => $popup['bordercolor'],
                "border_radius"    	            => abs(intval($popup['border_radius'])),
                "shortcode"        	            => $popup['shortcode'],
                "custom_class"                  => $popup['custom_class'],
                "custom_css"                    => $popup['custom_css'],
                "custom_html"                   => $popup['custom_html'],
                "onoffswitch"                   => $popup['onoffswitch'],
                "show_all"                      => $popup['show_all'],
                "delay"                         => abs(intval($popup['delay'])),
                "scroll_top"                    => intval($popup['scroll_top']),
                "animate_in"                    => $popup['animate_in'],
                "animate_out"                   => $popup['animate_out'],
                "action_button"                 => $popup['action_button'],
                "view_place"                    => $popup['view_place'],
                "action_button_type"            => $popup['action_button_type'],
                "modal_content"                 => $popup['modal_content'],
                "view_type"                     => $popup['view_type'],
                "onoffoverlay"                  => $popup['onoffoverlay'],
                "show_popup_title"              => $popup['show_popup_title'],
                "show_popup_desc"               => $popup['show_popup_desc'],
                "close_button"                  => $popup['close_button'],
                "header_bgcolor"  	            => $popup['header_bgcolor'],
                "bg_image"  	                => $popup['bg_image'],
                "log_user"                      => $popup['log_user'],
                "guest"                         => $popup['guest'],
                'active_date_check'             => $popup['active_date_check'],
                'activeInterval'                => $popup['activeInterval'],
                'deactiveInterval'              => $popup['deactiveInterval'],
                'options'                       => $popup['options']
            ),
            array(
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',

            )
        );
        if( $result >= 0 ){
            $message = "duplicated";
            $url = esc_url_raw( remove_query_arg(array('action', 'popupbox')  ) ) . '&status=' . $message;
            wp_redirect( $url );
        }

    }

    public function get_popupbox_by_id( $id ){
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_pb WHERE id=" . absint( intval( $id ) ). " ORDER BY id ASC";

        $result = $wpdb->get_row($sql, "ARRAY_A");

        return $result;
    }

    public function add_or_edit_popupbox($data){

		global $wpdb;
		$pb_table = $wpdb->prefix . "ays_pb";
		$id             = ( $data["id"] != NULL ) ? absint( intval( $data["id"] ) ) : null;
		$width          = absint( intval( $data['ays-pb']["width"] ) );
		$height         = absint( intval( $data['ays-pb']["height"] ) );
		$autoclose      = absint( intval( $data['ays-pb']["autoclose"] ) );
		$cookie     	= absint( intval( $data['ays-pb']["cookie"] ) );
		$title          = wp_unslash(sanitize_text_field( $data['ays-pb']["popup_title"] ));
		$shortcode      = wp_unslash(sanitize_text_field( $data['ays-pb']["shortcode"] ));
		$description	= stripslashes( $data['ays-pb']["popup_description"] );
		$bgcolor        = wp_unslash(sanitize_text_field( $data['ays-pb']["bgcolor"] ));
		$textcolor      = wp_unslash(sanitize_text_field( $data['ays-pb']["ays_pb_textcolor"] ));
		$bordersize     = wp_unslash(sanitize_text_field( $data['ays-pb']["ays_pb_bordersize"] ));
		$bordercolor    = wp_unslash(sanitize_text_field( $data['ays-pb']["ays_pb_bordercolor"] ));
		$border_radius  = wp_unslash(sanitize_text_field( $data['ays-pb']["ays_pb_border_radius"] ));
        // $custom_class   = wp_unslash(sanitize_text_field( $data['ays-pb']["custom-class"] ));
		$custom_css     = wp_unslash(sanitize_text_field( $data['ays-pb']["custom-css"] ));
		$custom_html    = stripslashes($data['ays-pb']["custom_html"]);
		$show_all       = wp_unslash(sanitize_text_field( $data['ays-pb']["show_all"] ));
		$delay          = wp_unslash(sanitize_text_field( $data['ays-pb']["delay"] ));
		$scroll_top     = wp_unslash(sanitize_text_field( $data['ays-pb']["scroll_top"] ));
		$animate_in     = wp_unslash(sanitize_text_field( $data['ays-pb']["animate_in"] ));
		$animate_out    = wp_unslash(sanitize_text_field( $data['ays-pb']["animate_out"] ));
		$action_button  = wp_unslash(sanitize_text_field( $data['ays-pb']["action_button"] ));
		$action_button_type  = wp_unslash(sanitize_text_field( $data['ays-pb']["action_button_type"] ));
		$modal_content  = wp_unslash(sanitize_text_field( $data['ays-pb']["modal_content"] ));
		$view_type      = wp_unslash(sanitize_text_field( $data['ays-pb']["view_type"] ));
        $header_bgcolor        = wp_unslash(sanitize_text_field( $data['ays-pb']["header_bgcolor"] ));
        $bg_image              = wp_http_validate_url($data['ays_pb_bg_image']);


        // Schedule Popup
        $active_date_check = (isset($data['active_date_check']) && $data['active_date_check'] == "on") ? 'on' : 'off';
        $activeInterval = isset($data['ays-active']) ? $data['ays-active'] : "";
        $deactiveInterval = isset($data['ays-deactive']) ? $data['ays-deactive'] : "";

        // Custom class for quiz container
        $custom_class = (isset($data['ays-pb']["custom-class"]) && $data['ays-pb']["custom-class"] != "") ? $data['ays-pb']["custom-class"] : '';
        $users_role = (isset($data['ays-pb']["ays_users_roles"]) && !empty($data['ays-pb']["ays_users_roles"])) ? $data['ays-pb']["ays_users_roles"] : array();

        // Background gradient
        $enable_background_gradient = ( isset( $data['ays_enable_background_gradient'] ) && $data['ays_enable_background_gradient'] == 'on' ) ? 'on' : 'off';
        $pb_background_gradient_color_1 = !isset($data['ays_background_gradient_color_1']) ? '' : $data['ays_background_gradient_color_1'];
        $pb_background_gradient_color_2 = !isset($data['ays_background_gradient_color_2']) ? '' : $data['ays_background_gradient_color_2'];
        $pb_gradient_direction = !isset($data['ays_pb_gradient_direction']) ? '' : $data['ays_pb_gradient_direction'];

        //Posts
        $except_types          = isset($data['ays_pb_except_post_types']) ? ($data['ays_pb_except_post_types']) : array();
        $except_posts          = isset($data['ays_pb_except_posts']) ? ($data['ays_pb_except_posts']) : array();

        //Close button delay
        $close_button_delay = (isset($data['ays_pb_close_button_delay']) && $data['ays_pb_close_button_delay'] != '') ? abs(intval($data['ays_pb_close_button_delay'])) : '';

        // Enable PopupBox sound option
        $enable_pb_sound = (isset($data['ays_pb_enable_sounds']) && $data['ays_pb_enable_sounds'] == "on") ? 'on' : 'off';

        //Overlay Color
        $overlay_color = (isset($data['ays_pb_overlay_color']) && $data['ays_pb_overlay_color'] != '') ? $data['ays_pb_overlay_color'] : '#000';
        //Animation speed
        $animation_speed = (isset($data['ays_pb_animation_speed']) && $data['ays_pb_animation_speed'] != '') ? abs(intval($data['ays_pb_animation_speed'])) : 1;

        //Hide popup on mobile
        $pb_mobile = (isset($data['ays_pb_mobile']) && $data['ays_pb_mobile'] == 'on') ? 'on' : 'off';

        //Close button text
        $close_button_text = (isset($data['ays_pb_close_button_text']) && $data['ays_pb_close_button_text'] != '') ? $data['ays_pb_close_button_text'] : 'x';

        // PopupBox max-width for mobile option
        $mobile_max_width = (isset($data['ays_pb_mobile_max_width']) && $data['ays_pb_mobile_max_width'] != "") ?abs(intval($data['ays_pb_mobile_max_width']))  : '';

        $close_button_position = (isset($data['ays_pb_close_button_position']) && $data['ays_pb_close_button_position'] != '') ? $data['ays_pb_close_button_position'] : 'right-top';

        //Show PopupBox only once
        $show_only_once = (isset($data['ays_pb_show_only_once']) && $data['ays_pb_show_only_once'] == 'on') ? 'on' : 'off';
       
        //Show only on home page
        $show_on_home_page = (isset($data['ays_pb_show_on_home_page']) && $data['ays_pb_show_on_home_page'] == 'on') ? 'on' : 'off';

        //close popup by esc
        $close_popup_esc = (isset($data['close_popup_esc']) && $data['close_popup_esc'] == 'on') ? 'on' : 'off';

        //popup width with percentage
        $popup_width_by_percentage_px = (isset($data['ays_popup_width_by_percentage_px']) && $data['ays_popup_width_by_percentage_px'] != '') ? $data['ays_popup_width_by_percentage_px'] : 'pixels';

        //font-family
        $pb_font_family = (isset($data['ays_pb_font_family']) && $data['ays_pb_font_family'] != '') ? $data['ays_pb_font_family'] : 'initial';
        
        //close popup by clicking overlay
        $close_popup_overlay = (isset($data['close_popup_overlay']) && $data['close_popup_overlay'] == 'on') ? $data['close_popup_overlay'] : 'off';

       //open full screen
       $enable_pb_fullscreen = (isset($data['enable_pb_fullscreen']) && $data['enable_pb_fullscreen'] == 'on') ? 'on' : 'off';
       
       //hide timer
       $enable_hide_timer = (isset($data['ays_pb_hide_timer']) && $data['ays_pb_hide_timer'] == 'on') ? 'on' : 'off';

       // --------- Check & get post type-----------         
            $post_type_for_allfeld = array();
            if (isset($data['ays_pb_except_post_types'])) {
                $all_post_types = $data['ays_pb_except_post_types'];              
                if (isset($data["ays_pb_except_posts"])) {
                    foreach ($all_post_types as $post_type) {
                        $all_posts = get_posts( array(
                        'numberposts' => -1,            
                        'post_type'   => $post_type,
                        'suppress_filters' => true,
                        ));

                        if (!empty($all_posts)) {
                            foreach ($all_posts as $posts_value) {
                                if (in_array($posts_value->ID, $data["ays_pb_except_posts"])) {
                                    $not_post_type = false;
                                    break;
                                }else{
                                    $not_post_type = true;
                                }                   
                            }

                            if ($not_post_type) {
                                $post_type_for_allfeld[] = $post_type;
                            }
                        }else{
                            $post_type_for_allfeld[] = $post_type;
                        }
                        
                    }
                }else{
                    $post_type_for_allfeld = $all_post_types;
                }
                
            }

// --------- end Check & get post type-----------   


        if($data['ays-pb']["onoffswitch"] == 'on'){
			$switch = 'On';
		}else{ $switch = 'Off';}

        if($data['ays-pb']["log_user"] == 'on'){
            $log_user = 'On';
        }else{ $log_user = 'Off';}

        if($data['ays-pb']["guest"] == 'on'){
            $guest = 'On';
        }else{ $guest = 'Off';}

		if(isset($data['ays-pb']["close_button"]) && $data['ays-pb']["close_button"] == 'on'){
			$closeButton = 'on';
		}else{ $closeButton = 'off';}

        if($data['ays-pb']["onoffoverlay"] == 'on'){
            $switchoverlay = 'On';
        }else{ $switchoverlay = 'Off';}

        if($data["show_popup_title"] == 'on'){
            $showPopupTitle = 'On';
        }else{ $showPopupTitle = 'Off';}

        if($data["show_popup_desc"] == 'on'){
            $showPopupDesc = 'On';
        }else{ $showPopupDesc = 'Off';}

        if($show_all == 'yes'){
            $view_place = '';
        }else{
            $view_place = isset($data['ays-pb']["ays_pb_view_place"]) ? sanitize_text_field( implode( "***", $data['ays-pb']["ays_pb_view_place"] ) ) : '';
        }
        $JSON_user_role = json_encode($users_role);

        $options = array(
            'enable_background_gradient'    => $enable_background_gradient,
            'background_gradient_color_1'   => $pb_background_gradient_color_1,
            'background_gradient_color_2'   => $pb_background_gradient_color_2,
            'pb_gradient_direction'         => $pb_gradient_direction,
            'except_post_types'             => $except_types,
            'except_posts'                  => $except_posts,
            'all_posts'                     => (empty($post_type_for_allfeld) ? '' : $post_type_for_allfeld),
            'close_button_delay'            => $close_button_delay,
            'enable_pb_sound'               => $enable_pb_sound,
            'overlay_color'                 => $overlay_color,
            'animation_speed'               => $animation_speed,
            'pb_mobile'                     => $pb_mobile,
            'close_button_text'             => $close_button_text,
            'mobile_max_width'              => $mobile_max_width,
            'close_button_position'         => $close_button_position,
            'show_only_once'                => $show_only_once,
            'show_on_home_page'             => $show_on_home_page,
            'close_popup_esc'               => $close_popup_esc,
            'popup_width_by_percentage_px'  => $popup_width_by_percentage_px,
            'pb_font_family'                => $pb_font_family,
            'close_popup_overlay'           => $close_popup_overlay,
            'enable_pb_fullscreen'          => $enable_pb_fullscreen,
            'enable_hide_timer'             => $enable_hide_timer,
        );

        $submit_type = (isset($data['submit_type'])) ?  $data['submit_type'] : '';
        
		if( $id == null ){
			$pb_result = $wpdb->insert(
				$pb_table,
				array(
					"title"         	            => $title,
					"description"   	            => $description,
					"autoclose"  		            => $autoclose,
					"cookie"   			            => $cookie,
					"width"         	            => $width,
					"height"        	            => $height,
					"bgcolor"        	            => $bgcolor,
                    "textcolor"        	            => $textcolor,
                    "bordersize"      	            => $bordersize,
                    "bordercolor"     	            => $bordercolor,
                    "border_radius"    	            => $border_radius,
					"shortcode"        	            => $shortcode,
                    "custom_class"                  => $custom_class,
					"custom_css"                    => $custom_css,
					"custom_html"                   => $custom_html,
					"onoffswitch"                   => $switch,
					"show_all"                      => $show_all,
                    "delay"                         => $delay,
                    "scroll_top"                    => $scroll_top,
                    "animate_in"                    => $animate_in,
                    "animate_out"                   => $animate_out,
                    "action_button"                 => $action_button,
                    "view_place"                    => $view_place,
                    "action_button_type"            => $action_button_type,
                    "modal_content"                 => $modal_content,
                    "view_type"                     => $view_type,
                    "onoffoverlay"                  => $switchoverlay,
                    "show_popup_title"              => $showPopupTitle,
                    "show_popup_desc"               => $showPopupDesc,
                    "close_button"                  => $closeButton,
                    "header_bgcolor"  	            => $header_bgcolor,
                    'bg_image'                      => $bg_image,
                    'log_user'                      => $log_user,
                    'guest'                         => $guest,
                    'active_date_check'             => $active_date_check,
                    'activeInterval'                => $activeInterval,
                    'deactiveInterval'              => $deactiveInterval,
                    "users_role"                    => $JSON_user_role,
                    "options"                       => json_encode($options),
				),
				array( "%s", "%s", "%d", "%d", "%d", "%d", "%s", "%s", "%d", "%s", "%d", "%s", "%s", "%s", "%s", "%s", "%s", "%d", "%d", "%s", "%s", "%s", "%s", "%s", "%s", "%s","%s","%s" )
			);
			$message = "created";
		}else{
			$pb_result = $wpdb->update(
				$pb_table,
				array(
					"title"         	            => $title,
					"description"   	            => $description,
					"autoclose"  		            => $autoclose,
					"cookie"   			            => $cookie,
					"width"         	            => $width,
					"height"        	            => $height,
					"bgcolor"        	            => $bgcolor,
                    "textcolor"        	            => $textcolor,
                    "bordersize"      	            => $bordersize,
                    "bordercolor"     	            => $bordercolor,
                    "border_radius"    	            => $border_radius,
					"shortcode"        	            => $shortcode,
                    "custom_class"                  => $custom_class,
					"custom_css"                    => $custom_css,
					"custom_html"                   => $custom_html,
					"onoffswitch"                   => $switch,
					"show_all"                      => $show_all,
                    "delay"                         => $delay,
                    "scroll_top"                    => $scroll_top,
                    "animate_in"                    => $animate_in,
                    "animate_out"                   => $animate_out,
                    "action_button"                 => $action_button,
                    "view_place"                    => $view_place,
                    "action_button_type"            => $action_button_type,
                    "modal_content"                 => $modal_content,
                    "view_type"                     => $view_type,
                    "onoffoverlay"                  => $switchoverlay,
                    "show_popup_title"              => $showPopupTitle,
                    "show_popup_desc"               => $showPopupDesc,
                    "close_button"                  => $closeButton,
                    "header_bgcolor"                => $header_bgcolor,
                    'bg_image'                      => $bg_image,
                    'log_user'                      => $log_user,
                    'guest'                         => $guest,
                    'active_date_check'             => $active_date_check,
                    'activeInterval'                => $activeInterval,
                    'deactiveInterval'              => $deactiveInterval,
                    "users_role"                    => $JSON_user_role,
                    "options"                       => json_encode($options),
				),
				array( "id" => $id ),
				array( "%s", "%s", "%d", "%d", "%d", "%d", "%s", "%s", "%d", "%s", "%d", "%s", "%s", "%s", "%s", "%s", "%s", "%d", "%d", "%s", "%s", "%s", "%s", "%s", "%s", "%s","%s","%s" ),
				array( "%d" )
			);
			$message = "updated";
		}

        $ays_pb_tab = isset($data['ays_pb_tab']) ? $data['ays_pb_tab'] : 'tab1';
		if( $pb_result >= 0 ){
			if($submit_type != ''){
                if($id == null){
                    $url = esc_url_raw( add_query_arg( array(
                        "action"    => "edit",
                        "popupbox"      => $wpdb->insert_id,
                        "ays_pb_tab"  => $ays_pb_tab,
                        "status"    => $message
                    ) ) );
                }else{
                    $url = esc_url_raw( add_query_arg( array(
                        "ays_pb_tab"  => $ays_pb_tab,
                        "status"    => $message
                    ) ) );
//                    $url = esc_url_raw( remove_query_arg(false) ) . 'ays_pb_tab='.$ays_pb_tab."&status=" . $message . "&type=success";
                }
                wp_redirect( $url );
            }else{
                $url = esc_url_raw( remove_query_arg(["action", "popupbox"]  ) ) . "&status=" . $message . "&type=success";
                wp_redirect( $url );
            }
		}
    }



    /**
     * Delete a customer record.
     *
     * @param int $id customer ID
     */
    public static function delete_popupboxes( $id ) {
        global $wpdb;
        $wpdb->delete(
            "{$wpdb->prefix}ays_pb",
            [ "id" => $id ],
            [ "%d" ]
        );
    }


    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count() {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}ays_pb";

        return $wpdb->get_var( $sql );
    }


    /** Text displayed when no customer data is available */
    public function no_items() {
       echo __( "There are no popupboxes yet.", $this->plugin_name );
    }


    /**
     * Render a column when no column specific method exist.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case "title":
            case "onoffswitch":
                return wp_unslash($item[ $column_name ]);
                break;
            case "shortcode":
            case "id":
                return $item[ $column_name ];
                break;
            default:
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            "<input type='checkbox' name='bulk-delete[]' value='%s' />", $item["id"]
        );
    }


    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    function column_title( $item ) {
        $delete_nonce = wp_create_nonce( $this->plugin_name . "-delete-popupbox" );
        $unpublish_nonce = wp_create_nonce( $this->plugin_name . "-unpublish-popupbox" );
        $publish_nonce = wp_create_nonce( $this->plugin_name . "-publish-popupbox" );
        
        if (isset($item['onoffswitch']) && $item['onoffswitch'] == 'On') {
            $publish_button = 'unpublish';
            $publish_button_val = sprintf( '<a href="?page=%s&action=%s&popupbox=%d&_wpnonce=%s">'. __('Unpublish', $this->plugin_name) .'</a>', esc_attr( $_REQUEST['page'] ), 'unpublish', absint( $item['id'] ), $unpublish_nonce );
        }else{
            $publish_button = 'publish';
            $publish_button_val = sprintf( '<a href="?page=%s&action=%s&popupbox=%d&_wpnonce=%s">'. __('Publish', $this->plugin_name) .'</a>', esc_attr( $_REQUEST['page'] ), 'publish', absint( $item['id'] ), $publish_nonce );
        }

        $title = sprintf( "<a href='?page=%s&action=%s&popupbox=%d'>".$item["title"]."</a>", esc_attr( $_REQUEST["page"] ), "edit", absint( $item["id"] ) );

        $pb_title = Ays_Pb_Admin::ays_pb_restriction_string("word",$item["title"], 5);

        $actions = [
            "edit" => sprintf( "<a href='?page=%s&action=%s&popupbox=%d'>". __( 'Edit' ) ."</a>", esc_attr( $_REQUEST["page"] ), "edit", absint( $item["id"] ) ),
            'duplicate' => sprintf( '<a href="?page=%s&action=%s&popupbox=%d">'. __('Duplicate', $this->plugin_name) .'</a>', esc_attr( $_REQUEST['page'] ), 'duplicate', absint( $item['id'] ) ),

            $publish_button => $publish_button_val,

            'delete' => sprintf( '<a class="ays_pb_confirm_del" data-message="%s" href="?page=%s&action=%s&popupbox=%d&_wpnonce=%s">'. __('Delete', $this->plugin_name) .'</a>', $pb_title, esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
        ];

        return $title . $this->row_actions( $actions );
    }

    function column_shortcode( $item ) {
        return sprintf("<input type='text' onClick='this.setSelectionRange(0, this.value.length)' readonly  style='width:200px;' value='[ays_pb id=%s]' />", $item["id"]);
    }


    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns() {
        $columns = [
            "cb"                => "<input type='checkbox' />",
            "title"             => __( "Title", $this->plugin_name ),
            "onoffswitch"       => __( "Enabled/Disabled", $this->plugin_name ),
            "shortcode"         => __( "Shortcode", $this->plugin_name ),
            "id"                => __( "ID", $this->plugin_name ),
        ];

        return $columns;
    }


    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            "title"         => array( "title", true ),
            "id"            => array( "id", true ),
        );

        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = [
            "bulk-delete" => "Delete"
        ];

        return $actions;
    }


    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {

        $this->_column_headers = $this->get_column_info();

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page     = $this->get_items_per_page( "popupboxes_per_page", 5 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args( [
            "total_items" => $total_items, //WE have to calculate the total number of items
            "per_page"    => $per_page //WE have to determine how many items to show on a page
        ] );

        $this->items = self::get_ays_popupboxes( $per_page, $current_page );
    }

    public function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        $message = "deleted";
        if ( "delete" === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST["_wpnonce"] );

            if ( ! wp_verify_nonce( $nonce, $this->plugin_name . "-delete-popupbox" ) ) {
                die( "Go get a life script kiddies" );
            }
            else {
                self::delete_popupboxes( absint( $_GET["popupbox"] ) );

                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url

                $url = esc_url_raw( remove_query_arg(["action", "popupbox", "_wpnonce"]  ) ) . "&status=" . $message . "&type=success";
                wp_redirect( $url );
                exit();
            }

        }

        // If the delete bulk action is triggered
        if ( ( isset( $_POST["action"] ) && $_POST["action"] == "bulk-delete" )
            || ( isset( $_POST["action2"] ) && $_POST["action2"] == "bulk-delete" )
        ) {

            $delete_ids = esc_sql( $_POST["bulk-delete"] );

            // loop over the array of record IDs and delete them
            foreach ( $delete_ids as $id ) {
                self::delete_popupboxes( $id );

            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url

            $url = esc_url_raw( remove_query_arg(["action", "popupbox", "_wpnonce"]  ) ) . "&status=" . $message . "&type=success";
            wp_redirect( $url );
            exit();
        }
    }

    public function popupbox_notices(){
        $status = (isset($_REQUEST["status"])) ? sanitize_text_field( $_REQUEST["status"] ) : "";
        $type = (isset($_REQUEST["type"])) ? sanitize_text_field( $_REQUEST["type"] ) : "";

        if ( empty( $status ) )
            return;

        if ( "created" == $status )
            $updated_message = esc_html( __( "PopupBox created.", $this->plugin_name ) );
        elseif ( "updated" == $status )
            $updated_message = esc_html( __( "PopupBox saved.", $this->plugin_name ) );
        elseif ( "deleted" == $status )
            $updated_message = esc_html( __( "PopupBox deleted.", $this->plugin_name ) );
        elseif ( 'duplicated' == $status )
            $updated_message = esc_html( __( 'PopupBox duplicated.', $this->plugin_name ) );
        elseif ( 'published' == $status )
            $updated_message = esc_html( __( 'PopupBox published.', $this->plugin_name ) );
        elseif ( 'unpublished' == $status )
            $updated_message = esc_html( __( 'PopupBox unpublished.', $this->plugin_name ) );
        elseif ( "error" == $status )
            $updated_message = __( "You're not allowed to add popupbox for more popupboxes please checkout to ", $this->plugin_name)."<a href='http://ays-pro.com/index.php/wordpress/facebook-popup-likebox' target='_blank'>PRO ".__("version", $this->plugin_name)."</a>.";

        if ( empty( $updated_message ) )
            return;

        ?>
        <div class="notice notice-<?php echo $type; ?> is-dismissible">
            <p> <?php echo $updated_message; ?> </p>
        </div>
        <?php
    }
}
