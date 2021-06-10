<?php

namespace App\Http\Controllers\Backend\Shippings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Shippings\ShippingsUpdateRequest;
use App\Http\Requests\Frontend\Shippings\Shippingscharge;
use App\Models\Shippings;
use App\Models\ShippingCommission;
use App\Models\ShippingFee;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
class ShippingsController extends Controller
{

   /**
     * @var Coupon
     */
    protected $shippings;
    protected $shippingcommission;
    protected $shippingfee;
    protected $country;
    protected $state;
    protected $city;

    public function __construct(Shippings $shippings,ShippingCommission $shippingcommission,ShippingFee $shippingfee,Country $country,
        State $state,
        City $city)
    {
      $this->shippings=$shippings;
      $this->shippingcommission=$shippingcommission;
      $this->shippingfee=$shippingfee;
      $this->country = $country;
      $this->state = $state;
      $this->city = $city;

    }

    public function index()
    {
      $shippings= $this->shippings->orderBy('id', 'DESC')->paginate(PAGINATION);
  	   return view('backend.shippings.index', compact('shippings'));
    }

     public function shippingcharge()
    {
      $shippingcharge= $this->shippings->orderBy('id', 'DESC')->paginate(PAGINATION);
      $countriedata = $this->country->where('sortname','US')->select('name','id')->get();
       return view('backend.shippings.shippingcharge', compact('shippingcharge','countriedata'));
    }

     public function shippingcalculate11(Shippingscharge $request)
    {
      $day=$request->day;
      $from_zipcode=$request->from_zipcode;
      $to_zipcode=$request->to_zipcode;
      $shippingcalculate= $this->shipingchargeamount12($day,$from_zipcode,$to_zipcode);
      $shippingcharge= $this->shippings->orderBy('id', 'DESC')->paginate(PAGINATION);
       return view('backend.shippings.shippingcharge', compact('shippingcharge','shippingcalculate','from_zipcode','to_zipcode','day'));
    }

public function shipingchargeamount899(){
  //print_r($to);die;
    $rate = new \Ups\Rate(
      env('UPS_API_KEY'),
      env('UPS_USER_ID'),
     env('UPS_PASSWORD')
  );
    $code='02';
    $from='96734';
    $to='99501';
    //echo $code;die;
  $shipment = new \Ups\Entity\Shipment();

    $shipperAddress = $shipment->getShipper()->getAddress();
    $shipperAddress->setPostalCode($from);

    $address = new \Ups\Entity\Address();
    $address->setPostalCode($from);
    $shipFrom = new \Ups\Entity\ShipFrom();
    $shipFrom->setAddress($address);

    $shipment->setShipFrom($shipFrom);

    $shipTo = $shipment->getShipTo();
    $shipTo->setCompanyName('Test Ship To');
    $shipToAddress = $shipTo->getAddress();
    $shipToAddress->setPostalCode($to);
    $shipToAddress->setCountryCode('US');

    $package = new \Ups\Entity\Package();
    $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
    $package->getPackageWeight()->setWeight(10);
    $dimensions = new \Ups\Entity\Dimensions();
    $dimensions->setHeight(10);
    $dimensions->setWidth(10);
    $dimensions->setLength(10);

    $unit = new \Ups\Entity\UnitOfMeasurement;
    $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

    $dimensions->setUnitOfMeasurement($unit);
    $package->setDimensions($dimensions);

    $shipment->addPackage($package);

    $service = new \Ups\Entity\Service;
  $service->setCode($code);
  $service->setDescription($service->getName());
  //print_r($service);
  $shipment->setService($service);
  $rates=$rate->getRate($shipment);
  print_r($rates);
return $rates->RatedShipment[0]->TotalCharges->MonetaryValue;
   // die;
}

  public function shippingcalculate(Request $request)
  {
//echo "<pre>"; print_r($request->all());die;
    $AccessLicenseNumber ='7D8657A977D58776';
    $UserID ="one@j-fo.com";
    $Password = "Newyork2020";

    $CustomerContext = "Ups Shipping ";
    $RequestAction = "ShipConfirm";     // These values are contained in documentation 
    $RequestOption = "nonvalidate";
    $domtree = new \DOMDocument('1.0');
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($request->f_country.$request->f_state.$request->from_zipcode)."&sensor=false&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
          
      $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);

       $dataresultcheck=$result['results'][0]['address_components'];
       $stateshort_code='';
       $countryshort_code='';
       if(in_array('country', $dataresultcheck[0]['types'])){
         $countryshort_code =$result['results'][0]['address_components'][1]['short_name'];
       }else if(in_array('country', $dataresultcheck[1]['types'])){
         $countryshort_code =$result['results'][0]['address_components'][1]['short_name'];
       }else if(in_array('country', $dataresultcheck[2]['types'])){
         $countryshort_code =$result['results'][0]['address_components'][2]['short_name'];
       }else if(in_array('country', $dataresultcheck[3]['types'])){
         $countryshort_code =$result['results'][0]['address_components'][3]['short_name'];
       } else if(in_array('country', $dataresultcheck[4]['types'])){
         $countryshort_code =$result['results'][0]['address_components'][4]['short_name'];
       } 
           
       if(in_array('administrative_area_level_1', $dataresultcheck[0]['types'])){
         $stateshort_code =$result['results'][0]['address_components'][1]['short_name'];
       }else if(in_array('administrative_area_level_1', $dataresultcheck[1]['types'])){
         $stateshort_code =$result['results'][0]['address_components'][1]['short_name'];
       }else if(in_array('administrative_area_level_1', $dataresultcheck[2]['types'])){
         $stateshort_code =$result['results'][0]['address_components'][2]['short_name'];
       }else if(in_array('administrative_area_level_1', $dataresultcheck[3]['types'])){
         $stateshort_code =$result['results'][0]['address_components'][3]['short_name'];
       } else if(in_array('administrative_area_level_1', $dataresultcheck[4]['types'])){
         $stateshort_code =$result['results'][0]['address_components'][4]['short_name'];
       } 


       $url1 = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($request->t_country.$request->t_state.$request->to_zipcode)."&sensor=false&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
          
      $result_string1 = file_get_contents($url1);
        $result1 = json_decode($result_string1, true);

       $dataresultcheck1=$result1['results'][0]['address_components'];
       $stateshort_code1='';
       $countryshort_code1='';
       if(in_array('country', $dataresultcheck1[0]['types'])){
         $countryshort_code1 =$result1['results'][0]['address_components'][1]['short_name'];
       }else if(in_array('country', $dataresultcheck1[1]['types'])){
         $countryshort_code1 =$result1['results'][0]['address_components'][1]['short_name'];
       }else if(in_array('country', $dataresultcheck1[2]['types'])){
         $countryshort_code1 =$result1['results'][0]['address_components'][2]['short_name'];
       }else if(in_array('country', $dataresultcheck1[3]['types'])){
         $countryshort_code1 =$result1['results'][0]['address_components'][3]['short_name'];
       } else if(in_array('country', $dataresultcheck1[4]['types'])){
         $countryshort_code1 =$result1['results'][0]['address_components'][4]['short_name'];
       } 
           
       if(in_array('administrative_area_level_1', $dataresultcheck1[0]['types'])){
         $stateshort_code1 =$result1['results'][0]['address_components'][1]['short_name'];
       }else if(in_array('administrative_area_level_1', $dataresultcheck1[1]['types'])){
         $stateshort_code1 =$result1['results'][0]['address_components'][1]['short_name'];
       }else if(in_array('administrative_area_level_1', $dataresultcheck1[2]['types'])){
         $stateshort_code1 =$result1['results'][0]['address_components'][2]['short_name'];
       }else if(in_array('administrative_area_level_1', $dataresultcheck1[3]['types'])){
         $stateshort_code1 =$result1['results'][0]['address_components'][3]['short_name'];
       } else if(in_array('administrative_area_level_1', $dataresultcheck1[4]['types'])){
         $stateshort_code1 =$result1['results'][0]['address_components'][4]['short_name'];
       } 

    $AccessRequest = $domtree->createElement("AccessRequest");
$AccessRequest->setAttribute("xml:lang", "en_US");
$domtree->appendChild($AccessRequest);
$AccessRequest->appendChild($domtree->createElement('AccessLicenseNumber', $AccessLicenseNumber));
$AccessRequest->appendChild($domtree->createElement('UserId', $UserID));
$AccessRequest->appendChild($domtree->createElement('Password', $Password));
$ShipmentConfirmRequest = $domtree->createElement("ShipmentConfirmRequest");
$ShipmentConfirmRequest->setAttribute("xml:lang", "en_US");
$domtree->appendChild($ShipmentConfirmRequest);
    $Request = $domtree->createElement("Request");
    $ShipmentConfirmRequest->appendChild($Request);
        $TransactionReference = $domtree->createElement("TransactionReference");
        $Request->appendChild($TransactionReference);
                    $TransactionReference->appendChild($domtree->createElement('CustomerContext', $CustomerContext)); // Length: 1-512, Required: No
                $Request->appendChild($domtree->createElement('RequestAction', $RequestAction)); // Length: 10, Required: Yes, Must be "ShipConfirm"
                // <RequestOption>
                $Request->appendChild($domtree->createElement('RequestOption', $RequestOption)); // Length: 1-256, Required: Yes, "validate" or "nonvalidate"
        // </Request>
        // <Shipment>
    $PickupType = $domtree->createElement("PickupType");
    $ShipmentConfirmRequest->appendChild($PickupType);
    $Code ='03';
    $PickupType->appendChild($domtree->createElement('Code', $Code));
        $Shipment = $domtree->createElement("Shipment");
        $ShipmentConfirmRequest->appendChild($Shipment);
            // <Shipper>
            $Shipper = $domtree->createElement("Shipper");
            $Shipment->appendChild($Shipper);
               $ShipperName='Umami Square';
                $Shipper->appendChild($domtree->createElement('Name', $ShipperName)); // Length: 1-35, Required: Yes, Company Name
                $ShipperAttentionName='';
                $Shipper->appendChild($domtree->createElement('AttentionName', $ShipperAttentionName)); // Length: 1-35, Required: Cond, Required if destination is international
                $ShipperPhoneNumber='+1 3475120849';
                $Shipper->appendChild($domtree->createElement('PhoneNumber', $ShipperPhoneNumber)); // Length: 1-15, Required: Cond
               $ShipperNumber='R673Y5';
                $Shipper->appendChild($domtree->createElement('ShipperNumber', $ShipperNumber)); // Length: 6, Required: Yes
                // <Address>
                $Address = $domtree->createElement('Address');
                $Shipper->appendChild($Address);
                 $ShipperAddressLine=$request->f_city;
                    $Address->appendChild($domtree->createElement('AddressLine1', $ShipperAddressLine)); // Length: 1-35, Required: Yes
                    $ShipperCity=$request->f_city;
                    $Address->appendChild($domtree->createElement('City', $ShipperCity)); // Length: 1-30, Required: Yes
                    $ShipperStateProvinceCode=$stateshort_code;
                    $Address->appendChild($domtree->createElement('StateProvinceCode', $ShipperStateProvinceCode)); // Length: 2-5, Required: Cond, Required if shipper is in the US or CA.
                    // <PostalCode>
                    $ShipperPostalCode=$request->from_zipcode;
                    $Address->appendChild($domtree->createElement('PostalCode', $ShipperPostalCode)); // Length: 1-10, Required: Cond, For all other countries, the postal code is optional
                    // <CountryCode>
                    $ShipperCountryCode=$countryshort_code;
                    $Address->appendChild($domtree->createElement('CountryCode', $ShipperCountryCode)); // Length: 2, Required: Yes
                // </Address>
            // </Shipper>
            // <ShipTo>
            $ShipTo = $domtree->createElement("ShipTo");
            $Shipment->appendChild($ShipTo);
                $ShipToCompanyName='Wdp Technology';
                $ShipTo->appendChild($domtree->createElement('CompanyName', $ShipToCompanyName)); // Length: 1-35, Required: Yes
                // <AttentionName>
                $ShipToAttentionName='';
                $ShipTo->appendChild($domtree->createElement('AttentionName', $ShipToAttentionName)); // Length: 1-35, Required: Cond, for UPS Next Day Air Early service, and when ShipTo country is different than ShipFrom country.
                // <PhoneNumber>
                $ShipTo_phone_number='';
                $ShipTo->appendChild($domtree->createElement('PhoneNumber', $ShipTo_phone_number)); // Length: 1-15, Required: Cond, Required for UPS Next Day Air Early service, and when Ship To country is different than the ShipFrom country.
                // <Address>
                $Address2=$request->t_city;
                $Address2 = $domtree->createElement('Address');
                $ShipTo->appendChild($Address2);
                    // <AddressLine1>
                $ShipToAddressLine=$request->t_city;
                    $Address2->appendChild($domtree->createElement('AddressLine1', $ShipToAddressLine)); // Length: 1-35, Required: Yes
                    // <City>
                    $ShipToCity=$request->t_city;
                    $Address2->appendChild($domtree->createElement('City', $ShipToCity)); // Length: 1-30, Required: Yes
                    // <StateProvinceCode>
                    $ShipToStateProvinceCode=$stateshort_code1;
                    $Address2->appendChild($domtree->createElement('StateProvinceCode', $ShipToStateProvinceCode)); // Length: 2-5, Required: Cond, Required if shipper is in the US or CA.
                    // <PostalCode>
                    $ShipToPostalCode=$request->to_zipcode;
                    $Address2->appendChild($domtree->createElement('PostalCode', $ShipToPostalCode)); // Length: 1-10, Required: Cond, For all other countries, the postal code is optional
                    // <CountryCode>
                    $ShipToCountryCode=$countryshort_code1;
                    $Address2->appendChild($domtree->createElement('CountryCode', $ShipToCountryCode)); // Length: 2, Required: Yes
                // </Address>
            // </ShipTo>
            // <PaymentInformation>
                    $PaymentInformation='R673Y5';
            $PaymentInformation = $domtree->createElement("PaymentInformation");
            $Shipment->AppendChild($PaymentInformation);
                // <Prepaid>
                $Prepaid = $domtree->createElement("Prepaid");
                $PaymentInformation->appendChild($Prepaid);
                    // <BillShipper>
                    $BillShipper = $domtree->createElement("BillShipper");
                    $Prepaid->appendChild($BillShipper);
                        // <AccountNumber>
                    $AccountNumber='R673Y5';
                        $BillShipper->appendChild($domtree->createElement('AccountNumber', $AccountNumber)); // Length: 6, Required: Cond, Based on PaymentInformation container, Must be the same UPS account number as the one provided in Shipper/ShipperNumber.
                    // </BillShipper>
                // </Prepaid>
            // </PaymentInformation>
            // <Service>
            $Service = $domtree->createElement("Service");
            $Shipment->appendChild($Service);
                // <Code>

            $ServiceCode=$request->day;
           $service_name= $this->servicename($ServiceCode);
           //  print_r($service_name);
                $Service->appendChild($domtree->createElement('Code', $ServiceCode)); // Length: 2, Required: Yes, 01 = Next Day Air 02 = 2nd Day Air ...
            // </Service>
              


       /*    $dddd=$this->shipingchargeamount899();
           print_r($dddd);*/
            // <Package>
            $Package = $domtree->createElement('Package');
            $Shipment->appendChild($Package);
                // <PackagingType>
                $PackagingType = $domtree->createElement('PackagingType');
                $Package->appendChild($PackagingType);
                    // <Code>
                $PackageTypeCode='02';
                    $PackagingType->appendChild($domtree->createElement('Code', $PackageTypeCode)); // Length: 2, Required: Yes, 01 = UPS Letter 02 = Customer Supplied Package ...
                // </PackagingType>
                // <Description>
                  
                    $Description='Product Deliver';
                $Package->appendChild($domtree->createElement('Description', $Description)); // Length: 1-35, Required: Cond, Required for shipment with return service.
                // </Description>
                // <Dimensions>
              
                $Dimensions = $domtree->createElement('Dimensions'); // Required: Cond, Length + 2*(Width + Height) must be less than or equal to 130 IN or CM.
                $Package->appendChild($Dimensions);
                    // <UnitOfMeasurement>
           
                    $UnitOfMeasurement = $domtree->createElement('UnitOfMeasurement');
                    $Dimensions->appendChild($UnitOfMeasurement);
                        // <Code>
                 /*   $DimensionUnitOfMeasurementCode='IN';
                        $UnitOfMeasurement->appendChild($domtree->createElement('Code', $DimensionUnitOfMeasurementCode));*/ // Length: 2, Required: Yes*, Codes are: IN = Inches, CM = Centimeters, 00 = Metric Units Of Measurement, 01 = English Units of Measurement.
                    // </UnitOfMeasurement>
                    // <Length>
                        $PackageLength=$request->length;
                    $Dimensions->appendChild($domtree->createElement('Length', $PackageLength)); // Length: 9, Required: Yes*, Valid values are 0 to 108 IN and 0 to 270 CM.
                    // <Width>
                    $PackageWidth=$request->width;
                    $Dimensions->appendChild($domtree->createElement('Width', $PackageWidth)); // Length: 9, Required: Yes*
                    // <Height>
                    $PackageHeight=$request->height;
                    $Dimensions->appendChild($domtree->createElement('Height', $PackageHeight)); // Length: 9, Required: Yes*
                // </Dimensions>
                // <PackageWeight>
                $PackageWeight = $domtree->createElement('PackageWeight');
                $Package->appendChild($PackageWeight);
                    // <UnitOfMeasurement>
                    $UnitOfMeasurement2 = $domtree->createElement('UnitOfMeasurement');
                    $PackageWeight->appendChild($UnitOfMeasurement2);
                        // <Code>
                    /*$WeightUnitOfMeasurementCode='KGS';
                        $UnitOfMeasurement2->appendChild($domtree->createElement('Code', $WeightUnitOfMeasurementCode));*/ // Length: 3, Required: Cond, LBS = Pounds KGS = Kilograms OZS = Ounces ...
                    // <Weight>
                        $Pack_weights=$request->weight;
                    $PackageWeight->appendChild($domtree->createElement('Weight', $Pack_weights)); // Length: 1-5, Required: Yes*, Weight accepted for letters/envelopes.
                    // </UnitOfMeasurement>
                // </PackageWeight>
            // </Package>
       
        // </Shipment>
        // <LabelSpecification>
        $RateInformation = $domtree->createElement("RateInformation");
        $Shipment->appendChild($RateInformation);
        $NegotiatedRatesIndicator = $domtree->createElement('NegotiatedRatesIndicator');
        $RateInformation->appendChild($NegotiatedRatesIndicator);

        $LabelSpecification = $domtree->createElement('LabelSpecification');
        $ShipmentConfirmRequest->appendChild($LabelSpecification);
            // <LabelPrintMethod>
            $LabelPrintMethod = $domtree->createElement('LabelPrintMethod');
            $LabelSpecification->appendChild($LabelPrintMethod);
                // <Code>
            $LabelCode='GIF';
                $LabelPrintMethod->appendChild($domtree->createElement('Code', $LabelCode)); // Length: 4, Required: Yes*
            // </LabelPrintMethod>
            // <LabelImageFormat>
            $LabelImageFormat = $domtree->createElement('LabelImageFormat');
            $LabelSpecification->appendChild($LabelImageFormat);
                // <Code>
            $LabelImageCode='GIF';
                $LabelImageFormat->appendChild($domtree->createElement('Code', $LabelImageCode)); 

                $domtree->preserveWhiteSpace = true;
$domtree->formatOutput = true;
$xml_string = $domtree->saveXML();

// UPS Address
$url = 'https://www.ups.com/ups.app/xml/ShipConfirm';
$stream_options = array(
    'http' => array(
       'method'  => 'POST',
       'header'  => 'Content-type: application/x-www-form-urlencoded',
       'content' => "$xml_string",
    ),
);
$context  = stream_context_create($stream_options);
$response = file_get_contents($url, null, $context);
$ShipmentConfirmResponse = new \SimpleXMLElement($response);

if ((string)$ShipmentConfirmResponse->Response->ResponseStatusCode == 1) { // If the response is "success" then continue with second request
    // If ShipmentCofirmRequest is successful, send ShipmentAcceptRequest
$connect='R673Y5';
$ShipmentID=$ShipmentConfirmResponse->ShipmentIdentificationNumber;
    $ShipmentDigest = $ShipmentConfirmResponse->ShipmentDigest;
   $valuedata= $this->AcceptRequest($AccessLicenseNumber, $UserID, $Password, $CustomerContext, $ShipmentDigest, $ShipmentID, $connect); // After first successful request call a function which will send AcceptRequest

} else {
    echo isset($ShipmentConfirmResponse->Response->Error->ErrorDescription)?$ShipmentConfirmResponse->Response->Error->ErrorDescription:'Invalid ShipTo PostalCode';
}

      $day=$request->day;
      $from_zipcode=$request->from_zipcode;
      $to_zipcode=$request->to_zipcode;
    echo  $shippingcalculate=  isset($valuedata)?$valuedata:'Invalid Zip code.';
      /*$shippingcharge= $this->shippings->orderBy('id', 'DESC')->paginate(PAGINATION);
       return view('backend.shippings.shippingcharge', compact('shippingcharge','shippingcalculate','from_zipcode','to_zipcode','day'));*/
    }
public function shipingchargeamount11($code,$from,$to){
  //print_r($to);die;
    $rate = new \Ups\Rate(
      env('UPS_API_KEY'),
      env('UPS_USER_ID'),
     env('UPS_PASSWORD')
  );
    //echo $code;die;
  $shipment = new \Ups\Entity\Shipment();

    $shipperAddress = $shipment->getShipper()->getAddress();
    $shipperAddress->setPostalCode($from);

    $address = new \Ups\Entity\Address();
    $address->setPostalCode($from);
    $shipFrom = new \Ups\Entity\ShipFrom();
    $shipFrom->setAddress($address);

    $shipment->setShipFrom($shipFrom);

    $shipTo = $shipment->getShipTo();
    $shipTo->setCompanyName('Test Ship To');
    $shipToAddress = $shipTo->getAddress();
    $shipToAddress->setPostalCode($to);

    $package = new \Ups\Entity\Package();
    $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
    $package->getPackageWeight()->setWeight(10);
    $dimensions = new \Ups\Entity\Dimensions();
    $dimensions->setHeight(10);
    $dimensions->setWidth(10);
    $dimensions->setLength(10);

    $unit = new \Ups\Entity\UnitOfMeasurement;
    $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

    $dimensions->setUnitOfMeasurement($unit);
    $package->setDimensions($dimensions);

    $shipment->addPackage($package);

    $service = new \Ups\Entity\Service;
  $service->setCode($code);
  $service->setDescription($service->getName());
  //print_r($service);
  $shipment->setService($service);
  $rates=$rate->getRate($shipment);
return $rates->RatedShipment[0]->TotalCharges->MonetaryValue;
   // die;
}
    

    public function servicename($code){
        $service = new \Ups\Entity\Service;
        $service->setCode($code);
        $service->setDescription($service->getName());
       return $service;
    }

    public function editShippings(int $id)
    {
      $shippings = $this->shippings->find($id);
      return view('backend.shippings.edit', compact('shippings'));
    } 

    public function updateShippings(ShippingsUpdateRequest $request ,int $id)
    {
        $checkDisType= $this->shippings->where('id', $id)->first();
          $this->shippings->where('id', $id)->update(
                    [ 
                      'day' => $request->get('day'),
                      'service_name' => $request->get('service_name'),
                      'price' => $request->get('price'),
                    ]
                  );
  

        return redirect()->to('admin/shippings')->with(['flash_success' => trans('Shippings has been successfully updated.')]);
               
      }

    public function shippingsList()
    {
      $currentdate= date('Y-m-d');
      $shippingslists = $this->shippings->get();
       return view('frontend.shippings.shippings-list', compact('shippingslists'));

    } 

     public function shippingCommission()
     {
        $shippingcommisssion= $this->shippingcommission->first();
       return view('backend.shippings.shippingcommission', compact('shippingcommisssion'));
     }

        public function shippingCommissionAdd(Request $request)
        {
          $commission= $this->shippingcommission->where('id',$request->id)->first();
          if(empty($commission))
          {
            $commission= new ShippingCommission;
          }
          $commission->shipping_commission=$request->shipping_commission;
          $commission->save();
           return redirect()->to('admin/shippings/commission')->with(['flash_success' => trans('Shippings commission successfully updated.')]);
        }



      public function shippingFree()
      {
        $freeshippings=$this->shippingfee->get();
         return view('backend.shippings.freeshipping', compact('freeshippings'));

      }

       public function editShippingsFee($id=null)
       {
        $freeshipping=$this->shippingfee->where('id', $id)->first();
         return view('backend.shippings.freeshippingedit', compact('freeshipping'));
       }

        public function updateShippingsFees(Request $request, $id= null)
        {
            $this->shippingfee->where('id',$id)->update(
                        [
                         'title'=>$request->title,
                         'min_distance'=>$request->min_distance,
                         'max_distance'=>$request->max_distance,
                         'alaska_1day'=>$request->alaska_1day,
                         'hawai_1day'=>$request->hawai_1day,
                         'service_1'=>$request->service_1,
                         'alaska_2day'=>$request->alaska_2day,
                         'hawai_2day'=>$request->hawai_2day,
                         'service_2'=>$request->service_2,
                         'alaska_3day'=>$request->alaska_3day,
                         'hawai_3day'=>$request->hawai_3day,
                         'service_3'=>$request->service_3,
                         'alaska_above'=>$request->alaska_above,
                         'hawai_above'=>$request->hawai_above,
                         'service_above'=>$request->service_above,
                        ]);
             return redirect()->to('admin/shippings/freeshipping')->with(['flash_success' => trans('Shippings Fees successfully updated.')]);

        }

        public function AcceptRequest ($AccessLicenseNumber, $UserID, $Password, $CustomerContext, $ShipmentDigest) {
      $RequestAction = "ShipAccept";
      $domtree = new \DOMDocument('1.0');
      $AccessRequest = $domtree->createElement("AccessRequest");
      $domtree->appendChild($AccessRequest);
      $AccessRequest->appendChild($domtree->createElement('AccessLicenseNumber', $AccessLicenseNumber));
      $AccessRequest->appendChild($domtree->createElement('UserId', $UserID));
      // <Password>
      $AccessRequest->appendChild($domtree->createElement('Password', $Password));
      // </AccessRequest>
      // <ShipmentAcceptRequest>
      $ShipmentAcceptRequest = $domtree->createElement("ShipmentAcceptRequest");
      $domtree->appendChild($ShipmentAcceptRequest);
      // <Request>
      $Request = $domtree->createElement("Request");
      $ShipmentAcceptRequest->appendChild($Request);
      // <TransactionReference>
      $TransactionReference = $domtree->createElement("TransactionReference");
      $Request->appendChild($TransactionReference);
      // <CustomerContext>
      $TransactionReference->appendChild($domtree->createElement('CustomerContext', $CustomerContext));
      // </TransactionReference>
      // <RequestAction>
      $Request->appendChild($domtree->createElement('RequestAction', $RequestAction));
      // </Request>
      // <ShipmentDigest>
      $ShipmentAcceptRequest->appendChild($domtree->createElement('ShipmentDigest', $ShipmentDigest));
      $domtree->preserveWhiteSpace = true;
      $domtree->formatOutput = true;
      $xml_string = $domtree->saveXML();
      $url = 'https://www.ups.com/ups.app/xml/ShipAccept'; // Again testing URL
      $stream_options = array(
        'http' => array(
          'method'  => 'POST',
          'header'  => 'Content-type: application/x-www-form-urlencoded',
          'content' => "$xml_string",
        ),
      );
      $context  = stream_context_create($stream_options);
      $response = file_get_contents($url, null, $context);

      $ShipmentAcceptResponse = new \SimpleXMLElement($response);

 
      if ((string)$ShipmentAcceptResponse->Response->ResponseStatusCode == 1) {

        $Tracking_ID = $ShipmentAcceptResponse->ShipmentResults->PackageResults->TrackingNumber;
        $Price = $ShipmentAcceptResponse->ShipmentResults->ShipmentCharges->TransportationCharges->MonetaryValue;
        $ImageBase64 = $ShipmentAcceptResponse->ShipmentResults->PackageResults->LabelImage->GraphicImage;
         //echo "<pre>"; print_r($ShipmentAcceptResponse);
        //$dataarray=array('TrackingNumber'=>$Tracking_ID,'lableimage'=>$ImageBase64);
        //return $ShipmentAcceptResponse;
    return    $ShipmentAcceptResponse->ShipmentResults->NegotiatedRates->NetSummaryCharges->GrandTotal->MonetaryValue;

      } else {
         $ShipmentAcceptResponse->Response->Error->ErrorDescription;
      }
    }




   public function getShippingState(Request $request)
    {
        $countryId  = $request->get('country_id');
        $countryId=$this->country->where('name',$countryId)->select('id')->first();
        if ($countryId !='') {
            $stateList  = $this->state
                                ->where('country_id',$countryId->id)
                                ->orderBy('name','ASC')
                                ->pluck('name','id')
                                ->all();

            $list = '<select class="form-control box-size" id="tostate" name="t_state"><option value="">'.trans('Select State').'</option>';

            if (count($stateList)>0) {
                foreach($stateList as $k=>$v) {
                    $list.= '<option value="'.$v.'">'.$v.'</option>';
                }
            }
            $list .=  '</select>';
            echo $list;
            die;
        } else {
            echo '<select class="form-control box-size" name="t_state"><option value="">'.trans('To State').'</option></select>';
            die;
        }
    }

    /**
     * @param AddressFormRequest $request
     */
    public function getShippingCity(Request $request)
    {
        $stateId  = $request->get('state_id');
         $stateId=$this->state->where('name',$stateId)->select('id')->first();
        if ($stateId !='') {
            $cityList = $this->city
                                ->where('state_id', $stateId->id)
                                ->orderBy('name','ASC')
                                ->pluck('name','id')
                                ->all();

            $list = '<select class="form-control box-size"  name="t_city"><option value="">'.trans('To City').'</option>';

            if(count($cityList)>0){
                foreach($cityList as $k=>$v){
                    $list.= '<option value="'.$v.'">'.$v.'</option>';
                }
            }
            $list .=  '</select>';
            echo $list;
            die;
        }else{
            echo '<select class="form-control box-size" name="t_city"><option value="">'.trans('To City').'</option></select>';
            die;
        }
    }



       public function getShippingFromState(Request $request)
    {
        $countryId  = $request->get('country_id');
        $countryId=$this->country->where('name',$countryId)->select('id')->first();
        if ($countryId !='') {
            $stateList  = $this->state
                                ->where('country_id',$countryId->id)
                                ->orderBy('name','ASC')
                                ->pluck('name','id')
                                ->all();

            $list = '<select class="form-control box-size" id="fromstate" name="f_state"><option value="">'.trans('From State').'</option>';

            if (count($stateList)>0) {
                foreach($stateList as $k=>$v) {
                    $list.= '<option value="'.$v.'">'.$v.'</option>';
                }
            }
            $list .=  '</select>';
            echo $list;
            die;
        } else {
            echo '<select class="form-control box-size" name="f_state"><option value="">'.trans('From State').'</option></select>';
            die;
        }
    }

    /**
     * @param AddressFormRequest $request
     */
    public function getShippingFromCity(Request $request)
    {
        $stateId  = $request->get('state_id');
         $stateId=$this->state->where('name',$stateId)->select('id')->first();
        if ($stateId !='') {
            $cityList = $this->city
                                ->where('state_id', $stateId->id)
                                ->orderBy('name','ASC')
                                ->pluck('name','id')
                                ->all();

            $list = '<select class="form-control box-size"  name="f_city"><option value="">'.trans('From City').'</option>';

            if(count($cityList)>0){
                foreach($cityList as $k=>$v){
                    $list.= '<option value="'.$v.'">'.$v.'</option>';
                }
            }
            $list .=  '</select>';
            echo $list;
            die;
        }else{
            echo '<select class="form-control box-size" name="f_city"><option value="">'.trans('From City').'</option></select>';
            die;
        }
    }
}
