<?php

/**
 * Aula Plugin
 * 
 * Plugin Name: Aula Plugin
 * Plugin URL: http://localhost/tarefa10/wordpress/wp-content/plugins/aula-plugin
 * Description: Um simples plugin para criar um simples custom post type
 * Version: 0.0.1
 * Author: Micael Macedo
 * License GPLv2 or later
 * Text Domain: didox-modulos
 * 
 */

 if( ! defined('ABSPATH')){
    die('Invalid request');
 }
$frase = "Hello World";
 add_filter('the_content', 'insert_phrase_in_the_end');

 function insert_phrase_in_the_end($content){
    global $frase;
    $content = $content . $frase;
    return $content;
 }
 class AulaPlugin{
    public function __construct(){
        add_action('init', Array($this, 'create_custom_post_type_modulo'));
    }
    public function uninstall(){
        flush_rewrite_rules();
        global $wpdb;
        $wpdb->get_results('DELETE FROM wp_posts WHERE post_type="post";');
    }
    public function activate(){
        $this->create_custom_post_type_modulo();

        flush_rewrite_rules();
        global $wpdb;
        $wpdb->get_results('INSERT INTO wp_posts (post_author, post_content, post_title, post_status, comment_status, ping_status, post_type, comment_count) VALUES (1, "teste Micael", "teste Micael", "publish", "open", "open", "modulo", 0);');
    }
    public function deactivate(){
        flush_rewrite_rules();

    }
    public function create_custom_post_type_modulo(){
        $labels = array(
            'name' => _x('Aula plugins', 'aula_plugins', 'text_domain'),
            'singular_name' => _x('Aula plugin', 'aula_plugin', 'text_domain'),
            'menu_name' => __('Aula plugin', 'text_domain'),
            'name_admin_bar' => __('Aula plugin', 'aula_plugin', 'text_domain')
        );
        $args = array(
            'label' => __('Aula plugin', 'text_domain'),
            'description' => __('Descrição Aula plugin', 'text_domain'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
            'taxonomies' => array('category', 'post_tag'),
            'hierarchial' => false,
            'public' => true,
            'show_ui' => true, 
            'show_in_menu' => true, 
            'menu_position' => 3,
            'show_in_admin_bar' => true, 
            'show_in_nav_menus' => true, 
            'can_export' => true,
            'menu_icon' => 'dashucons-format-video',
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capacity_type' => 'page',
        );
        register_post_type('aula_plugin', $args);
    }
 }

 if(class_exists('AulaPlugin')){
    $didoxModulo = new AulaPlugin();
    register_activation_hook(__FILE__, array( $didoxModulo, 'active'));
    register_deactivation_hook(__FILE__, array( $didoxModulo, 'deactivate'));
    register_uninstall_hook(__FILE__, array( $didoxModulo, 'uninstall'));
 }