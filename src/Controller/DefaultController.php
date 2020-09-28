<?php

namespace App\Controller;
use App\Service\MyService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class DefaultController
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var MyService
     */
    private $service;

    /**
     * DefaultController constructor.
     * @param Environment $twig
     * @param MyService $service
     */
    public function __construct(Environment $twig, MyService $service)
    {
        $this->service = $service;
        $this->twig = $twig;
    }

    public function index()
    {
        $content = $this->twig->render('home/index.html.twig' , [ 'name' => 'Pierre']);
        return new Response($content);

    }

    /**
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @Route ("/articles")
     */
    public function articles() {
        $content = $this->twig->render('home/articles.html.twig' , [ 'articles' =>[
                [
                    'titre' => 'titre1',
                    'contenu' => 'contenu1',
                    'image' => 'https://picsum.photos/200',
                    'etoiles' => 4,
                ],
                [
                    'titre' => 'titre2',
                    'contenu' => 'contenu2',
                    'image' => 'https://picsum.photos/300',
                    'etoiles' => 2,
                ]
            ]
        ]);
        return new Response($content);
    }

    public function prenom(string $prenom)
    {
        return new Response($prenom);

    }

    /**
     * @param int $int1
     * @param int $int2
     * @return Response
     * @Route ("/{int1}/{int2}")
     */
    public function main(int $int1, int $int2)
    {
        $content = $this->service->addition($int1, $int2);
        $display = $this->twig->render('home/articles.html.twig' , [
            'articles' =>[
            [
                'titre' => 'titre1',
                'contenu' => 'contenu1',
                'image' => 'https://picsum.photos/200',
                'etoiles' => 4,
            ],
            [
                'titre' => 'titre2',
                'contenu' => 'contenu2',
                'image' => 'https://picsum.photos/300',
                'etoiles' => 2,
            ]
            ],
            'test' => $content

        ]);
        return new  Response($display);
    }

}