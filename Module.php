<?php
namespace DluPhpSettings;
use Laminas\EventManager\Event;
use Laminas\Loader\ClassMapAutoloader;
use Laminas\Loader\StandardAutoloader;

class Module
{
    public function getAutoloaderConfig() {
        return array(
            'ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Configure PHP ini settings on the bootstrap event
     * @param Event $e
     */
    public function onBootstrap(Event $e) {
        $app            = $e->getParam('application');
        /* @var $app \Laminas\Mvc\Application */
        $config         = $app->getConfig();
        if(array_key_exists('phpSettings', $config)) {
            $phpSettings    = $config['phpSettings'];
            if(is_array($phpSettings)) {
                foreach($phpSettings as $key => $value) {
                    ini_set($key, $value);
                }
            }
        }
    }
}
