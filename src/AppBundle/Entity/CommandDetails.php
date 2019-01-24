<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Command;
use AppBundle\Entity\Beer;

/**
 * CommandDetails
 *
 * @ORM\Table(name="command_details")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandDetailsRepository")
 */
class CommandDetails
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="qty", type="integer")
     */
    private $qty;

    /**
     * @ORM\ManyToOne(targetEntity="Command", inversedBy="commanddetails")
     * @ORM\JoinColumn(name="command_id", referencedColumnName="id")
     */
    private $command;

    /**
     * @ORM\ManyToOne(targetEntity="Beer", inversedBy="beers")
     * @ORM\JoinColumn(name="beer_id", referencedColumnName="id")
     */
    private $beer;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CommandDetails
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return CommandDetails
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set command
     *
     * @param \AppBundle\Entity\Command $command
     *
     * @return CommandDetails
     */
    public function setCommand(\AppBundle\Entity\Command $command = null)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return \AppBundle\Entity\Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set beer
     *
     * @param Beer $beer
     *
     * @return CommandDetails
     */
    public function setBeer(Beer $beer = null)
    {
        $this->beer = $beer;

        return $this;
    }

    /**
     * Get beer
     *
     * @return Beer
     */
    public function getBeer()
    {
        return $this->beer;
    }
}
