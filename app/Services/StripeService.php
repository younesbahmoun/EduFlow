<?php
namespace App\Services;

use Stripe\StripeClient;

class StripeService {
    private $stripe;

    public function __construct() {
        // get the secret key from .env file: config/services.php/stripe => secret
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    // public function createCheckoutSession($student, $course) {
    //     return $this->stripe->checkout->sessions->create([
    //         'payment_method_types' => ['card'],
    //         // line_items is an array of items to be purchased
    //         'line_items' => [[
    //             'price_data' => [
    //                 'currency' => 'usd', // or 'mad'
    //                 'product_data' => [
    //                     'name' => $course->title,
    //                     'description' => $course->description,
    //                 ],
    //                 // 1$ = 100 cents, 1DH = 1000 centa
    //                 'unit_amount' => $course->prix * 100, // cents
    //             ],
    //             'quantity' => 1,
    //         ]],
    //         'mode' => 'payment', // or 'subscription'
    //         // where to redirect after successful payment
    //         'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}&course_id=' . $course->id,
    //         'cancel_url' => route('payment.cancel'),
    //         // metadata is an array of data to be passed to the webhook
    //         'metadata' => [
    //             'student_id' => $student->id,
    //             'course_id' => $course->id,
    //         ]
    //     ]);
    // }

    public function createCheckoutSession($student, $course)
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $course->title,
                        'description' => $course->description,
                    ],
                    'unit_amount' => $course->prix * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}&course_id=' . $course->id,
            'cancel_url' => route('payment.cancel'),
            'metadata' => [
                'student_id' => $student->id,
                'course_id' => $course->id,
            ]
        ]);
    }
}