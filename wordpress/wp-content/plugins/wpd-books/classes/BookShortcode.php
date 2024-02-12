<?php

namespace KN\BookPlugin;
/**
 * Represents a Book Shortcode
 */
class BookShortcode extends Singleton
{

    /**
     * @var static $instance Hold the single instance
     */
    protected static $instance;

    /**
     * Book Shortcode constructor
     */
    protected function __construct()
    {
        add_shortcode('kn-most-recent-books-block', [$this, 'mostRecentBooksShortCode']);
        add_shortcode('kn-simple-most-recent-books-block', [$this, 'simpleMostRecentBooksShortCode']);
    }

    /**
     * @return void Prevent cloning (PHP specific)
     */
    protected function __clone(){}

    /**
     * @return string A simple most recent book template
     */
    public function simpleMostRecentBooksShortCode(){
        $output = '';
        $query = new \WP_Query(array(
            'post_type' => BookPostType::POST_TYPE,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => get_option(BookSettings::MOST_RECENT_BOOKS_AMT),
        ));

        if($query->have_posts()){
            $output .= '<ul>';
            while($query->have_posts()){
                $query->the_post();
                $output .= '<li>
                                <a href="' . get_the_permalink() . '">'.esc_html(get_the_title()).'</a>
                            </li>';
            }
            $output .= '</ul>';
        }
        else {
            $output .= __('Sorry, no posts matched your criteria.');
        }

        wp_reset_postdata();

        return $output;
    }

    /**
     * @return string A fancy most recent book template
     */
    public function mostRecentBooksShortCode(){
        $output = '<h3>Most recent books</h3>';
        $query = new \WP_Query(array(
                'post_type' => BookPostType::POST_TYPE,
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => get_option(BookSettings::MOST_RECENT_BOOKS_AMT),
        ));

        if($query->have_posts()){
            /*$output .= '<ul>';
            while($query->have_posts()){
                $query->the_post();
                $output .= '<li>
                                '.get_the_post_thumbnail().'
                                <a href="' . get_the_permalink() . '">'.esc_html(get_the_title()).'</a>
                            </li>';
            }
            $output .= '</ul>';*/
            $output .= '<div class="row">';
            while($query->have_posts()){
                $query->the_post();
                $output .= '<div class="col-md-4 recent-book-item">
                                <a href="' . get_the_permalink() . '">
                                <div class="grow">'.get_the_post_thumbnail().'</div>
                                <p>'.esc_html(get_the_title()).'</p>
                                </a>
                            </div>';
            }
            $output .= '</div>';
        }
        else {
            $output .= __('Sorry, no posts matched your criteria.');
        }

        wp_reset_postdata();

        return $output;
    }
}