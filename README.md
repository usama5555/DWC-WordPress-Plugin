# DWC WordPress Plugin

This WordPress plugin displays WooCommerce categories on a custom page template and allows users to load products via AJAX. 

## Description

The "Display WooCommerce Categories" plugin provides a shortcode to display WooCommerce categories on custom template page. When a category is selected, products are dynamically loaded without refreshing the page, thanks to the AJAX functionality. 

### Features

- Display WooCommerce product categories with thumbnails.
- Load products dynamically using AJAX when a category is selected.
- Customizable settings for the number of categories displayed.
- Includes a custom settings page in the WordPress admin dashboard.

## Installation

1. **Upload the Plugin Files:**
   - Upload the plugin folder to the `/wp-content/plugins/` directory.

2. **Activate the Plugin:**
   - Activate the plugin through the 'Plugins' screen in WordPress.

3. **Add the Shortcode:**
   - Add the `[ecommerce_categories]` shortcode to custom template page where you want to display the WooCommerce categories.

4. **Create a Custom Template:**
   - Create a custom page template in your theme with the following code:
   
   ```php
   <?php
   /*
   Template Name: My Custom Template
   */

   get_header();
   ?>

   <div class="categories">
       <h2 style="text-align: center;margin-top: 50px;font-size: 26px;">WooCommerce Categories</h2>
       <?php echo do_shortcode('[ecommerce_categories]' ); ?>
   </div>

   <div>
       <div class="products-main">
           <button id="back-btn">Go Back</button>
           <h2 style="text-align:center; padding:30px 0;">All Products</h2>
           <div id="product-container"></div> 
       </div>
   </div>

   <?php get_footer(); ?>

- Assign this template to a page where you want to display categories and their respective products.
## Usage
**Display Categories:**

Use the shortcode [ecommerce_categories] on any page or post to display WooCommerce categories with their respective thumbnails.

**Customize Settings:**

Navigate to DWC Settings in the WordPress admin menu.
Set the number of categories you want to display.
Click the Save button to save your settings.
## AJAX Functionality
The plugin uses jQuery to handle the AJAX request.
When a category is clicked, products are loaded dynamically without refreshing the page.
Users can navigate back to the categories view by clicking the "Go Back" button.

## Author:
Usama Maqsood


