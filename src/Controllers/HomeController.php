<?php

declare(strict_types=1);

namespace SellNow\Controllers;

use Twig\Environment;

class HomeController
{
    public function __construct(
        private Environment $twig
    ) {}

    /**
     * Returns the home page.
     * 
     * @Route("/")
     */
    public function index(): void
    {
        echo $this->twig->render('home/index.html.twig');
    }
}