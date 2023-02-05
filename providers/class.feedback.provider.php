<?php

class WiflyDemoFeedbackProvider{

    public static function getCategories(){
        global $wpdb;
        return $wpdb->get_results("select * from {$wpdb->prefix}feedback_category");
    }

    public static function addCategory($title){
        global $wpdb;
        $wpdb->query($wpdb->prepare("insert into {$wpdb->prefix}feedback_category (`title`) values ('%s')", [$title]));
    }

    public static function editCategory($data){
        global $wpdb;
        $title = $data['title'];
        $id = $data['id'];
        $wpdb->query($wpdb->prepare("update {$wpdb->prefix}feedback_category set `title` = '%s' where `id` = '%s'", [$title, $id]));
    }

    public static function deleteCategory($id){
        global $wpdb;
        $wpdb->query($wpdb->prepare("delete from {$wpdb->prefix}feedback_category where `id` = '%s'", [$id]));
    }

    public static function getFeedback(){
        global $wpdb;
        return $wpdb->get_results("select title, value, feedback_id from {$wpdb->prefix}feedback_category join {$wpdb->prefix}feedback on {$wpdb->prefix}feedback.category_id={$wpdb->prefix}feedback_category.id");
    }

    public static function getFeedbackById($id){
        global $wpdb;
        return $wpdb->get_results($wpdb->prepare("select title, value, feedback_id from {$wpdb->prefix}feedback_category join {$wpdb->prefix}feedback on {$wpdb->prefix}feedback.category_id={$wpdb->prefix}feedback_category.id where {$wpdb->prefix}feedback.feedback_id='%s'", [$id]));
    }

    public static function addFeedback($data){
        global $wpdb;
        $feedback_id = uniqid();
        foreach ($data as $key=>$value){
            $data[$key] = sanitize_text_field($value);
            if(!$wpdb->get_results($wpdb->prepare("select * from {$wpdb->prefix}feedback_category where title='%s'", [$key]))){
                $wpdb->query($wpdb->prepare("insert into {$wpdb->prefix}feedback_category (`title`) values ('%s')", [$key]));
            }
            $id = $wpdb->get_row($wpdb->prepare("select id from {$wpdb->prefix}feedback_category where title='%s'", [$key]))->id;
            $wpdb->query($wpdb->prepare("insert into {$wpdb->prefix}feedback (`category_id`, `value`, `feedback_id`) values ('%s', '%s', '%s')", [$id, $value, $feedback_id]));
        }
    }

    public static function CSVDump(){
        $filename = "feedback_dump_".time().'.csv';
        $delimiter = ',';
        $f = fopen('php://output', 'w');
        $feedbacks = self::getFeedback();
        $columns = [];
        $feedback_ids = [];
        foreach ($feedbacks as $feedback){
            if(!in_array($feedback->title, $columns))
                array_push($columns, $feedback->title);
            if(!in_array($feedback->feedback_id, $feedback_ids))
                array_push($feedback_ids, $feedback->feedback_id);
        }
        fputcsv($f, $columns, $delimiter);

        foreach ($feedback_ids as $feedback_id){
            $line = [];
            $feedbacks_ = self::getFeedbackById($feedback_id);
            foreach ($columns as $key=>$column){
                if($feedbacks_[$key]->title == $column){
                    array_push($line, $feedbacks_[$key]->value);
                }
                else array_push($line, '');
            }
            fputcsv($f, $line, $delimiter);
        }

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');
    }
}
