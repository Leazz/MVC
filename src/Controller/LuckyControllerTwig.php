<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky/number/twig", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky_number.html.twig', $data);
    }

    #[Route("/home", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route('/', name: 'me')]
    public function me(): Response
    {
        return $this->render('me.html.twig', [
            'name' => 'Lea',
            'image' => 'me.jpg',
            'description' => 'A little about me '
        ]);
    }

    #[Route('/api/quote')]
    public function quote(): Response
    {
        $quotes = [
            'You can do it, you are strong <3',
            'Love your self',
            'Success dosent come to you, you go yo it',
        ];

        $randomQuote = $quotes[array_rand($quotes)];

        $data = [
            'quote' => $randomQuote,
            'date' => date('Y-m-d'),
            'timestamp' => time(),
        ];
        $response = new Response();
        $response->setContent(json_encode($data));

        return $response;
    }

    #[Route('/report')]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

}