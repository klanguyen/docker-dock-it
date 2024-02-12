<?php

namespace KN\BookPlugin;
/**
 * Represents a Review Post Type
 */
class BookPostType extends Singleton
{

    /**
     * A constant holding post type name
     */
    const POST_TYPE = 'book';

    /**
     * @var static $instance Hold the single instance
     */
    protected static $instance;

    /**
     * Book Post Type constructor
     */
    protected function __construct()
    {
        add_action( 'init', [$this, 'registerBookPostType'], 0 );
        add_filter('the_content', [$this, 'bookContentTemplate']);
    }

    /**
     * @return void Register a custom post type
     */
    public function registerBookPostType() {

        $labels = array(
            'name'                  => _x( 'Books', 'Post Type General Name', KnBookPlugin::TEXT_DOMAIN ),
            'singular_name'         => _x( 'Book', 'Post Type Singular Name', KnBookPlugin::TEXT_DOMAIN ),
            'menu_name'             => __( 'Books', KnBookPlugin::TEXT_DOMAIN ),
            'name_admin_bar'        => __( 'Books', KnBookPlugin::TEXT_DOMAIN ),
            'archives'              => __( 'Book Archives', KnBookPlugin::TEXT_DOMAIN ),
            'attributes'            => __( 'Book Attributes', KnBookPlugin::TEXT_DOMAIN ),
            'parent_item_colon'     => __( 'Parent Book:', KnBookPlugin::TEXT_DOMAIN ),
            'all_items'             => __( 'All Books', KnBookPlugin::TEXT_DOMAIN ),
            'add_new_item'          => __( 'Add New Book', KnBookPlugin::TEXT_DOMAIN ),
            'add_new'               => __( 'Add New Book', KnBookPlugin::TEXT_DOMAIN ),
            'new_item'              => __( 'New Book', KnBookPlugin::TEXT_DOMAIN ),
            'edit_item'             => __( 'Edit Book', KnBookPlugin::TEXT_DOMAIN ),
            'update_item'           => __( 'Update Book', KnBookPlugin::TEXT_DOMAIN ),
            'view_item'             => __( 'View Book', KnBookPlugin::TEXT_DOMAIN ),
            'view_items'            => __( 'View Books', KnBookPlugin::TEXT_DOMAIN ),
            'search_items'          => __( 'Search Book', KnBookPlugin::TEXT_DOMAIN ),
            'not_found'             => __( 'Not found', KnBookPlugin::TEXT_DOMAIN ),
            'not_found_in_trash'    => __( 'Not found in Trash', KnBookPlugin::TEXT_DOMAIN ),
            'featured_image'        => __( 'Featured Image', KnBookPlugin::TEXT_DOMAIN ),
            'set_featured_image'    => __( 'Set featured image', KnBookPlugin::TEXT_DOMAIN ),
            'remove_featured_image' => __( 'Remove featured image', KnBookPlugin::TEXT_DOMAIN ),
            'use_featured_image'    => __( 'Use as featured image', KnBookPlugin::TEXT_DOMAIN ),
            'insert_into_item'      => __( 'Insert into book', KnBookPlugin::TEXT_DOMAIN ),
            'uploaded_to_this_item' => __( 'Uploaded to this book', KnBookPlugin::TEXT_DOMAIN ),
            'items_list'            => __( 'Books list', KnBookPlugin::TEXT_DOMAIN ),
            'items_list_navigation' => __( 'Books list navigation', KnBookPlugin::TEXT_DOMAIN ),
            'filter_items_list'     => __( 'Filter books list', KnBookPlugin::TEXT_DOMAIN ),
        );
        $args = array(
            'label'                 => __( 'Book', KnBookPlugin::TEXT_DOMAIN ),
            'description'           => __( 'Interesting Books', KnBookPlugin::TEXT_DOMAIN ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-book',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'books',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => get_option(BookSettings::USE_GUTENBERG),
        );
        register_post_type( static::POST_TYPE, $args );

    }

    /**
     * @param mixed|string $content The content of the post
     * @return mixed|string The book content template
     */
    public function bookContentTemplate($content){
        $post = get_post();

        if($post->post_type == self::POST_TYPE){
            $bookPublisher = get_post_meta($post->ID, BookMeta::BOOK_PUBLISHER, true);
            $bookPublishedDate = get_post_meta($post->ID, BookMeta::BOOK_PUBLISHED_DATE, true);
            $bookPageCount = get_post_meta($post->ID, BookMeta::BOOK_PAGE_COUNT, true);
            $bookPrice = get_post_meta($post->ID, BookMeta::BOOK_PRICE, true);
            $bookAccolades = get_post_meta($post->ID, BookMeta::BOOK_ACCOLADES, true);
            $bookPurchaseLink = get_post_meta($post->ID, BookMeta::PURCHASE_LINK, true);

            $avgRating = ReviewPostType::getAverageRating(get_the_ID());
            $reviewList = ReviewPostType::displayReviewsList(get_the_ID());

            $content = "<div class='book-description'>
                            $content
                            <div class='avg-rating'><p>Average Ratings: $avgRating</p></div>";
            if(get_option(BookSettings::SHOW_PURCHASE_LINK)){
                $content .= "<div class='purchase-link'>
                                <p>You can buy ".get_the_title()." from your favorite retailer via the 
                                <a href='{$bookPurchaseLink}'>Penguin portal</a></p>
                            </div>";
            }
            $content .= "</div> <!-- end .book-description -->
                        <div class='book-meta'>
                            <div class='row'>
                                <div class='col-md-5'>
                                    <h4>Book Information</h4>
                                    <p><strong>Publisher: </strong>$bookPublisher</p>
                                    <p><strong>Published Date: </strong>$bookPublishedDate</p>
                                    <p><strong>Page Count: </strong>$bookPageCount</p>
                                    <p><strong>Price: </strong>\$$bookPrice</p>
                                    <p><strong>Accolades: </strong>$bookAccolades</p>
                                </div>
                                <div class='col-md-7'>
                                    $reviewList
                                </div>
                            </div>
                        </div>";
        }

        return $content;
    }


}