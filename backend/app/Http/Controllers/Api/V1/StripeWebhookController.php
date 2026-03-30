<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EnrollmentService;
use App\Repositories\PaymentRepository;
use Stripe\Webhook;
use App\Services\GroupService;

class StripeWebhookController extends Controller
{
    protected $enrollmentService;
    protected $groupService;

    public function __construct(EnrollmentService $enrollmentService, GroupService $groupService)
    {
        $this->enrollmentService = $enrollmentService;
        $this->groupService = $groupService;
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
            // add student to group
            $this->groupService->addStudentToGroup($studentId, $courseId);
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

// 🟢 STEP 6: حماية إضافية (مهم بزاف)
// ✔ منع إعادة الدفع
// $enrollment = $student->enrollments()
//     ->where('course_id', $course->id)
//     ->first();

// if ($enrollment && $enrollment->payment_status === 'paid') {
//     return response()->json(['message' => 'Already enrolled'], 400);
// }