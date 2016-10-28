<?php
namespace datagenerator\LolitaFramework\CssLoader;

use \datagenerator\LolitaFramework;
use \datagenerator\LolitaFramework\Core\Arr;
use \datagenerator\LolitaFramework\Core\View;
use \datagenerator\LolitaFramework\Core\Url;

class CssLoader
{
    /**
     * CssLoader class constructor
     *
     * @author Guriev Eugen <gurievcreative@gmail.com>
     */
    public function __construct()
    {
        require_once('templates.php');
        add_action('wp_enqueue_scripts', array(&$this, 'addScriptsAndStyles'));
        add_action('admin_enqueue_scripts', array(&$this, 'addScriptsAndStyles'));
        add_action('customize_controls_enqueue_scripts', array(&$this, 'addScriptsAndStyles'));
        // add_action('customize_controls_enqueue_scripts', array(&$this, 'addScriptsAndStyles'));
        // add_action('customize_controls_enqueue_scripts', array(&$this, 'renderTemplates'));
        $this->addShortcodes();
    }

    /**
     * Add all shortcodes
     */
    public function addShortcodes()
    {
        add_shortcode('lf_css_loader_hide', array(&$this, 'renderHide'));
        for ($i = 1; $i <= 11; $i++) {
            add_shortcode('lf_css_loader_' . $i, array(&$this, 'renderTemplate'));
        }
    }

    /**
     * Add scripts and styles
     *
     * @author Guriev Eugen <gurievcreative@gmail.com>
     */
    public function addScriptsAndStyles()
    {
        $assets = Url::toUrl(__DIR__) . DS . 'assets' . DS;
        // ==============================================================
        // Scripts
        // ==============================================================
        wp_enqueue_script('jquery');
        wp_enqueue_script(
            'lolita-css-loader',
            $assets . 'js' . DS . 'lolita_css_loader.js',
            array('jquery'),
            false,
            true
        );

        // ==============================================================
        // Styles
        // ==============================================================
        wp_enqueue_style('lolita-css-loader', $assets . 'css' . DS . 'lolita_css_loader.css', array(), '1.0');
    }

    /**
     * Render loader template
     * @param  array $atts attributes.
     * @param  mixed $tmp  some shit.
     * @param  string $tag  shortcode name.
     * @return string html code.
     */
    public function renderTemplate($atts, $tmp, $tag)
    {
        return View::make(
            __DIR__ . DS . 'views' . DS . $tag . '.php',
            array(
                'class' => Arr::get($atts, 'class'),
                'bg'    => Arr::get($atts, 'bg', '#fff'),
                'color' => Arr::get($atts, 'color', '#000'),
                'style' => Arr::get($atts, 'style'),
            )
        );
    }

    /**
     * Hide loader
     * @param  array $atts attributes.
     * @return string html code.
     */
    public function renderHide($atts)
    {
        echo View::make(
            __DIR__ . DS . 'views' . DS . 'lf_css_loader_hide.php',
            array(
                'delay' => Arr::get($atts, 'delay', 0),
                'spent_time' => sprintf(
                    'Time spent %s seconds.',
                    timer_stop()
                ),
            )
        );
    }
}
