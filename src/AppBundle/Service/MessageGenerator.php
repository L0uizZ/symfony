<?php
namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class MessageGenerator
{
    private $transport;


    public function getHappyMessage()
    {
        $container = new ContainerBuilder();
        $container
            ->register('mailer', 'Mailer')
            ->addArgument('sendmail');

        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];
        $index = array_rand($messages);
        $this->transport = 'sendmail';

        return $messages[$index];
    }

    public function __construct($transport)
    {
        $this->transport = $transport;
    }
}