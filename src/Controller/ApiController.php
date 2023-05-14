<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\cardsSet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ApiController extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }

    #[Route("/api/deck", name: "deck_api", methods:['GET'])]
    public function apiDeck(): Response
    {

        $deck = new DeckOfCards();
        $cards = $deck->sortedCards();

        $cardSets = '';
        foreach($cards as $card) {
            $cardSets .= "[{$card->getTheValue()}{$card->getTheSuit()}]";
        }
        $data = [
            'cards' => $cardSets
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "deck_shuffle_api", methods:['POST'])]
    public function apiShuffle(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $session->set('deck', $deck);
        $cards = $deck->shuffle();

        $cardSets = '';
        foreach($cards as $card) {
            $cardSets .= "[{$card->getTheValue()}{$card->getTheSuit()}]";
        }
        $data = [
            'cards' => $cardSets
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "deck_draw_api", methods:['POST'])]
    public function apiDraw(SessionInterface $session): Response
    {
        $deck = $session->get('deck');


        $card = $deck->draw();
        $cardSets = "[{$card->getTheValue()}{$card->getTheSuit()}]";

        $numCards = $deck->numCards();
        $data = [
            'cards' => $cardSets,
            'numCards' => $numCards
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

    #[Route("/api/deck/draw/{number<\d+>}", name: "deck_draw_num_api", methods:['POST'])]
    public function apiDrawNum(
        int $number,
        SessionInterface $session
    ): Response {

        $deck = $session->get('deck');
        $cards = $deck->shuffle();

        if ($number < 1 || $number > $deck->numCards()) {
            throw new \Exception("The number of cards to draw is invalid.");
        }

        $cards = [];
        for ($i = 0; $i < $number; $i++) {
            $cards[] = array_pop($deck->cards);
        }

        $numCards = $deck->numCards();

        $cardsSet = '';
        foreach($cards as $card) {
            $cardsSet .= "[{$card->getTheValue()}{$card->getTheSuit()}]";
        }

        $data = [
            'cards' => $cardsSet,
            'numCards' => $numCards
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

}
