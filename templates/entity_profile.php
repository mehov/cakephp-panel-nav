<?php
$this->Html->css('PanelNav.entity_profile', ['block' => true]);
$this->Html->script('PanelNav.entity_profile', ['block' => true]);
$this->loadHelper('PanelNav.ControllerSurroundings');
$this->loadHelper('PanelNav.EntityProfile', ['entity' => $entity]);
?>
<?= $this->element('PanelNav.controllers_nav') ?>
<div id="entity_profile">
    <aside>
        <nav>
            <ul>
                <li>
                    <strong><?= $this->EntityProfile->getTitle() ?></strong>
                </li>
            </ul>
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
        </nav>
    </aside>
    <div>
        <?= $this->fetch('content') ?>
    </div>
</div>
