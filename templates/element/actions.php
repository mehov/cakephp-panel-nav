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
<?php foreach ($this->ControllerSurroundings->getActions() as $action): ?>
    <li class="<?= $liClass ?>">
        <a
            class="<?= $aClass ?>"
<?php if ($action === $this->getRequest()->getParam('action')): ?>
            aria-current="page"
<?php endif; ?>
            href="<?= \Cake\Routing\Router::url(['action' => $action, $this->EntityProfile->getId()])?>"
        ><?= \Cake\Utility\Inflector::humanize($action) ?></a>
    </li>
<?php endforeach; ?>
</ul>
