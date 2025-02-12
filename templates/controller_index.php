<?php
$cssFramework = \Cake\Core\Configure::read('Bakeoff/PanelNav.cssFramework');
$this->Html->css('Bakeoff/PanelNav.panel_nav', ['block' => true]);
if ($cssFramework) {
    $this->Html->css('Bakeoff/PanelNav.panel_nav.'.$cssFramework, ['block' => true]);
}

switch ($cssFramework) {
    case 'bootstrap':
        $wrapperClass = 'row';
        $asideClass = 'col-md-2 text-bg-dark';
        $panelClass = 'col mt-3';
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
    <div id="controller_index" class="<?= $panelClass ?>">
        <?= $this->element('Bakeoff/PanelNav.actions_nav', ['entity' => null]) ?>
        <?= $this->fetch('content') ?>
    </div>
</div>
