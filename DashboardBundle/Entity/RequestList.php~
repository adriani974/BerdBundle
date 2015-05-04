<?php

namespace Berd\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequestList
 */
class RequestList
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $request;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $dateCreation;

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
     * Set description
     *
     * @param string $description
     * @return RequestList
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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return RequestList
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return RequestList
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
     * @return RequestList
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
	
	public function __toString()
	{
		return $this->getId().'';
	}
	
    /**
     * @var string
     */
    private $requestListName;


    /**
     * Set requestListName
     *
     * @param string $requestListName
     * @return RequestList
     */
    public function setRequestListName($requestListName)
    {
        $this->requestListName = $requestListName;

        return $this;
    }

    /**
     * Get requestListName
     *
     * @return string 
     */
    public function getRequestListName()
    {
        return $this->requestListName;
    }
}
