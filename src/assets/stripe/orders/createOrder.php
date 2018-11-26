<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/assets/vendor/autoload.php');

    $data = (array) json_decode(file_get_contents('php://input'), TRUE);

    try{
        //Set API Key.
        \Stripe\Stripe::setApiKey($data['apiKey']);

        //Create order
        $order = \Stripe\Order::create(array(
            'customer' => $data['customerId'],
            'items' => $data['items'],
            'currency' => 'usd',
            'shipping' => $data['shipping'],
            'email' => $data['email'],
            'metadata' => $data['metadata'],
            'coupon' => $data['coupon']
        ));

        echo $order->__toJSON();
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
?>