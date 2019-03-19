<?php
/**
 * Created by PhpStorm.
 * User: Shadow
 * Date: 19/03/2019
 * Time: 19:01
 */

namespace App\Tests\Entity;


use App\Entity\Trashs;
use PHPUnit\Framework\TestCase;

class TrashTest extends TestCase
{
    /**
     * @test
     */
    public function testTrash(){
        $trash= new Trashs();
        $trash->setCity('Toulouse');
        $trash->setActualCapacity(123);
        $trash->setAddress('rue de toulouse');
        $trash->setAltitude(12.5);
        $trash->setAvailability(1);
        $trash->setCapacityMax(456);
        $trash->setDamage(0);
        $trash->setInseeCode('INSEE');
        $trash->setLatitude(49.1);
        $trash->setLongitude(1.9);
        $trash->setReference("1234");
        $this->assertStringMatchesFormat(
            'Toulouse',$trash->getCity()
        );
        $this->assertEquals(123,$trash->getActualCapacity());
        $this->assertStringMatchesFormat(
            'rue de toulouse',$trash->getAddress()
        );
        $this->assertEquals(12.5,$trash->getAltitude());
        $this->assertEquals(1,$trash->getAvailability());
        $this->assertEquals(456,$trash->getCapacityMax());
        $this->assertEquals(0,$trash->getDamage());
        $this->assertStringMatchesFormat(
            'INSEE',$trash->getInseeCode()
        );
        $this->assertEquals(49.1,$trash->getLatitude());
        $this->assertEquals(1.9,$trash->getLongitude());
        $this->assertStringMatchesFormat(
            '1234',$trash->getReference()
        );
    }

}