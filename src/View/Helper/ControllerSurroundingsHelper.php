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
     * @var \Cake\Controller\ControllerFactory
     */
    private $controllerFactory;

    public function initialize(array $config): void
    {
        $container = new \Cake\Core\Container();
        $this->controllerFactory = new \Cake\Controller\ControllerFactory($container);
    }

    /**
     * Analyse public methods (a.k.a. actions) in current controller and find
     * what could be clickable links. This way we can render navigation
     * automatically without relying on manually hardcoded list of actions.
     *
     * These clickable links can be grouped as:
     * - actions for specific entity and requiring ID (edit or delete);
     * - general actions (index or add).
     *
     * @param \Cake\ORM\Entity|null $entity pass if getting entity actions
     * @return string[]
     * @throws \ReflectionException
     */
    public function getActions($entity = null)
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
        // Initiate a copy of the controller into an instance
        $instance = $this->controllerFactory->create($request);
        // Use PHP Reflection to analyse the controller class
        $reflection = new \ReflectionClass($instance);
        $methods = array_filter(
            // We're only looking for public methods on that controller
            $reflection->getMethods(\ReflectionMethod::IS_PUBLIC),
            // Filter the public methods we got
            function($method) use ($entity, $instance, $reflection, $id_arguments) {
                // method must be declared on that controller and not inherited
                if ($method->getDeclaringClass()->getName() !== $reflection->getName()) {
                    return false;
                }
                // reuse Controller::isAction() logic
                if (!$instance->isAction($method->getName())) {
                    return false;
                }
                // shorthand to declared method parameters a.k.a. arguments
                $params = $method->getParameters();
                // if not looking for entity actions
                if (!$entity || $entity->isNew()) {
                    return !isset($params[0]);// allow if no arguments expected
                }
                // method must accept entity ID as first argument
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
        $request = $this->getView()->getRequest();
        $name = $this->controllerFactory->getControllerClass($request);
        $controllerReflector = new \ReflectionClass($name);
        unset($request, $name);
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
