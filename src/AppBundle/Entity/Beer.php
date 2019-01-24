<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Beer
 *
 * @ORM\Table(name="beer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BeerRepository")
 */
class Beer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="brasseur", type="string", length=255)
     */
    private $brasseur;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="string", length=255)
     */
    private $info;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="volume", type="integer")
     */
    private $volume;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="beers")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="CommandDetails", mappedBy="beer")
     */
    private $commanddetails;

    public function __construct()
    {
        $this->commanddetails = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Beer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set brasseur
     *
     * @param string $brasseur
     *
     * @return Beer
     */
    public function setBrasseur($brasseur)
    {
        $this->brasseur = $brasseur;

        return $this;
    }

    /**
     * Get brasseur
     *
     * @return string
     */
    public function getBrasseur()
    {
        return $this->brasseur;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return Beer
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Beer
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set volume
     *
     * @param integer $volume
     *
     * @return Beer
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return int
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Beer
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Beer
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add commanddetail
     *
     * @param \AppBundle\Entity\CommandDetails $commanddetail
     *
     * @return Beer
     */
    public function addCommanddetail(\AppBundle\Entity\CommandDetails $commanddetail)
    {
        $this->commanddetails[] = $commanddetail;

        return $this;
    }

    /**
     * Remove commanddetail
     *
     * @param \AppBundle\Entity\CommandDetails $commanddetail
     */
    public function removeCommanddetail(\AppBundle\Entity\CommandDetails $commanddetail)
    {
        $this->commanddetails->removeElement($commanddetail);
    }

    /**
     * Get commanddetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommanddetails()
    {
        return $this->commanddetails;
    }
}
