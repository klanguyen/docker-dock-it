<?php

namespace KN\BookPlugin;
/**
 * Represents a Review Post Type
 */
class ReviewPostType extends Singleton
{

    /**
     * A constant holding post type name
     */
    const POST_TYPE = 'review';

    /**
     * @var static $instance Hold the single instance
     */
    protected static $instance;

    /**
     * A constructor registers review post type and run the function generating content template
     */
    protected function __construct()
    {
        add_action( 'init', [$this, 'registerReviewPostType'], 0 );
        add_filter('the_content', [$this, 'reviewContentTemplate']);
    }

    // Register Custom Post Type

    /**
     * @return void Register custom post type
     */
    public function registerReviewPostType() {

        $labels = array(
            'name'                  => _x( 'Reviews', 'Post Type General Name', KnBookPlugin::TEXT_DOMAIN ),
            'singular_name'         => _x( 'Review', 'Post Type Singular Name', KnBookPlugin::TEXT_DOMAIN ),
            'menu_name'             => __( 'Reviews', KnBookPlugin::TEXT_DOMAIN ),
            'name_admin_bar'        => __( 'Reviews', KnBookPlugin::TEXT_DOMAIN ),
            'archives'              => __( 'Review Archives', KnBookPlugin::TEXT_DOMAIN ),
            'attributes'            => __( 'Review Attributes', KnBookPlugin::TEXT_DOMAIN ),
            'parent_item_colon'     => __( 'Parent Review:', KnBookPlugin::TEXT_DOMAIN ),
            'all_items'             => __( 'All Reviews', KnBookPlugin::TEXT_DOMAIN ),
            'add_new_item'          => __( 'Add New Review', KnBookPlugin::TEXT_DOMAIN ),
            'add_new'               => __( 'Add New', KnBookPlugin::TEXT_DOMAIN ),
            'new_item'              => __( 'New Review', KnBookPlugin::TEXT_DOMAIN ),
            'edit_item'             => __( 'Edit Review', KnBookPlugin::TEXT_DOMAIN ),
            'update_item'           => __( 'Update Review', KnBookPlugin::TEXT_DOMAIN ),
            'view_item'             => __( 'View Review', KnBookPlugin::TEXT_DOMAIN ),
            'view_items'            => __( 'View Reviews', KnBookPlugin::TEXT_DOMAIN ),
            'search_items'          => __( 'Search Review', KnBookPlugin::TEXT_DOMAIN ),
            'not_found'             => __( 'Not found', KnBookPlugin::TEXT_DOMAIN ),
            'not_found_in_trash'    => __( 'Not found in Trash', KnBookPlugin::TEXT_DOMAIN ),
            'featured_image'        => __( 'Featured Image', KnBookPlugin::TEXT_DOMAIN ),
            'set_featured_image'    => __( 'Set featured image', KnBookPlugin::TEXT_DOMAIN ),
            'remove_featured_image' => __( 'Remove featured image', KnBookPlugin::TEXT_DOMAIN ),
            'use_featured_image'    => __( 'Use as featured image', KnBookPlugin::TEXT_DOMAIN ),
            'insert_into_item'      => __( 'Insert into review', KnBookPlugin::TEXT_DOMAIN ),
            'uploaded_to_this_item' => __( 'Uploaded to this review', KnBookPlugin::TEXT_DOMAIN ),
            'items_list'            => __( 'Reviews list', KnBookPlugin::TEXT_DOMAIN ),
            'items_list_navigation' => __( 'Reviews list navigation', KnBookPlugin::TEXT_DOMAIN ),
            'filter_items_list'     => __( 'Filter reviews list', KnBookPlugin::TEXT_DOMAIN ),
        );
        $args = array(
            'label'                 => __( 'Review', KnBookPlugin::TEXT_DOMAIN ),
            'description'           => __( 'Reviews for Books', KnBookPlugin::TEXT_DOMAIN ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => 'edit.php?post_type=book',
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-star-filled',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type( static::POST_TYPE, $args );

    }

    /**
     * @param mixed|string $content The content of the post
     * @return mixed|string The content template
     */
    public function reviewContentTemplate($content){
        $post = get_post();

        if($post->post_type == self::POST_TYPE){
            $reviewerName = get_post_meta($post->ID, ReviewMeta::REVIEWER_NAME, true);
            $reviewerCity = get_post_meta($post->ID, ReviewMeta::REVIEWER_CITY, true);
            $reviewerState = get_post_meta($post->ID, ReviewMeta::REVIEWER_STATE, true);
            $reviewRating = get_post_meta($post->ID, ReviewMeta::REVIEW_RATING, true);
            //$reviewBookId = get_post_meta($post->ID, ReviewMeta::REVIEW_BOOK_ID, true);

            $reviewerLocation = '';
            $ratings = RatingGenerator::outputRatings($reviewRating);

            /*$content = "<h3>Description</h3>
                        <div>$content</div>
                        <h3>Review Information</h3>
                        <p><strong>Reviewer Name: </strong>$reviewerName</p>
                        <span>$reviewerLocation</span>
                        <p><strong>Ratings: </strong>$ratings</p>";*/
            if(get_option(BookSettings::SHOW_REVIEWER_LOCATION)){
                $reviewerLocation = "(".$reviewerCity.', '.$reviewerState.")";
            }
            $content = "<div class='review-description'>
                            <div class='review-meta'>
                                <p>Written by <span>$reviewerName</span> $reviewerLocation
                                </p></div>
                            <div class='avg-rating'><p>Ratings: $ratings</p></div>
                            <div class='review-content'>$content</div>
                        </div>";
        }

        return $content;
    }

    /**
     * @param mixed|int $bookId The ID of the book
     * @return string The formatted average rating
     */
    public static function getAverageRating($bookId){
        $args = array(
            'post_type' => ReviewPostType::POST_TYPE,
        );
        $allReviews = get_posts($args);
        $bookReviews = [];
        $output = 'N/A';

        foreach($allReviews as $review) {
            $reviewBookId = get_post_meta($review->ID, ReviewMeta::REVIEW_BOOK_ID, true);
            if($reviewBookId == $bookId){
                array_push($bookReviews, $review);
            }
        }
        if(count($bookReviews) !== 0){
            $ratings = 0;
            $ratingCount = 0;

            foreach($bookReviews as $bookReview){
                $ratingCount += 1;
                $ratings += get_post_meta($bookReview->ID, ReviewMeta::REVIEW_RATING, true);
            }

            $output = number_format($ratings/$ratingCount, 1).'/5';
        }

        return $output;
    }

    /**
     * @param mixed|int $bookId The ID of the book
     * @return string A template displaying the reviews list
     */
    public static function displayReviewsList($bookId){
        $args = array(
            'post_type' => ReviewPostType::POST_TYPE,
        );
        $allReviews = get_posts($args);
        $bookReviews = [];
        $output = "<h4>Reviews</h4>";

        foreach($allReviews as $review) {
            $reviewBookId = get_post_meta($review->ID, ReviewMeta::REVIEW_BOOK_ID, true);
            if($reviewBookId == $bookId){
                array_push($bookReviews, $review);
            }
        }

        if(count($bookReviews) !== 0){
            $output .= "<ul class='book-reviews'>";
            foreach($bookReviews as $bookReview){
                $reviewerName = get_post_meta($bookReview->ID, ReviewMeta::REVIEWER_NAME, true);
                $reviewerLocation = get_post_meta($bookReview->ID, ReviewMeta::REVIEWER_CITY, true).', '
                                    .get_post_meta($bookReview->ID, ReviewMeta::REVIEWER_STATE, true);
                $ratings = RatingGenerator::outputRatings(get_post_meta($bookReview->ID, ReviewMeta::REVIEW_RATING, true));
                $reviewContent = get_post_field('post_content', $bookReview->ID);
                $output .= "<li>
                                <span>$ratings</span>
                                <blockquote class='blockquote'>$reviewContent</blockquote>
                                <p class='blockquote-footer'><strong>$reviewerName</strong> ";
                if(get_option(BookSettings::SHOW_REVIEWER_LOCATION)){
                    $output .= "($reviewerLocation)";
                }
                $output .=      "</p>
                            </li>";
            }
            $output .= "</ul>";
        }
        else {
            $output .= "<p>There's no review yet, comeback later or <a href='".admin_url('post-new.php?post_type=review')."'>add a new review</a></p>";
        }

        return $output;
    }
}