<?php

namespace Berd\EventLogsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actions
 *
 */
class Actions
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nomAction;

    /**
     * @var \DateTime
     */
    private $dateAction;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $userId;
	
	/**
	* @var array
	*/
	private $data;
	
	
	/**
	* Actions Constructor
	*/
	public function __construct($data = array()){
		$this->nomAction = $data['nomAction'];
		$this->dateAction = $data['dateAction'];
		$this->description = $data['description'];
		$this->userId = $data['userId'];
		$this->device = $data['device'];
		$this->tableEventLogs = $data['tableEventLogs'];
	}

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
     * Set nomAction
     *
     * @param string $nomAction
     * @return Actions
     */
    public function setNomAction($nomAction)
    {
        $this->nomAction = $nomAction;

        return $this;
    }

    /**
     * Get nomAction
     *
     * @return string 
     */
    public function getNomAction()
    {
        return $this->nomAction;
    }

    /**
     * Set dateAction
     *
     * @param \DateTime $dateAction
     * @return Actions
     */
    public function setDateAction($dateAction)
    {
        $this->dateAction = $dateAction;

        return $this;
    }

    /**
     * Get dateAction
     *
     * @return \DateTime 
     */
    public function getDateAction()
    {
        return $this->dateAction;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Actions
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Actions
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    /**
     * @var \Berd\EventLogsBundle\Entity\Device
     */
    private $device;


    /**
     * Set device
     *
     * @param \Berd\EventLogsBundle\Entity\Device $device
     * @return Actions
     */
    public function setDevice(\Berd\EventLogsBundle\Entity\Device $device = null)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device
     *
     * @return \Berd\EventLogsBundle\Entity\Device 
     */
    public function getDevice()
    {
        return $this->device;
    }
    /**
     * @var \Berd\EventLogsBundle\Entity\TableEventLogs
     */
    private $tableEventLogs;


    /**
     * Set tableEventLogs
     *
     * @param \Berd\EventLogsBundle\Entity\TableEventLogs $tableEventLogs
     * @return Actions
     */
    public function setTableEventLogs(\Berd\EventLogsBundle\Entity\TableEventLogs $tableEventLogs = null)
    {
        $this->tableEventLogs = $tableEventLogs;

        return $this;
    }
	
	public function __toString()
	{
		return $this->getId().'';
	}

    /**
     * Get tableEventLogs
     *
     * @return \Berd\EventLogsBundle\Entity\TableEventLogs 
     */
    public function getTableEventLogs()
    {
        return $this->tableEventLogs;
    }
}
