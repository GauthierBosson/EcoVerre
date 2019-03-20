<?php
/**
 * Created by PhpStorm.
 * User: Shadow
 * Date: 19/03/2019
 * Time: 18:40
 */

namespace App\Tests\Entity;

use App\Entity\Users;
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    /**
     * @test
     */
    public function testUser(){
        $user = new Users();
        $user->setName('Smith');
        $user->setFirstname('John');
        $user->setCity('Rouen');
        $user->setEmail('smith@mail.com');
        $user->setPassword('smith');
        $this->assertStringMatchesFormat(
            'Smith',
            $user->getName()
        );
        $this->assertStringMatchesFormat(
            'John',
            $user->getFirstname()
        );
        $this->assertStringMatchesFormat(
            'Rouen',
            $user->getCity()
        );
        $this->assertStringMatchesFormat(
            'smith@mail.com',
            $user->getEmail()
        );
        $this->assertStringMatchesFormat(
            'smith',
            $user->getPassword()
        );
    }
}