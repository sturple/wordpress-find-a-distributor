<?php
namespace Fgms\Distributor;

/**
 *	Provides settings from the WordPress administration
 *	page.
 */
abstract class Settings
{
    private $wp;
    private $prefix;
    private $api_key;
    private $domain;
    private $page;

    public function __construct (WordPress $wp, $prefix='fgms-distributor-', $domain='fgms-distributor')
    {
        $this->wp=$wp;
        $this->prefix=$prefix;
        $this->api_key=$prefix.'api-key';
        $this->domain=$domain;
        $this->page=$domain.'.php';
        //	Hook into WordPress
        $wp->add_action('admin_menu',[$this,'addOptionsPage']);
        $wp->add_action('admin_init',[$this,'registerSettings']);
    }

    public function registerSettings()
    {
        $this->wp->add_settings_section('section','All Settings',null,$this->page);
        $this->wp->add_settings_field(
            $this->api_key,
            $this->wp->__('Google Maps API Key',$this->domain),
            [$this,'outputApiKey'],
            $this->page,
            'section'
        );
        $this->wp->register_setting('section',$this->api_key);
    }

    public function addOptionsPage()
    {
        $name=$this->wp->__('Find a Distributor',$this->domain);
        $this->wp->add_options_page(
            $name,
            $name,
            'manage_options',
            $this->page,
            [$this,'outputOptionsPage']
        );
    }

    public function outputOptionsPage()
    {
        $this->output('<div class="wrap"><h1>');
        $this->output(htmlspecialchars($this->wp->__('Find a Distributor',$this->domain)));
        $this->output('</h1><form method="post" action="options.php">');
        $this->wp->settings_fields('section');
        $this->wp->do_settings_sections($this->page);
        $this->wp->submit_button();
        $this->output('</form></div>');
    }

    public function outputApiKey()
    {
        $this->output(
            sprintf(
                '<input type="text" class="widefat" name="%1$s" value="%2$s">',
                $this->api_key,
                $this->getApiKey()
            )
        );
    }

    public function getApiKey()
    {
        return $this->wp->get_option($this->api_key,'');
    }

    /**
     *  When implemented in a derived class performs
     *  output.
     *
     *  \param [in] $str
     *      The string to output.
     */
    abstract protected function output($str);
}