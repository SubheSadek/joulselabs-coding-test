<?php

declare(strict_types=1);

namespace SellNow\Controllers;

use SellNow\Core\Logger\TransactionLogger;
use SellNow\Core\Request;
use SellNow\Core\Security\Csrf;
use SellNow\Services\CartService;
use SellNow\Services\CheckoutService;
use Twig\Environment;

class CheckoutController
{
    public function __construct(
        protected Environment $twig,
        protected CheckoutService $checkoutService,
        protected CartService $cartService,
        protected TransactionLogger $logger
    )
    {}

    /**
     * Checkout page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request): void
    {
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            header("Location: /cart");
            exit;
        }

        $data = $this->checkoutService->formatCheckoutData($cart);
        echo $this->twig->render('checkout/index.html.twig', $data);
    }

    /**
     * Process checkout
     *
     * @param Request $request
     * @return void
     */
    public function process(Request $request): void
    {
        $provider = $request->input('provider');

        if (!$this->checkoutService->isValidProvider($provider)) {
            header("Location: /checkout");
            exit;
        }

        if (empty($_SESSION['cart'])) {
            header("Location: /cart");
            exit;
        }

        $_SESSION['provider'] = $provider;

        header("Location: /payment");
        exit;
    }

    /**
     * Payment page
     *
     * @param Request $request
     * @return void
     */
    public function payment(Request $request): void
    {
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            header("Location: /cart");
            exit;
        }

        $provider = $_SESSION['provider'];

        if (!$this->checkoutService->isValidProvider($provider)) {
            header("Location: /checkout");
            exit;
        }

        $total = $this->cartService->getCartTotal($cart);

        echo $this->twig->render('checkout/payment.html.twig', [
            'provider' => $provider,
            'total' => $total
        ]);
    }

    /**
     * Success page
     *
     * @param Request $request
     * @return void
     */
    public function success(Request $request): void
    {
        $provider = $_SESSION['provider'];

        if (!$this->checkoutService->isValidProvider($provider)) {
            header("Location: /checkout");
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            header("Location: /cart");
            exit;
        }

        $this->logger->log($provider, $_SESSION['user_id'] ?? null);

        unset($_SESSION['cart']);
        unset($_SESSION['provider']);
        Csrf::regenerate();

        echo $this->twig->render('success/index.html.twig', [
            'provider' => $provider
        ]);
    }
}
