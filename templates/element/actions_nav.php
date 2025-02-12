<?php
$this->loadHelper('Bakeoff/PanelNav.EntityProfile', ['entity' => $entity]);

$cssFramework = \Cake\Core\Configure::read('Bakeoff/PanelNav.cssFramework');
switch ($cssFramework) {
    case 'bootstrap':
        $navClass = 'navbar navbar-expand-sm navbar-light justify-content-between';
        $ulClass = 'navbar-nav';
        $liClass = 'navbar-brand';
        break;
    case 'picocss':
        $navClass = '';
        $ulClass = '';
        $liClass = '';
        break;
    default:
        $navClass = '';
        $ulClass = '';
        $liClass = '';
        break;
}
?>
<nav class="<?= $navClass ?>">
    <ul class="<?= $ulClass ?>">
        <li class="<?= $liClass ?>">
            <strong><?= $entity ? $this->EntityProfile->getTitle() : $this->getName() ?></strong>
        </li>
    </ul>
<?= $this->element('Bakeoff/PanelNav.actions', ['entity' => $entity]) ?>
</nav>
