<?php 
/*
Plugin Name: Display Woocommerce Categories
Description: This plugin displays woocommerce categories
Author: Usama Maqsood
Version: 1.0.0
*/


function include_plugin_files() {
    wp_enqueue_style('plugin_style', plugin_dir_url(__FILE__) . 'css/style.css');

    // Enqueue jQuery from WordPress core
    wp_enqueue_script('jquery');

    wp_enqueue_script('plugin-js', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'));
    
    // Localize the script with the nonce and AJAX URL
    wp_localize_script('plugin-js', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_products_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'include_plugin_files');


function display_woocommerce_categories(){

    $categories_count = get_option( 'categories_count', '' );

    $product_categories = get_terms(
        array(
            'taxonomy' => 'product_cat',
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => FALSE,
            'number' => $categories_count
        )
    );
    if(!empty($product_categories)){

        $output = '<div class="woocommerce_categories">';

        foreach($product_categories as $category){

            $thumbnail_id = get_term_meta($category->term_id , 'thumbnail_id', true);

            $image_url = wp_get_attachment_url( $thumbnail_id );

            $category_name = $category->name;

            $category_url = get_term_link($category);

            $output .= '<div class="single_category">';
            $output .= '<h5 class="cat-name">'. $category_name .'</h5>';
            $output .= '<img src="'.$image_url. '"/>';
            $output .= '<div class="button-container"><a href="#" class="button" category_id=
            "'.$category->term_id.'">View All</a></div>';
            $output .= '</div>';

        }

        $output .= '</div>';
        return $output;
    }
}

add_shortcode( 'ecommerce_categories', 'display_woocommerce_categories' );

function load_products_by_cat(){
    check_ajax_referer('load_products_nonce', 'nonce'); 
    $category_id = $_POST['category_id'];
    $term = get_term_by('id', $category_id, 'product_cat');

    if (!$term) {
        wp_send_json_error('Invalid category ID');
    }

    $category_slug = $term->slug;

    $product_html = do_shortcode('[products category="' . $category_slug . '"]');

    wp_send_json_success($product_html);
}

add_action('wp_ajax_load_products_by_cat', 'load_products_by_cat');
add_action('wp_ajax_nopriv_load_products_by_cat', 'load_products_by_cat');


function my_custom_menu_page(){
    
    add_menu_page( 
        'Display Woocommerce Categories',
    'DWC Settings',
    'manage_options',
    'DWC-settings',
    'plugin_settings_page_content',
    'dashicons-admin-generic',
    20
    );

}

add_action('admin_menu', 'my_custom_menu_page');

function plugin_settings_page_content(){

    $categories_count = get_option( 'categories_count', '' );

    if(isset($_POST['save_btn']) && $_SERVER['REQUEST_METHOD'] == "POST"){
        $categories_count = isset($_POST['categories_count']) ? sanitize_text_field( $_POST['categories_count'] ) : "";
        update_option( 'categories_count', $categories_count);
    }

    ?>
    <div class="wrap">
        <h4 style ="font-size:25px;text-align:center;">DWC Plugin Settings</h4>
        <form action="" method="post">
            <label for="categories_count">Categories Count</label>
            <input type="number" id="categories_count" name="categories_count" value="<?php echo $categories_count; ?>">
            <button type="submit" value="save" class="btn btn-primary " name="save_btn">Save</button>
        </form>
    </div>


<?php
}