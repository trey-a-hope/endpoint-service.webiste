<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/assets/vendor/autoload.php');

    $data = (array) json_decode(file_get_contents('php://input'), TRUE);

    try{
        //Set API Key.
        \Stripe\Stripe::setApiKey($data['apiKey']);

        //Create payout.
        $payout = \Stripe\Payout::create(
            array(
              "amount" => $data['amount'],
              "currency" => "usd",
              "method" => "instant"
            ),
            array("stripe_account" => $data['stripe_account'])
          );

        echo $payout->__toJSON(); 
    }catch(\Stripe\Error\Card $e) {
      echo $e->getMessage();
    } catch (\Stripe\Error\RateLimit $e) {
      // Too many requests made to the API too quickly
      echo $e->getMessage();
    } catch (\Stripe\Error\InvalidRequest $e) {
      // Invalid parameters were supplied to Stripe's API
      echo $e->getMessage();
    } catch (\Stripe\Error\Authentication $e) {
      // Authentication with Stripe's API failed
      echo $e->getMessage();
    } catch (\Stripe\Error\ApiConnection $e) {
      // Network communication with Stripe failed
      echo $e->getMessage();
    } catch (\Stripe\Error\Base $e) {
      echo $e->getMessage();
    } catch (Exception $e) {
      // Something else happened, completely unrelated to Stripe
      echo $e->getMessage();
    }  
?>