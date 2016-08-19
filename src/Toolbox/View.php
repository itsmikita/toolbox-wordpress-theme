<?php
namespace Toolbox;

use Toolbox\Theme;
use Mustache_Autoloader;
use Mustache_Loader_FilesystemLoader;
use Mustache_Engine;

if( ! class_exists( __NAMESPACE__ . "\View" ) ):
class View
{
	/**
	 * Get Mustache (singleton) instance
	 */
	public static function getMustache()
	{
		static $mustache = null;
		
		if( empty( $mustache ) ) {
			if( ! class_exists( 'Mustache_Autoloader' ) ) {
				require_once Theme::getPath( 'vendor/mustache-php/src/Mustache/Autoloader.php' );
				
				Mustache_Autoloader::register();
			}
			
			$templateDir = Theme::getPath( 'assets/templates' );
			$partialsDir = "{$templateDir}/partials";
			$loader = new Mustache_Loader_FilesystemLoader( $templateDir, [
				'extension' => "ms"
			] );
			$partialsLoader = Mustache_Loader_FilesystemLoader( $partialsDir, [
				'extension' => "ms"
			] );
			$mustache = new Mustache_Engine( [
				'loader' => $loader,
				'partials_loader' => $partialsLoader,
				'cache' => WP_CONTENT_DIR . "/cache/mustache",
				'helpers' => self::getMustacheHelpers()
			] );
		}
		
		return $mustache;
	}
	
	/**
	 * Get Mustache helpers
	 */
	public static function getMustacheHelpers()
	{
		$helpers = [];
		
		/**
		 * wp_title()
		 */
		$helpers['wp_title'] = function() {
			ob_start();
			wp_title();
			
			return ob_get_clean();
		};
		
		/**
		 * wp_head()
		 */
		$helpers['wp_head'] = function() {
			ob_start();
			wp_head();
			
			return ob_get_clean();
		};
		
		/**
		 * wp_footer
		 */
		$helpers['wp_footer'] = function() {
			ob_start();
			
			wp_footer();
			
			return ob_get_clean();
		};
		
		/**
		 * language_attributes()
		 */
		$helpers['language_attributes'] = function() {
			ob_start();
			
			language_attributes();
			
			return ob_get_clean();
		};
		
		/**
		 * body_class()
		 */
		$helpers['body_class'] = function() {
			ob_start();
			
			body_class();
			
			return ob_get_clean();
		};
		
		/**
		 * site_url()
		 *
		 * @param string $path
		 */
		$helpers['site_url'] = function( $path = '' ) {
			return site_url( $path );
		};
		
		/**
		 * wp_nav_menu()
		 *
		 * @param string $location
		 */
		$helpers['wp_nav_menu'] = function( $location ) {
			ob_start();
			
			wp_nav_menu( [
				'theme_location' => $location,
				'container' => false,
				'items_wrap' => '<div class="menu-wrapper"><a href="#" class="icon-menu">Meny</a><ul id="%1$s" class="%2$s">' . apply_filters( 'prepend_to_' . $location . '_menu', '' ) . '%3$s' . apply_filters( 'append_to_' . $location . '_menu', '' ) . '</ul></div>'
			] );
			
			return ob_get_clean();
		};
		
		return $helpers;
	}
	
	/**
	 * Render template
	 *
	 * @param string $template
	 * @param mixed $data
	 */
	public static function render( $template, $data = [] )
	{
		add_filter( 'template_data', function( $data ) {
			$data['is_archive'] = is_archive();
			$data['is_front_page'] = is_front_page();
			$data['is_home'] = is_home();
			$data['is_page'] = is_page();
			$data['is_search'] = is_search();
			$data['is_single'] = is_single();
			
			return $data;
		} );
		
		$mustache = self::getMustache();
		$data = apply_filters( 'template_data', $data );
		
		return $mustache->render( $template, $data );
	}
}
endif;