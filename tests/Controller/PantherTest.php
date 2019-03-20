<?php
/**
 * Created by PhpStorm.
 * User: Shadow
 * Date: 20/03/2019
 * Time: 00:04
 */

namespace App\Tests\Controller;


use Symfony\Component\Panther\PantherTestCase;

class PantherTest extends PantherTestCase
{
    /**
     * @test
     */
    public function testFormSuccessAction()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/admin/login');
        $form = $crawler->selectButton('Connexion')->form();
        $form['admin_login_form[email]'] ='admin@greenworld.com';
        $form['admin_login_form[password]'] = 'root';
        //sleep(2);
        $client->submit($form);



    }

}