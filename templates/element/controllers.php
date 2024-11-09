<?php
$this->loadHelper('PanelNav.ControllerSurroundings');
?>
<ul>
<?php foreach($this->ControllerSurroundings->getOtherControllers() as $name): ?>
    <li><?= $this->Html->link(
            $name, [
            'controller' => $name, 'action' => 'index'
        ], [
            'class' => $name === $this->getRequest()->getParam('controller') ? 'contrast' : 'secondary'
        ]) ?></li>
<?php endforeach; ?>
</ul>
