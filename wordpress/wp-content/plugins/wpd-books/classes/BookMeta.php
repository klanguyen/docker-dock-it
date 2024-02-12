<?php

namespace KN\BookPlugin;
/**
 * Represents a Review Meta box
 */
class BookMeta extends Singleton
{

    /**
     * A constant holding the name of book publisher field
     */
    const BOOK_PUBLISHER = 'bookPublisher';
    /**
     * A constant holding the name of book published date field
     */
    const BOOK_PUBLISHED_DATE = 'bookPublishedDate';
    /**
     * A constant holding the name of book page count field
     */
    const BOOK_PAGE_COUNT = 'bookPageCount';
    /**
     * A constant holding the name of book price field
     */
    const BOOK_PRICE = 'bookPrice';
    /**
     * A constant holding the name of book accolades field
     */
    const BOOK_ACCOLADES = 'bookAccolades';

    /**
     * A constant holding the name of book purchase link field
     */
    const PURCHASE_LINK = 'bookPurchaseLink';

    /**
     * @var static $instance Hold the single instance
     */
    protected static $instance;

    /**
     * Book Meta constructor
     */
    protected function __construct()
    {
        add_action('admin_init', [$this, 'registerMetaBox'], 0);

        add_action('save_post_'.BookPostType::POST_TYPE, [$this, 'saveBookInformation']);
    }

    /**
     * @return void Function registering a meta box
     */
    public function registerMetaBox(){
        add_meta_box('book_information_meta',
                    'Book Information',
                    [$this, 'outputBookInformation'],
                    BookPostType::POST_TYPE,
                    'normal');
    }

    /**
     * @return void Book information template
     */
    public function outputBookInformation(){
        $post = get_post();

        $bookPublisher = get_post_meta($post->ID, self::BOOK_PUBLISHER, true);
        $bookPublishedDate = get_post_meta($post->ID, self::BOOK_PUBLISHED_DATE, true);
        $bookPageCount = get_post_meta($post->ID, self::BOOK_PAGE_COUNT, true);;
        $bookPrice = get_post_meta($post->ID, self::BOOK_PRICE, true);
        $bookAccolades = get_post_meta($post->ID, self::BOOK_ACCOLADES, true);
        $bookPurchaseLink = get_post_meta($post->ID, self::PURCHASE_LINK, true);

        $output = '<p>
                        <label>'.__('Publisher: ').'<input type="text" name="bookPublisher" value="'.$bookPublisher.'"></label>
                    </p>
                    <p>
                        <label>'.__('Published Date: ').'<input type="date" name="bookPublishedDate" value="'.$bookPublishedDate.'"></label>
                    </p>
                    <p>
                        <label>'.__('Page Count: ').'<input type="number" min="1" name="bookPageCount" value="'.$bookPageCount.'"></label>
                    </p>
                    <p>
                        <label>'.__('Price: $').'<input type="number" name="bookPrice" value="'.$bookPrice.'"></label>
                    </p>
                    <p>
                        <label>'.__('Accolades: ').'<input type="text" name="bookAccolades" value="'.$bookAccolades.'"></label>
                    </p>';

        if(get_option(BookSettings::SHOW_PURCHASE_LINK)){
            $output .= '<p>
                            <label>'.__('Purchase link: ').'<input type="text" name="bookPurchaseLink" value="'.$bookPurchaseLink.'"></label>
                        </p>';
        }
        /*?>
        <p>
            <label>Publisher: <input type="text" name="bookPublisher" value="<?= $bookPublisher ?>"></label>
        </p>
        <p>
            <label>Published Date: <input type="date" name="bookPublishedDate" value="<?= $bookPublishedDate ?>"></label>
        </p>
        <p>
            <label>Page Count: <input type="number" min='1' name="bookPageCount" value="<?= $bookPageCount ?>"></label>
        </p>
        <p>
            <label>Price: $<input type="number" name="bookPrice" value="<?= $bookPrice ?>"></label>
        </p>
        <p>
            <label>Accolades: <input type="text" name="bookAccolades" value="<?= $bookAccolades ?>"></label>
        </p>
        <?php*/

        echo $output;
    }

    /**
     * @return void Update or create a book meta
     */
    public function saveBookInformation(){
        // get values from the form
        $bookPublisher = sanitize_text_field($_POST['bookPublisher']);
        $bookPublishedDate = $_POST['bookPublishedDate'];
        $bookPageCount = intval($_POST['bookPageCount']);
        $bookPrice = number_format($_POST['bookPrice'], 2);
        $bookAccolades = sanitize_text_field($_POST['bookAccolades']);
        $bookPurchaseLink = sanitize_url($_POST['bookPurchaseLink']);

        $post = get_post();

        // store meta in the database
        update_post_meta($post->ID, self::BOOK_PUBLISHER, $bookPublisher);
        update_post_meta($post->ID, self::BOOK_PUBLISHED_DATE, $bookPublishedDate);
        update_post_meta($post->ID, self::BOOK_PAGE_COUNT, $bookPageCount);
        update_post_meta($post->ID, self::BOOK_PRICE, $bookPrice);
        update_post_meta($post->ID, self::BOOK_ACCOLADES, $bookAccolades);
        update_post_meta($post->ID, self::PURCHASE_LINK, $bookPurchaseLink);
    }
}