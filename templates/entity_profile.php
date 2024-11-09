<?php
$this->Html->css('PanelNav.entity_profile', ['block' => true]);
$this->Html->script('PanelNav.entity_profile', ['block' => true]);
$this->loadHelper('PanelNav.ControllerSurroundings');
$this->loadHelper('PanelNav.EntityProfile', ['entity' => $entity]);
?>
<?= $this->element('PanelNav.controllers_nav') ?>
<div id="entity_profile">
    <aside>
        <?= $this->element('PanelNav.actions_nav', ['entity' => $entity]) ?>
    </aside>
    <div>
        <?= $this->fetch('content') ?>
    </div>
</div>
