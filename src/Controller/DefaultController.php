<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{


    public function index()
    {
        $test = "Hello";
        return new Response($test);

    }

    public function prenom(string $prenom)
    {
        return new Response($prenom);

    }

    /**
     * @param string $prenom1
     * @param string $prenom2
     * @return Response
     * @Route ("/{prenom1}/{prenom2}")
     */
    public function main(string $prenom1, string $prenom2)
    {
        $content = "Hello " . $prenom1 . " & " . $prenom2;
        return new  Response($content);
    }

}