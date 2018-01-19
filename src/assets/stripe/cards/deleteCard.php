<?php 
    require_once(dirname(__FILE__) . '../../vendor/autoload.php');
    
    $apiKey = $_POST["apiKey"];
    
    if(isset($apiKey)){
        try{
            //Set API Key.
            \Stripe\Stripe::setApiKey($apiKey);
            
            //Retrieve customer.
            $customer = \Stripe\Customer::retrieve($_POST["customerId"]);

            //Remove card.
            $customer->sources->retrieve($_POST["cardId"])->delete();

            //Print json object.
            echo $customer->__toJSON();
        }catch(\Stripe\Error\Card $e) {
            echo $e->__toJSON();
        }catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            echo $e->__toJSON();
        }catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            echo $e->__toJSON();
        }catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            echo $e->__toJSON();
        }catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            echo $e->__toJSON();
        }catch (\Stripe\Error\Base $e) {
            echo $e->__toJSON();
        }catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            echo $e->__toJSON();
        }           
    }else{
        echo "Api key not set, cannot access. Goodbye.";
    }
?>