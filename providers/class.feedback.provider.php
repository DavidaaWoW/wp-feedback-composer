<?php

class FeedbackProvider{

    public static function getCategories(){
        global $wpdb;
        $categories = FEEDBACK_CATEGORY_TABLE;
        return $wpdb->get_results("select * from $categories");
    }

    public static function addCategory($title){
        global $wpdb;
        $categories = FEEDBACK_CATEGORY_TABLE;
        $wpdb->query("insert into $categories (`title`) values ('$title')");
    }

    public static function editCategory($data){
        global $wpdb;
        $categories = FEEDBACK_CATEGORY_TABLE;
        $title = $data['title'];
        $id = $data['id'];
        $wpdb->query("update $categories set `title` = '$title' where `id` = '$id'");
    }

    public static function deleteCategory($id){
        global $wpdb;
        $categories = FEEDBACK_CATEGORY_TABLE;
        $wpdb->query("delete from $categories where `id` = '$id'");
    }

    public static function getFeedback(){
        global $wpdb;
        $table_name = FEEDBACK_TABLE;
        $categories = FEEDBACK_CATEGORY_TABLE;
        return $wpdb->get_results("select title, value, feedback_id from $categories join $table_name on $table_name.category_id=$categories.id;");
    }

    public static function getFeedbackById($id){
        global $wpdb;
        $table_name = FEEDBACK_TABLE;
        $categories = FEEDBACK_CATEGORY_TABLE;
        return $wpdb->get_results("select title, value, feedback_id from $categories join $table_name on $table_name.category_id=$categories.id where $table_name.feedback_id='$id'");
    }

    public static function addFeedback($data){
        global $wpdb;
        $table_name = FEEDBACK_TABLE;
        $categories = FEEDBACK_CATEGORY_TABLE;
        $feedback_id = uniqid();
        foreach ($data as $key=>$value){
            if(!$wpdb->get_results("select * from $categories where title='$key'")){
                $wpdb->query("insert into $categories (`title`) values ('$key')");
            }
            $id = $wpdb->get_row("select id from $categories where title='$key'")->id;
            $wpdb->query("insert into $table_name (`category_id`, `value`, `feedback_id`) values ('$id', '$value', '$feedback_id')");
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
