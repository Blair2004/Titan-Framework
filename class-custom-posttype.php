<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TitanFrameworkCustomPostType {

	private $saved_post_type	=	array();
	function __construct( $settings ,  $owner )	{
		// Set default labels for custom post type 
		$this->default_labels	=	array(
			'name'				=>	'Custom',
			'singular_name'		=>	'Custom',
			'menu_name'			=>	'Custom',
			'name_admin_bar'	=>	__( 'Add New' , TF_I18NDOMAIN ),
			'all_items'			=>	__( 'All Customs' , TF_I18NDOMAIN ),
			'add_new'			=>	__( 'Add New Custom' , TF_I18NDOMAIN ),
			'add_new_item'		=>	__( 'Add New Custom' , TF_I18NDOMAIN ),
			'edit_item'			=>	__( 'Edit Custom' , TF_I18NDOMAIN ),
			'new_item'			=>	__( 'New Custom' , TF_I18NDOMAIN ),
			'view_item'			=>	__( 'View Custom' , TF_I18NDOMAIN ),
			'search_items'		=>	__( 'Search Custom' , TF_I18NDOMAIN ),
			'not_found'			=>	__( 'No customs found' , TF_I18NDOMAIN ),
			'not_found_in_trash'=>	__( 'No customs found in trash' , TF_I18NDOMAIN ),
			'parent_item_colon'	=>	__( 'Parent Custom' , TF_I18NDOMAIN )
		);
		$this->post_type( $settings );
	}
	private function post_type( $post_type = array() )	{
		// If an array is send
		if( count( $post_type ) > 0 && is_array( $post_type ) )		{
			// Checking post type, since post_type key is required
			if( $this->return_if_array_key_exists( 'post_type' , $post_type ) )			{
				$registered_labels			=	$this->return_if_array_key_exists( 'labels' , $post_type , array() );
				$merged_labels				=	array_merge( $registered_labels , $this->default_labels );
				// Saving Merged labels
				$post_type[ 'labels' ]		=	$merged_labels;
				
				$this->saved_post_type[]	=	$post_type;
			}
		}
		return $this;
	}
	function save_post_type()
	{
		foreach( $this->saved_post_type as $post_index	=> $post_type )
		{
			$this->_post_index	=	$post_index;
			add_action( 'init' , array( $this , 'get_post_type' ) );
		}
	}
	private function get_post_type()
	{
		register_post_type( $this->saved_post_type[ $this->_post_index ] );
	}
	private function return_if_array_key_exists( $key , $array , $default = false )
	{
		if( array_key_exists( $key , $array ) ){
			return $array[ $key ];
		}
		return $default;
	}
}