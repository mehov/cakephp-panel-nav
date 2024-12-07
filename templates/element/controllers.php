<?php
$this->loadHelper('Bakeoff/PanelNav.ControllerSurroundings');

$cssFramework = \Cake\Core\Configure::read('Bakeoff/PanelNav.cssFramework');
switch ($cssFramework) {
    case 'bootstrap':
        $ulClass = 'list-group';
        $liClass = 'list-group-item';
        $liClassCurrent = 'list-group-item active';
        $aClass = 'nav-link text-white';
        $aClassCurrent = 'nav-link active';
        break;
    case 'picocss':
        $ulClass = '';
        $liClass = '';
        $liClassCurrent = '';
        $aClass = '';
        $aClassCurrent = '';
        break;
    default:
        $ulClass = '';
        $liClass = '';
        $liClassCurrent = '';
        $aClass = '';
        $aClassCurrent = '';
        break;
}

echo '<ul class="'.$ulClass.'">';
foreach($this->ControllerSurroundings->getOtherControllers() as $name):
    $isCurrent = $name === $this->getRequest()->getParam('controller');
    echo '<li class="'.($isCurrent ? $liClassCurrent : $liClass).'">';
    $url = ['controller' => $name, 'action' => 'index'];
    $options = [];
    $options['class'] = $isCurrent ? $aClassCurrent : $aClass;
    if ($isCurrent) {
        $options['aria-current'] = 'page';
    }
    echo $this->Html->link($name, $url, $options);
    echo '</li>';
endforeach;
echo '</ul>';
