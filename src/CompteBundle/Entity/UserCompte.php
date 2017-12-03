<?php

/**
 * Created by IntelliJ IDEA.
 * User: walid
 * Date: 05/11/2017
 * Time: 01:47
 */

namespace CompteBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="compte")
 */
class UserCompte extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $smoker;

    /**
     * @ORM\Column(type="boolean")
     */
    private $drinker;

    /**
     * @ORM\Column(type="integer")
     */
    private $drinkScore;

    /**
     * @ORM\Column(type="integer")
     */
    private $smokeScore;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return mixed
     */
    public function getSmoker()
    {
        return $this->smoker;
    }

    /**
     * @param mixed $smoker
     */
    public function setSmoker($smoker)
    {
        $this->smoker = $smoker;
    }

    /**
     * @return mixed
     */
    public function getDrinker()
    {
        return $this->drinker;
    }

    /**
     * @param mixed $drinker
     */
    public function setDrinker($drinker)
    {
        $this->drinker = $drinker;
    }

    /**
     * @return mixed
     */
    public function getDrinkScore()
    {
        return $this->drinkScore;
    }

    /**
     * @param mixed $drinkScore
     */
    public function setDrinkScore($drinkScore)
    {
        $this->drinkScore = $drinkScore;
    }

    /**
     * @return mixed
     */
    public function getSmokeScore()
    {
        return $this->smokeScore;
    }

    /**
     * @param mixed $smokeScore
     */
    public function setSmokeScore($smokeScore)
    {
        $this->smokeScore = $smokeScore;
    }




}