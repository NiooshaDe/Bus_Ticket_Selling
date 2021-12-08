<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Payment;
use Barryvdh\DomPDF\Facade as PDf;
use App\Http\Traits\ProjectResponse;
use App\Http\Requests\CreatePdfRequest;
use Illuminate\Support\Facades\Storage;
use App\Repositories\TicketUserRepositories;

class GateWayController extends Controller
{
    use ProjectResponse;

    public function payment(Request $request, Invoice $invoice, Payment $payment)
    {
        $invoice->amount($request->total_price);
        $invoice->detail(['detail' => 'total price of tickets']);
        $transaction_id = $invoice->getTransactionId();

        return $payment->purchase($invoice, function ($driver, $transactionId) {

        })->pay()->render();

        try {
            $receipt = Payment::amount(1000)->transactionId($transaction_id)->verify();

            // you can show payment's referenceId to user
            echo $receipt->getReferenceId();

        } catch (InvalidPaymentException $exception) {
            /**
            when payment is not verified , it throw an exception.
            we can catch the excetion to handle invalid payments.
            getMessage method, returns a suitable message that can be used in user interface.
             **/
            echo $exception->getMessage();
        }
    }



    public function createPdf(CreatePdfRequest $data)
    {

        //declare the file path in storage file
        $file_path = 'public/csv/'. $data->ticket_user_id.'.pdf';

        // share data to view
        $pdf = PDF::loadView('ticketPdf', $data);
        $content = $pdf->download('invoice.pdf')->getOriginalContent();

        //store file with current file path
        Storage::put($file_path,$content);

        //returns the file path
        return $this->showData($file_path);

    }
}
