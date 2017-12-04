<?php

namespace CompteBundle\Controller;

use CompteBundle\Entity\Setting;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SettingController extends Controller
{
    public function indexAction(Request $request)
    {
        $smokingPrice = $request->get('smokingPrice');
        $drinkingPrice = $request->get('drinkingPrice');
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Setting::class)->findOneBy(array("user"=>$this->getUser()));
        $json = new JsonResponse();
        if(!empty($data)){
            $data->setDrinkingSettingPrice($drinkingPrice);
            $data->setSmokingSettingPrice($smokingPrice);
            $em->flush();
            return $json->setData(['smokingPrice' => $data->getSmokingSettingPrice(),'drinkingPrice' => $data->getDrinkingSettingPrice()]);
        }
        return $json->setData(['smokingPrice' => $smokingPrice,'drinkingPrice' => $drinkingPrice]);
    }
}
