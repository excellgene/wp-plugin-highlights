<?php
/**
 * 
 *  Plugin Name: Display_Last_Post
 *  @author 
 *  @version
 * 
 * 
 */


class Display_Last_Post
{

    public $plugin_name = "wp-plugin-highlights";
    public $version = "1.0.0";

    public function __construct()
    {

        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);

        add_action('wp_ajax_get_latest_post', [$this, 'get_latest_post']);
    }


    public function enqueue_styles ()
    {
            var_dump(plugin_dir_url(__FILE__) . 'public/css/display-last-post-public.css');
            wp_enqueue_style('index', plugin_dir_url(__FILE__) . 'public/css/display-last-post-public.css', array(), null, 'all');
    }


    public function enqueue_scripts()
    {
        wp_enqueue_script('index', plugin_dir_url(__FILE__) . 'public/js/display-last-post-public.js', ['jquery']);
        wp_localize_script('index', 'url', [admin_url('admin-ajax.php')]);
    }

  
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
        wp_die();
    }
}

new Display_Last_Post();