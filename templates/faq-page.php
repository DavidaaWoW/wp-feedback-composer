<div class="wrap">
    <h1>How does this plugin work?</h1>

    <p>At first, you need to visit setting page and configure needed columns names for your feedback form</p>

    <img src="<?php echo esc_url(WIFLY_DEMO_FEEDBACK_PLUGIN_URL.'static/images/settings_image.png')?>" alt="">

    <p>But don't worry, if you forget to add some fields, or misspelled them - they gonna be automatic added to the DB, and you will be able to edit them as well on settings page</p>

    <p>Next, you need to add the feedback form to your site, you can just copy code below...</p>

    <textarea>
        &lt;form action=&quot; &lt;?php echo admin_url( 'admin-post.php' ) ?&gt;&quot; method=&quot;post&quot; style=&quot;padding-top:10px&quot;&gt;
        &lt;input style=&quot;width:100%;padding:5px;padding-left:40px;height:45px;&quot; type=&quot;text&quot; placeholder=&quot;Your placeholder for the input&quot; name=&quot;data[name of the feedback column]&quot;&gt;
        &lt;textarea style=&quot;width:100%;padding:5px;padding-left:40px;height:105px;margin-top:10px;&quot; type=&quot;text&quot; placeholder=&quot;Your placeholder for the input&quot; name=&quot;data[name of the feedback column]&quot;&gt;&lt;/textarea&gt;

        &lt;?php echo wp_nonce_field( 'add_feedback', 'wifly_feedback_nonce' ) ?&gt;
        &lt;input type=&quot;hidden&quot; name=&quot;action&quot; value=&quot;add_feedback&quot;&gt;

        &lt;button type=&quot;submit&quot; style=&quot;    width: 70%; padding: 5px; height: 48px; margin-top: 10px; font-size: 20px; color: #003864; margin: auto; display: block;&quot;&gt;Send feedback&lt;/button&gt;
        &lt;/form&gt;
    </textarea>

    <p>You can create as many input fields as you want!</p>

    <p>After user submits new feedback it will be available on feedback page, inside your admin panel. Also you can download a dump with all the feedback in CSV file, simply clicking on the corresponded button</p>

    <img src="<?php echo esc_url(WIFLY_DEMO_FEEDBACK_PLUGIN_URL . 'static/images/feedback_image.png') ?>" alt="">
</div>

<style>

    p{
        font-size: 1.2em;
    }
    h1{
        font-size: 1.2em;
    }
    textarea{
        width: 100%;
        height: 10em;
    }
</style>