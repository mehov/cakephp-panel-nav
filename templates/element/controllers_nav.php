<?php
$cssFramework = \Cake\Core\Configure::read('PanelNav.cssFramework');
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
<?= $this->element('PanelNav.controllers') ?>
</nav>
