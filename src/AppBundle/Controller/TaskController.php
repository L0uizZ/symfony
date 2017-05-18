<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;


class TaskController extends Controller
{
    public function newAction(Request $request){
        $task = new Task();
        $task->setTask("Buy some drinks!");
        $task->setDuedate(new \DateTime('tomorrow'));
        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, array('label'=>'Save Task'))
            ->add('find', SubmitType::class, array('label'=>'Find Task'))
            ->add('erase', SubmitType::class, array('label'=>'Erase Task'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid())
        {
            $task = $form->getData();
            $repository = $this->getDoctrine()->getRepository('AppBundle:Task');

            if($form->get('save')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();
                return new Response('Saved your Task');
            }
            if($form->get('find')->isClicked()) {
                $dbtable = $repository->findByTask($task->getTask($form->get('task')));
                return $this->render('task/taskdb.html.twig', array('dbtable' => $dbtable));
            }
            if($form->get('erase')->isClicked()) {

            }
        }

        return $this->render('task/new.html.twig', array('form' => $form->createView()));
    }

    public function showAction(){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        $dbtable = $repository->findAll();
        return $this->render('task/taskdb.html.twig', array('dbtable' => $dbtable));
    }

}