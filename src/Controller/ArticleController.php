<?php

namespace App\Controller;
use App\Entity\Article;
use App\Form\ArticleForm;
use App\Service\MyService;
use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ArticleController extends AbstractController
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
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ArticleController constructor.
     * @param Environment $twig
     * @param MyService $service
     * @param EntityManagerInterface $entityManager
     * @param LoggerInterface $logger
     */
    public function __construct(Environment $twig, MyService $service, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->service = $service;
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    /**
     * @Route ("/formulaire")
     */
    public function form() {

        $form = $this->createForm(ArticleForm::class);
        $display = $this->twig->render('home/articles.html.twig', [
            'articles' => $form->createView()
        ]);
        return new Response($display);

    }
    /**
     *
     * @param int $id
     * @return Response
     * @Route ("/article/{id}")
     */
    public function findArticles(int $id) {

        $em = $this->entityManager->getRepository(Article::class);
        $response = $em->findAll();


        $display = $this->twig->render('home/articles.html.twig', [
            'articles' => $response
        ]);
        return new Response($display);
    }

    /**
     * @param Request $request
     * @return void
     * @Route ("/article/new")
     * @throws \Doctrine\ORM\ORMException
     */
    public function input(Request $request)
    {
        $title = $request->query->get('title');
        $content = $request->query->get('content');

        $article = new Article($title, $content, new \DateTime());


        $message = $article->getContent().' '.$article->getTitle();
        $this->logger->info($message);

        $display = $this->twig->render('home/articles.html.twig', [
            'content' => $message

        ]);

        $this->entityManager->persist($article);
        $this->entityManager->flush($article);

        return new Response($display);

    }
}