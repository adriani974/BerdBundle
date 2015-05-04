<?php

namespace Berd\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Params
 */
class Params
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $paramKey;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var string
     */
    private $paramValue;

    /**
     * @var string
     */
    private $userId;


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
     * Set paramKey
     *
     * @param string $paramKey
     * @return Params
     */
    public function setParamKey($paramKey)
    {
        $this->paramKey = $paramKey;

        return $this;
    }

    /**
     * Get paramKey
     *
     * @return string 
     */
    public function getParamKey()
    {
        return $this->paramKey;
    }

    /**
     * Set operator
     *
     * @param string $operator
     * @return Params
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Get operator
     *
     * @return string 
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set paramValue
     *
     * @param string $paramValue
     * @return Params
     */
    public function setParamValue($paramValue)
    {
        $this->paramValue = $paramValue;

        return $this;
    }

    /**
     * Get paramValue
     *
     * @return string 
     */
    public function getParamValue()
    {
        return $this->paramValue;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Params
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
     * @var \Berd\DashboardBundle\Entity\Requete
     */
    private $requete;


    /**
     * Set requete
     *
     * @param \Berd\DashboardBundle\Entity\Requete $requete
     * @return Params
     */
    public function setRequete(\Berd\DashboardBundle\Entity\Requete $requete = null)
    {
        $this->requete = $requete;

        return $this;
    }

    /**
     * Get requete
     *
     * @return \Berd\DashboardBundle\Entity\Requete 
     */
    public function getRequete()
    {
        return $this->requete;
    }
	
	public function __toString(){
		return $this->getId().'';
	}
}
