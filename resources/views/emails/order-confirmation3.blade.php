@extends('emails.layouts.layout')

@section('content')


<div class="content">
    <div class="invoice" style="margin: 0px auto;font-family: Arial;overflow: hidden;">
        <div class="spacing">
            <hr
                style="width: 100%;margin-top: 10px;margin-bottom: 5px;display: inline-block;border: 1px solid #e0e0e0;">
        </div>
        <div class="thanks" style="width: 100%;text-align:left;font-family: Arial; padding: 15px 0;">
            <?php if($mail_type == 'customer') { ?>
                <p style="font-size: 20px;color: #393939;margin: 0; padding: 0; line-height: 28px;">
                Hi {{ $order_data->first_name . ' ' . $order_data->last_name }}, <br>
                Thank you for your order.</p>
            <?php } ?>
            <?php if($mail_type == 'vendor') { ?>
                <p style="font-size: 20px;color: #393939;margin: 0; padding: 0; line-height: 28px;">
                Hi there is an order from <b>{{ $order_data->first_name . ' ' . $order_data->last_name }}</b>.</p>
            <?php } ?>
            <?php if($mail_type == 'admin') { ?>
                <p style="font-size: 20px;color: #393939;margin: 0; padding: 0; line-height: 28px;">
                Hi there is an order from <b>{{ $order_data->first_name . ' ' . $order_data->last_name }}</b>.</p>
            <?php } ?>
        </div>
        <div class="spacing">
            <hr
                style="width: 100%;margin-top: 10px;margin-bottom: 5px;display: inline-block;border: 1px solid #e0e0e0;">
        </div>
        <div class="orderinfo" style="margin: 0px;width: 100%;line-height: 23px;">
            <!-- <p style="font-size: 17px;font-weight: bold;margin-bottom: 0px;color: #393939; margin: 0; padding: 7px 0;"> Order Information: </p>
            <strong> Order Id: </strong> {{ $order_data->order_id }} <span style="color: #f00;">|</span>
            <strong> Order Date: </strong> {{ date('m-d-Y', strtotime($order_data->order_date)) }} <span style="color: #f00;">|</span>
            <?php if(in_array($mail_type, ['vendor', 'admin'])) { ?>
                <strong> Pickup Date: </strong> {{ date('m-d-Y', strtotime($order_data->pickup_date)) }}
            <?php } ?>
            <?php if(in_array($mail_type, ['customer'])) { ?>
                <strong> Delivery Date: </strong> {{ date('m-d-Y', strtotime($order_data->delivery_date)) }}
            <?php } ?> -->
            <div style="width: 50%; float: left;">
                <div style="padding: 0 10px 0 0px;">
                    <!-- <p style="font-size: 17px; margin-bottom: 0px;color: #393939; margin: 0; padding: 7px 0 0px 0;"><b>Order ID: </b><?php echo $order_data->order_id; ?></p> -->
                    <p style="font-size: 17px;font-weight: bold;margin-bottom: 0px;color: #393939; margin: 0; padding: 7px 0;">Restaurant Name: </p>
                    <div><?php echo strtoupper($order_items[0]->vendor_name); ?></div>
                    <p style="font-size: 17px;font-weight: bold;margin-bottom: 0px;color: #393939; margin: 0; padding: 7px 0;">Delivery Address: </p>
                    <div><?php echo $order_data->street_address . ', ' . ($order_data->address_line_2 != '' ? $order_data->address_line_2 . ', ' : '') . '<br>' . $order_data->city . ', ' . $order_data->state_name . ' ' . $order_data->zip_code; ?></div>
                </div>
            </div>
            <div style="width: 50%; float: right;">
                <div style="padding: 0 10px 0 0px;">
                    <!-- <p style=""><b>Order Status: </b>{{ $order_data->status }}</p> -->
                    <p style="font-size: 17px; margin-bottom: 0px;color: #393939; margin: 0; padding: 7px 0 0px 0;"><b>Order ID: </b><?php echo $order_data->order_id; ?></p>
                    <p style="font-size: 17px; margin-bottom: 0px;color: #393939; margin: 0; padding: 7px 0 0px 0;"><b>Order Date: </b><?php echo date('m-d-Y', strtotime($order_data->order_date)); ?></p>
                    <p style="font-size: 17px; margin-bottom: 0px;color: #393939; margin: 0; padding: 7px 0 0px 0;"><b>Ship Date: </b><?php echo date('m-d-Y', strtotime($order_data->pickup_date)); ?></p>
                    <p style="font-size: 17px; margin-bottom: 0px;color: #393939; margin: 0; padding: 7px 0 7px 0;"><b>Delivery Date: </b><?php echo date('m-d-Y', strtotime($order_data->delivery_date)); ?></p>
                    <a href="{{ url('track-order', \Crypt::encryptString($order_data->id)) }}" style="display: inline-block; padding: 4px 10px; background: #e4282a; color: #fff; text-decoration: none;">Track Order</a>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div class="spacing">
            <hr
                style="width: 100%;margin-top: 10px;margin-bottom: 5px;display: inline-block;border: 1px solid #e0e0e0;">
        </div>
        <div class="productinfo" style="margin: 0px;width: 100%;padding: 0;">
            <p style="font-weight: bold;font-size: 17px; margin: 0; padding: 10px 0;"> Order information:</p>
            <table width="100%" border="1"
                style=" border:1px solid #e0e0e0; border-collapse:collapse" class="info-table">
                <tbody>
                    <tr>
                        <th class="name" align="left" style="padding: 7px; border-color: #e0e0e0;"> Product Name </th>
                        <th class="detail" align="center" style="padding: 7px; border-color: #e0e0e0;"> Price</th>
                        <th class="qty" align="center" style="padding: 7px; border-color: #e0e0e0;">Qty</th>
                        <th class="cost" align="right" style="padding: 7px; border-color: #e0e0e0;">Cost</th>
                    </tr>
                    <?php
                    $product_total = 0;
                    foreach ($order_items as $key => $value) {
                        $product_price = $value->price;
                        if($mail_type == 'vendor') {
                            $product_price -= $value->included_shipping_price;
                        }
                        $product_line_total = $product_price * $value->quantity;
                        $product_total += $product_line_total;
                    ?>
                    <tr>
                        <td class="name" align="left" style="padding: 7px; border-color: #e0e0e0;">{{ $value->product->title }}</td>
                        <td class="detail" align="center" style="padding: 7px; border-color: #e0e0e0;">${{ number_format($product_price, 2) }}</td>
                        <td class="qty" align="center" style="padding: 7px; border-color: #e0e0e0;">{{ $value->quantity }}</td>
                        <td class="cost" align="right" style="padding: 7px; border-color: #e0e0e0;">${{ number_format($product_line_total, 2) }}</td>
                    </tr>
                    <?php } ?>
                    <!-- <tr>
                        <td class="name" align="left">Matcha Cream Puff Kit</td>
                        <td class="detail" align="center">$54.00</td>
                        <td class="qty" align="center">1</td>
                        <td class="cost" align="right">$54.00</td>
                    </tr> -->
                </tbody>
            </table>
            <?php //dd($payment_history); ?>
            <table width="100%" border="0" style="border-collapse:collapse" class="total-wrap" style="margin-bottom: 20px;">
                <tbody>
                    <tr>
                        <th style="text-align: right; padding: 7px;">Subtotal:</th>
                        <td style="text-align: right;">${{ number_format($product_total, 2) }}</td>
                    </tr>
                    <?php if($mail_type == 'vendor') { ?>
                        <tr style="border-top: 1px solid #999;">
                            <th style="text-align: right; padding: 7px;">Total:</th>
                            <th style="text-align: right; padding: 7px;">${{ number_format($product_total, 2) }}</th>
                        </tr>
                    <?php } else { ?>
                        <?php if($payment_history->discount_price > 0) { ?>
                        <tr>
                            <th style="text-align: right; padding: 7px;">Discount:</th>
                            <td style="text-align: right;">${{ number_format($payment_history->discount_price, 2) }}</td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th style="text-align: right; padding: 7px;">Processing Fee:</th>
                            <td style="text-align: right;">${{ number_format(($payment_history->amount - ($payment_history->product_amount - $payment_history->discount_price)), 2) }}</td>
                        </tr>
                        <tr style="border-top: 1px solid #999;">
                            <th style="text-align: right; padding: 7px;">Total:</th>
                            <th style="text-align: right; padding: 7px;">${{ number_format($payment_history->amount, 2) }}</th>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
                    

@endsection 