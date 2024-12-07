<?php
$cssFramework = \Cake\Core\Configure::read('Bakeoff/PanelNav.cssFramework');
switch ($cssFramework) {
    case 'bootstrap':
        $navClass = '';
        break;
    case 'picocss':
        $navClass = '';
        break;
    default:
        $navClass = '';
        break;
}
?>
<nav class="<?= $navClass ?>">
<?= $this->element('Bakeoff/PanelNav.controllers') ?>
</nav>
