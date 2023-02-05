<div class="wrap">

    <?php
    require WIFLY_DEMO_FEEDBACK_PLUGIN_DIR . '/providers/class.feedback.provider.php';
    $feedbacks = WiflyDemoFeedbackProvider::getFeedback();
    $columns = [];
    $feedback_ids = [];
    foreach ($feedbacks as $feedback) {
        if (!in_array($feedback->title, $columns))
            array_push($columns, $feedback->title);
        if (!in_array($feedback->feedback_id, $feedback_ids))
            array_push($feedback_ids, $feedback->feedback_id);
    }

    ?>

    <h1>Feedback</h1>
    <form action="<?php echo admin_url( 'admin-post.php' )?>" method="post">
        <input type="hidden" name="action" value="get_dump">
        <?php echo wp_nonce_field( 'get_dump', 'wifly_feedback_nonce' );?>

        <button style="margin: 3em 0" class="btn btn-primary" type="submit">Download CSV dump</button>
    </form>
    <table class="table table-hover table-dark table-striped">
        <tr>
            <?php
            foreach ($columns as $column) {
                echo '<th>' . esc_html($column) . '</th>';
            }
            ?>
        </tr>
        <?php
        foreach ($feedback_ids as $feedback_id) {
            echo '<tr>';
            $feedbacks_ = WiflyDemoFeedbackProvider::getFeedbackById($feedback_id);
            foreach ($columns as $key => $column) {
                echo '<td>';
                if ($feedbacks_[$key]->title == $column) {
                    echo esc_html($feedbacks_[$key]->value);
                }
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
        <?php
        //    require WIFLY_DEMO_FEEDBACK_PLUGIN_DIR.'/providers/class.feedback.provider.php';
        //    $feedbacks = FeedbackProvider::getFeedback();
        //    foreach ($feedbacks as $feedback){
        //        $fio = $feedback->fio;
        //        $tel_number = $feedback->tel_number;
        //        $flight_number = $feedback->flight_num;
        //        $date = $feedback->date;
        //        $message = $feedback->message;
        //        echo '<tr> <td>'. $fio .'</td> <td>'. $tel_number . '</td> <td>'. $flight_number .'</td> <td>'. $date .'</td> <td>'. $message .'</td></tr>';
        //    }
        //    ?>
    </table>

</div>
