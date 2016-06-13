<?php

namespace App\Http\Controllers;

use App\Category;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class DonateController extends HelpController
{
    protected $MerchantID = '111111';
    protected $Password = '*****';
    public function index()
    {
        $cat = Category::lists('title','id');
        return view('donate',compact('cat'))->with('title','همین الان دونیت کن');
    }
    public function payment(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            'price'=>'required|numeric',
            'category'=>'required'
        ]);
        $name = $request->input('name');
        $email = $request->input('email');
        $price = $request->input('price');
        $category = $request->input('category');

        $resnumber = $this->BuildResNumber($name,$email,$price,$category);

        $MerchantID = $this->MerchantID;

        $Password = $this->Password ;

        $ReturnPath = 'http://localhost/donate/check';

        $Description = $category;

        $client = new \SoapClient('http://merchant.parspal.com/WebService.asmx?wsdl');

        $res = $client->RequestPayment(array("MerchantID" => $MerchantID , "Password" =>$Password , "Price" =>$price, "ReturnPath" =>$ReturnPath, "ResNumber" =>$resnumber, "Description" =>$Description, "Paymenter" =>$name, "Email" =>$email));

        $PayPath = $res->RequestPaymentResult->PaymentPath;
        $Status = $res->RequestPaymentResult->ResultStatus;

        if($Status == 'Succeed')
        {

            echo "<html><head><title>Connecting ....</title><head><body onload=\"javascript:window.location='$PayPath'\" style=\"font-family:tahoma; text-align:center;font-waight:bold;direction:rtl\">درحال اتصال به درگاه پرداخت پارس پال ...</body></html>";
        }
        else
        {
            echo $Status;
        }


    }
    public function check(request $request)
    {
        $MerchantID = $this->MerchantID;
        $Password = $this->Password ;


        $Status = $request['status'];

        if(isset($Status) && $Status == 100){

            $Refnumber = $request->input('refnumber');

            $Resnumber = $request->input('resnumber');
//Your Order ID
            $payment = Payment::where('resnumber',$Refnumber)->first();

            $client = new \SoapClient('http://merchant.parspal.com/WebService.asmx?wsdl');

            $res = $client->VerifyPayment(array("MerchantID" => $MerchantID , "Password" =>$Password , "Price" =>$payment->price,"RefNum" =>$Refnumber ));




            $Status = $res->verifyPaymentResult->ResultStatus;
            $PayPrice = $res->verifyPaymentResult->PayementedPrice;
            if($Status == 'success')// Your Peyment Code Only This Event
            {
                if($this->restatusPayment($payment->id))
                {
                    $email = $payment->email;
                    $name = $payment->name;
                    $price = $payment->price;
                    $this->MailSendTo($email,'email','دونیت شما در امید نیک راه',['refNumber'=>$Refnumber , 'Email'=>$email , 'Price'=>$price  ]);
                    return view('finally',compact('name'))->with('title','نتیجه دونیت');
                }
                else
                {
                    return 'قبلا پول رو ریختی اوکی شده فکر کنم!!';
                }
            }else{
                echo '<div style="color:green; font-family:tahoma; direction:rtl; text-align:right">
			خطا در پردازش عملیات پرداخت ، نتیجه پرداخت : '.$Status.' !
			<br /></div>';
            }
        }
        else
        {
            echo '<div style="color:red; font-family:tahoma; direction:rtl; text-align:right">
		بازگشت از عمليات پرداخت، خطا در انجام عملیات پرداخت ( پرداخت ناموق ) !
		<br /></div>';
        };
    }
    public function restatusPayment($id)
    {
        $payment = Payment::find($id);
        if($payment->status == false)
        {
            $payment->update([
                'status'=>true,
            ]);
            return true;
        }
        else{
            return false;
        }
    }
    public function MailSendTo($email,$view,$subject,$data = [])
    {
        Mail::send($view,$data, function($massage) use($email , $subject){
            $massage->To($email)->subject($subject);

        });
    }
    public function see(Request $request)
    {
        if ($request->has('email')) {
            $SearchTerm = $request->input('email');
            $donates = Payment::where('email',$SearchTerm)->get();
            return view('see',compact('donates'))->with('title','ببین چقدر دونیت کردی');
        }
        return view('see')->with('title','ببین چقدر دونیت کردی');
    }

}
