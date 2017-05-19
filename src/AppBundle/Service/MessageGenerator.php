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

    public function  __construct(LoggerInterface $logger, $loggingEnabled)
    {
        $this->logger = $logger;
        $this->loggingEnabled = $loggingEnabled;
    }

    public function getHappyMessage()
    {

        if($this->loggingEnabled){
            $this->logger->info('About to find a happy message!');
        }

        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];
        $index = array_rand($messages);

        return $messages[$index];
    }

}