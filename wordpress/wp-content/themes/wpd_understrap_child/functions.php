<?php
if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.2.2' );
}

add_action('wp_enqueue_scripts', 'wpd_understrap_child_enqueue_styles', 100);
function wpd_understrap_child_enqueue_styles()
{
    $parenthandle = 'understrap';
    $theme = wp_get_theme();
    // fonts
    wp_enqueue_style( 'wpd_understrap_child-fonts',
        'https://fonts.googleapis.com/css2?family=Caveat&display=swap',
        array(),
        _S_VERSION);

    wp_enqueue_style($parenthandle,
        // template_directory always refers to the parent
        get_template_directory_uri() . '/style.css',
        array(),  // If the parent theme code has a dependency, copy it to here.
        $theme->parent()->get('Version')
    );
    wp_enqueue_style('wpd_understrap_child',
        // stylesheet_directory refers to the active/child theme
        get_stylesheet_uri(),
        array($parenthandle),
        $theme->get('Version') // This only works if you have Version defined in the style header.
    );

    // remove duplicates or styles we're not using
    wp_dequeue_style('understrap-style');
    wp_dequeue_style('flexslider');
}

function wpd_understrap_child_scripts() {
     wp_enqueue_style( 'wpd_understrap_child-style', get_stylesheet_uri(), array(), _S_VERSION );
}
add_action( 'wp_enqueue_scripts', 'wpd_understrap_child_scripts' );


function wpd_understrap_child_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Most recent books', 'wpd_understrap_child' ),
            'id'            => 'most-recent-books',
            'description'   => esc_html__( 'Add widgets here.', 'wpd_understrap_child' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Random review', 'wpd_understrap_child' ),
            'id'            => 'random-review',
            'description'   => esc_html__( 'Add widgets here.', 'wpd_understrap_child' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
        )
    );
}
add_action( 'widgets_init', 'wpd_understrap_child_widgets_init' );

// get rid of the “Category:”, “Tag:”, “Author:”, “Archives:” and “Other taxonomy name:”
function wpd_understrap_child_archive_title( $title ) {
    if ( is_post_type_archive() ) {
        $title = post_type_archive_title('', false);
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'wpd_understrap_child_archive_title' );