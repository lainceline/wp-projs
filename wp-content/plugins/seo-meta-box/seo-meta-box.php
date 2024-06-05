<?php
/*
Plugin Name: SEO Meta Box
Description: A plugin to add an SEO meta box to post edit screens.
Version: 0.2.3
Author: Sarah Myers
*/

function seomb_add_meta_box() {
    add_meta_box('seomb_meta', 'SEO Meta', 'seomb_display_meta_box', 'post', 'normal', 'high');
}

add_action('add_meta_boxes', 'seomb_add_meta_box');

function seomb_display_meta_box($post) {
    $seo_title = get_post_meta($post->ID, '_seomb_title', true);
    $seo_description = get_post_meta($post->ID, '_seomb_description', true);
    ?>
    <label for="seomb_title">SEO Title:</label>
    <input type="text" name="seomb_title" id="seomb_title" value="<?php echo esc_attr($seo_title); ?>" style="width: 100%; margin-bottom: 10px;">
    <label for="seomb_description">SEO Description:</label>
    <textarea name="seomb_description" id="seomb_description" style="width: 100%;"><?php echo esc_textarea($seo_description); ?></textarea>
    <?php
}

function seomb_save_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['seomb_title'])) {
        update_post_meta($post_id, '_seomb_title', sanitize_text_field($_POST['seomb_title']));
    }
    
    if (isset($_POST['seomb_description'])) {
        update_post_meta($post_id, '_seomb_description', sanitize_textarea_field($_POST['seomb_description']));
    }
}

add_action('save_post', 'seomb_save_meta_box');