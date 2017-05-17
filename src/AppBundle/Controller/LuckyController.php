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
            echo '<i>SAVED YOUR NUMBER IN DB</i>';
            return $this->render('lucky/number.html.twig', array('number' => $formnumb));

        }
    }

    public function findAction(Request $request)
    {
        $numberid = $request->get('contentid');
        $repository = $this->getDoctrine()->getRepository('AppBundle:Number');
        $dbcontent = $repository->find($numberid);

        $foundcontent = $repository->findById($numberid);

        if(!$dbcontent){
            throw $this->createNotFoundException('No DB entry found for ID '.$numberid);
        } else {
            echo '<b>Found an entry for ID </b>' .$numberid;
            return $this->render('lucky/luckydb.html.twig', array('dbtable' => $foundcontent));


        }
    }

    public function showAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Number');
        $dbtable = $repository->findAll();

        return $this->render('lucky/luckydb.html.twig', array('dbtable' => $dbtable));
    }
}