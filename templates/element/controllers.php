<?php
$this->loadHelper('PanelNav.ControllerSurroundings');
?>
<ul>
<?php foreach($this->ControllerSurroundings->getOtherControllers() as $name): ?>
    <li>
        <?php
$url = ['controller' => $name, 'action' => 'index'];
$options = [];
if ($name === $this->getRequest()->getParam('controller')) {
    $options['aria-current'] = 'page';
}
echo $this->Html->link($name, $url, $options);
?>
    </li>
<?php endforeach; ?>
</ul>
