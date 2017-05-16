<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Number;


class LuckyController extends Controller
{

    public function numberAction($max)
    {


        if($max>1000||$max<0){
            throw new HttpNotFoundException("Invalid Range!");
        } else {
            $number = mt_rand(0, $max);
            $dbwriter = new Number();

            return $this->render('lucky/number.html.twig', array('number' => $number,));
        }

    }
    public function formAction(Request $request)
    {
        $numbrange = $request->get('numbrange');

        if($numbrange>1000||$numbrange<0){
            throw new HttpNotFoundException("Invalid Range!");
        } else {
            $formnumb = mt_rand(0, $numbrange);
            $dbwriter = new Number();
            $dbwriter->setNumber($formnumb);
            $dbwriter->setCreatedAt((date("d.m.y")));
            echo $dbwriter->getCreatedAt();
            return $this->render('lucky/number.html.twig', array('number' => $dbwriter->getNumber()));
        }
    }

#
#        public function dbAction(Request $request){
#        $numbrange = $request->get('numbrange');
#        $formnumb = mt_rand(0, $numbrange);
#        $numberdb = new Number();
#        $formdb = $this->createForm(new NumberType(), $numberdb);
#        $request = $this->get('request');
#        $formdb->handleRequest($request);
#        if($request->getMethod() == 'POST'){
#            if($formdb->isValid()){
#                return new Response('Number successfully added to DB!');
#            }
#
#        }
#    }

}