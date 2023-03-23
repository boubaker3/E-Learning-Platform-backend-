<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use JWTAuth;
use App\Models\PurshasesModel;
use App\Models\CoursesModel;

class PurshasesController extends Controller
{

    function createPurshaseId(){
        $userid="";
        
        for($i=0;$i<=rand(5,20);$i++){
            $userid.=rand(0,9);
        }
        return $userid;
    }


    public function purshase(Request $request){

        $clientId = env("PAYPAL_CLIENT_KEY");
        $clientSecret = env("PAYPAL_SECRET_KEY");
        $apiContext = new ApiContext(new OAuthTokenCredential($clientId, $clientSecret));


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
    
        $amount = new Amount();
        $amount->setCurrency('USD');
        $amount->setTotal($request->input('amount'));
    
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Course purchase');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("http://127.0.0.1:5173/validatePayment?userid={$request->userid}&courseid={$request->courseid}&price={$amount->getTotal()}")
            ->setCancelUrl('http://127.0.0.1:5173/cancelPayment');
    
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);
    
        try {
            // Create payment and get approval URL
            $createdPayment = $payment->create($apiContext);
            $approvalUrl = $createdPayment->getApprovalLink();
            return response()->json(['approvalUrl' => $approvalUrl]);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
    function validatePayment(Request $request){
        $purshase=new PurshasesModel();
        $clientId = env("PAYPAL_CLIENT_KEY");
        $clientSecret = env("PAYPAL_SECRET_KEY");
        $apiContext = new ApiContext(new OAuthTokenCredential($clientId, $clientSecret));
        // Get payment details and execute payment
        $payment = Payment::get($request->paymentid, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->payerid);
        try {
            $result = $payment->execute($execution, $apiContext);
            if ($result->getState() === 'approved') {
                 $purshase->insert(["purshaseid"=>$this->createPurshaseId(),
                                    "userid"=>$request->userid,
                                    "courseid"=>$request->courseid,
                                    "amount"=>$request->amount,
                                    "paymentid"=>$request->paymentid,
                                    "payerid"=>$request->payerid]);
            $courses=new CoursesModel();
                $course=$courses->where("courseid",$request->courseid)->first();
                return response()->json(['message' => 'Payment successful','course'=>$course]);
            } else {
                // Payment failed, handle the error
                return response()->json(['error' => 'Payment failed']);
            }
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
}
