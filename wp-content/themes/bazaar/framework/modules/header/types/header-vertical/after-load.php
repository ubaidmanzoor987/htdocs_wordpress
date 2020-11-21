<?php

if ( ! function_exists( 'bazaar_qodef_disable_behaviors_for_header_vertical' ) ) {
	/**
	 * This function is used to disable sticky header functions that perform processing variables their used in js for this header type
	 */
	function bazaar_qodef_disable_behaviors_for_header_vertical( $allow_behavior ) {
		return false;
	}
	
	if ( bazaar_qodef_check_is_header_type_enabled( 'header-vertical', bazaar_qodef_get_page_id() ) ) {
		add_filter( 'bazaar_qodef_allow_sticky_header_behavior', 'bazaar_qodef_disable_behaviors_for_header_vertical' );
		add_filter( 'bazaar_qodef_allow_content_boxed_layout', 'bazaar_qodef_disable_behaviors_for_header_vertical' );
	}
}