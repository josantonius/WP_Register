<?php 
/**
 * Register, minify and unify CSS and JavaScript resources.
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/WP_Register
 * @since      1.0.4
 */
namespace Josantonius\WP_Register\Test;

use Josantonius\WP_Register\WP_Register;

/**
 * Tests class for WP_Register library.
 * 
 * @since 1.0.4
 */
final class UnifyAdminFiles extends \WP_UnitTestCase { 

    /**
     * Theme url.
     *
     * @since 1.0.4
     *
     * @var string
     */
    protected $themeUrl;

    /**
     * Set up.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function setUp() {

        parent::setUp();

        $this->themeUrl = get_theme_root_uri() . '/twentytwelve/';
    }

    /**
     * Unify files specifying the same url path for styles and scripts.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testUnify() {
        
        $this->assertTrue(

            WP_Register::unify('UniqueID', $this->themeUrl . 'min/')
        );
    }

    /**
     * Unify files specifying different url paths for styles and scripts.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testUnifySpecifyingDifferentUrlPaths() {
        
        $this->assertTrue(

            WP_Register::unify('UniqueID', [

                'styles'  => $this->themeUrl . 'min/css/',
                'scripts' => $this->themeUrl . 'min/js/'
            ])
        );
    }

    /**
     * Unify files specifying the same url path for styles and scripts.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testUnifyAndMinify() {
        
        $this->assertTrue(

            WP_Register::unify('UniqueID', $this->themeUrl . 'min/', true)
        );
    }

    /**
     * Unify files specifying different url paths for styles and scripts.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testUnifyAndMinifySpecifyingDifferentUrlPaths() {
        
        $this->assertTrue(

            WP_Register::unify('UniqueID', [

                'styles'  => $this->themeUrl . 'min/css/',
                'scripts' => $this->themeUrl . 'min/js/'

            ], true)
        );
    }

    /**
     * Add front-end styles and scripts.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddFrontEndStylesAndScripts() {
        
        $this->assertTrue(

            WP_Register::add('style', [

                'name' => 'EditorStyleAdmin',
                'url'  => $this->themeUrl . 'editor-style.css',
                'place'   => 'admin',
                'deps'    => [],
                'version' => '1.1.3',
                'media'   => 'all'
            ])
        );

        $this->assertTrue(

            WP_Register::add('style', [

                'name'    => 'DefaultStyleAdmin',
                'url'     => $this->themeUrl . 'style.css',
                'place'   => 'admin',
                'deps'    => [],
                'version' => '1.1.3',
                'media'   => 'all'
            ])
        );

        $this->assertTrue(

            WP_Register::add('script', [

                'name'  => 'HTML_scriptAdmin',
                'url'   => $this->themeUrl . 'js/html5.js',
                'place'   => 'admin',
                'deps'    => ['jquery'],
                'version' => '1.1.3',
                'footer'  => true,
                'params'  => ['date' => date('now')]
            ])
        );

        $this->assertTrue(

            WP_Register::add('script', [

                'name'    => 'NavigationScriptAdmin',
                'url'     => $this->themeUrl . 'js/navigation.js',
                'place'   => 'admin',
                'deps'    => ['jquery-effects-core'],
                'version' => '1.1.3',
                'footer'  => true,
                'params'  => ['date' => date('now')]
            ])
        );
    }

    /**
     * Check if the admin styles and scripts have been added correctly.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testIfFrontEndStylesAndScriptsAddedCorrectly() {

        $this->assertTrue(

            WP_Register::isAdded('style', 'EditorStyleAdmin')
        );

        $this->assertTrue(

            WP_Register::isAdded('style', 'DefaultStyleAdmin')
        );

        $this->assertTrue(

            WP_Register::isAdded('script', 'HTML_scriptAdmin')
        );

        $this->assertTrue(

            WP_Register::isAdded('script', 'NavigationScriptAdmin')
        );
    }

    /**
     * If admin style is registered.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testIfFrontEndStyleAndScriptsWasRegistered() {

        do_action('admin_enqueue_scripts');

        $this->assertTrue(

            wp_style_is('UniqueID', 'registered')
        );

        $this->assertTrue(

            wp_script_is('UniqueID', 'registered')
        );

        $this->assertTrue(

            wp_script_is('jquery', 'registered')
        );

        $this->assertTrue(

            wp_script_is('jquery-effects-core', 'registered')
        );
    }

    /**
     * Validate whether unified files have been created.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testIfUnifiedFilesWasCreated() {

        $css = sha1('editor-style.css' . 'style.css') . '.css';

        $this->assertTrue(

            file_exists(get_theme_root() . '/twentytwelve/min/css/' . $css)
        );

        $js = sha1('html5.js' . 'navigation.js') . '.js';
        
        $this->assertTrue(

            file_exists(get_theme_root() . '/twentytwelve/min/js/' . $js)
        );
    }

    /**
     * If admin style is enqueued.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testIfFrontEndStylesAndScriptsAreEnqueued() {

        $this->assertTrue(

            wp_style_is('UniqueID', 'enqueued')
        );

        $this->assertTrue(

            wp_script_is('UniqueID', 'enqueued')
        );

        $this->assertTrue(

            wp_script_is('jquery', 'enqueued')
        );

        $this->assertTrue(

            wp_script_is('jquery-effects-core', 'enqueued')
        );
    }

    /**
     * If admin style is queue.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testIfFrontEndStylesAndScriptsAreQueue() {

        $this->assertTrue(

            wp_style_is('UniqueID', 'queue')
        );

        $this->assertTrue(

            wp_script_is('UniqueID', 'queue')
        );

        $this->assertTrue(

            wp_script_is('jquery', 'queue')
        );

        $this->assertTrue(

            wp_script_is('jquery-effects-core', 'queue')
        );
    }

    /**
     * If admin style has been printed.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testIfFrontEndStylesAndScriptAreDone() {

        do_action('wp_print_footer_scripts');

        $this->assertTrue(

            wp_style_is('UniqueID', 'done')
        );

        $this->assertTrue(

            wp_script_is('UniqueID', 'done')
        );

        $this->assertTrue(

            wp_script_is('jquery', 'done')
        );

        $this->assertTrue(

            wp_script_is('jquery-effects-core', 'done')
        );
    }

    /**
     * Delete added front-end styles.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testRemoveAddedFrontEndStylesAndScripts() {

        WP_Register::unify('UniqueID', false);

        $this->assertTrue(

            WP_Register::remove('style', 'UniqueID')
        );

        wp_deregister_style('UniqueID');
        
        wp_dequeue_style('UniqueID');

        $this->assertTrue(

            WP_Register::remove('script', 'UniqueID')
        );

        wp_deregister_script('UniqueID');
        
        wp_dequeue_script('UniqueID');
    }

    /**
     * Validation after deletion.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testValidationAfterDeletion() {

        $this->assertFalse(

            wp_style_is('UniqueID', 'queue')
        );

        $this->assertFalse(

            wp_style_is('UniqueID', 'enqueued')
        );

        $this->assertFalse(

            wp_style_is('UniqueID', 'registered')
        );

        $this->assertFalse(

            WP_Register::isAdded('style', 'UniqueID')
        );

        $this->assertFalse(

            wp_script_is('UniqueID', 'queue')
        );

        $this->assertFalse(

            wp_script_is('UniqueID', 'enqueued')
        );

        $this->assertFalse(

            wp_script_is('UniqueID', 'registered')
        );

        $this->assertFalse(

            WP_Register::isAdded('script', 'UniqueID')
        );
    }
}
