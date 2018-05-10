<?php 
    require_once($_SERVER['DOCUMENT_ROOT']."/assets/vendor/autoload.php");

    //Required parameters.
    $apiKey = $_POST['apiKey'];
    $customerId = $_POST['customerId'];
    
    if(isset($apiKey)){
        try{
            //Set API Key.
            \Stripe\Stripe::setApiKey($apiKey);
            
            //Retrieve customer.
            $customer = \Stripe\Customer::retrieve($customerId);

            //Update customer description
            if(!empty($_POST['description'])){
              $customer->description = $_POST['description'];
            }

            //Update customer source.
            if(!empty($_POST['token'])){
              $customer->source = $_POST['token'];
            }

            //Update customer shipping information.
            if(!empty($_POST['shipping'])){
              $customer->shipping = $_POST['shipping'];
            }

            //Save customer.
            $customer->save();

            echo $customer->__toJSON();
          }catch(\Stripe\Error\Card $e) {
            echo $e->__toJSON();
          } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            echo $e->__toJSON();
          } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            echo $e->__toJSON();
          } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            echo $e->__toJSON();
          } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            echo $e->__toJSON();
          } catch (\Stripe\Error\Base $e) {
            echo $e->__toJSON();
          } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            echo $e->__toJSON();
          }         
    }else{
        echo "Api key not set, cannot access. Goodbye.";
    }
?>