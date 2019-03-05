<?php

namespace App\Controller;

use BotMan\Drivers\Web\WebDriver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Middleware\ApiAi;


class WidgetController extends Controller {

    /**
     * @Route("/message", name="message")
     */
    function messageAction(Request $request, \App\Services\BotServices $botService)
    {
        // Create a BotMan instance, using the WebDriver
        DriverManager::loadDriver(WebDriver::class);
        $botman = BotManFactory::create([]); //No config options required


        $botman->hears('(hello|hi|hey)', function (BotMan $bot) use ($botService) {
            $bot->reply($botService->handleHello());
        });

        $botman->hears('(Ou|ou|Où|où) se trouve le rapport (d\'incidents|d\'incident) ?', function (BotMan $bot) use ($botService) {
            $bot->reply($botService->handleIncident());
        });

        $botman->hears('(Qui|qui) est le référend de ma ville ?', function (BotMan $bot) use ($botService) {
           $bot->reply($botService->handleReferend());
        });

        $botman->hears('(Qui|qui) prévenir en cas (d\'incident|d\'incidents) ?', function (BotMan $bot) use ($botService) {
            $bot->reply($botService->handleReferend2());
        });

        // Start listening
        $botman->listen();

        //Send an empty response (Botman has already sent the output itself - https://github.com/botman/botman/issues/342)
        return new Response();
    }



}
