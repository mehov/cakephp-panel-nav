<?php
$cssFramework = \Cake\Core\Configure::read('Bakeoff/PanelNav.cssFramework');
$this->Html->css('Bakeoff/PanelNav.panel_nav', ['block' => true]);
if ($cssFramework) {
    $this->Html->css('Bakeoff/PanelNav.panel_nav.'.$cssFramework, ['block' => true]);
}
$this->loadHelper('Bakeoff/PanelNav.ControllerSurroundings');
$this->loadHelper('Bakeoff/PanelNav.EntityProfile', ['entity' => $entity]);

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
        <?= $this->element('Bakeoff/PanelNav.controllers_nav') ?>
    </aside>
    <div id="entity_profile" class="<?= $panelClass ?>">
        <?= $this->element('Bakeoff/PanelNav.actions_nav', ['entity' => $entity]) ?>
        <?= $this->fetch('content') ?>
    </div>
</div>
