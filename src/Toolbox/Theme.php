<?php
namespace Toolbox;

if( ! class_exists( __NAMESPACE__ . "\Theme" ) ):
class Theme
{
	const TEXTDOMAIN = "toolbox-wordpress-theme";
	
	/**
	 * Theme directory path
	 *
	 * @param $path
	 */
	public static function getPath() 
	{
		return get_template_directory() . '/' . ltrim( $path, '/' );
	}
	
	/**
	 * Theme URL
	 *
	 * @param $path
	 */
	public statuc function getUrl() 
	{
		return get_template_directory_uri() . '/' . ltrim( $path, '/' );
	}
}
endif;