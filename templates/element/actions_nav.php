<?php
$this->loadHelper('PanelNav.EntityProfile', ['entity' => $entity]);

$cssFramework = \Cake\Core\Configure::read('PanelNav.cssFramework');
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
            <strong><?= $this->EntityProfile->getTitle() ?></strong>
        </li>
    </ul>
<?= $this->element('PanelNav.actions', ['entity' => $entity]) ?>
</nav>
