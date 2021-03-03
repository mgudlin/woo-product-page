<?php
/*
Plugin Name: WooCommerce Assembly Instructions
Plugin URI:  http://speakinginbytes.com
Description: Add assembly instructions to the product page
Version:     1.0
Author:      Patrick Rauland
Author URI:  http://speakinginbytes.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: woocommerce-assembly-instructions
Domain Path: /languages
*/

// Check to make sure WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    // only run if there's no other class with this name
    if ( ! class_exists('WC_Assembly_Instructions')){
        class WC_Assembly_Instructions{
            public function __construct(){
                add_filter('woocommerce_product_data_tabs', array($this, 'my_product_data_tab'), 20);
                add_action('woocommerce_product_data_panels', array($this, 'woocommerce_product_data_panels'));
                add_action('woocommerce_process_product_meta', 'WC_Assembly_Instructions::save', 20, 2);
            }

            public function my_product_data_tab( $product_data_tabs ){
                $product_data_tabs[''] = array(
    				'label'  => __( 'Assembly Instructions', 'woocommerce-assembly-instructions' ),
    				'target' => 'assembly_product_data',
    				'class'  => array()
                );

                return $product_data_tabs;
            }

            public static function save( $post_id, $post ){
                // update post meta
                if( isset( $_POST['_assembly_instructions'])){
                    update_post_meta($post_id, '_assembly_instructions', wc_clean($_POST['_assembly_instructions']));
                }
                if( isset( $_POST['_kite_price'])){
                    update_post_meta($post_id, '_kite_price', wc_clean($_POST['_kite_price']));
                }
                if( isset( $_POST['_select'])){
                    update_post_meta($post_id, '_select', wc_clean($_POST['_select']));
                }
            }

            public function woocommerce_product_data_panels(){
                ?>
                <div id='assembly_product_data' class='panel woocommerce_options_panel'>
                    <p>hello world</p>
                    <?php
                    woocommerce_wp_text_input( array(
        				'id'          => '_assembly_instructions',
        				'label'       => __( 'Assembly Instructions', 'woocommerce-assembly-instructions' ),
        				'placeholder' => 'http://',
        				'description' => __( 'Enter the url to the assembly instructions (kites only)', 'woocommerce-assembly-instructions' ),
        			) );

                    woocommerce_wp_text_input( array(
        				'id'          => '_kite_price',
        				'label'       => __( 'Price', 'woocommerce-assembly-instructions' ),
        				'data_type' => 'price'
        			) );

                    woocommerce_wp_select( array(
        				'id'          => '_select',
        				'label'       => __( 'My Select Field', 'woocommerce-assembly-instructions' ),
        				'options' => array(
                            'one' => __('Option 1', 'woocommerce-assembly-instructions'),
                            'two' => __('Option 2', 'woocommerce-assembly-instructions'),
                            'three' => __('Option 3', 'woocommerce-assembly-instructions')
                        )
        			) );
                    ?>
                </div>
                <?php
            }

        }
        $GLOBALS['wc_assembly_instructions'] = new WC_Assembly_Instructions();
    }
}
