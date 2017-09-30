<?php
/*
 Plugin Name: Style Versions
 Description: Easy handle style versions to avoid browser cache problems.
 Version: 1.0
 Author: Sergey Zaharchenko
 Author URI: https://github.com/zahardoc/
 Text Domain: style-versions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$classes = glob(__DIR__ . '/inc/class-*.php');

foreach ( $classes as $class ) {
	require_once $class;
};

\Style_Versions\Options::app()->init(__FILE__);
\Style_Versions\Handle_Style_Versions::app()->init();
