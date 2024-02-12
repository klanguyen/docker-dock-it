<?php

namespace KN\BookPlugin;

use KN\BookPlugin\Singleton;
/**
 * Represents a Review Meta box
 */
class ReviewMeta extends Singleton
{

    /**
     * A constant holding the name of reviewer name field
     */
    const REVIEWER_NAME = 'reviewerName';
    /**
     * A constant holding the name of reviewer city field
     */
    const REVIEWER_CITY = 'reviewerCity';
    /**
     * A constant holding the name of reviewer state field
     */
    const REVIEWER_STATE = 'reviewerState';
    /**
     * A constant holding the name of reviewer rating field
     */
    const REVIEW_RATING = 'reviewRating';
    /**
     * A constant holding the name of review book ID field
     */
    const REVIEW_BOOK_ID = 'reviewBookId';

    /**
     * @var static $instance Hold the single instance
     */
    protected static $instance;

    /**
     * Review Meta constructor
     */
    protected function __construct()
    {
        add_action('admin_init', [$this, 'registerMetaBox'], 0);
        // call our function when WP is trying to save a Recipe
        add_action('save_post_'.ReviewPostType::POST_TYPE, [$this, 'saveBookReviewInformation']);
    }

    /**
     * @return void Function registering meta box
     */
    public function registerMetaBox(){
        add_meta_box('book_review_information_meta',
            'Book Reviews Information',
            [$this, 'outputBookReviewInformation'],
            ReviewPostType::POST_TYPE,
            'normal');
    }

    /**
     * @return void Review information template
     */
    public function outputBookReviewInformation(){
        $post = get_post();

        $reviewerName = get_post_meta($post->ID, self::REVIEWER_NAME, true);
        $reviewerCity = get_post_meta($post->ID, self::REVIEWER_CITY, true);
        $reviewerState = get_post_meta($post->ID, self::REVIEWER_STATE, true);
        $reviewRating = get_post_meta($post->ID, self::REVIEW_RATING, true);
        $reviewBookId = get_post_meta($post->ID, self::REVIEW_BOOK_ID, true);

        /*$ratings = array(
                'one' => '<i class=\'fa fa-star\' aria-hidden=\'true\'></i>
                    <i class=\'fa fa-star-o\' aria-hidden=\'true\'></i>
                    <i class=\'fa fa-star-o\' aria-hidden=\'true\'></i>
                    <i class=\'fa fa-star-o\' aria-hidden=\'true\'></i>
                    <i class=\'fa fa-star-o\' aria-hidden=\'true\'></i>',
                'two' => '<i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>',
                'three' => '<i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>',
                'four' => '<i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>',
                'five' => '<i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>',
        );*/

        $dropdown_args_book = array(
            'post_type' => BookPostType::POST_TYPE,
            'name' => 'reviewBookId',
            'echo' => 0, // if not set this to 0, it'll show up when we set these arguments
            'selected' => $reviewBookId,
        );

        $output = '<p>
                        <label>'.__('Reviewer Name: ').'<input type="text" name="reviewerName" value="'.$reviewerName.'"></label>
                    </p>';

        if(get_option(BookSettings::SHOW_REVIEWER_LOCATION)) {
            $output .= '<h4>Reviewer\'s Location</h4>
                        <label>' . __('City: ') . '<input type="text" name="reviewerCity" value="' . $reviewerCity . '"></label>
                        <label>' . __('State: ') . '<input type="text" name="reviewerState" value="' . $reviewerState . '"></label>';
        }

        $output .=     '<p>
                        <label for="reviewRating">'.__('Rating:').'</label>
                        <select name="reviewRating" id="reviewRating">
                            <option value="1" '.selected($reviewRating, 1, false).'>One star</option>
                            <option value="2" '.selected($reviewRating, 2, false).'>Two stars</option>
                            <option value="3" '.selected($reviewRating, 3, false).'>Three stars</option>
                            <option value="4" '.selected($reviewRating, 4, false).'>Four stars</option>
                            <option value="5" '.selected($reviewRating, 5, false).'>Five stars</option>
                        </select>
                    </p>
                    <p>
                        <label for="reviewBookId">'.__('Book: ').'</label>'.
                        wp_dropdown_pages($dropdown_args_book).'
                    </p>';
        /*?>
        <p>
            <label>Reviewer Name: <input type="text" name="reviewerName" value="<?= $reviewerName ?>"></label>
        </p>
        <h4>Reviewer's Location</h4>
        <label>City: <input type="text" name="reviewerCity" value="<?= $reviewerCity ?>"></label>
        <label>State: <input type="text" name="reviewerState" value="<?= $reviewerState ?>"></label>

        <p>
            <label for="reviewRating">Rating:</label>
            <select name="reviewRating" id="reviewRating">
                <option value="1" <?php selected($reviewRating, 1) ?>>One star</option>
                <option value="2" <?php selected($reviewRating, 2) ?>>Two stars</option>
                <option value="3" <?php selected($reviewRating, 3) ?>>Three stars</option>
                <option value="4" <?php selected($reviewRating, 4) ?>>Four stars</option>
                <option value="5" <?php selected($reviewRating, 5) ?>>Five stars</option>
            </select>
        </p>
        <p>
            <label for="reviewBookId">Book :</label>
            <?= wp_dropdown_pages($dropdown_args_book) ?>
        </p>
        <?php*/

        echo $output;
    }

    /**
     * @return void Update or create a review meta
     */
    public function saveBookReviewInformation(){
        // get values from the form
        $reviewerName = sanitize_text_field($_POST['reviewerName']);
        $reviewerCity = sanitize_text_field($_POST['reviewerCity']);
        $reviewerState = sanitize_text_field($_POST['reviewerState']);
        $reviewRating = intval($_POST['reviewRating']);
        $reviewBookId = intval($_POST['reviewBookId']);

        $post = get_post();

        // store meta in the database
        update_post_meta($post->ID, self::REVIEWER_NAME, $reviewerName);
        update_post_meta($post->ID, self::REVIEWER_CITY, $reviewerCity);
        update_post_meta($post->ID, self::REVIEWER_STATE, $reviewerState);
        update_post_meta($post->ID, self::REVIEW_RATING, $reviewRating);
        update_post_meta($post->ID, self::REVIEW_BOOK_ID, $reviewBookId);
    }
}