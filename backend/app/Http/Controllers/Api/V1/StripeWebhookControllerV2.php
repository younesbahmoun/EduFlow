<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\EnrollmentService;
use App\Repositories\PaymentRepository;

use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // التعامل مع الأحداث
        switch ($event->type) {

            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;

                // مثال: تحديث الطلب
                // Order::where('payment_id', $paymentIntent->id)->update(['status' => 'paid']);

                break;

            case 'payment_intent.payment_failed':
                // التعامل مع الفشل
                break;
        }

        return response()->json(['status' => 'success']);
    }
}