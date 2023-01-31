<?php

/*
Plugin Name: WiflyDemoFeedbackComposer
Plugin URI: https://github.com/DavidaaWoW/wp-feedback-composer
Description: The plugin is responsible for collecting and displaying feedback
Version: 1.0.2
Author: DavitG
Author URI: https://github.com/DavidaaWoW
*/

global $table_prefix;

defined("ABSPATH") or die;

define("WIFLY_DEMO_FEEDBACK_PLUGIN_DIR", plugin_dir_path(__FILE__));
define("WIFLY_DEMO_FEEDBACK_PLUGIN_URL", plugin_dir_url(__FILE__));
define("FEEDBACK_TABLE", $table_prefix.'feedback');
define("FEEDBACK_CATEGORY_TABLE", $table_prefix.'feedback_category');

require WIFLY_DEMO_FEEDBACK_PLUGIN_DIR . 'app/class.wifly-demo-feedback-composer.php';

register_activation_hook(__FILE__, function (){
    Wifly_Demo_Feedback_Composer::dbInit();
});

Wifly_Demo_Feedback_Composer::initPlugin();