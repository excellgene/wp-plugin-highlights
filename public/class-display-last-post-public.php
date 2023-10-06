<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.excellgene.com
 * @since      1.0.0
 *
 * @package    Display_Last_Post
 * @subpackage Display_Last_Post/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Display_Last_Post
 * @subpackage Display_Last_Post/public
 * @author     Excellgene <sergio.dacosta@excellgene.com>
 */
class Display_Last_Post_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;


        add_action('wp_ajax_get_latest_post', [$this, 'get_latest_post']);
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Display_Last_Post_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Display_Last_Post_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/display-last-post-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script('index', plugin_dir_url(__FILE__) . 'js/display-last-post-public.js', ['jquery']);
        wp_localize_script('index', 'url', [admin_url('admin-ajax.php')]);
    }

    /**
     * 
     * 
     * 
     */
    public function get_latest_post()
    {
        global $wpdb;
        $ret = [];

        foreach(get_categories() as $category){
            $args = [
                'post_type' => 'post',
                'post_status' => 'publish',
                'category_name' => $category->slug,
                'posts_per_page' => 1,
                'orderby' => 'date',
                'order' => 'DESC',
            ];
    
            $query = new WP_Query([
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'category_name' => $category->slug,
                    'posts_per_page' => 1,
                    'orderby' => 'date',
                    'order' => 'DESC',
            ]);
            
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $ret[] = [
                        'category' => get_the_category()[0]->name, 
                        'latest_post' => get_the_title(),
                        'date' => get_the_date(),
                        'content' => get_the_excerpt(),
                        'url_post' => get_permalink()
                    ];
                }
                wp_reset_postdata();
            }
        }

        echo json_encode([
            'json' => $ret,
        ]);
        die();
    }
}