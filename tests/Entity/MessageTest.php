<?php
/**
 * Created by PhpStorm.
 * User: Shadow
 * Date: 19/03/2019
 * Time: 19:10
 */

namespace App\Tests\Entity;


use App\Entity\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testMessage(){
        $message = new Message();
        $message->setContent('Je suis un message');
        $message->setObject('Je suis un objet');
        $message->setReceiver('toi');
        $message->setSender('moi');
        $message->setStatus('lu');
        $this->assertStringMatchesFormat(
            'Je suis un message',$message->getContent()
            );
        $this->assertStringMatchesFormat(
            'Je suis un objet',$message->getObject()
        );$this->assertStringMatchesFormat(
            'toi',$message->getReceiver()
        );$this->assertStringMatchesFormat(
            'moi',$message->getSender()
        );$this->assertStringMatchesFormat(
            'lu',$message->getStatus()
        );
    }
}