<?php

class GravityView_Capabilities {

	/**
	 * Pass a single string or array of capabilities and check whether the current user has the capability
	 * @param  string|array $caps Pass a single cap in a string or array of caps
	 * @return boolean       True: Yes, the current user can do one of the passed capabilities; False: no, they have none of the caps.
	 */
	public static function current_user_can_any($caps){

		if(!is_array($caps)){
			$has_cap = current_user_can( $caps ) || current_user_can( 'gform_full_access' );
			return $has_cap;
		}

		foreach($caps as $cap){
			if(current_user_can($cap)){
				return true;
			}
		}

		$has_full_access = current_user_can( 'gravityview_full_access' );

		return $has_full_access;
	}

	/**
	 * Check which capabilities an user has from a list of provided capabilities
	 * @param  array $caps Array of capabilities
	 * @return string       The key of the capability
	 */
	public static function current_user_can_which($caps){

		foreach( (array)$caps as $cap){
			if( current_user_can( $cap ) ) {
				return $cap;
			}
		}

		return '';
	}

	/**
	 * Fetch all the GravityView capabilities
	 * @return array Array of caps
	 */
	public static function all_caps(){
		return array(
			'gravityview_view_settings',
			'gravityview_edit_settings',
			'gravityview_approve_entries',
			'gravityview_edit_views',
			'gravityview_create_views',
		);
	}

}
