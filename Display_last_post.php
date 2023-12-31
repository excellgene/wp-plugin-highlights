<?php
 /**
  *  Plugin Name: Display_Last_Post
  *  @author 
  *  @version
  */

class Display_Last_Post
{
    public function __construct()
    {

        // load scripts and style
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);

        // link api endpoints to method for private and public navigation
        add_action('wp_ajax_nopriv_get_latest_post', [$this, 'get_latest_post']);
        add_action('wp_ajax_get_latest_post', [$this, 'get_latest_post']);
    }


    public function enqueue_styles()
    {
        wp_enqueue_style('index', plugin_dir_url(__FILE__) . 'public/css/display-last-post-public.css', array(), null, 'all');
    }


    public function enqueue_scripts()
    {
        wp_enqueue_script('index', plugin_dir_url(__FILE__) . 'public/js/display-last-post-public.js', ['jquery']);
        wp_localize_script('index', 'url', [ admin_url('admin-ajax.php') ]);
    }

    public function formated_post($query)
    {
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $excerpt = do_shortcode(get_the_excerpt());

                $ret = [
                    'category' => get_the_category()[0]->name,
                    'latest_post' => get_the_title(),
                    'date' => get_the_date("j M Y"),
                    'excerpt' =>  $excerpt,
                    'url_post' => get_permalink()
                ];
            }
            wp_reset_postdata();
        }

        return $ret;
    }

    public function parse_categories_to_get_only_name($categories)
    {
        $ret = [];
        foreach($categories as $category) {
            $ret[] = $category->name;
        }
        return $ret;
    }

    public function remove_events(&$array) 
    {
        foreach($array as $key => $value) {
            if($value === 'events') {
                unset($array[$key]);
            }
        }
    }

    public function get_latest_post()
    {
        global $wpdb;
        
        $categories = $this->parse_categories_to_get_only_name(get_categories());

        $this->remove_events($categories);

        $cat = array_slice($categories, 0,3);

        $posts = [];

        foreach (array_merge($cat, ["events"]) as $category) {
            if ($category != 'uncategorized') {
                $args = [
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'category_name' => $category,
                    'posts_per_page' => 1,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ];
        
                $query = new WP_Query($args);
                
                $posts[] = $this->formated_post($query);
            }
        }

        echo json_encode([
            'json' => $posts,
        ]);
        wp_die();
    }

    public function get_all_categories()
    {

        $text = "hello world";
        return $text;

    }
}
new Display_Last_Post();