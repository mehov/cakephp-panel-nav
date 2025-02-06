# Navigation Helpers for custom CakePHP 5 Panels

This plugin contains views and helpers that can simplify building UI in custom admin panels, control panels, consoles.

When you're building an admin panel in CakePHP 5, you would have a route prefix such as `/admin` and a bunch of controllers inside `APP/Controller/Admin`: say, `ArticlesController`, `CommentsController`, `TagsController` etc. In your view templates, you would have navigation menus linking to them and their actions.

This plugin lets you automate the process by automatically picking up all present controllers and their actions within that prefix, so you don't have to manually hardcode links to them.

### Usage

##### Linking to actions

`ArticlesController` manages `Article` entities and has [actions](https://book.cakephp.org/5/en/controllers.html#controller-actions) such as `edit($id)`, `reviewComments($id)` etc.

You can extend your view templates for those actions with `Bakeoff/PanelNav./entity_profile`. This will render navigation to other actions available to this entity, as well as other controllers in the current prefix.

For example, `templates/Articles/edit.php`:

```php
<?php
$this->extend('Bakeoff/PanelNav./entity_profile');
echo $this->Form->create($entity).PHP_EOL;
echo $this->Form->control('title').PHP_EOL;
echo $this->Form->control('body').PHP_EOL;
echo $this->Form->control('is_published').PHP_EOL;
echo $this->Form->button('Save').PHP_EOL;
echo $this->Form->end().PHP_EOL;
```

**Note**: the current entity has to be available as `$entity`.

##### Linking to controllers

```php
<?php
$this->loadHelper('Bakeoff/PanelNav.ControllerSurroundings');
// Loop though other controllers in the same folder a.k.a. same prefix
foreach ($this->ControllerSurroundings->getOtherControllers() as $name):
    // We get the controller name, without the 'Controller' suffix
    echo $name; // outputs e.g. Articles
    // Render a link to the controller index
    echo $this->Html->link($name, ['controller' => $name, 'action' => 'index']);
    // Here's how we can tell if we're in this controller right now
    if ($name === $this->getRequest()->getParam('controller')) {
        // ...
    }
endforeach;
```
