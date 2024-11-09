<?php
$this->loadHelper('PanelNav.EntityProfile', ['entity' => $entity]);
?>
<nav>
    <ul>
        <li>
            <strong><?= $this->EntityProfile->getTitle() ?></strong>
        </li>
    </ul>
<?= $this->element('PanelNav.actions', ['entity' => $entity]) ?>
</nav>
