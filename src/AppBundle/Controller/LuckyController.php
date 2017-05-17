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
            throw new UnexpectedValueException("Invalid Range!");
        } else {
            $number = mt_rand(0, $max);
            return $this->render('lucky/number.html.twig', array('number' => $number,));
        }

    }
    public function formAction(Request $request)
    {
        $numbrange = $request->get('numbrange');

        if($numbrange>1000||$numbrange<0){
            throw new \UnexpectedValueException("Invalid Range!");
        } else {

            $formnumb = mt_rand(0, $numbrange);

            $dbwriter = new Number();
            $dbwriter->setNumber($formnumb);
            $dbwriter->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($dbwriter);
            $em->flush();

            #bekommt keine id?!
            echo 'ID: '.$dbwriter->getId();

            return $this->render('lucky/number.html.twig', array('number' => $formnumb));

        }
    }

    public function showAction(Request $request)
    {
        $numberid = $request->get('contentid');
        $dbcontent = $this->getDoctrine()->getRepository('AppBundle:Number')->find($numberid);

        if(!$dbcontent){
            throw $this->createNotFoundException('No DB content found for id '.$numberid);
        } else {
             return new Response('successfully found content for id ' .$numberid);

        }
    }
}