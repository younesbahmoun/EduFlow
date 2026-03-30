<?php
// app/Services/StripeService.php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
    public function __construct()
    {
        // Set the API key once hna, machi f kol method
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Step 1: Créer une session Stripe pour un cours
     * Student ydir redirect l URL li traja3 lih
     */
    public function createSession(User $user, Course $course): Session
    {
        return Session::create([

            'payment_method_types' => ['card'],

            // Chno katbay Stripe f checkout page
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'mad',
                    'unit_amount'  => $course->price, // ex: 15000 = 150 MAD
                    'product_data' => [
                        'name'        => $course->title,
                        'description' => $course->description,
                    ],
                ],
                'quantity' => 1,
            ]],

            'mode' => 'payment',

            // Stripe katredirect l had URLs men ba3d payment
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('payment.cancel'),

            // had metadata ghadi nستعملوها f webhook bach n3arfo
            // ach enrollment ncréériw
            'metadata' => [
                'user_id'   => $user->id,
                'course_id' => $course->id,
            ],
        ]);
    }

    /**
     * Step 2: Webhook jat → ncréériw enrollment
     * Had method katcall men WebhookController
     */
    public function handleSuccess(object $session): void
    {
        $userId   = $session->metadata->user_id;
        $courseId = $session->metadata->course_id;

        // Créer enrollment seulement après payment réussi
        Enrollment::updateOrCreate(
            // conditions: fin katfetch
            ['user_id' => $userId, 'course_id' => $courseId],
            // data: chno katupdate/create
            [
                'stripe_session_id' => $session->id,
                'payment_status'    => 'paid',
            ]
        );
    }

    /**
     * Student cancel payment → nmarkiw enrollment failed
     * (ila kan existant)
     */
    public function handleFailed(object $session): void
    {
        $userId   = $session->metadata->user_id;
        $courseId = $session->metadata->course_id;

        Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->update(['payment_status' => 'failed']);
    }
}