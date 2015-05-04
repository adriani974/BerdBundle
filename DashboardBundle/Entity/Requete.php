<?php

namespace Berd\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Requete
 */
class Requete
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $requestName;

    /**
     * @var boolean
     */
    private $isEnable;

    /**
     * @var boolean
     */
    private $isFixed;

    /**
     * @var string
     */
    private $renderType;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var \Berd\DashboardBundle\Entity\RequestList
     */
    private $requestList;


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
     * Set body
     *
     * @param string $body
     * @return Requete
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set requestName
     *
     * @param string $requestName
     * @return Requete
     */
    public function setRequestName($requestName)
    {
        $this->requestName = $requestName;

        return $this;
    }

    /**
     * Get requestName
     *
     * @return string 
     */
    public function getRequestName()
    {
        return $this->requestName;
    }

    /**
     * Set isEnable
     *
     * @param boolean $isEnable
     * @return Requete
     */
    public function setIsEnable($isEnable)
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    /**
     * Get isEnable
     *
     * @return boolean 
     */
    public function getIsEnable()
    {
        return $this->isEnable;
    }

    /**
     * Set isFixed
     *
     * @param boolean $isFixed
     * @return Requete
     */
    public function setIsFixed($isFixed)
    {
        $this->isFixed = $isFixed;

        return $this;
    }

    /**
     * Get isFixed
     *
     * @return boolean 
     */
    public function getIsFixed()
    {
        return $this->isFixed;
    }

    /**
     * Set renderType
     *
     * @param string $renderType
     * @return Requete
     */
    public function setRenderType($renderType)
    {
        $this->renderType = $renderType;

        return $this;
    }

    /**
     * Get renderType
     *
     * @return string 
     */
    public function getRenderType()
    {
        return $this->renderType;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Requete
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
     * Set requestList
     *
     * @param \Berd\DashboardBundle\Entity\RequestList $requestList
     * @return Requete
     */
    public function setRequestList(\Berd\DashboardBundle\Entity\RequestList $requestList = null)
    {
        $this->requestList = $requestList;

        return $this;
    }

    /**
     * Get requestList
     *
     * @return \Berd\DashboardBundle\Entity\RequestList 
     */
    public function getRequestList()
    {
        return $this->requestList;
    }
	
	public function __toString()
	{
		return $this->getId().'';
	}
}
