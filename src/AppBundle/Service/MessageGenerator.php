<?php
#SERVICECLASS
namespace AppBundle\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MessageGenerator
{
    private $logger;
    private $loggingEnabled;

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

        $this->logger->info('===> H A P P Y ===> M E S S A G E <=== I N C O M I N G <===');
        $this->logger->info($messages[$index]);

        return $messages[$index];
    }

}