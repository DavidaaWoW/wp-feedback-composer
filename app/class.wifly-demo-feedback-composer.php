<?php

class Wifly_Demo_Feedback_Composer
{
    public static function dbInit(){
        global $wpdb;
        $wpdb->query("create table if not exists {$wpdb->prefix}feedback_category(
            `id` int primary key auto_increment,
            `title` text
        )");
        $wpdb->query("create table if not exists {$wpdb->prefix}feedback(
            `id` int primary key auto_increment,
            `feedback_id` text,
            `category_id` int,
            `value` text,
            foreign key (category_id) references {$wpdb->prefix}feedback_category(`id`)
        )");
    }

    public static function initPlugin(){
        self::define_admin_hooks();
        self::define_public_hooks();
        self::register_styles();
    }

    private static function register_styles(){
        wp_register_script('bootstrap', plugin_dir_url(__FILE__).'../ext/bootstrap.js');
        wp_register_style('bootstrap', plugin_dir_url(__FILE__).'../ext/bootstrap-icons.css');
        wp_register_style('bootstrap-icons', plugin_dir_url(__FILE__).'../ext/bootstrap.css');
        wp_enqueue_script('bootstrap');
        wp_enqueue_style('bootstrap');
        wp_enqueue_style('bootstrap-icons');
    }

    private static function define_admin_hooks()
    {
        require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR.'/admin/class.wifly-demo.admin.php';
        Wifly_Demo_Feedback_Admin::AdminInit();
    }

    private static function define_public_hooks()
    {
        require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR.'/public/class.wifly-demo.public.php';
        Wifly_Demo_Feedback_Public::PublicInit();
    }


}