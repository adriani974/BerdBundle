<?php

namespace Berd\PersonnageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personnage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Berd\PersonnageBundle\Repository\PersonnageRepository")
 */
class Personnage
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;
	
	/**
    * @var sac
    * @ORM\OneToOne(targetEntity="Sac")
    */
    private $sac;

    /**
     * @var integer
     *
     * @ORM\Column(name="niveau", type="integer")
     */
    private $niveau;

	public function __toString()
	{
		return $this->getId().'';
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
     * Set nom
     *
     * @param string $nom
     * @return Personnage
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Personnage
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set niveau
     *
     * @param integer $niveau
     * @return Personnage
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return integer 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set item
     *
     * @param \Berd\PersonnageBundle\Entity\Items $item
     * @return Personnage
     */
    public function setItem(\Berd\PersonnageBundle\Entity\Items $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \Berd\PersonnageBundle\Entity\Items 
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set sac
     *
     * @param \Berd\PersonnageBundle\Entity\Sac $sac
     * @return Personnage
     */
    public function setSac(\Berd\PersonnageBundle\Entity\Sac $sac = null)
    {
        $this->sac = $sac;

        return $this;
    }

    /**
     * Get sac
     *
     * @return \Berd\PersonnageBundle\Entity\Sac 
     */
    public function getSac()
    {
        return $this->sac;
    }
}
