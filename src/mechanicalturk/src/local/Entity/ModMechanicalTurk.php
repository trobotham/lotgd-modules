<?php

namespace Lotgd\Local\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mod Mechanical Turk.
 *
 * @ORM\Table
 * @ORM\Entity
 */
class ModMechanicalTurk
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"unsigned": true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $creaturename;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $creaturecategory;

    /**
     * @var string
     *
     * @ORM\Column(type="text", length=65535, nullable=false)
     */
    private $creaturedescription;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $creatureweapon;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $creaturelose;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $creaturewin;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $submittedby;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"unsigned": true})
     */
    private $submittedbyid;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default": 0})
     */
    private $forest = 0;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default": 0})
     */
    private $graveyard = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="text", length=65535, nullable=false)
     */
    private $notes;

    /**
     * Set the value of Id.
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of Creaturename.
     *
     * @param string creaturename
     *
     * @return self
     */
    public function setCreaturename($creaturename)
    {
        $this->creaturename = $creaturename;

        return $this;
    }

    /**
     * Get the value of Creaturename.
     *
     * @return string
     */
    public function getCreaturename(): string
    {
        return $this->creaturename;
    }

    /**
     * Set the value of Creaturecategory.
     *
     * @param string creaturecategory
     *
     * @return self
     */
    public function setCreaturecategory($creaturecategory)
    {
        $this->creaturecategory = $creaturecategory;

        return $this;
    }

    /**
     * Get the value of Creaturecategory.
     *
     * @return string
     */
    public function getCreaturecategory(): string
    {
        return $this->creaturecategory;
    }

    /**
     * Set the value of Creaturedescription.
     *
     * @param string creaturedescription
     *
     * @return self
     */
    public function setCreaturedescription($creaturedescription)
    {
        $this->creaturedescription = $creaturedescription;

        return $this;
    }

    /**
     * Get the value of Creaturedescription.
     *
     * @return string
     */
    public function getCreaturedescription(): string
    {
        return $this->creaturedescription;
    }

    /**
     * Set the value of Creatureweapon.
     *
     * @param string creatureweapon
     *
     * @return self
     */
    public function setCreatureweapon($creatureweapon)
    {
        $this->creatureweapon = $creatureweapon;

        return $this;
    }

    /**
     * Get the value of Creatureweapon.
     *
     * @return string
     */
    public function getCreatureweapon(): string
    {
        return $this->creatureweapon;
    }

    /**
     * Set the value of Creaturelose.
     *
     * @param string creaturelose
     *
     * @return self
     */
    public function setCreaturelose($creaturelose)
    {
        $this->creaturelose = $creaturelose;

        return $this;
    }

    /**
     * Get the value of Creaturelose.
     *
     * @return string
     */
    public function getCreaturelose(): string
    {
        return $this->creaturelose;
    }

    /**
     * Set the value of Creaturewin.
     *
     * @param string creaturewin
     *
     * @return self
     */
    public function setCreaturewin($creaturewin)
    {
        $this->creaturewin = $creaturewin;

        return $this;
    }

    /**
     * Get the value of Creaturewin.
     *
     * @return string
     */
    public function getCreaturewin(): string
    {
        return $this->creaturewin;
    }

    /**
     * Set the value of Submittedby.
     *
     * @param string submittedby
     *
     * @return self
     */
    public function setSubmittedby($submittedby)
    {
        $this->submittedby = $submittedby;

        return $this;
    }

    /**
     * Get the value of Submittedby.
     *
     * @return string
     */
    public function getSubmittedby(): string
    {
        return $this->submittedby;
    }

    /**
     * Set the value of Forest.
     *
     * @param bool forest
     *
     * @return self
     */
    public function setForest($forest)
    {
        $this->forest = $forest;

        return $this;
    }

    /**
     * Get the value of Forest.
     *
     * @return bool
     */
    public function getForest(): bool
    {
        return $this->forest;
    }

    /**
     * Set the value of Graveyard.
     *
     * @param bool graveyard
     *
     * @return self
     */
    public function setGraveyard($graveyard)
    {
        $this->graveyard = $graveyard;

        return $this;
    }

    /**
     * Get the value of Graveyard.
     *
     * @return bool
     */
    public function getGraveyard(): bool
    {
        return $this->graveyard;
    }

    /**
     * Get the value of submittedbyid
     *
     * @return  int
     */
    public function getSubmittedbyid()
    {
        return $this->submittedbyid;
    }

    /**
     * Set the value of submittedbyid
     *
     * @param  int  $submittedbyid
     *
     * @return  self
     */
    public function setSubmittedbyid(int $submittedbyid)
    {
        $this->submittedbyid = $submittedbyid;

        return $this;
    }

    /**
     * Get the value of notes
     *
     * @return  string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set the value of notes
     *
     * @param  string  $notes
     *
     * @return  self
     */
    public function setNotes(string $notes)
    {
        $this->notes = $notes;

        return $this;
    }
}
