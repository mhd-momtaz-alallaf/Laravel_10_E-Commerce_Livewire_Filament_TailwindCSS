<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

#[Title('Success | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class SuccessPage extends Component
{
    // getting the session_id from the url parameter.
    #[Url]
    public $session_id; 

    public function render()
    {
        // getting the latest order of the current user.
        $user_latest_order = Order::with('address')->where('user_id', auth()->user()->id)->latest()->first();

        // checking if there any session_id parameter in the url, to change the $user_latest_order payment status to 'paid' if the payment is successfully completed.
        if($this->session_id){
            // connecting to stripe by the api secret key
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // getting the information of the passed session_id from the stripe servers.
            $session_info = Session::retrieve($this->session_id);

            // checking if the payment is successfully paid
            if($session_info->payment_status == 'paid'){
                // so changing the user latest order status to 'paid'
                $user_latest_order->payment_status = 'paid';
                $user_latest_order->save();
                
            } else {
                $user_latest_order->payment_status = 'failed';
                $user_latest_order->save();
                
                return redirect()->route('cancel');
            }
        }

        return view('livewire.success-page',[
            'order' => $user_latest_order,
        ]);
    }
}
