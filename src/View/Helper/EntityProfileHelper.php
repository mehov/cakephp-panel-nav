<?php

namespace PanelNav\View\Helper;

/**
 * Entity profile is like a social network profile but for an entity. This class
 * determines navigateable actions in controller for this entity and renders
 * them as clickable links in the sidebar. Entity profile also consists of
 * templates and static assets.
 *
 * @package PanelNav\View\Helper
 */
class EntityProfileHelper extends \Cake\View\Helper
{

    /**
     * @return Entity an instance of entity attached to this helper
     */
    public function getEntity()
    {
        return $this->getConfig('entity');
    }

    /**
     * For attached entity, find table alias and return a class instance for it
     *
     * @return \Cake\ORM\Table
     */
    public function getEntityTable()
    {
        $alias = $this->getEntity()->getSource();
        return \Cake\ORM\TableRegistry::getTableLocator()->get($alias);
    }

    /**
     * Use this entity table class to find display field name
     *
     * @return string
     */
    public function getDisplayField()
    {
        return $this->getEntityTable()->getDisplayField();
    }

    /**
     * Use this entity table class to find primary key name
     *
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getEntityTable()->getPrimaryKey();
    }

    /**
     * Use getDisplayField() above to determine and return actual title or name
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getEntity()->get($this->getDisplayField());
    }

    /**
     * Use getPrimaryKey() above to determine and return actual ID
     *
     */
    public function getId()
    {
        return $this->getEntity()->get($this->getPrimaryKey());
    }

}
