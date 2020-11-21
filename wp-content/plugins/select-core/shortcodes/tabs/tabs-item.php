<?php
namespace QodeCore\CPT\Shortcodes\Tabs;

use QodeCore\Lib;

class TabsItem implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'qodef_tabs_item';
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'            => esc_html__( 'Select Tabs Item', 'select-core' ),
					'base'            => $this->getBase(),
					'as_parent'       => array( 'except' => 'vc_row' ),
					'as_child'        => array( 'only' => 'qodef_tabs' ),
					'category'        => esc_html__( 'by Select', 'select-core' ),
					'icon'            => 'icon-wpb-tabs-item extended-custom-icon',
					'content_element' => true,
					'js_view'         => 'VcColumnView',
					'params'          => array(
						array(
							'type'       => 'textfield',
							'param_name' => 'tab_title',
							'heading'    => esc_html__( 'Title', 'select-core' )
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$default_atts = array(
			'tab_title' => 'Tab',
			'tab_id'    => ''
		);
		$params       = shortcode_atts( $default_atts, $atts );
		
		$rand_number         = rand( 0, 1000 );
		$params['tab_title'] = $params['tab_title'] . '-' . $rand_number;
		$params['content']   = $content;
		
		$output = qodef_core_get_shortcode_module_template_part( 'templates/tab-content', 'tabs', '', $params );
		
		return $output;
	}
}