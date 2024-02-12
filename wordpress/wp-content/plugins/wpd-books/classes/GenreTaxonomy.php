<?php

namespace KN\BookPlugin;
/**
 * Represents a Genre Taxonomy
 */
class GenreTaxonomy extends Singleton
{
    /**
     * A constant holding name of taxonomy
     */
    const TAXONOMY = 'genre';

    /**
     * @var static $instance Hold the single instance
     */
    protected static $instance;

    /**
     * Genre Taxonomy constructor
     */
    protected function __construct()
    {
        add_action( 'init', [$this, 'registerTaxonomy'], 0 );
    }

    // Register Custom Taxonomy

    /**
     * @return void Register a taxonomy
     */
    public function registerTaxonomy() {

        $labels = array(
            'name'                       => _x( 'Genres', 'Taxonomy General Name', KnBookPlugin::TEXT_DOMAIN ),
            'singular_name'              => _x( 'Genre', 'Taxonomy Singular Name', KnBookPlugin::TEXT_DOMAIN ),
            'menu_name'                  => __( 'Genre', KnBookPlugin::TEXT_DOMAIN ),
            'all_items'                  => __( 'All Genres', KnBookPlugin::TEXT_DOMAIN ),
            'parent_item'                => __( 'Parent Genre', KnBookPlugin::TEXT_DOMAIN ),
            'parent_item_colon'          => __( 'Parent Genre:', KnBookPlugin::TEXT_DOMAIN ),
            'new_item_name'              => __( 'New Genre Name', KnBookPlugin::TEXT_DOMAIN ),
            'add_new_item'               => __( 'Add New Genre', KnBookPlugin::TEXT_DOMAIN ),
            'edit_item'                  => __( 'Edit Genre', KnBookPlugin::TEXT_DOMAIN ),
            'update_item'                => __( 'Update Genre', KnBookPlugin::TEXT_DOMAIN ),
            'view_item'                  => __( 'View Genre', KnBookPlugin::TEXT_DOMAIN ),
            'separate_items_with_commas' => __( 'Separate genres with commas', KnBookPlugin::TEXT_DOMAIN ),
            'add_or_remove_items'        => __( 'Add or remove genres', KnBookPlugin::TEXT_DOMAIN ),
            'choose_from_most_used'      => __( 'Choose from the most used', KnBookPlugin::TEXT_DOMAIN ),
            'popular_items'              => __( 'Popular Genres', KnBookPlugin::TEXT_DOMAIN ),
            'search_items'               => __( 'Search Genres', KnBookPlugin::TEXT_DOMAIN ),
            'not_found'                  => __( 'Not Found', KnBookPlugin::TEXT_DOMAIN ),
            'no_terms'                   => __( 'No genres', KnBookPlugin::TEXT_DOMAIN ),
            'items_list'                 => __( 'Genres list', KnBookPlugin::TEXT_DOMAIN ),
            'items_list_navigation'      => __( 'Genres list navigation', KnBookPlugin::TEXT_DOMAIN ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'show_in_rest'               => true,
        );
        register_taxonomy( static::TAXONOMY, array( BookPostType::POST_TYPE ), $args );

    }
}