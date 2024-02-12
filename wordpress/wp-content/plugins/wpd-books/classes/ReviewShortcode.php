<?php

namespace KN\BookPlugin;
/**
 * Represents a Review Shortcode
 */
class ReviewShortcode extends Singleton
{

    /**
     * @var static $instance Hold the single instance
     */
    protected static $instance;

    /**
     * @return void Constructor creates a shortcode
     */
    protected function __construct()
    {
        add_shortcode('kn-random-review-block', [$this, 'randomReviewShortcode']);
    }

    /**
     * @return void Prevent cloning (PHP specific)
     */
    protected function __clone(){}

    /**
     * @return string Display a random review string
     */
    public function randomReviewShortcode(){
        // display a random review
        // That review should include the review, reviewer’s name, location and a link to the book.
        $output = '';
        $query = new \WP_Query(array(
            'post_type' => ReviewPostType::POST_TYPE,
            'orderby' => 'rand',
            'posts_per_page' => '1',
        ));

        if($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $reviewContent = get_post_field('post_content', get_the_ID());
                $reviewerName = get_post_meta(get_the_ID(), ReviewMeta::REVIEWER_NAME, true);
                $reviewerLocation = get_post_meta(get_the_ID(), ReviewMeta::REVIEWER_CITY, true).', '.
                                    get_post_meta(get_the_ID(), ReviewMeta::REVIEWER_STATE, true);
                $bookLink = get_permalink(get_post_meta(get_the_ID(), ReviewMeta::REVIEW_BOOK_ID, true));
                $bookTitle = get_the_title(get_post_meta(get_the_ID(), ReviewMeta::REVIEW_BOOK_ID, true));
                $output .= "<div class='review-block'>
                                <blockquote class='blockquote'>{$reviewContent}</blockquote>
                                <p class='blockquote-footer'><strong>{$reviewerName}</strong> ";
                if(get_option(BookSettings::SHOW_REVIEWER_LOCATION)){
                    $output .= "({$reviewerLocation})";
                }
                $output .=      "</p>
                                <p>A review for <a href='".$bookLink."'>{$bookTitle}</a></p>
                            </div>";
            }
        } else {
            $output .= __('Sorry, no posts matched your criteria.');
        }

        wp_reset_postdata();

        return $output;
    }
}