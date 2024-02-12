<?php

namespace KN\BookPlugin;
/**
 * Represents a Book Settings
 */
class BookSettings extends Singleton
{
    // these are the keys that will be stored in the database (need to be unique)
    // we will reference these constants to avoid typos

    /**
     * A constant holding the name of use Gutenberg editor field
     */
    const USE_GUTENBERG = 'useGutenbergEditor';
    /**
     * A constant holding the name of show purchase link field
     */
    const SHOW_PURCHASE_LINK = 'showPurchaseLink';
    /**
     * A constant holding the name of homepage greetings field
     */
    const HOMEPAGE_GREETINGS = 'homePageGreetings';
    /**
     * A constant holding the name of most recent books amount field
     */
    const MOST_RECENT_BOOKS_AMT = 'mostRecentBooksAmount';
    /**
     * A constant holding the name of show reviewer's location field
     */
    const SHOW_REVIEWER_LOCATION = 'showReviewerLocation';
    /**
     * A constant holding the name of the settings group
     */
    const SETTINGS_GROUP = 'books';

    /**
     * @var static $instance Hold the single instance
     */
    protected static $instance;

    /**
     * Book Settings constructor
     */
    protected function __construct()
    {
        add_action('admin_init', [$this, 'registerSettings']);
        add_action('admin_menu', [$this, 'addMenuPages']);
    }


    /**
     * @return void Register the settings/group with WordPress
     */
    public function registerSettings(){
        register_setting(self::SETTINGS_GROUP, self::USE_GUTENBERG);
        register_setting(self::SETTINGS_GROUP, self::SHOW_PURCHASE_LINK);
        register_setting(self::SETTINGS_GROUP, self::HOMEPAGE_GREETINGS);
        register_setting(self::SETTINGS_GROUP, self::MOST_RECENT_BOOKS_AMT);
        register_setting(self::SETTINGS_GROUP, self::SHOW_REVIEWER_LOCATION);

        $this->addFields();
    }

    /**
     * @return void Add page(s) to admin menu
     */
    public function addMenuPages(){
        add_submenu_page(
                        'edit.php?post_type=book',
                        'Book Plugin Settings',
                        'Settings',
                        'manage_options',
                        'book_settings',
                        [$this, 'settingsPage'],
                        99
        );

        // for debugging
        /*echo "<pre>";
        print_r($GLOBALS['menu']);
        print_r($GLOBALS['submenu']);
        die();*/
    }

    /**
     * @return void Settings page template
     */
    public function settingsPage(){
        ?>
        <div class="wrap">
            <h2>Book Settings</h2>
            <p>Configure features of this plugin.</p>
            <form method="post" action="options.php">
            <!-- This needs to match what is in register_settings() -->
            <?php settings_fields(self::SETTINGS_GROUP); ?>

            <!-- This needs to match 'page' defined in add_settings_section() -->
            <?php do_settings_sections('book'); ?>
            <?php submit_button('Save Changes'); ?>
            </form>
        </div>
        <?php
    }

    /**
     * @return void Add custom input fields
     */
    public function addFields(){
        // define our sections
        add_settings_section(
                'book_general',
                'General Book Settings',
                function(){}, // more important if using an existing settings page
                'book' // or 'general', 'writing', etc.
        );

        add_settings_field(
                self::USE_GUTENBERG,
                'Use Gutenberg Editor',
                function(){
                    $checked = get_option(self::USE_GUTENBERG) ? 'checked' : '';
                    ?>
                    <input type="checkbox"
                           id="<?= self::USE_GUTENBERG ?>"
                           name="<?= self::USE_GUTENBERG ?>"
                           <?= $checked ?>
                    >
                    <?php
                },
                'book',
                'book_general'
        );

        add_settings_field(
            self::SHOW_PURCHASE_LINK,
            'Show Purchase Link',
            function(){
                $checked = get_option(self::SHOW_PURCHASE_LINK) ? 'checked' : '';
                ?>
                <input type="checkbox"
                       id="<?= self::SHOW_PURCHASE_LINK ?>"
                       name="<?= self::SHOW_PURCHASE_LINK ?>"
                    <?= $checked ?>
                >
                <?php
            },
            'book',
            'book_general'
        );

        add_settings_field(
            self::HOMEPAGE_GREETINGS,
            'Home Page Greetings',
            function(){
                $greetings = get_option(self::HOMEPAGE_GREETINGS);
                ?>
                <input type="text"
                       id="<?= self::HOMEPAGE_GREETINGS ?>"
                       name="<?= self::HOMEPAGE_GREETINGS ?>"
                       value="<?= $greetings ?>"
                >
                <?php
            },
            'book',
            'book_general'
        );

        add_settings_field(
            self::MOST_RECENT_BOOKS_AMT,
            'Most Recent Books Amount',
            function(){
                $mostRecentBooksAmt = get_option(self::MOST_RECENT_BOOKS_AMT);
                ?>
                <input type="number" min="1" max="5"
                       id="<?= self::MOST_RECENT_BOOKS_AMT ?>"
                       name="<?= self::MOST_RECENT_BOOKS_AMT ?>"
                       value="<?= $mostRecentBooksAmt ?>"
                >
                <?php
            },
            'book',
            'book_general'
        );

        add_settings_field(
            self::SHOW_REVIEWER_LOCATION,
            'Show Reviewer\'s Location',
            function(){
                $checked = get_option(self::SHOW_REVIEWER_LOCATION) ? 'checked' : '';
                ?>
                <input type="checkbox"
                       id="<?= self::SHOW_REVIEWER_LOCATION ?>"
                       name="<?= self::SHOW_REVIEWER_LOCATION ?>"
                    <?= $checked ?>
                >
                <?php
            },
            'book',
            'book_general'
        );
    }
}