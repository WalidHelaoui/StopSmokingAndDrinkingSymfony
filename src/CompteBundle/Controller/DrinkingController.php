<?php

namespace CompteBundle\Controller;

use CompteBundle\Entity\DrinkingStatistics;
use CompteBundle\Entity\Setting;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DrinkingController extends Controller
{
    public function indexAction()
    {
        $response = $this->getDoctrine()->getRepository(DrinkingStatistics::class)->findBy(array("user"=>$this->getUser()));
        $i = 0;
        foreach ($response as $item){
            $i++;
             $json[$i-1]=(['number' => $item->getNumber(),'price' => $item->GetPrice(),'date' => $item->getDate()]);
        }

        return $json;
    }

    public function savedMoneyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $response = $em->getRepository(DrinkingStatistics::class)->findBy(array("user"=>$this->getUser()));
        $setting = $em->getRepository(Setting::class)->findOneBy(array("user"=>$this->getUser()));

        $json = new JsonResponse();

        $savedMoney = 0;
        foreach ($response as $item){
                $diffrence = ($setting->getDrinkingSettingPrice())-($item->getPrice());
                $savedMoney=$savedMoney+$diffrence;
        }
        $json->setData(['savedMoney' => $savedMoney,'count' => count($response)]);
        return $json;
    }

    public function changeScoreAction(Request $request){
        $drinkScore = $request->get('drinkScore');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setDrinkScore($drinkScore);
        $em->flush();
        $json = new JsonResponse();
        $json->setData(['DrinkScore' => $user->getDrinkScore()]);
        return $json;
    }

    public function addAction(Request $request){
        $drinkNumber = $request->get('drinkNumber');
        $drinkPrice = $request->get('drinkPrice');
        $mydate=getdate(date("U"));
        $date = "$mydate[weekday], $mydate[mday] $mydate[month], $mydate[year]";
        $drinking = new DrinkingStatistics();
        $drinking->setUser($this->getUser());
        $drinking->setDate($date);
        $drinking->setNumber($drinkNumber);
        $drinking->setPrice($drinkPrice);
        $json = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        if ($drinkPrice!=null&&$drinkNumber!=null){
            $em->persist($drinking);
            $em->flush();

            return $json->setData("Drink Quiz added with success");
        }else {
            return $json->setData("Invalid Data");
        }
    }

    public function restAction(){
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $var = $em->getRepository(DrinkingStatistics::class)->findBy(array("number"=>0,"user"=>$user));
        $json = new JsonResponse();
        $json->setData(['drinkingRest' => count($var)]);
        return $json;
    }
}
