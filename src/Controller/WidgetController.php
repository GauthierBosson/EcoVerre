<?php

namespace App\Controller;

use BotMan\Drivers\Web\WebDriver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Middleware\ApiAi;


class WidgetController extends AbstractController {

    /**
     * @Route("/message", name="message")
     */
    function messageAction(Request $request, \App\Services\BotServices $botService)
    {
        // Create a BotMan instance, using the WebDriver
        DriverManager::loadDriver(WebDriver::class);
        $botman = BotManFactory::create([]); //No config options required


        $botman->hears('(Bonjour|bonjour|salut|Salut)', function (BotMan $bot) use ($botService) {
            $bot->reply($botService->handleHello());
        });

        $botman->hears('(Ou|ou|Où|où) se trouve le rapport (d\'incidents|d\'incident)', function (BotMan $bot) use ($botService) {
            $bot->reply($botService->handleIncident());
        });

        $botman->hears('(Qui|qui) est le référent de ma ville', function (BotMan $bot) use ($botService) {
            $bot->reply($botService->handleReferent());
        });

        $botman->hears('(Qui|qui) prévenir en cas (d\'incidents|d\'incident)', function (BotMan $bot) use ($botService) {
            $bot->reply($botService->handleReferent2());
        });

        $botman->hears('(Toulouse|toulouse)', function (BotMan $bot) use ($botService) {
            $bot->reply($botService->handleAskReferent());
        });

        $botman->hears('help', function (Botman $bot) use ($botService) {
            $bot->reply($botService->handleHelp());
        });


        // Start listening
        $botman->listen();

        //Send an empty response (Botman has already sent the output itself - https://github.com/botman/botman/issues/342)
        return new Response();
    }



}
