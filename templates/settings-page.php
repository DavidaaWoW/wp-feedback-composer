<div class="wrap">

    <h1>Settings</h1>

    <h3>Feedback fields</h3>

    <?php
    require_once WIFLY_DEMO_FEEDBACK_PLUGIN_DIR.'providers/class.feedback.provider.php';
    $categories = WiflyDemoFeedbackProvider::getCategories();
    foreach ($categories as $category){
        $title = $category->title;
        $id = $category->id;
        echo '<div class="row">';
        echo '<form action="'. admin_url( 'admin-post.php' ) .'" method="post" class="col">';
        echo '<input type="hidden" name="action" value="edit_category">';
        echo '<input type="hidden" name="id" value="'. esc_attr($id) .'">';
        echo '<input type="text" value="'. esc_attr($title) .'" name="title">';
        wp_nonce_field( 'edit_category', 'wifly_feedback_category_nonce' );
        echo '<button type="submit" class="col-1 btn btn-primary">e</button>';
        echo '</form>';
        echo '<form action="'. admin_url( 'admin-post.php' ) .'" method="post" class="col">';
        echo '<input type="hidden" name="action" value="delete_category">';
        echo '<input type="hidden" name="id" value="'. esc_attr($id) .'">';
        wp_nonce_field( 'delete_category', 'wifly_feedback_category_nonce' );
        echo '<button type="submit" class="col-1 btn btn-danger">d</button>';
        echo '</form>';
        echo '</div>';
    }
    ?>
    <form action="<?php echo admin_url( 'admin-post.php' )?>" method="post" class="row">
        <input type="text" class="col-5" name="title">
        <input type="hidden" name="action" value="add_category">
        <?php echo wp_nonce_field( 'add_category', 'wifly_feedback_category_nonce' );?>
        <button type="submit" class="col-1 btn btn-success">+</button>
    </form>
</div>