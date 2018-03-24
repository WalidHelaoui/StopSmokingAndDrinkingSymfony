<?php
/**
 * Created by IntelliJ IDEA.
 * User: walid
 * Date: 04/12/2017
 * Time: 00:58
 */

namespace CompteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Setting
 * @ORM\Entity()
 */
class Setting
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $smokingSettingPrice=99999;

    /**
     * @ORM\Column(type="string")
     */
    private $drinkingSettingPrice=99999;

    /**
     * @ORM\OneToOne(targetEntity="CompteBundle\Entity\UserCompte")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getSmokingSettingPrice()
    {
        return $this->smokingSettingPrice;
    }

    /**
     * @param mixed $smokingSettingPrice
     */
    public function setSmokingSettingPrice($smokingSettingPrice)
    {
        $this->smokingSettingPrice = $smokingSettingPrice;
    }

    /**
     * @return mixed
     */
    public function getDrinkingSettingPrice()
    {
        return $this->drinkingSettingPrice;
    }

    /**
     * @param mixed $drinkingSettingPrice
     */
    public function setDrinkingSettingPrice($drinkingSettingPrice)
    {
        $this->drinkingSettingPrice = $drinkingSettingPrice;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}