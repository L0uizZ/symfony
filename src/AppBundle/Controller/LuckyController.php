<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Number;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LuckyController extends Controller
{

    public function numberAction($max)
    {
        if ($max > 1000 || $max < 0) {
            throw new UnexpectedValueException("Invalid Range!");
        } else {
            $number = mt_rand(0, $max);
            return $this->render('lucky/number.html.twig', array('number' => $number,));
        }

    }


    public function formAction(Request $request)
    {
        $numbrange = $request->get('numbrange');

        if ($numbrange > 1000 || $numbrange < 0) {
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

        if (!$dbcontent) {
            throw new \UnexpectedValueException('No DB entry found for ID ' . $numberid);
        } else {
            echo '<b>Found an entry for ID </b>' . $numberid;
            return $this->render('lucky/luckydb.html.twig', array('dbtable' => $foundcontent));


        }
    }


    public function showAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Number');
        $dbtable = $repository->findAll();
        return $this->render('lucky/luckydb.html.twig', array('dbtable' => $dbtable));
    }


    public function eraseAction(Request $request)
    {
        $numberid = $request->get('contentid');
        $em = $this->getDoctrine()->getManager();
        $toerase = $em->getRepository('AppBundle:Number')->find($numberid);

        if (!$toerase) {
            throw new \UnexpectedValueException('No DB entry found for ID ' . $numberid);

        } else {

            $em->remove($toerase);
            $em->flush();
            return new Response("Erased entry with ID " . $numberid);
        }
    }

    public function updateAction(Request $request)
    {

        $numberid = $request->get('contentid');
        $em = $this->getDoctrine()->getManager();
        $toupdate = $em->getRepository('AppBundle:Number')->find($numberid);
        if (!$toupdate) {
            throw new \UnexpectedValueException('No DB entry found for ID ' . $numberid);
        }
        $toupdate->setNumber('1000');
        $toupdate->setCreatedAt(new \DateTime());
        $em->flush();

        return new Response('Updated entry with ID ' . $numberid);
    }

    public function serviceAction(){
        $messageGenerator = $this->container->get('app.message_generator');
        $message = $messageGenerator->getHappyMessage();
        $this->addFlash('success', $message);

        $logger = $this->container->get('logger');
        $logger->info('Look! I just used a service');

        return new Response($message);
    }

}
# update
# formbundle formtypes
# services dependency
