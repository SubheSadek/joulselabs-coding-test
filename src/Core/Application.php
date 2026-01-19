<?php

declare(strict_types=1);

namespace SellNow\Core;

use SellNow\Config\Database;
use PDO;
use SellNow\Core\Security\Csrf;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Application
{
    /**
     * @return void
     */
    public function run(): void
    {
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        session_start();

        $container = new Container();

        $container->bind(PDO::class, fn () =>
            Database::getInstance()->getConnection()
        );

        $container->bind(Environment::class, function () {
            $loader = new FilesystemLoader(
                dirname(__DIR__, 2) . '/templates'
            );

            $twig = new Environment($loader, [
                'cache' => false,
                'debug' => true
            ]);

            $twig->addGlobal('session', $_SESSION);
            $twig->addGlobal('csrf_token', Csrf::token());

            return $twig;
        });

        $router = new Router($container);

        require dirname(__DIR__, 2) . '/routes/web.php';

        $router->dispatch(Request::capture());
    }
}
