<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Apr_Core_Static' ) ) {
	class Apr_Core_Static {
		function __construct() {
			add_action( 'init', array( $this, 'register_static' ), 1 );
		}
		function register_static() {
			$slug = apply_filters( 'apr_core_static_slug', 'static' );
			$labels = array(
				'name'                  => esc_html__( 'Statics', 'apr-core' ),
				'singular_name'         => esc_html__( 'Static', 'apr-core' ),
				'all_items'             => esc_html__( 'All Statics', 'apr-core' ),
				'menu_name'             => _x( 'Statics', 'Admin menu name', 'apr-core' ),
				'add_new'               => esc_html__( 'Add New', 'apr-core' ),
				'add_new_item'          => esc_html__( 'Add new  static', 'apr-core' ),
				'edit'                  => esc_html__( 'Edit', 'apr-core' ),
				'edit_item'             => esc_html__( 'Edit static', 'apr-core' ),
				'new_item'              => esc_html__( 'New static', 'apr-core' ),
				'search_items'          => esc_html__( 'Search statics', 'apr-core' ),
				'not_found'             => esc_html__( 'No statics found', 'apr-core' ),
				'not_found_in_trash'    => esc_html__( 'No statics found in trash', 'apr-core' ),
				'parent'                => esc_html__( 'Parent static', 'apr-core' ),
				'filter_items_list'     => esc_html__( 'Filter statics', 'apr-core' ),
				'items_list_navigation' => esc_html__( 'Statics navigation', 'apr-core' ),
				'items_list'            => esc_html__( 'Static list', 'apr-core' ),
			);
			$supports = array(
				'title',
				'editor',
				'revisions',
			);
			 register_post_type('static', array(    
	            'labels' => $labels,
	            'public' => true,
	           	'rewrite'     => array(
					'slug' => $slug,
				),
	           	'supports'    => $supports,
	            'menu_icon'   => 'dashicons-welcome-add-page',
	        )
	        );
		}
	}
	new Apr_Core_Static;
}
