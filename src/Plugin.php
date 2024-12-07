<?php

namespace Bakeoff\PanelNav;

class Plugin extends \Cake\Core\BasePlugin
{

    public function __construct()
    {
        $cssFramework = self::detectCssFramework();
        \Cake\Core\Configure::write('Bakeoff/PanelNav.cssFramework', $cssFramework);
    }

    public static function detectCssFramework()
    {
        if (\Cake\Core\Plugin::isLoaded('BootstrapUI')) {
            return 'bootstrap';
        }
        if (\Composer\InstalledVersions::isInstalled('picocss/pico')) {
            return 'picocss';
        }
        if (\Composer\InstalledVersions::isInstalled('twbs/bootstrap')) {
            return 'bootstrap';
        }
        return null;
    }

}
