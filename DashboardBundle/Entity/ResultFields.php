<?php

namespace Berd\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultFields
 */
class ResultFields
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var string
     */
    private $fieldValue;

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
     * Set fieldName
     *
     * @param string $fieldName
     * @return ResultFields
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    /**
     * Get fieldName
     *
     * @return string 
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * Set fieldValue
     *
     * @param string $fieldValue
     * @return ResultFields
     */
    public function setFieldValue($fieldValue)
    {
        $this->fieldValue = $fieldValue;

        return $this;
    }

    /**
     * Get fieldValue
     *
     * @return string 
     */
    public function getFieldValue()
    {
        return $this->fieldValue;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return ResultFields
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
     * @var \Berd\DashboardBundle\Entity\Results
     */
    private $results;


    /**
     * Set results
     *
     * @param \Berd\DashboardBundle\Entity\Results $results
     * @return ResultFields
     */
    public function setResults(\Berd\DashboardBundle\Entity\Results $results = null)
    {
        $this->results = $results;

        return $this;
    }

    /**
     * Get results
     *
     * @return \Berd\DashboardBundle\Entity\Results 
     */
    public function getResults()
    {
        return $this->results;
    }
}
