<?php
/**
 * Created by PhpStorm.
 * User: praktikant
 * Date: 15/05/17
 * Time: 15:44
 */

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExceptionsController extends Controller
{
  public function showExceptionsAction(){



      return $this->render('error/404.html.twig');
  }
}