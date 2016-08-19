<?php
namespace Toolbox;

use WP_Customize_Control;

if( ! class_exists( __NAMESPACE__ . "\Customizer" ) ):
class Customizer
{
	/**
	 * Add section
	 *
	 * @param array $section
	 * @param $manager
	 */
	public static function addSection( $section, $manager )
	{
		$defaults = [
			'name' => null,
			'title' => null,
			'priority' => null
		];
		$section = array_merge( $defaults, $section );
		$manager->add_section( $section['name'], $section );
	}
	
	/**
	 * Add setting
	 *
	 * @param $setting
	 * @param $manager
	 */
	public static function addSetting( $setting, $manager )
	{
		$defaults = [
			'setting' => null,
			'label' => null,
			'section' => null,
			'type' => "text",
			//'choices' => []
		];
		$setting = array_merge( $defaults, $setting );
		$manager->add_setting( $setting['setting'], $setting );
		$control = new WP_Customize_Control(
			$manager,
			$setting['setting'],
			$setting
		);
		$manager->add_control( $control );
	}
}
endif;