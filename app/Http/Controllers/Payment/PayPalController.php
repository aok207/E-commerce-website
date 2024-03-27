<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function processTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.successTransaction'),
                "cancel_url" => route('paypal.cancelTransaction'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "$request->total_amount"
                    ],
                    "reference_id" => $request->order_id
                ]
            ]
        ]);

        // dd($response);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('orders.show', ["id" => $request->order_id]);
        }
    }

    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $order_id = $response['purchase_units'][0]['reference_id'];

            $payment = Payment::where('order_id', $order_id)->first();

            if ($payment) {

                $payment->update([
                    'payment_status' => 'paid'
                ]);
            }

            // Update the sales count
            $order_items = OrderItem::where('order_id', $order_id)->get();

            foreach ($order_items as $item) {
                $product = $item->product;

                if ($product) {
                    $product->update([
                        'sales_count' => $product->sales_count += $item->quantity
                    ]);
                }
            }

            return redirect()->route('orders.show', ["id" => $order_id])->with('success', 'Payment success.');
        } else {
            return redirect()->route('orders.index')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    public function cancelTransaction()
    {
        return redirect()->route('orders.index')->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
}
