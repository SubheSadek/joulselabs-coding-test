<?php

namespace SellNow\Services;

class CheckoutService
{
    public function __construct(
        private CartService $cartService
    )
    {}

    /**
     * Format checkout data
     *
     * @param array $cart
     * @return array
     */
    public function formatCheckoutData(array $cart): array
    {
        $total = $this->cartService->getCartTotal($cart);

        $providers = ['Stripe', 'PayPal', 'Razorpay'];

        return [
            'total' => $total,
            'providers' => $providers
        ];
    }

    /**
     * Check if provider is valid
     *
     * @param string $provider
     * @return bool
     */
    public function isValidProvider(string $provider): bool
    {
        if (empty($provider)) {
            return false;
        }

        return in_array($provider, ['Stripe', 'PayPal', 'Razorpay']);
    }
}