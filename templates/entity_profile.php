<?php
$this->Html->css('PanelNav.panel_nav', ['block' => true]);
$this->Html->css('PanelNav.entity_profile', ['block' => true]);
$this->Html->script('PanelNav.entity_profile', ['block' => true]);
$this->loadHelper('PanelNav.ControllerSurroundings');
$this->loadHelper('PanelNav.EntityProfile', ['entity' => $entity]);
?>
<div id="panel_nav" class="grid">
    <aside>
        <?= $this->element('PanelNav.controllers_nav') ?>
    </aside>
    <div id="entity_profile">
        <?= $this->element('PanelNav.actions_nav', ['entity' => $entity]) ?>
        <?= $this->fetch('content') ?>
    </div>
</div>
