<?php
/**
 * Created by PhpStorm.
 * User: pc 01
 * Date: 16/01/2019
 * Time: 10:26
 */

namespace App\Membre\Listener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MembrePasswordFieldSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
          FormEvents::PRE_SET_DATA => 'preSetData'
        ];
    }

    public function preSetData(FormEvent $event)
    {
        $membre = $event->getData();
        $form = $event->getForm();

        if ($membre || null !== $membre->getId()) {
            $form->remove('password');
        }
    }

}