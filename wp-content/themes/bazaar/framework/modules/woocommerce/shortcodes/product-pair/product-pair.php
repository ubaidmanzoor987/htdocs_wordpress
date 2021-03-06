<?php
namespace QodeCore\CPT\Shortcodes\ProductPair;

use QodeCore\Lib;

class ProductPair implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'qodef_product_pair';
		
		add_action('vc_before_init', array($this,'vcMap'));
		
		//Small product id filter
		add_filter( 'vc_autocomplete_qodef_product_pair_small_product_id_callback', array( &$this, 'smallProductIdAutocompleteSuggester', ), 10, 1 );
		
		//Small product id render
		add_filter( 'vc_autocomplete_qodef_product_pair_small_product_id_render', array( &$this, 'smallProductIdAutocompleteRender', ), 10, 1 );

		//Big product id filter
		add_filter( 'vc_autocomplete_qodef_product_pair_big_product_id_callback', array( &$this, 'bigProductIdAutocompleteSuggester', ), 10, 1 );

		//Big product id render
		add_filter( 'vc_autocomplete_qodef_product_pair_big_product_id_render', array( &$this, 'bigProductIdAutocompleteRender', ), 10, 1 );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if(function_exists('vc_map')) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Select Product Pair', 'bazaar' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by Select', 'bazaar' ),
					'icon'                      => 'icon-wpb-product-pair extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'small_product_id',
							'heading'     => esc_html__( 'Small Product', 'bazaar' ),
							'settings'    => array(
								'sortable'      => true,
								'unique_values' => true
							),
							'admin_label' => true,
							'save_always' => true,
							'description' => esc_html__( 'If you left this field empty then product ID will be of the current page', 'bazaar' )
						),array(
                            'type'        => 'dropdown',
                            'param_name'  => 'enable_custom_image_1',
                            'heading'     => esc_html__( 'Enable Custom Image For Small Product', 'bazaar' ),
                            'value'       => array_flip(bazaar_qodef_get_yes_no_select_array(false)),
                            'admin_label' => true,
                            'save_always' => true,
                        ),
                        array(
                            'type'        => 'attach_image',
                            'param_name'  => 'custom_image_1',
                            'heading'     => esc_html__( 'Custom Image', 'bazaar' ),
                            'value'       => bazaar_qodef_get_yes_no_select_array(false),
                            'admin_label' => true,
                            'save_always' => true,
                            'dependency'  => array('element' => 'enable_custom_image_1', 'value' => 'yes')
                        ),
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'big_product_id',
							'heading'     => esc_html__( 'Big Product', 'bazaar' ),
							'settings'    => array(
								'sortable'      => true,
								'unique_values' => true
							),
							'admin_label' => true,
							'save_always' => true,
							'description' => esc_html__( 'If you left this field empty then product ID will be of the current page', 'bazaar' )
						),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'enable_custom_image_2',
                            'heading'     => esc_html__( 'Enable Custom Image For Big Image', 'bazaar' ),
                            'value'       => array_flip(bazaar_qodef_get_yes_no_select_array(false)),
                            'admin_label' => true,
                            'save_always' => true,
                        ),
                        array(
                            'type'        => 'attach_image',
                            'param_name'  => 'custom_image_2',
                            'heading'     => esc_html__( 'Custom Image', 'bazaar' ),
                            'value'       => bazaar_qodef_get_yes_no_select_array(false),
                            'admin_label' => true,
                            'save_always' => true,
                            'dependency'  => array('element' => 'enable_custom_image_2', 'value' => 'yes')
                        ),
						array(
							'type' => 'dropdown',
							'param_name' => 'layout',
							'heading' => esc_html__('Layout order','bazaar'),
							'value' => array(
								esc_html__('Small Product On The Left','bazaar') => '',
								esc_html__('Big Product On The Left','bazaar') => 'qodef-big-product-first',
							)
						),
						array(
							'type' => 'dropdown',
							'param_name' => 'title_tag',
							'heading' => esc_html__('Title Tag','bazaar'),
							'value' => array_flip(bazaar_qodef_get_title_tag(true))
						),
						array(
							'type' => 'colorpicker',
							'param_name' => 'trim_background_color',
							'heading' => esc_html__('Trim Background Color','bazaar'),
						),
					)
				)
			);
		}
    }
	
    public function render($atts, $content = null) {
        $args = array(
	        'small_product_id'          => '',
			'big_product_id'            => '',
            'enable_custom_image_1'     => 'no',
            'custom_image_1'            => '',
            'enable_custom_image_2'     => 'no',
            'custom_image_2'            => '',
			'layout'					=> '',
			'title_tag'					=> 'h5',
			'trim_background_color'		=> ''
        );

		$params = shortcode_atts($args, $atts);
		extract($params);

	    $params['small_product_id'] = !empty($params['small_product_id']) ? $params['small_product_id'] : get_the_ID();
		$params['big_product_id'] = !empty($params['big_product_id']) ? $params['big_product_id'] : get_the_ID();

		$params['title_tag'] = !empty($params['title_tag']) ? $params['title_tag'] : $args['title_tag'];

		$params['products'] = array();
		$params['products'][] = array('class_name' => 'qodef-small-product', 'product_id' => $params['small_product_id'], 'image_size' => 'bazaar_qodef_square', 'enable_custom_image' => $params['enable_custom_image_1'], 'custom_image' => $params['custom_image_1'] );
		$params['products'][] = array('class_name' => 'qodef-big-product', 'product_id' => $params['big_product_id'], 'image_size' => 'bazaar_qodef_portrait', 'enable_custom_image' => $params['enable_custom_image_2'], 'custom_image' => $params['custom_image_2'] );


		$params['holder_classes'] = $this->getHolderClasses($params);
		$params['trim_styles'] = $this->getTrimStyles($params);

		$html = bazaar_qodef_get_woo_shortcode_module_template_part( 'templates/product-pair', 'product-pair', '', $params );

		return $html;
	}
	
	/**
	 * Return product info styles
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getHolderClasses( $params ) {
		$holderClasses = array();
		
		if ( ! empty( $params['layout'] ) ) {
			$holderClasses[] = $params['layout'];
		}
		
		return implode( ' ', $holderClasses );
	}
	
	/**
	 * Generates product title html based on id
	 *
	 * @param $params
	 *
	 * @return html
	 */
	public function getItemTitleHtml( $params ) {
		$html               = '';
		$product_id         = $params['product_id'];
		$title              = get_the_title( $product_id );
		$title_tag          = $params['title_tag'];

		if ( ! empty( $title ) ) {
			$html = '<' . esc_attr( $title_tag ) . ' itemprop="name" class="qodef-pi-title entry-title">';
				$html .= '<a itemprop="url" href="' . esc_url( get_the_permalink( $product_id ) ) . '">' . esc_html( $title ) . '</a>';
			$html .= '</' . esc_attr( $title_tag ) . '>';
		}
		
		return $html;
	}
	
	/**
	 * Generates product price html based on id
	 *
	 * @param $params
	 *
	 * @return html
	 */
	public function getItemPriceHtml( $params ) {
		$html               = '';
		$product_id         = $params['product_id'];
		$product            = wc_get_product( $product_id );
		$currency = '<div class="qodef-currency">' . get_woocommerce_currency_symbol() . '</div>';
		
		if ($product->is_in_stock() ) {

			if( $product->is_on_sale() ) {
				$price_html = $currency . $product->get_sale_price($context = 'view');
			}
			else $price_html = $currency . $product->get_regular_price();

			$html = '<div class="qodef-pi-price">' . $price_html . '</div>';
		}
		
		return $html;
	}
	
	/**
	 * Generates product add to cart html based on id
	 *
	 * @param $params
	 *
	 * @return html
	 */
	public function getItemExcerptHtml( $params ) {
		$html               = '';
		$product_id         = $params['product_id'];

		if ( $product_excerpt = get_the_excerpt($product_id) ) {
			$html = '<div class="qodef-pi-excerpt">' . $product_excerpt . '</div>';
		}

		return $html;
	}

	/**
	 * Filter small product by ID or Title
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function smallProductIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$product_id = (int) $query;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT ID AS id, post_title AS title
					FROM {$wpdb->posts} 
					WHERE post_type = 'product' AND ( ID = '%d' OR post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'bazaar' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'bazaar' ) . ': ' . $value['title'] : '' );
				$results[] = $data;
			}
		}

		return $results;

	}

	/**
	 * Find small product by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function smallProductIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			
			$product = get_post( (int) $query );
			if ( ! is_wp_error( $product ) ) {
				
				$product_id = $product->ID;
				$product_title = $product->post_title;
				
				$product_title_display = '';
				if ( ! empty( $portfolio_title ) ) {
					$product_title_display = ' - ' . esc_html__( 'Title', 'bazaar' ) . ': ' . $product_title;
				}
				
				$product_id_display = esc_html__( 'Id', 'bazaar' ) . ': ' . $product_id;

				$data          = array();
				$data['value'] = $product_id;
				$data['label'] = $product_id_display . $product_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}

	/**
	 * Filter big product by ID or Title
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function bigProductIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$product_id = (int) $query;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT ID AS id, post_title AS title
					FROM {$wpdb->posts}
					WHERE post_type = 'product' AND ( ID = '%d' OR post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'bazaar' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'bazaar' ) . ': ' . $value['title'] : '' );
				$results[] = $data;
			}
		}

		return $results;

	}

	/**
	 * Find big product by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function bigProductIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {

			$product = get_post( (int) $query );
			if ( ! is_wp_error( $product ) ) {

				$product_id = $product->ID;
				$product_title = $product->post_title;

				$product_title_display = '';
				if ( ! empty( $portfolio_title ) ) {
					$product_title_display = ' - ' . esc_html__( 'Title', 'bazaar' ) . ': ' . $product_title;
				}

				$product_id_display = esc_html__( 'Id', 'bazaar' ) . ': ' . $product_id;

				$data          = array();
				$data['value'] = $product_id;
				$data['label'] = $product_id_display . $product_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}


	public function getTrimStyles( $params ) {
		$styles = array();

		if (!empty($params['trim_background_color'])) {
			$styles[] = 'border-color: ' . $params['trim_background_color'] . ';';
		}

		return implode( ';', $styles );
	}
}