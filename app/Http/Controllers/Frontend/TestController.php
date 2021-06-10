<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Shippo_Address;
use Shippo_Shipment;
use Shippo_Transaction;

use LaravelShipStation\ShipStation;
use GuzzleHttp\Guzzle;


class TestController extends Controller
{

	public function shippo()
  {
     
  	/*$key = '8419c9ced0924c54869bc944c75b181a';
  	$secret = '94415145b8984d4894a114be8cc0b735';*/
  	/*$key = 'ff25e42ccb8c46838dd811df7b47e75b';
  	$secret = 'a3db9cbc852d469b90b43588d76b07da';*/
    $key = '329f6809949d4b1587448a8d5f07d9df';
    $secret = '7e5e8ec5817d482c912ce62f887eebc3';
  	$api_url = 'https://ssapi.shipstation.com';
  	$shipStation = new ShipStation($key, $secret, $api_url);

		/*$stores = $shipStation->stores->get([]);
		print_r($stores); die;*/

		/*$address = new \LaravelShipStation\Models\Address();
    $address->name = "Joe Campo";
    $address->street1 = "123 Main St";
    $address->city = "Cleveland";
    $address->state = "OH";
    $address->postalCode = "44127";
    $address->country = "US";
    $address->phone = "2165555555";

    $item = new \LaravelShipStation\Models\OrderItem();
    $item->lineItemKey = '1';
    $item->sku = '580123456';
    $item->name = "Awesome sweater.";
    $item->quantity = '1';
    $item->unitPrice  = '29.99';
    $item->warehouseLocation = 'Warehouse A';

    $order = new \LaravelShipStation\Models\Order();
    $order->orderNumber = '1';
    $order->orderDate = '2016-05-09';
    $order->orderStatus = 'awaiting_shipment';
    $order->amountPaid = '29.99';
    $order->taxAmount = '0.00';
    $order->shippingAmount = '0.00';
    $order->internalNotes = 'A note about my order.';
    $order->billTo = $address;
    $order->shipTo = $address;
    $order->items[] = $item;

    var_dump($shipStation->orders->post($order, 'createorder'));*/

    
    $shipment = new \LaravelShipStation\Helpers\Shipments($shipStation);
    //$shipment->orderId = '123456';
    /*$shipment->carrierCode = 'fedex';
    $shipment->serviceCode = 'fedex_ground';*/
    $shipment->carrierCode = 'ups';
    $shipment->serviceCode = 'ups_ground';
    $shipment->packageCode = 'package';
    $shipment->confirmation = 'delivery';
    $shipment->shipDate = '2021-02-02';
    $weight = new \LaravelShipStation\Models\Weight();
    $weight->value = 3;
    $weight->units = 'ounces';
    $shipment->weight = $weight;
    $dimensions = new \LaravelShipStation\Models\Dimensions();
    $dimensions->units = '';
    $dimensions->length = 7;
    $dimensions->width = 5;
    $dimensions->height = 6;
    $shipment->dimensions = $dimensions;
    $address = new \LaravelShipStation\Models\Address();
    $address->name = "Joe Campo";
    $address->street1 = "123 Main St";
    $address->city = "Cleveland";
    $address->state = "OH";
    $address->postalCode = "44127";
    $address->country = "US";
    $address->phone = "2165555555";
    $shipment->shipFrom = $address;
    $address = new \LaravelShipStation\Models\Address();
    $address->name = "Joe Campo";
    $address->street1 = "456 Main St";
    $address->city = "Cleveland";
    $address->state = "OH";
    $address->postalCode = "44127";
    $address->country = "US";
    $address->phone = "2165555556";
    $shipment->shipTo = $address;
    $shipment->testLabel = true;

    var_dump($shipStation->shipments->post($shipment, 'createlabel'));

		die;














  	 \Shippo::setApiKey(env('SHIPPO_API_KEY'));
      // Example from_address array
      // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
      $from_address = array(
          'name' => 'Mr Hippo',
          'company' => 'Shippo',
          'street1' => '215 Clayton St.',
          'city' => 'San Francisco',
          'state' => 'CA',
          'zip' => '94117',
          'country' => 'US',
          'phone' => '+1 555 341 9393',
          'email' => 'mr-hippo@goshipppo.com',
      );

      // Example to_address array
      // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
      $to_address = array(
          'name' => 'Ms Hippo',
          'company' => 'San Diego Zoo',
          'street1' => '2920 Zoo Drive',
          'city' => 'San Diego',
          'state' => 'CA',
          'zip' => '92101',
          'country' => 'US',
          'phone' => '+1 555 341 9393',
          'email' => 'ms-hippo@goshipppo.com',
      );

      // Parcel information array
      // The complete reference for parcel object is here: https://goshippo.com/docs/reference#parcels
      $parcel = array(
          'length'=> '5',
          'width'=> '5',
          'height'=> '5',
          'distance_unit'=> 'in',
          'weight'=> '2',
          'mass_unit'=> 'lb',
      );

      // Example shipment object
      // For complete reference to the shipment object: https://goshippo.com/docs/reference#shipments
      // This object has async=false, indicating that the function will wait until all rates are generated before it returns.
      // By default, Shippo handles responses asynchronously. However this will be depreciated soon. Learn more: https://goshippo.com/docs/async
      $shipment = Shippo_Shipment::create(
      array(
          'address_from'=> $from_address,
          'address_to'=> $to_address,
          'parcels'=> array($parcel),
          'async'=> false,
      ));

      // Rates are stored in the `rates` array
      // The details on the returned object are here: https://goshippo.com/docs/reference#rates
      // Get the first rate in the rates results for demo purposes.
      $rate = $shipment['rates'][0];

      // Purchase the desired rate with a transaction request
      // Set async=false, indicating that the function will wait until the carrier returns a shipping label before it returns
      $transaction = Shippo_Transaction::create(array(
          'rate'=> $rate['object_id'],
          'async'=> false,
      ));

      // Print the shipping label from label_url
      // Get the tracking number from tracking_number
      if ($transaction['status'] == 'SUCCESS'){
          echo "--> " . "Shipping label url: " . $transaction['label_url'] . "\n";
          echo "--> " . "Shipping tracking number: " . $transaction['tracking_number'] . "\n";
      } else {
          echo "Transaction failed with messages:" . "\n";
          foreach ($transaction['messages'] as $message) {
              echo "--> " . $message . "\n";
          }
      }
              
      var_dump($address);

  }

}