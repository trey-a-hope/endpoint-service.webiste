<?php 
    require_once($_SERVER['DOCUMENT_ROOT']."/assets/vendor/autoload.php");
    
    $apiKey = $_POST['apiKey'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $destination = $_POST['destination'];
    $source_type = $_POST['source_type'];
    $statement_descriptor = $_POST['statement_descriptor'];

    if(isset($apiKey)){
        try{
            //Set API Key.
            \Stripe\Stripe::setApiKey($apiKey);
        
            $params = array(
                'amount'                => $amount,                 // A positive integer in cents representing how much to payout.
                'currency'              => 'usd',                   // Three-letter ISO currency code, in lowercase.
                'description'           => $description,            // An arbitrary string attached to the object.
                'destination'           => $destination,            // The ID of a bank account or a card to send the payout to.
                'method'                => 'instant',               // The method used to send this payout, which can be standard or instant.
                'source_type'           => $source_type,            // The source balance to draw this payout from.
                'statement_descriptor'  => $statement_descriptor    // A string to be displayed on the recipient’s bank or card statement. This may be at most 22 characters. 
            );
    
            $charge = \Stripe\Payout::create($params);
    
            echo $charge->__toJSON(); 
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