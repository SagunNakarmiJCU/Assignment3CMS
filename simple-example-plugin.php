<?php
/*
Plugin Name: Simple Example Plugin
Description: Welcome to WordPress plugin development.
Plugin URI:  https://plugin-planet.com/
Author:      Sagun Nakarmi
Version:     1.0
License:     GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 
2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this program. If not, visit: https://www.gnu.org/licenses/

*/
defined('ABSPATH') or die();


if( !function_exists( 'add_action')){
    echo 'you cant access this file';
    exit;
}
function  myplugin_action_hook_example()
{
    wp_mail('nakarmisagun33@gmail.com', 'Subject', 'Hi');
}

add_action( 'init', 'myplugin_action_hook_example');

function myplugin_filter_hook_example( $content ){
    $content = $content . '<p>Custom content ..</p>';
    return $content;
}

add_filter( 'the_content', 'myplugin_filter_hook_example');

class SagunPlugin
{
    function __construct(){
        add_action( 'init', array( $this,'custom_post_type'));
    }

   
    function activate(){
        $this -> custom_post_type();
        flush_rewrite_rules();
    }

    function deactivate(){
        flush_rewrite_rules();
    }
    function custom_post_type(){
        register_post_type( 'book', ['public' => true, 'label'=>'Books']);
    }
    function enqueue(){
        wp_enqueue_style( 'mypluginstyle', plugins_url('/assets/mystyle.css', __FILE__), array( '' ), false, 'all');        
    }
    
}

if( class_exists('SagunPlugin')){
    $sagunPlugin = new SagunPlugin();
}

function customFunction( $arg ){
    echo $arg;
}

register_activation_hook( __FILE__, 'myplugin_on_activation' );


