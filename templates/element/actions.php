<?php
$this->loadHelper('PanelNav.ControllerSurroundings');
?>
<ul>
<?php foreach ($this->ControllerSurroundings->getActions() as $action): ?>
    <li>
        <a
            <?php if ($action === $this->getRequest()->getParam('action')): ?>
                aria-current="page"
            <?php else: ?>
                class="secondary"
            <?php endif; ?>
            href="<?= \Cake\Routing\Router::url(['action' => $action, $this->EntityProfile->getId()])?>"
        ><?= \Cake\Utility\Inflector::humanize($action) ?></a>
    </li>
<?php endforeach; ?>
</ul>
