<?php
namespace Ois\TwigFoundation;

class TwigFoundation extends \TimberSite
{

    /**
     * Initialise all the things
     */
    public function __construct()
    {
        add_theme_support('post-formats');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');

        add_filter('timber_context', array($this, 'add_to_context'));
        add_filter('get_twig',       array($this, 'add_to_twig'));

        add_action('init', array($this, 'register_post_types'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('init', array($this, 'register_menus'));

        add_action('widgets_init', array($this, 'widgets_init'));

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        parent::__construct();
    }

    /**
     * A place to register custom post types
     */
    public function register_post_types()
    {

    }

    /**
     * A place to register taxonomies
     */
    public function register_taxonomies()
    {

    }

    /**
     * enqueue all the things
     */
    public function enqueue_scripts() {

        $this->register_css();
        $this->register_js();

        $this->enqueue_css();
        $this->enqueue_js();
    }

    /**
     * A place to register css
     */
    public function register_css()
    {

        $dir = get_stylesheet_directory_uri();

        wp_register_style(
            'ois_wptf_app',
            $dir . '/stylesheets/app.css',
            array()
        );
    }

    /**
     * A place to register js
     */
    public function register_js()
    {

        $dir = get_stylesheet_directory_uri();

        wp_register_script(
            'ois_wptf_modernizr',
            $dir . '/bower_components/modernizr/modernizr.js',
            array(),
            FALSE,
            FALSE
        );
        wp_register_script(
            'ois_wptf_jquery',
            $dir . '/bower_components/jquery/dist/jquery.js',
            array(),
            FALSE,
            TRUE
        );
        wp_register_script(
            'ois_wptf_foundation',
            $dir . '/bower_components/foundation/js/foundation.js',
            array(
                'ois_wptf_modernizr',
                'ois_wptf_jquery'
            ),
            FALSE,
            TRUE
        );
        wp_register_script(
            'ois_wptf_app',
            $dir . '/scripts/app.js',
            array(
                'ois_wptf_foundation'
            ),
            FALSE,
            TRUE
        );
    }

    /**
     * A place to enqueue css
     */
    public function enqueue_css()
    {

        wp_enqueue_style('ois_wptf_app');
    }

    /**
     * A place to enqueue js
     */
    public function enqueue_js()
    {

        wp_enqueue_script('ois_wptf_app');
    }

    /**
     * A place to register sidebars
     */
    public function widgets_init()
    {

        register_sidebar(array(
            'name' => 'Home Primary Widget',
            'id' => 'home-primary',
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
        ));

        register_sidebar(array(
            'name' => 'Home Widget 1',
            'id' => 'home-one',
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
        ));

        register_sidebar(array(
            'name' => 'Home Widget 2',
            'id' => 'home-two',
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
        ));
    }

    /**
     * A place to make stuff available in the view
     *
     * @param  Array $context
     * @return Array $context
     */
    public function add_to_context($context)
    {
        $context['menu'] = array(
            'header' => new \TimberMenu('header-menu'),
            'footer' => new \TimberMenu('footer-menu')
        );
        $context['site'] = $this;

        return $context;
    }

    /**
     * A place to add Twig Filters
     *
     * @param  Twig $twig
     * @return Twig $twig
     */
    public function add_to_twig($twig)
    {
        $twig->addExtension(new \Twig_Extension_StringLoader);

        return $twig;
    }

    /**
     * A place to register menus
     */
    public function register_menus()
    {
        register_nav_menus(array(
            'header-menu' => 'Header Menu',
            'footer-menu' => 'Footer Menu'
        ));
    }
}