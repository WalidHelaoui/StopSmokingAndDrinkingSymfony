<?php

namespace CompteBundle\Controller;

use CompteBundle\Entity\Setting;
use CompteBundle\Entity\SmokingStatistics;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SmokingController extends Controller
{
    public function indexAction()
    {
        $response = $this->getDoctrine()->getRepository(SmokingStatistics::class)->findBy(array("user"=>$this->getUser()));
        $i = 0;
        $json = [];
        foreach ($response as $item){
            $i++;
            $json[$i-1]=(['number' => $item->getNumber(),'price' => $item->GetPrice(),'date' => $item->getDate()]);
        }

        return $json;
    }

    public function savedMoneyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $response = $em->getRepository(SmokingStatistics::class)->findBy(array("user"=>$this->getUser()));
        $setting = $em->getRepository(Setting::class)->findOneBy(array("user"=>$this->getUser()));
        $json = new JsonResponse();

        $savedMoney = 0;
        foreach ($response as $item){
            $diffrence = ($setting->getSmokingSettingPrice())-($item->getPrice());
            $savedMoney=$savedMoney+$diffrence;
        }
        $json->setData(['savedMoney' => $savedMoney,'count' => count($response)]);
        return $json;
    }

    public function changeScoreAction(Request $request){
        $smokeScore = $request->get('smokeScore');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setSmokeScore($smokeScore);
        $em->flush();
        $json = new JsonResponse();
        $json->setData(['SmokeScore' => $user->getSmokeScore()]);
        return $json;
    }

    public function addAction(Request $request){
        $cigaretteNumber = $request->get('cigaretteNumber');
        $cigarettePrice = $request->get('cigarettePrice');
        $mydate=getdate(date("U"));
        $date = "$mydate[weekday], $mydate[mday] $mydate[month], $mydate[year]";
        $smoking = new SmokingStatistics();
        $smoking->setUser($this->getUser());
        $smoking->setDate($date);
        $smoking->setNumber($cigaretteNumber);
        $smoking->setPrice($cigarettePrice);
        $json = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        if ($cigarettePrice!=null&&$cigaretteNumber!=null){
            $em->persist($smoking);
            $em->flush();

            return $json->setData("Smoking Quiz added with success");
        }else {
            return $json->setData("Invalid Data");
        }
    }

    public function restAction(){
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $var = $em->getRepository(SmokingStatistics::class)->findBy(array("number"=>0,"user"=>$user));
        $json = new JsonResponse();
        $json->setData(['smokingRest' => count($var)]);
        return $json;
    }
}
