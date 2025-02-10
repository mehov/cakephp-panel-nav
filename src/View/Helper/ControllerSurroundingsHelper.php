<?php

namespace Bakeoff\PanelNav\View\Helper;

use Cake\Utility\Inflector;

/**
 * Class ControllerSurroundingsHelper
 *
 * @package Bakeoff\PanelNav\View\Helper
 */
class ControllerSurroundingsHelper extends \Cake\View\Helper
{

    /**
     * @return string full name with namespace of currently requested controller
     */
    public function getCurrentControllerFullName()
    {
        // Get request from this view
        $request = $this->getView()->getRequest();
        // Now get the full path to controller class
        /*
         * Copied from \Cake\Controller\ControllerFactory::getControllerClass()
         * See https://github.com/cakephp/cakephp/blob/cb3a3f7f6508842cb90927bc1e91a3618aece7cc/src/Controller/ControllerFactory.php#L297
        */
        $pluginPath = '';
        $namespace = 'Controller';
        $controller = $request->getParam('controller', '');
        if ($request->getParam('plugin')) {
            $pluginPath = $request->getParam('plugin') . '.';
        }
        if ($request->getParam('prefix')) {
            $namespace .= '/' . $request->getParam('prefix');
        }
        return \Cake\Core\App::className($pluginPath . $controller, $namespace, 'Controller');
    }

    /**
     * Analyse public methods in current controller and find
     * what could be clickable links. This way Console can render navigation
     * automatically without relying on manually hardcoded list of actions for
     * each given entity.
     *
     * @return string[]
     * @throws \ReflectionException
     */
    public function getActions()
    {
        // Get request from this view
        $request = $this->getView()->getRequest();
        /*
         * CakePHP actions that deal with entries receive ID as first argument.
         * For Users, that can be: $id, $users_id, $user_id, $usersId, $userId.
         * Use controller name to list all acceptable variants.
         */
        $name = $request->getParam('controller');
        // Reusable shorthand to controller name singularized
        $name_singularized = Inflector::singularize($name);
        // Expected first arguments: id, users_id, user_id, usersId, userId
        $id_arguments = array(
            // simply $id
            'id',
            // underscored pluralized: $users_id, $user_accounts_id
            Inflector::underscore($name) . '_id',
            // underscored singularized: $user_id, $user_account_id
            Inflector::underscore($name_singularized) . '_id',
            // camelcased pluralized: $usersId, $userAccountsId
            lcfirst($name) . 'Id',
            // camelcased singularized: $userId, $userAccountId
            lcfirst($name_singularized) . 'Id',
        );
        unset($name, $name_singularized); // clean up
        // Get full controller name including namespace
        $name = $this->getCurrentControllerFullName();
        // Initiate a copy of the controller into an instance
        $instance = new $name($request);
        // Use PHP Reflection to analyse the controller class
        $reflection = new \ReflectionClass($instance);
        $methods = array_filter(
            // We're only looking for public methods on that controller
            $reflection->getMethods(\ReflectionMethod::IS_PUBLIC),
            // Filter the public methods we got
            function($method) use ($reflection, $id_arguments) {
                // method must be declared on that controller and not inherited
                if ($method->getDeclaringClass()->getName() !== $reflection->getName()) {
                    return false;
                }
                // method must accept entity ID as first argument
                $params = $method->getParameters();
                return isset($params[0]) && in_array($params[0]->getName(), $id_arguments);
            }
        );
        // Each item is object(ReflectionMethod){name, class}; keep names only
        $methodNames = array_map(function($method) {
            return $method->getName();
        }, $methods);
        return $methodNames;
    }

    /**
     * @return array[] other controllers in same folder with current controller
     */
    public function getOtherControllers()
    {
        $name = $this->getCurrentControllerFullName();
        $controllerReflector = new \ReflectionClass($name);
        $path = dirname($controllerReflector->getFileName());
        $classes = [];
        foreach ($iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        ) as $item) {
            // Skip if item we're looking at is a directory
            if ($item->isDir()) {
                continue;
            }
            // Skip if item is not a PHP file
            if (!$item->isFile() || !$item->getExtension() === 'php') {
                continue;
            }
            // Prepend full namespace of currently requested controller to controller we look at
            $class = $controllerReflector->getNamespaceName() . '\\' . $item->getBasename('.php');
            // Skip if this is not a valid existing class
            if (!class_exists($class)) {
                continue;
            }
            $thisReflector = new \ReflectionClass($class);
            // Skip if class is abstract
            if ($thisReflector->isAbstract()) {
                continue;
            }
            // We will be linking to index. Skip if class does not have it.
            if (!$thisReflector->hasMethod('index')) {
                continue;
            }
            // Get basename of controller class we're looking at
            $basename = $item->getBasename('.php');
            $classes[] = str_ireplace('controller', '', $basename);
        }
        return $classes;
    }

}
