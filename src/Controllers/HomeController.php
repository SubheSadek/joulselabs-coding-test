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
        echo $this->twig->render(
            'layouts/base.html.twig', 
            [
                'content' => "<h1>Welcome</h1><a href='/login'>Login</a>",
                'title' => 'Home'
            ]
        );
    }
}