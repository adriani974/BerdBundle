<?php

namespace Berd\EventLogsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Device
 */
class Device
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $modele;

    /**
     * @var string
     */
    private $osArchitecture;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var integer
     */
    private $width;

    /**
     * @var string
     */
    private $netmask;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var string
     */
    private $manufacturer;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $others;

    /**
     * @var boolean
     */
    private $isWeb;

	/**
	* @var array
	*/
	private $data;
	
	/**
	* Device Constructor
	*/
	public function __construct($data = array()){
		$this->modele = $data['modele'];
		$this->osArchitecture = $data['osArchitecture'];
		$this->height = $data['height'];
		$this->width = $data['width'];
		$this->netmask = $data['netmask'];
		$this->userId = $data['userId'];
		$this->deviceId = $data['deviceId'];
		$this->manufacturer = $data['manufacturer'];
		$this->version = $data['version'];
		$this->others = $data['others'];
		$this->isWeb = $data['isWeb'];
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
     * Set modele
     *
     * @param string $modele
     * @return Device
     */
    public function setModele($modele)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get modele
     *
     * @return string 
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Set osArchitecture
     *
     * @param string $osArchitecture
     * @return Device
     */
    public function setOsArchitecture($osArchitecture)
    {
        $this->osArchitecture = $osArchitecture;

        return $this;
    }

    /**
     * Get osArchitecture
     *
     * @return string 
     */
    public function getOsArchitecture()
    {
        return $this->osArchitecture;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Device
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }
	
	public function __toString()
	{
		return $this->getId().'';
	}

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return Device
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set netmask
     *
     * @param string $netmask
     * @return Device
     */
    public function setNetmask($netmask)
    {
        $this->netmask = $netmask;

        return $this;
    }

    /**
     * Get netmask
     *
     * @return string 
     */
    public function getNetmask()
    {
        return $this->netmask;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Device
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
     * Set deviceId
     *
     * @param string $deviceId
     * @return Device
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string 
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set manufacturer
     *
     * @param string $manufacturer
     * @return Device
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return string 
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return Device
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set others
     *
     * @param string $others
     * @return Device
     */
    public function setOthers($others)
    {
        $this->others = $others;

        return $this;
    }

    /**
     * Get others
     *
     * @return string 
     */
    public function getOthers()
    {
        return $this->others;
    }

    /**
     * Set isWeb
     *
     * @param boolean $isWeb
     * @return Device
     */
    public function setIsWeb($isWeb)
    {
        $this->isWeb = $isWeb;

        return $this;
    }

    /**
     * Get isWeb
     *
     * @return boolean 
     */
    public function getIsWeb()
    {
        return $this->isWeb;
    }
}
