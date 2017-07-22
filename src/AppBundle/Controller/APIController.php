<?php
/**
 * Created by PhpStorm.
 * User: shan
 * Date: 8/23/2016
 * Time: 12:00 PM
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Data;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api")
 */
class APIController extends DefaultController
{
/**
 *send data as a response to mobile API calls
 * @param $object
 * @return Response
 */

    protected function apiSendResponse($object){
        $response =  new Response($this->objectSerialize($object));
        $responseHeaders = $response->headers;
        $responseHeaders->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
        $responseHeaders->set('Access-Control-Allow-Origin', '*');
        $responseHeaders->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
        return $response;
    }

    protected function objectSerialize($object){
        //some encoding here
        return json_encode($object);
    }

    protected function objectDeserialize($text){
        // some decoding here
        return json_decode($text);
    }

    /**
     * @Route("/data/", name="api")
     */
    public function apiAction(Request $request,$value)
    {
        $data = new Data();
        $data->setDatetime(new \DateTime('now'));
        $data->setData($request->get('value'));
        $this->insert($data);

        return new Response("value saved");
    }
}