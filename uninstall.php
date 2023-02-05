<?php

defined("WP_UNINSTALL_PLUGIN") or die;

global $wpdb;
$wpdb->query("drop table if exists {$wpdb->prefix}feedback");
$wpdb->query("drop table if exists {$wpdb->prefix}feedback_category");
