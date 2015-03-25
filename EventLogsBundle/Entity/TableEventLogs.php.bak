<?php

namespace Berd\EventLogsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TableEventLogs
 * 
 */
class TableEventLogs
{
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     */
    private $type;


    /**
     * Set type
     *
     * @param string $type
     * @return TableEventLogs
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $action;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->action = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add action
     *
     * @param \Berd\EventLogsBundle\Entity\Actions $action
     * @return TableEventLogs
     */
    public function addAction(\Berd\EventLogsBundle\Entity\Actions $action)
    {
        $this->action[] = $action;

        return $this;
    }

    /**
     * Remove action
     *
     * @param \Berd\EventLogsBundle\Entity\Actions $action
     */
    public function removeAction(\Berd\EventLogsBundle\Entity\Actions $action)
    {
        $this->action->removeElement($action);
    }

    /**
     * Get action
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAction()
    {
        return $this->action;
    }
}
