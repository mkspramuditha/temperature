<?php

namespace AppBundle\Controller;

use AppBundle\Entity\data;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

class DashboardController extends DefaultController
{
    /**
     * @Route("/", name="homepage")
     */

    public function indexAction(Request $request)
    {
        $values = $this->getRepository('Data')->findBy(array(), array('datetime' => 'ASC'));
        $arry = [];
        foreach ($values as $value){
            $time =$value->getDateTime();
            $unixTime = (float)(mktime($time->format('s'), $time->format('i'), $time->format('H'), $time->format('d'), $time->format('m'), $time->format('Y')))*1000;
//            var_dump($unixTime);
            $arry[] = [$unixTime,(float)$value->getData()];
        }

        $chartData = json_encode($arry);

        return $this->render('dashboard/dashboard.html.twig',array(
            'chart'=>$chartData

        ));
    }
}
