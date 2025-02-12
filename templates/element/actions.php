<?php
$this->loadHelper('Bakeoff/PanelNav.ControllerSurroundings');

$cssFramework = \Cake\Core\Configure::read('Bakeoff/PanelNav.cssFramework');
switch ($cssFramework) {
    case 'bootstrap':
        $ulClass = 'navbar-nav';
        $liClass = 'nav-item';
        $aClass = 'nav-link';
        break;
    case 'picocss':
        $ulClass = '';
        $liClass = '';
        $aClass = '';
        break;
    default:
        $ulClass = '';
        $liClass = '';
        $aClass = '';
        break;
}
?>
<ul class="<?= $ulClass ?>">
<?php foreach ($this->ControllerSurroundings->getActions($entity) as $action): ?>
    <li class="<?= $liClass ?>">
        <a
            class="<?= $aClass ?>"
<?php if ($action === $this->getRequest()->getParam('action')): ?>
            aria-current="page"
<?php endif; ?>
<?php if ($entity): ?>
            href="<?= \Cake\Routing\Router::url(['action' => $action, $this->EntityProfile->getId()])?>"
<?php else: ?>
            href="<?= \Cake\Routing\Router::url(['action' => $action])?>"
<?php endif; ?>
        ><?= \Cake\Utility\Inflector::humanize($action) ?></a>
    </li>
<?php endforeach; ?>
</ul>
