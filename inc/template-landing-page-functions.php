<?php



/**
 * Adds a metabox named "Landing Page Settings" on the editing screen of pages 
 * that use the "Landing Pages" template. The metabox will appear on the right side 
 * of the editor with high priority.
 */
function add_landing_page_metabox() {
    global $post;
    if ($post) {
        $current_template = get_post_meta($post->ID, '_wp_page_template', true);
        if ($current_template == 'page-templates/template-landing-page.php') {
            add_meta_box(
                'landing_page_settings', // Metabox ID
                'Landing Page Settings', // Titel der Metabox
                'landing_page_metabox_callback', // Callback-Funktion
                'page', // Post-Typ
                'side', // settings on the right side
                'high' // priority
            );
        }
    }
}
add_action('add_meta_boxes_page', 'add_landing_page_metabox'); // Beachten Sie, dass ich 'add_meta_boxes' in 'add_meta_boxes_page' geändert habe



/**
 * Callback function for displaying the contents of the "Landing Page Settings" metabox. 
 * This function fetches the saved values (if any) for padding and max-width and 
 * displays input fields for them.
 */
function landing_page_metabox_callback($post) {
    $padding = get_post_meta($post->ID, '_landing_page_padding', true);
    $width = get_post_meta($post->ID, '_landing_page_width', true);
    echo '<label for="landing_page_padding">Padding (em): </label>';
    echo '<input type="text" id="landing_page_padding" name="landing_page_padding" value="' . esc_attr($padding) . '" />';
    echo '<br/><label for="landing_page_width">max-width (px): </label>';
    echo '<input type="text" id="landing_page_width" name="landing_page_width" value="' . esc_attr($width) . '" />';
}



/**
 * This function is triggered when a post/page is saved. It checks if the page being saved 
 * uses the "Landing Pages" template and, if so, it saves the values entered in the 
 * "Landing Page Settings" metabox into the post's meta data.
 */
function save_landing_page_settings($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
    if (!current_user_can('edit_page', $post_id)) return $post_id;

    if (isset($_POST['landing_page_padding']))
        update_post_meta($post_id, '_landing_page_padding', sanitize_text_field($_POST['landing_page_padding']));
    if (isset($_POST['landing_page_width']))
        update_post_meta($post_id, '_landing_page_width', sanitize_text_field($_POST['landing_page_width']));
}
add_action('save_post', 'save_landing_page_settings');




/**
 * Outputs custom CSS to the site's head section based on the values entered in 
 * the "Landing Page Settings" metabox. The custom styles are applied to the #page-wrapper 
 * and #main elements, with the padding value specifically being applied only for 
 * screen widths greater than 800px.
 */
 function sot_output_custom_css() {
    if (is_page_template('page-templates/template-landing-page.php')) {
        $padding = get_post_meta(get_the_ID(), '_landing_page_padding', true);
        $width = get_post_meta(get_the_ID(), '_landing_page_width', true);

        $custom_css = "
        <style>
            #page-wrapper {
                max-width: {$width}px;
            }
            @media screen and (min-width: 801px) {
                #main {
                    padding: {$padding}em;
                }
            }
        </style>";

        echo $custom_css;
    }
}
add_action('wp_head', 'sot_output_custom_css');

