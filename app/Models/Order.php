<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\OrderDetail;
use App\Models\Products\Product;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\PaymentHistory;
use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Restaurant\Restaurant;

use DB;

class Order extends Model
{

    protected $fillable = [
        'user_id',
        'product_id',
    		'country_id',
    		'state_id',
    		'city_id',
    		'order_id',
    		'first_name',
    		'last_name',
    		'email',
    		'phone',
    		'street_address',
    		'alternative_address',
    		'zip_code',
    		'payment_type',
        'order_date',
        'ups_service_code',
    		'status',
    		'is_gift',
        'gift_message',
        'gift_message_name'
    ];
	
	public function setFirstNameAttribute(string $value)
    {
        return $this->attributes['first_name'] =  ucfirst($value);
    }
	
	public function setLastNameAttribute(string $value)
    {
        return $this->attributes['last_name'] =  ucfirst($value);
    }

    /**
     * @return mixed
     */


  //   public function orderDetails()
  //   {
		// return $this->hasOne(OrderDetail::class);
  //   }

    public function orderDetails()
    {
    return $this->hasMany(OrderDetail::class, 'order_id')->with('product','ratingData');
    }
	
	 /*public function PaymentHistory()
    {
    return $this->hasMany(PaymentHistory::class, 'order_id');
	
    }*/

      public function orderDetailsRating()
    {
    return $this->hasMany(OrderDetail::class, 'order_id');
    }
	 
	public function product()
    {
		return $this->belongsTo(Product::class, 'product_id')
          ->with('singleProductImage');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id')->with('restaurant');
    }

	public function productId()
	{
		return $this->product_id;
	}

	public function countryId()
	{
		return isset($this->country_id) ? $this->country_id : '';
	}

	public function stateId()
	{
		return isset($this->state_id) ? $this->state_id : '';
	}

	public function cityId()
	{
		return isset($this->city_id) ? $this->city_id : '';
	}

	public function orderId()
	{
		return isset($this->order_id) ? $this->order_id : '';
	}

	public function firstName()
	{
		return isset($this->first_name) ? $this->first_name : '';
	}

	public function lastName()
	{
		return isset($this->last_name) ? $this->last_name : '';
	}

	public function email()
	{
		return isset($this->email) ? $this->email : '';
	}

	public function phone()
	{
		return isset($this->phone) ? $this->phone : '';
	}

	public function streetAddress()
	{
		return isset($this->street_address) ? $this->street_address : '';
	}

	public function alternativeAddress()
	{
		return isset($this->alternative_address) ? $this->alternative_address : '';
	}

	public function zipCode()
	{
		return isset($this->zip_code) ? $this->zip_code : '';
	}

	public function paymentType()
	{
		return isset($this->payment_type) ? ucfirst(strtolower(str_replace('_',' ',$this->payment_type))) : '';
	}

	public function status()
	{
		return isset($this->status) ? $this->status : '';
	}

	public function isGift()
	{
		return isset($this->is_gift) ? $this->is_gift : '';
	}

	public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('d-M-Y H:i A');
    }
	
	public function fullName()
	{
		return $this->firstName() .' '. $this->lastName();
	}
	
	/**
     * @return BelongsTo
     */
    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return BelongsTo
     */
    public function state() : BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return BelongsTo
     */
    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }
	
	public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
    public function sellerProductId()
    {
      return $this->belongsTo(Product::class, 'product_id');
    }
      public function payment()
    {
      return $this->belongsTo(PaymentHistory::class, 'order_id','order_id');
    }

    
    public static function generate_shipping_label_dummy($params) {
    	$order_id = $params['order_id'];
    	$order = DB::table('orders')->where('id', $order_id)->first();
		$restaurant = DB::table('restaurants')->where('user_id', $order->vendor_id)->first();
		$restaurant_location = DB::table('restaurant_locations')->where('user_id', $order->vendor_id)->first();
    	//$restaurant_city = DB::table('cities')->where('name', $restaurant_location->city)->first();
        $restaurant_city = DB::table('cities')->select('cities.*')->leftJoin('states', 'states.id', 'cities.state_id')->where('cities.name', $restaurant_location->city)->where('states.name', $restaurant_location->state)->first();
    	$street_address = $order->street_address;
        $first_name = $order->first_name;
        $last_name = $order->last_name;
        $phone = $order->phone;
        $email = $order->email;
        $zip_code = $order->zip_code;
        $city = $order->city;
        $state_code = DB::table('states')->where('id', $order->state_id)->pluck('state_code')->first();

        $accesskey = env('UPS_API_KEY');
        $userid = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');

        $shipping = new \Ups\Shipping($accesskey, $userid, $password, true);
        //$residential_address = "Jforward Inc, Menya Jiro 306 gold street, Suite c2, BROOKLYN, NY 11201 US";
        try {
            $shipment = new \Ups\Entity\Shipment();
			
			$shipper = $shipment->getShipper();
            $shipper->setShipperNumber("R673Y5");
            //$shipper->setShipperNumber("W007R5");
            $shipper->setName($restaurant->name);
            $shipperAddress = $shipment->getShipper()->getAddress();
            $shipperAddress->setPostalCode($restaurant_location->zip_code);
            $shipperAddress->setAddressLine1($restaurant_location->location);
            //$shipperAddress->setAddressLine2('BUSINESS ADDRESS 2');
            $shipperAddress->setCity($restaurant_location->city);
            $shipperAddress->setStateProvinceCode($restaurant_city->state_code);
			
            $address = new \Ups\Entity\Address();
            $address->setPostalCode('11201');
            $address->setAddressLine1('306 Gold Street');
            //$address->setAddressLine2('BUSINESS ADD 2');
            $address->setCity('Brooklyn');
            $address->setStateProvinceCode('NY');
            $shipFrom = new \Ups\Entity\ShipFrom();
            $shipFrom->setAddress($address);
            $shipFrom->setCompanyName('Umami Square');
            $shipment->setShipFrom($shipFrom);
            $ship = $shipment->getShipFrom();
            $ship->CompanyName = 'Umami Square';

            $shipTo = $shipment->getShipTo();
            $shipTo->setAttentionName($first_name . ' ' . $last_name);
            $shipTo->setReceivingAddressName($first_name . ' ' . $last_name);
            $shipTo->setPhoneNumber($phone);
            $shipTo->setEmailAddress($email);
            $shipTo->setCompanyName($first_name . ' ' . $last_name);
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($zip_code);
            $shipToAddress->setAddressLine1($street_address);
            //$shipToAddress->setAddressLine2('ADDRESS 2');
            $shipToAddress->setCity($city);
            $shipToAddress->setStateProvinceCode($state_code);
            //$shipToAddress->setCountryCode('US');
            //residenial address indicator will increase the shipping rate
            $shipToAddress->setResidentialAddressIndicator('TRUE');
            $shipment->setShipTo($shipTo);
            //Add package
            $package = new \Ups\Entity\Package();
            $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
            $package->getPackageWeight()->setWeight(2);

            $dimensions = new \Ups\Entity\Dimensions();
            $dimensions->setHeight(8);
            $dimensions->setWidth(8);
            $dimensions->setLength(8);

            $unit = new \Ups\Entity\UnitOfMeasurement;
            $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

            $dimensions->setUnitOfMeasurement($unit);
            $package->setDimensions($dimensions);
            $shipment->addPackage($package);

            $billshipper = new \Ups\Entity\BillShipper();
            $billshipper->setAccountNumber("R673Y5");
            //$billshipper->setAccountNumber("W007R5");
            $prepaid = new \Ups\Entity\Prepaid(); 
            $prepaid->setBillShipper($billshipper);
            $paymentInformation = new \Ups\Entity\PaymentInformation;
            $paymentInformation->setPrepaid($prepaid);
            $shipment->setPaymentInformation($paymentInformation);
            //This will create UPS shipment
            $result = $shipping->confirm(\Ups\Shipping::REQ_VALIDATE, $shipment);

            $shipment_charges = $result->ShipmentCharges->TotalCharges->MonetaryValue;
            $shipment_weight = $result->BillingWeight->Weight." ".$result->BillingWeight->UnitOfMeasurement->Code;
            $tracking_number = $result->ShipmentIdentificationNumber;
            $shipment_digest = $result->ShipmentDigest;
            $accept = $shipping->accept($shipment_digest);
            $tracking_number = $accept->PackageResults->TrackingNumber;
            $imageformat = $accept->PackageResults->LabelImage->LabelImageFormat->Code;
            $base64image = $accept->PackageResults->LabelImage->GraphicImage;
            $image = base64_decode($base64image);
			//echo '<img src="data:image/png;base64,' . $base64image . '" />';
        } catch (\Ups\Exception\InvalidResponseException $e) {
            $error = $e->getMessage();
        }
    }

    public static function generate_shipping_label($params) {
    	$order_id = $params['order_id'];
        $service_code = $params['service_code'] ?? '';
        $sandbox = $params['sandbox'] ?? false;
        $test_only = $params['test_only'] ?? false;
        $param_data = $params['param_data'] ?? false;
        $param_first_name = $params['first_name'] ?? '';
        $param_last_name = $params['last_name'] ?? '';
        $param_email = $params['email'] ?? '';
        $param_phone = $params['phone'] ?? '';
        $param_street_address = $params['street_address'] ?? '';
        $param_address_line_2 = $params['address_line_2'] ?? '';
        $param_alternative_address = $params['alternative_address'] ?? '';
        $param_zip_code = $params['zip_code'] ?? '';
        $param_country_id = $params['country_id'] ?? '';
        $param_state_id = $params['state_id'] ?? '';
        $param_city = $params['city'] ?? '';
        $param_vendor_id = $params['vendor_id'] ?? '';

    	//$order = DB::table('orders')->where('order_id', '!=', null)->where('tracking_id', null)->whereIn('status', ['PENDING', 'PACKED'])->where('id', $order_id)->first();
        if($order_id != '')
            $order = DB::table('orders')->where('id', $order_id)->first();
        else
            $order = new \stdClass;

        if($param_data) {
            $order->street_address = $param_street_address;
            $order->address_line_2 = $param_address_line_2;
            $order->first_name = $param_first_name;
            $order->last_name = $param_last_name;
            $order->phone = $param_phone;
            $order->email = $param_email;
            $order->city = $param_city;
            $order->zip_code = $param_zip_code;
            $order->state_id = $param_state_id;
            $order->vendor_id = $param_vendor_id;
        }

    	$restaurant = DB::table('restaurants')->where('user_id', $order->vendor_id)->first();
    	$restaurant_location = DB::table('restaurant_locations')->where('user_id', $order->vendor_id)->first();
    	//$restaurant_city = DB::table('cities')->where('name', $restaurant_location->city)->first();
        $restaurant_city = DB::table('cities')->select('cities.*')->leftJoin('states', 'states.id', 'cities.state_id')->where('cities.name', $restaurant_location->city)->where('states.name', $restaurant_location->state)->first();
    	$street_address = $order->street_address;
        $address_line_2 = $order->address_line_2;
        $first_name = $order->first_name;
        $last_name = $order->last_name;
        $phone = $order->phone;
        $email = $order->email;
        $zip_code = $order->zip_code;
        $city = $order->city;
        $state_code = DB::table('states')->where('id', $order->state_id)->pluck('state_code')->first();
        
        if($service_code == '') {
            //$from = 'Brooklyn, NY, United States';
            //$to = 'Anchorage, AK, United States';
            $from = $restaurant_location->city . ', ' . $restaurant_city->state_code . ', United States';
            $to = $city . ', ' . $state_code . ', United States';
            $url = "https://maps.googleapis.com/maps/api/directions/json?origin=".urlencode($from)."&destination=".urlencode($to)."&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
            $result_string = file_get_contents($url);
            //echo $url; dd($result_string);
            $result = json_decode($result_string, true);
            //echo $result['routes'][0]['legs'][0]['distance']['value'];
            //dd($result);
            $distance = ($result['routes'][0]['legs'][0]['distance']['value'] ?? 0) /1609;
            $shipping_info = json_decode($restaurant->shipping_info, true);
            $delivery_days = $shipping_info['delivery_days'];
            $service_code = '03';
            if($distance < 200) {
                $service_code = '03';
            }
            if($distance >= 200 && $distance <= 700) {
                if(in_array($delivery_days, [1])) $service_code = '13';
                if(in_array($delivery_days, [2])) $service_code = '02';
                if(in_array($delivery_days, [3])) $service_code = '12';
            }
            if($distance > 700) {
                if(in_array($delivery_days, [1])) $service_code = '13';
                if(in_array($delivery_days, [2])) $service_code = '02';
                if(in_array($delivery_days, [3])) $service_code = '12';
            }
            if((in_array($restaurant_city->state_code, ['AK', 'HI']) || in_array($state_code, ['AK', 'HI'])) && $restaurant_city->state_code != $state_code) {
                $service_code = '02';
                if(in_array($delivery_days, [1])) $service_code = '01';
            }
        }


        /*$service_code = '03';
        if((in_array($restaurant_city->state_code, ['AK', 'HI']) || in_array($state_code, ['AK', 'HI'])) && $restaurant_city->state_code != $state_code)
            $service_code = '01';*/

        /*echo $restaurant->name . ' - ' . $restaurant_location->zip_code . ' - ' . $restaurant_location->location . ' - ' . $restaurant_location->city . ' - ' . $restaurant_city->state_code . ' - ' . $first_name . ' - ' . $last_name . ' - ' . $phone . ' - ' . $email . ' - ' . $zip_code . ' - ' . $street_address . ' - ' . $city . ' - ' . $state_code . ' - ' . $service_code;
        die;*/
        /*$restaurant_city->state_code = 'XY';
        $sandbox = true;*/

        $accesskey = env('UPS_API_KEY');
        $userid = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');

        $shipping = new \Ups\Shipping($accesskey, $userid, $password, $sandbox);
        //$residential_address = "Jforward Inc, Menya Jiro 306 gold street, Suite c2, BROOKLYN, NY 11201 US";
        try {
            $shipment = new \Ups\Entity\Shipment();

            $shipper = $shipment->getShipper();
            $shipper->setShipperNumber("R673Y5");
            //$shipper->setShipperNumber("W007R5");
            $shipper->setName($restaurant->name);
            $shipperAddress = $shipment->getShipper()->getAddress();
            $shipperAddress->setPostalCode($restaurant_location->zip_code);
            $shipperAddress->setAddressLine1($restaurant_location->location);
            //$shipperAddress->setAddressLine2('BUSINESS ADDRESS 2');
            $shipperAddress->setCity($restaurant_location->city);
            $shipperAddress->setStateProvinceCode($restaurant_city->state_code);

            $address = new \Ups\Entity\Address();
            $address->setPostalCode('11201');
            $address->setAddressLine1('306 Gold Street');
            //$address->setAddressLine2('BUSINESS ADD 2');
            $address->setCity('Brooklyn');
            $address->setStateProvinceCode('NY');
            $shipFrom = new \Ups\Entity\ShipFrom();
            $shipFrom->setAddress($address);
            $shipFrom->setCompanyName('Umami Square');
            $shipment->setShipFrom($shipFrom);
            $ship = $shipment->getShipFrom();
            $ship->CompanyName = 'Umami Square';

            $shipTo = $shipment->getShipTo();
            $shipTo->setAttentionName($first_name . ' ' . $last_name);
            $shipTo->setReceivingAddressName($first_name . ' ' . $last_name);
            $shipTo->setPhoneNumber($phone);
            $shipTo->setEmailAddress($email);
            $shipTo->setCompanyName($first_name . ' ' . $last_name);
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($zip_code);
            /*$shipToAddress->setAddressLine1($street_address);
            if($address_line_2 != '')
                $shipToAddress->setAddressLine2($address_line_2);*/
            if($address_line_2 != '') {
              $shipToAddress->setAddressLine1($address_line_2);
              $shipToAddress->setAddressLine2($street_address);
            } else {
              $shipToAddress->setAddressLine1($street_address);
            }
            $shipToAddress->setCity($city);
            $shipToAddress->setStateProvinceCode($state_code);
            //$shipToAddress->setCountryCode('US');
            //residenial address indicator will increase the shipping rate
            $shipToAddress->setResidentialAddressIndicator('TRUE');
            $shipment->setShipTo($shipTo);

            $service = new \Ups\Entity\Service;
            //$service->setCode(\Ups\Entity\Service::S_STANDARD);
            $service->setCode($service_code); // 01 = next day air, 02 = 2nd day air, 03 = ground
            $service->setDescription($service->getName());
            $shipment->setService($service);

            //Add package
            $package = new \Ups\Entity\Package();
            $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
            $package->getPackageWeight()->setWeight(2);

            $dimensions = new \Ups\Entity\Dimensions();
            $dimensions->setHeight(8);
            $dimensions->setWidth(8);
            $dimensions->setLength(8);

            $unit = new \Ups\Entity\UnitOfMeasurement;
            $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

            $dimensions->setUnitOfMeasurement($unit);
            $package->setDimensions($dimensions);
            $shipment->addPackage($package);

            $billshipper = new \Ups\Entity\BillShipper();
            $billshipper->setAccountNumber("R673Y5");
            //$billshipper->setAccountNumber("W007R5");
            $prepaid = new \Ups\Entity\Prepaid(); 
            $prepaid->setBillShipper($billshipper);
            $paymentInformation = new \Ups\Entity\PaymentInformation;
            $paymentInformation->setPrepaid($prepaid);
            $shipment->setPaymentInformation($paymentInformation);
            //This will create UPS shipment
            $result = $shipping->confirm(\Ups\Shipping::REQ_VALIDATE, $shipment);

            $shipment_charges = $result->ShipmentCharges->TotalCharges->MonetaryValue;
            $shipment_weight = $result->BillingWeight->Weight." ".$result->BillingWeight->UnitOfMeasurement->Code;
            $tracking_number = $result->ShipmentIdentificationNumber;
            $shipment_digest = $result->ShipmentDigest;
            $accept = $shipping->accept($shipment_digest);
            
            $tracking_number = $accept->PackageResults->TrackingNumber;
            $imageformat = $accept->PackageResults->LabelImage->LabelImageFormat->Code;
                
            $base64image = $accept->PackageResults->LabelImage->GraphicImage;
            
            $image = base64_decode($base64image);

            if(!$test_only)
                DB::table('orders')->where('id', $order->id)->update(['ups_service_code' => $service_code, 'tracking_id' => $tracking_number, 'label_image' => $base64image]);

            /*$tracking = new \Ups\Tracking($accesskey, $userid, $password);
            try {
              $shipment = $tracking->track($tracking_number);
              $PickupDate = substr($shipment->PickupDate, 0, 4) . '-' . substr($shipment->PickupDate, 4, 2) . '-' . substr($shipment->PickupDate, 6, 2);
              $ScheduledDeliveryDate = substr($shipment->ScheduledDeliveryDate, 0, 4) . '-' . substr($shipment->ScheduledDeliveryDate, 4, 2) . '-' . substr($shipment->ScheduledDeliveryDate, 6, 2);
              DB::table('orders')->where('id', $order->id)->update(['pickup_date' => $PickupDate, 'delivery_date' => $ScheduledDeliveryDate]);
            } catch (\Ups\Exception\InvalidResponseException $e) {
            }*/
            return ['message' => '', 'success' => true];
        } catch (\Ups\Exception\InvalidResponseException $e) {
            //return $e->getMessage();
            return ['message' => $e->getMessage(), 'success' => false];
        } catch (\ErrorException $e) {
            return ['message' => $e->getMessage(), 'success' => false];
        }
        return true;
    }
}
