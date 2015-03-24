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
     * @var integer
	 * @ORM\ManyToOne(targetEntity="Device")
     */
    private $idDevice;

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
     * Set idDevice
     *
     * @param integer $idDevice
     * @return Actions
     */
    public function setIdDevice($idDevice)
    {
        $this->idDevice = $idDevice;

        return $this;
    }

    /**
     * Get idDevice
     *
     * @return integer 
     */
    public function getIdDevice()
    {
        return $this->idDevice;
    }

    /**
     * @var integer
	 * @ORM\ManyToOne(targetEntity="TableEventLogs")
     */
    private $idLogs;


    /**
     * Set idLogs
     *
     * @param integer $idLogs
     * @return Actions
     */
    public function setIdLogs($idLogs)
    {
        $this->idLogs = $idLogs;

        return $this;
    }

    /**
     * Get idLogs
     *
     * @return integer 
     */
    public function getIdLogs()
    {
        return $this->idLogs;
    }
}
