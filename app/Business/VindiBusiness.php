<?php

/**
 * @author Alberto Reyes <albertord84@gmail.com>
 * @name API Integration with Vindi
 * @version 1
 * @date 27/03/2020 4:00AM
 * @depends DB
 */

namespace App\Business;

use App\User;
use stdClass;

class VindiBusiness extends Business
{

    // const store_id = "1077629602";
    const store_id = "11858";
    const store_key_access = "k3LOEYQ0FOLwz1lgd3p4NTzbskdsBC4hVR2OK8kJipk"; // Chave criada para o Curos de Ingles
    // const store_key_access = "Bh9yqh34Ar_KjcjTXOUOoJRpExWwL_aoKi_doknv4SI";
    //    const store_api_uri = "https://sandbox-app.vindi.com.br/api/v1/"; // Sandbox
    const store_api_uri = "https://app.vindi.com.br/api/v1/"; // Production
    const store_address = "app.vindi.com.br/DW";
    const store_name = "DOUBLEWEISER SOLUCOES TECNOLOGICAS LTDA";
    const store_flag_names = "Visa, MasterCard, American Express, Aura, Diners, Discover, Elo, JCB, Visa Electron e Mastercard Débito";


    const gateway_plane_1real_id = "94980";
    const gateway_prod_1real_id = "576784";
    
    const gateway_plane_english_course_id = "153926";
    const gateway_prod_english_course_id = "576784";

    private $api_arguments;

    public function __construct()
    {
        parent::__construct();

        // Coloca a chave da Vindi (VINDI_API_KEY) na variável de ambiente do PHP.
        // putenv('VINDI_API_KEY=' . $this::store_key_access);
        // Coloca a chave da Vindi (VINDI_API_URI) na variável de ambiente do PHP.
        // putenv('VINDI_API_URI=' . $this::store_api_uri);

        $this->api_arguments = array(
            'VINDI_API_KEY' => $this::store_key_access,
            'VINDI_API_URI' => $this::store_api_uri,
        );
    }

    /**
     * Add new client to Vindi
     * @param type $name
     * @param type $email
     * @return Vindi client id or Exception whether fail
     */
    public function addClient($name, $email = null): stdClass
    {
        // Cria um novo cliente:
        $return = new \stdClass();
        $return->success = false;
        try {
            // Instancia o serviço de Customers (Clientes) com o array contendo VINDI_API_KEY e VINDI_API_URI
            $customerService = new \Vindi\Customer($this->api_arguments);
            $customer = $customerService->create([
                'name' => $name,
                'email' => $email,
            ]);
        } catch (\Throwable $e) {
            $return->message = $e->getMessage();
            return $return;
        }

        $return->success = true;
        $return->gateway_client_id = $customer->id;
        return $return;
    }

    /**
     * Add payment data to Client
     * @param type $Client app\User
     * @param type $payment_data
     * @return payment data or \Exception whether error
     */
    public function addClientPayment(User $Client, $payment_data): stdClass
    {
        $payment = null;
        $return = new \stdClass();
        $return->success = false;
        try {
            $payment_profilesService = new \Vindi\PaymentProfile($this->api_arguments);
            $payment = $payment_profilesService->create([
                "holder_name" => $payment_data['credit_card_name'],
                "card_expiration" => $payment_data['credit_card_exp_month'] . "/" . $payment_data['credit_card_exp_year'],
                "card_number" => $payment_data['credit_card_number'],
                "card_cvv" => $payment_data['credit_card_cvc'],
                "payment_method_code" => "credit_card",
                "customer_id" => $Client->gateway_client_id,
            ]);
        } catch (\Throwable $e) {
            $return->message = $e->getMessage();
            return $return;
        }

        $return->success = $payment->status == 'active';
        return $return;
    }

    /**
     * Add new Assigment for client
     * @param type $Client app\User
     * @param time $date
     * @param plane_id In update plane situation
     * @return \Exception recurrency payment or exception
     */
    public function create_recurrency_payment(User $Client, $date = null, $plane_id = null) : stdClass
    {
        $plane_id = $plane_id ?? $this::gateway_plane_english_course_id;

        // $plane_id = $plane_id ?? $this::gateway_plane_1real_id;

        // Cria nova assignatura:
        if (!$date) {
            $date = time();
        }

        $date = date("d/m/Y", $date);

        $return = new \stdClass();
        $return->success = false;
        try {
            // Instancia o serviço de Subscription (Assinaturas) com o array contendo VINDI_API_KEY e VINDI_API_URI
            $subscriptionService = new \Vindi\Subscription($this->api_arguments);
            $subscription = $subscriptionService->create([
                "start_at" => $date,
                "plan_id" => $plane_id,
                "customer_id" => $Client->gateway_client_id,
                "payment_method_code" => "credit_card",
            ]);
        } catch (\Exception $e) {
            $return->message = $e->getMessage();
            return $return;
        }

        $return->success = $subscription->status == 'active' || $subscription->status == 'future';
        $return->payment_key = isset($subscription) && isset($subscription->id) ? $subscription->id : null;
        $return->subscription = $subscription;
        return $return;
    }

    /**
     * Reschedule Assigment for client
     * @param type $Client app\User
     * @param timestamp $date
     * @return \Exception reschedule recurrency payment or exception
     */
    public function reschedule_recurrency_payment(User $Client, $date) : stdClass
    {
        // Cria nova assignatura:
        $return = new \stdClass();
        $return->success = false;
        try {
            // Instancia o serviço de Subscription (Assinaturas) com o array contendo VINDI_API_KEY e VINDI_API_URI
            $subscriptionService = new \Vindi\Subscription($this->api_arguments);
            $subscription = $subscriptionService->update($Client->payment_key, [
                "billing_trigger_day" => $date,
            ]);
        } catch (\Exception $e) {
            $return->message = $e->getMessage();
            return $return;
        }

        $return->success = $subscription->status == 'active' || $subscription->status == 'future';
        $return->payment_key = isset($subscription) && isset($subscription->id) ? $subscription->id : null;
        $return->subscription = $subscription;
        return $return;
    }

    /**
     * Delete recurrency payment status (Cancel subscription)
     * @param type $payment_key
     * @return Subscription or \Exception
     */
    public function cancel_recurrency_payment($payment_key) : stdClass
    {
        $return = new \stdClass();
        $return->success = false;
        try {
            // Instancia o serviço de Subscription (Assinaturas) com o array contendo VINDI_API_KEY e VINDI_API_URI
            $subsService = new \Vindi\Subscription($this->api_arguments);
            $subs = $subsService->delete($payment_key);
        } catch (\Exception $e) {
            $return->message = $e->getMessage();
            return $return;
        }
        $return->success = $subs->status == 'canceled' || $subs->status == 'expired';
        return $return;
    }

    /**
     * Check recurrency payment status
     * @param type $payment_key
     * @return Payment subscriptions or \Exception
     */
    public function query_recurrency_payment($payment_key) : stdClass
    {
        try {
            // Instancia o serviço de Subscription (Assinaturas) com o array contendo VINDI_API_KEY e VINDI_API_URI
            $subsService = new \Vindi\Subscription($this->api_arguments);
            $subs = $subsService->get($payment_key);
        } catch (\Exception $e) {
            return $e;
        }

        return $subs;
    }

    /**
     * Create a instantan payment
     * @param type $Client app\User
     * @param type $prod_id Products id
     * @param type $amount Amount of Products to by payed
     * @return \Exception recurrency payment or exception
     */
    public function create_payment(User $Client, $prod_id = null, $amount = 1) : stdClass
    {
        $prod_id = $prod_id ?? $this::gateway_prod_english_course_id;

        // Cria pagamento abulso:
        $return = new \stdClass();
        $return->success = false;
        try {
            // Instancia o serviço de Bill (Fatura) com o array contendo VINDI_API_KEY e VINDI_API_URI
            $billService = new \Vindi\Bill($this->api_arguments);
            $bill = $billService->create([
                "plan_id" => $this::gateway_plane_english_course_id,
                "customer_id" => $Client->gateway_client_id,
                "payment_method_code" => "credit_card",
                "bill_items" => [
                    [
                        "product_id" => $prod_id,
                        "amount" => $amount,
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            $return->message = $e->getMessage();
            return $return;
        }

        $return->success = true;
        $return->status = $bill->status ?? null;
        $return->payment_key = $bill->id ?? null;
        // $return->payment_key = isset($bill) && isset($bill->id) ? $bill->id : null;  // PHP 5.4
        return $return;
    }

    /**
     * Check payment status
     * @param type $payment_key
     * @return Payment or \Exception
     */
    public function query_payment($payment_key) : stdClass
    {
        $return = new \stdClass();
        $return->success = false;
        try {
            // Instancia o serviço de Bill (Fatura) com o array contendo VINDI_API_KEY e VINDI_API_URI
            $billService = new \Vindi\Bill($this->api_arguments);
            $bill = $billService->get($payment_key);
        } catch (\Exception $e) {
            $return->message = $e->getMessage();
            return $return;
        }

        $return->bill = $bill;
        $return->status = $bill->status;

        return $return;
    }

    public static function detectCardType($num) : string
    {
        $re = array(
            "visa" => "/^4[0-9]{12}(?:[0-9]{3})?$/",
            "mastercard" => "/^5[1-5][0-9]{14}$/",
            "amex" => "/^3[47][0-9]{13}$/",
            "discover" => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
            "diners" => "/^3[068]\d{12}$/",
            "elo" => "/^((((636368)|(438935)|(504175)|(451416)|(636297))\d{0,10})|((5067)|(4576)|(4011))\d{0,12})$/",
            "hipercard" => "/^(606282\d{10}(\d{3})?)|(3841\d{15})$/",
        );

        if (preg_match($re['visa'], $num)) {
            return 'Visa';
        } else if (preg_match($re['mastercard'], $num)) {
            return 'Mastercard';
        } else if (preg_match($re['amex'], $num)) {
            return 'Amex';
        } else if (preg_match($re['discover'], $num)) {
            return 'Discover';
        } else if (preg_match($re['diners'], $num)) {
            return 'Diners';
        } else if (preg_match($re['elo'], $num)) {
            return 'Elo';
        } else if (preg_match($re['hipercard'], $num)) {
            return 'Hipercard';
        } else {
            return false;
        }
    }

}
