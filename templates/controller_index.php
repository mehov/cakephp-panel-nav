<?php
$this->Html->css('PanelNav.panel_nav', ['block' => true]);
?>
<div id="panel_nav" class="grid">
    <aside>
        <?= $this->element('PanelNav.controllers_nav') ?>
    </aside>
    <div id="controller_index">
        <?= $this->fetch('content') ?>
    </div>
</div>
