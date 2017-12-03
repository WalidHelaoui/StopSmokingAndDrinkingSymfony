<?php

namespace CompteBundle\Controller;

use CompteBundle\Entity\SmokingStatistics;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class SmokingController extends Controller
{
    public function indexAction()
    {
        $response = $this->getDoctrine()->getRepository(SmokingStatistics::class)->findBy(array("user"=>$this->getUser()));
        $i = 0;
        foreach ($response as $item){
            $i++;
            $json[$i-1]=(['number' => $item->getNumber(),'price' => $item->GetPrice(),'date' => $item->getDate()]);
        }

        return $json;
    }

    public function savedMoneyAction()
    {
        $response = $this->getDoctrine()->getRepository(SmokingStatistics::class)->findBy(array("user"=>$this->getUser()));

        $json = new JsonResponse();

        $savedMoney = 0;
        foreach ($response as $item){
            $diffrence = ($response[0]->getPrice())-($item->getPrice());
            $savedMoney=$savedMoney+$diffrence;
        }
        $json->setData(['savedMoney' => $savedMoney,'count' => count($response)]);
        return $json;
    }
}
