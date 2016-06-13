<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HelpController extends Controller
{
    protected $secret = '4wlJ1VPwKlZgSJH8pgLtTx3yncWEKl8s';
    public function BuildResNumber($name,$email,$price,$category)
    {
        $resnumber = hash_hmac('sha256',str_random(40),$this->secret);
        ($this->ResNumberExist($resnumber)) ? $resnumber = $this->BuildNewResNumber() : '';
        Payment::create([
            'resnumber'=>$resnumber,
            'price'=>$price,
            'name'=>$name,
            'email'=>$email,
            'category'=>$category
        ]);
        return $resnumber;
    }
    protected function ResNumberExist($resnumber)
    {
        return (count(Payment::where('resnumber',$resnumber)->first()) == 1)? true : false;
    }
    protected function BuildNewResNumber()
    {
        return hash_hmac('sha256',str_random(40),$this->secret);

    }
}
