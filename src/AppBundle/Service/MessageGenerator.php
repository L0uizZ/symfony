<?php
#SERVICECLASS
namespace AppBundle\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MessageGenerator
{
    #SERVICES DOESNT HAVE CONTAINER $this->container PROPERTY (ONLY CONTROLLERS)
    #CREATING A __contrsuct() method with $mailer ARGUMENT AND SET PROPERTY

    private $logger;
    private $loggingEnabled;
    private $mailer;

    public function  __construct(LoggerInterface $logger, $loggingEnabled)
    {
        $this->logger = $logger;
        $this->loggingEnabled = $loggingEnabled;
    }

    public function getHappyMessage()
    {

        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];
        $index = array_rand($messages);

        $mailer = \Swift_Message::newInstance()
            ->setSubject('Just a Test!')
            ->setFrom('praktikant@symfony.dev')
            ->setTo('louis.hinz@hotmail.de')
            ->setBody($messages[$index]);

        return $messages[$index];
    }

}