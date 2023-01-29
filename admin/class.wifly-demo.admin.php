<?php

class Wifly_Demo_Feedback_Admin
{
    public static function AdminInit()
    {
        add_action('admin_menu', 'Wifly_Demo_Feedback_Admin::admin_menu');
        add_action('admin_post_get_dump', 'Wifly_Demo_Feedback_Admin::get_dump');
        add_action('admin_post_add_feedback', 'Wifly_Demo_Feedback_Admin::add_feedback');
        add_action('admin_post_add_category', 'Wifly_Demo_Feedback_Admin::add_category');
        add_action('admin_post_edit_category', 'Wifly_Demo_Feedback_Admin::edit_category');
        add_action('admin_post_delete_category', 'Wifly_Demo_Feedback_Admin::delete_category');
    }

    public static function admin_menu()
    {
        add_menu_page('Feedback page', 'Feedback page', 'manage_options', 'feedback_page', 'Wifly_Demo_Feedback_Admin::render_page', 'dashicons-format-quote');
        add_submenu_page('feedback_page', 'Settings', 'Settings', 'manage_options', 'settings_page', 'Wifly_Demo_Feedback_Admin::render_settings_page');
    }

    public static function render_page()
    {
        require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR . 'templates/admin-page.php';
    }

    public static function render_settings_page()
    {
        require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR . 'templates/settings-page.php';
    }

    public static function get_feedback(){
        require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR.'providers/class.feedback.provider.php';
    }

    public static function add_category(){
        if (!isset($_POST['wifly_feedback_category_nonce']) || !wp_verify_nonce($_POST['wifly_feedback_category_nonce'], 'add_category')) {
            wp_die("Nonce error");
        }

        $title = $_POST['title'];

        require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR.'providers/class.feedback.provider.php';
        FeedbackProvider::addCategory($title);
        wp_redirect( $_POST['_wp_http_referer'] );
    }

    public static function edit_category(){
        if (!isset($_POST['wifly_feedback_category_nonce']) || !wp_verify_nonce($_POST['wifly_feedback_category_nonce'], 'edit_category')) {
            wp_die("Nonce error");
        }

        $data = [];
        $data += ['title' => $_POST['title']];
        $data += ['id' => $_POST['id']];

        require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR.'providers/class.feedback.provider.php';
        FeedbackProvider::editCategory($data);
        wp_redirect( $_POST['_wp_http_referer'] );
    }

    public static function delete_category(){
        if (!isset($_POST['wifly_feedback_category_nonce']) || !wp_verify_nonce($_POST['wifly_feedback_category_nonce'], 'delete_category')) {
            wp_die("Nonce error");
        }

        $id = $_POST['id'];

        require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR.'providers/class.feedback.provider.php';
        FeedbackProvider::deleteCategory($id);
        wp_redirect( $_POST['_wp_http_referer'] );
    }

    public static function add_feedback(){
        if (!isset($_POST['wifly_feedback_nonce']) || !wp_verify_nonce($_POST['wifly_feedback_nonce'], 'add_feedback')) {
            wp_die("Nonce error");
        }

        require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR.'providers/class.feedback.provider.php';
        FeedbackProvider::addFeedback($_POST['data']);
        wp_redirect( $_POST['_wp_http_referer'] );
    }

    public static function get_dump(){
        if (!isset($_POST['wifly_feedback_nonce']) || !wp_verify_nonce($_POST['wifly_feedback_nonce'], 'get_dump')) {
            wp_die("Nonce error");
        }
        require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR.'providers/class.feedback.provider.php';
        FeedbackProvider::CSVDump();
    }

}