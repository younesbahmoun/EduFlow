<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EnrollmentService;
use App\Repositories\PaymentRepository;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    protected $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    public function handle(Request $request)
    {
        $event = json_decode($request->getContent());

        if ($event->type === 'checkout.session.completed') {

            $paymentIntent = $event->data->object;

            $studentId = $paymentIntent->metadata->student_id;
            $courseId = $paymentIntent->metadata->course_id;

            // update status → paid
            $this->enrollmentService->markAsPaid($studentId, $courseId);
        }

        // $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        // $payload = $request->getContent();
        // $sig_header = $request->header('Stripe-Signature');

        // try {
        //     $event = Webhook::constructEvent(
        //         $payload,
        //         $sig_header,
        //         $endpoint_secret
        //     );
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Invalid signature'], 400);
        // }

        // switch ($event->type) {

        //     case 'payment_intent.succeeded':
        //         $paymentIntent = $event->data->object;

        //         $studentId = $paymentIntent->metadata->student_id;
        //         $courseId = $paymentIntent->metadata->course_id;

        //         // update status => paid
        //         $this->enrollmentService->markAsPaid($studentId, $courseId);
        //         break;

        //     case 'payment_intent.payment_failed':
        //         // handle payment failed
        //         break;
        // }

        // return response()->json(['status' => 'success']);
    }
}
