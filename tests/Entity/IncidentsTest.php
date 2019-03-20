<?php
/**
 * Created by PhpStorm.
 * User: Shadow
 * Date: 19/03/2019
 * Time: 19:20
 */

namespace App\Tests\Entity;


use App\Entity\Incidents;
use PHPUnit\Framework\TestCase;

class IncidentsTest extends TestCase
{
    public function testIncidents(){
        $incident=  new Incidents();
        $incident->setReference('1234');
        $incident->setCity('Toulouse');
        $incident->setEmail('mail@mail.com');
        $incident->setDescription('Description');
        $incident->setPicture('tof.png');
        $incident->setTrash('Ben La Benne');
        $this->assertStringMatchesFormat('1234',$incident->getReference());
        $this->assertStringMatchesFormat('Toulouse',$incident->getCity());
        $this->assertStringMatchesFormat('mail@mail.com',$incident->getEmail());
        $this->assertStringMatchesFormat('Description',$incident->getDescription());
        $this->assertStringMatchesFormat('tof.png',$incident->getPicture());
        $this->assertStringMatchesFormat('Ben La Benne',$incident->getTrash());

    }

}