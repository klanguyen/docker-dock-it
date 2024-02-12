<?php
/**
 * Book Plugin
 *
 * @wordpress-plugin
 * Plugin Name: Book Plugin
 * Description: All about books
 * Version: 1.0.0
 * Author: Kayla Nguyen
 * Text Domain: wpd-books
 */

namespace KN\BookPlugin;

// include class files (autoloaders are complicated in WordPress)
require_once __DIR__.'/classes/Singleton.php';
require_once __DIR__.'/classes/BookPostType.php';
require_once __DIR__.'/classes/GenreTaxonomy.php';
require_once __DIR__.'/classes/ReviewPostType.php';
require_once __DIR__.'/classes/BookMeta.php';
require_once __DIR__.'/classes/ReviewMeta.php';
require_once __DIR__.'/classes/RatingGenerator.php';
require_once __DIR__.'/classes/ReviewShortcode.php';
require_once __DIR__.'/classes/BookShortcode.php';
require_once __DIR__.'/classes/ContactShortcode.php';
require_once __DIR__.'/classes/BookSettings.php';
/**
 * Represents a Book Plugin
 */
class KnBookPlugin extends Singleton
{

    /**
     * @var bool $instance Hold the single instance
     */
    protected static $instance = false;

    // unique to the namespace
    /**
     * A constant holding the text domain of the plugin
     */
    const TEXT_DOMAIN = 'wpd-books';

    /**
     * Book plugin constructor
     */
    protected function __construct()
    {
        // instantiate singletons
        BookPostType::getInstance();
        GenreTaxonomy::getInstance();
        ReviewPostType::getInstance();
        BookMeta::getInstance();
        ReviewMeta::getInstance();
        ReviewShortcode::getInstance();
        BookShortcode::getInstance();
        ContactShortcode::getInstance();
        BookSettings::getInstance();

        // create an activation hook so when the plugin is activated, flush permalinks cache
        function activate_plugin(){
            // manually register post type
            BookPostType::getInstance()->registerBookPostType();
            GenreTaxonomy::getInstance()->registerTaxonomy();
            ReviewPostType::getInstance()->registerReviewPostType();

            // refresh the permalink cache
            flush_rewrite_rules();
        }
        register_activation_hook(__FILE__, 'KN\BookPlugin\KnBookPlugin\activate_plugin');
    }
}

KnBookPlugin::getInstance();







