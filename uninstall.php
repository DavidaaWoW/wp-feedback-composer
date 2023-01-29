<?php

defined("WP_UNINSTALL_PLUGIN") or die;

global $wpdb;
global $table_prefix;
define("FEEDBACK_TABLE", $table_prefix.'feedback');
define("FEEDBACK_CATEGORY_TABLE", $table_prefix.'feedback_category');
$feedback_table = FEEDBACK_TABLE;
$feedback_categories = FEEDBACK_CATEGORY_TABLE;
$wpdb->query("drop table if exists $feedback_table");
$wpdb->query("drop table if exists $feedback_categories");
