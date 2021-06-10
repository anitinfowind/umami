@extends('emails.layouts.app')

@section('content')
<div class="content">
  <div class="invoice" style="margin: 0px auto;font-family: Arial;overflow: hidden;">
    <div class="thanks" style="width: 100%;text-align:left;font-family: Arial;margin-bottom: 10px;margin-top: 10px;text-transform: uppercase;">
      <p style=" font-size: 25px;font-weight: bold;color: #393939;margin-bottom: 4px;letter-spacing: 3px;text-transform: uppercase;"> <br />
        New order placed.</p>
    </div>
    <div class="spacing">
      <hr style=" width: 100%;margin-top: 10px;margin-bottom: 5px;display: inline-block;border: 1px dashed #393939;">
    </div>
    <div class="orderinfo" style="float: left;margin-left: 30px;width: 430px;line-height: 150%;padding-left: 15px;border-left: 1px dashed;height: 190px;">
      <p style="font-size: 18px;font-weight: bold;margin-bottom: 0px;color: #393939;"> Customer Information: </p>
      <strong>Name:</strong> {{ $order_result[0]['customer_info']->first_name }} {{ $order_result[0]['customer_info']->last_name }}<br />
      <strong>Email:</strong> {{ $order_result[0]['customer_info']->email }}<br />
      <strong> Contact Number: </strong> {{ $order_result[0]['customer_info']->phone }}<br />
    </div>
    <div class="spacing">
      <hr  style="width: 100%;margin-top: 10px;margin-bottom: 5px;display: inline-block;border: 1px dashed #393939;">
    </div>
    <div class="orderinfo" style="float: left;margin-left: 30px;width: 430px;line-height: 150%;padding-left: 15px;border-left: 1px dashed;height: 190px;">
      <p style="font-size: 18px;font-weight: bold;margin-bottom: 0px;color: #393939;"> Order Information: </p>
      <strong> Order Id: </strong> {{ $order_result[0]['order_info']->order_id }}<br />
      <strong> Order Date: </strong> {{ $order_result[0]['order_info']->order_date }}<br />
      <strong> Pickup  Date: </strong> {{ $order_result[0]['order_info']->pickup_date }}<br />
    </div>
    <div class="spacing">
      <hr style=" width: 100%;margin-top: 10px;margin-bottom: 5px;display: inline-block;border: 1px dashed #393939;">
    </div>
    <div class="productinfo" style="display: inline-block;margin-top: 20px;float: left;width: 98.3%;padding: 10px;margin-right: 30px;border-radius: 10px;">
      <p style="margin-top: 0px;font-weight: bold;font-size: 18px;margin-bottom: 5px;"> Order information:</p>
      <table width="100%" border="1" style=" border:1px solid; border-collapse:collapse">
        <tbody>
          <tr>
            <th class="name" align="left"> Product Name </th>
            <!-- <th class="detail" align="left"> Price</th> -->
            <th class="qty" align="left">Qty</th>
            <!-- <th class="cost" align="left">Cost</th> -->
          </tr>
          <?php
          foreach ($order_result as $key => $value) {
            ?>
          <tr>
            <td class="name" align="left">{{ $value['title'] }}</td>
            <!-- <td class="detail" align="left"></td> -->
            <td class="qty" align="left">{{ $value['qty'] }}</td>
            <!-- <td class="cost" align="left"></td> -->
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
@endsection 