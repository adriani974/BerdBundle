<?php

namespace Berd\PersonnageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sac
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Berd\PersonnageBundle\Repository\SacRepository")
 */
class Sac
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="volume", type="integer")
     */
    private $volume;

    /**
     * @var string
     *
     * @ORM\Column(name="nomSac", type="string", length=255)
     */
    private $nomSac;
	
	/**
    * @var items
    * @ORM\ManyToOne(targetEntity="Items")
    */
    private $items;


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
     * Set volume
     *
     * @param integer $volume
     * @return Sac
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return integer 
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set nomSac
     *
     * @param string $nomSac
     * @return Sac
     */
    public function setNomSac($nomSac)
    {
        $this->nomSac = $nomSac;

        return $this;
    }

    /**
     * Get nomSac
     *
     * @return string 
     */
    public function getNomSac()
    {
        return $this->nomSac;
    }

    /**
     * Set items
     *
     * @param \Berd\PersonnageBundle\Entity\Items $items
     * @return Sac
     */
    public function setItems(\Berd\PersonnageBundle\Entity\Items $items = null)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get items
     *
     * @return \Berd\PersonnageBundle\Entity\Items 
     */
    public function getItems()
    {
        return $this->items;
    }
}
