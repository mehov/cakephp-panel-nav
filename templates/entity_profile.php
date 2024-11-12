<?php
$cssFramework = \Cake\Core\Configure::read('PanelNav.cssFramework');
$this->Html->css('PanelNav.panel_nav', ['block' => true]);
if ($cssFramework) {
    $this->Html->css('PanelNav.panel_nav.'.$cssFramework, ['block' => true]);
}
$this->loadHelper('PanelNav.ControllerSurroundings');
$this->loadHelper('PanelNav.EntityProfile', ['entity' => $entity]);

switch ($cssFramework) {
    case 'bootstrap':
        $wrapperClass = 'row';
        $asideClass = 'col-md-2 text-bg-dark';
        $panelClass = 'col';
        break;
    case 'picocss':
        $wrapperClass = 'grid';
        $asideClass = '';
        $panelClass = '';
        break;
    default:
        $wrapperClass = '';
        $asideClass = '';
        $panelClass = '';
        break;
}
?>
<div id="panel_nav" class="<?= $wrapperClass ?>">
    <aside class="<?= $asideClass ?>">
        <?= $this->element('PanelNav.controllers_nav') ?>
    </aside>
    <div id="entity_profile" class="<?= $panelClass ?>">
        <?= $this->element('PanelNav.actions_nav', ['entity' => $entity]) ?>
        <?= $this->fetch('content') ?>
    </div>
</div>
