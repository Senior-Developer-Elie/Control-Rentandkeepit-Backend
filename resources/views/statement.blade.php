<style>
    .logo-image {
        margin-top: -30px;
    }
    .statement {
        font-family : Arial, Helvetica, sans-serif;
    }
    .content {
        margin-top: -20px;
    }
    .body-content {
        font-size : 10px;
        margin-left : 15px;
    }
    .title {
        text-align: center;
    }
    table, th, td {
        margin: 0px;
        padding: 1px;
        border: 0.8px solid rgb(15, 70, 141);
        border-collapse: collapse;
        font-size : 10px;
    }
    th, td {
        padding: 2px;
        text-align: left;
        font-size : 10px;    
    }
</style>
<div class="statement">
    <div class="logo-image">
        <img src="{{ public_path('heading.png') }}" width="720" height="130">
    </div>
    <div class="content">
        <div class='title'>
            <h2>Account Statement</h2>
        </div>
        <div class="body-content">
            <p>
                {{$customer_name}}<br>
                {{$customer_address}}<br>
                {{$customer_city}}<br>
                {{$customer_state}}   
            </p>
            <p>
                Customer account statement as of {{$today}}<br>
                Client Number: {{$customerId}}<br>
                For dates: {{$start_date_min}} - {{$expriy_date_max}}
            </p><br>

            <span style="font-weight: bold;">Open Contract Summery<span>
            <table width="100%">
                <tr>
                    <th>ID</th>
                    <th>Date Started</th>
                    <th>Expiry Date</th>
                    <th>Product Name</th>
                    <th>Term</th>
                    <th>No of Instalments Paid</th>
                    <th>Instalment Amount</th>
                    <th>Amount Received</th>
                    <th>Total Outstanding</th>
                    <th>Status</th>
                </tr>
                @php
                    $totalRecived = 0;
                    $totalOutstanding = 0;
                @endphp
                
                @foreach($orderList as $order)

                @php
                    $totalRecived += $order['total_recived'];
                    $totalOutstanding += $order['total_outstanding'];
                @endphp

                <tr style="font-weight: none;">
                    <td>{{ $order['id'] }}</td>
                    <td>{{ $order['start_date'] }}</td>
                    <td>{{ $order['expiry_date'] }}</td>
                    <td>{{ $order['product_name'] }}</td>
                    <td>{{ $order['term_length'] }}</td>
                    <td>{{ $order['no_payment'] }}</td>
                    <td>${{ $order['instalment'] }}</td>
                    <td>${{ $order['total_recived'] }}</td>
                    <td>${{ $order['total_outstanding'] }}</td>
                    <td>{{ $order['status'] }}</td>
                </tr>
                
                @endforeach

                <tr>
                    <td colspan="7">&nbsp;&nbsp;&nbsp;Total</td>
                    <td>${{ $totalRecived }}</td>
                    <td>${{ $totalOutstanding }}</td>
                    <td></td>
                </tr>
            </table><br>

            <span style="font-weight: bold;">Payment History<span>
            <table width="100%">
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    @php
                    $total_amount = array();
                    @endphp
                    @foreach($orderList as $order)
                    @php
                    $total_amount['paid_' . $order['id']] = 0;
                    @endphp
                    <th>Paid to #{{$order['id']}}</th>
                    @endforeach
                </tr>
 
                @foreach($paymentList as $payment)
                    
                    @if($payment['is_contract'] == 1)
                    <tr style="font-weight: none;">
                        <td>{{ $payment['date'] }}</td>
                        <td colspan="{{ $orderLength + 1 }}" style="font-weight: bold;">{{ $payment['description'] }}</td>
                    </tr>
                    @else
                    <tr style="font-weight: none;">
                        <td>{{ $payment['date'] }}</td>
                        <td>{{ $payment['description'] }}</td>
                        @foreach($orderList as $order)
                        @php
                            $total_amount['paid_' . $order['id']] += $payment['paid_' . $order['id']];
                        @endphp
                        <td>${{ $payment['paid_' . $order['id']] }}</td>
                        
                        @endforeach                    
                    </tr>
                    @endif

                @endforeach

                <tr>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;Total</td>
                    @foreach($orderList as $order)
                    <td>${{ $total_amount['paid_' . $order['id']] }}</td>
                    @endforeach   
                </tr>
            </table>
            <p><span style="font-weight: bold;">How to Own The Goods<span></p>
            <p>
                <span style="font-weight: bold;">During the Lease<span><br>
                <span style="font-weight: none;">You can make an offer to acquire the goods at any time.</span><br>
                <span style="font-weight: none;">Just call Direct Appliance Rentals and we will let you know the nominal value of the goods at that point in time.</span>
            </p>

            <p>
                <span style="font-weight: bold;">End of lease<span><br>
                <span style="font-weight: none;">We will send you a Contract Completion notice at the conclusion of the lease and this will detail our willingness to negotiate the sale of the leased goods</span>
                <span style="font-weight: none;">and the nominal value of the goods. Typically, if your contract is up-to-date at the end of the lease, we estimate the sale price of the goods to be no more</span>
                <span style="font-weight: none;">than $1.00.</span>
            </p>
            <br>
            <p>
                <span style="font-weight: none;">Warmest Regards,</span><br>
                <span style="font-weight: none;">the RentandKeepIt Team</span>
            </p>

            <p>
                <span style="font-weight: none;">Website:  <a href="#">www.rentandkeepit.com.au</a></span><br>
                <span style="font-weight: none;">Facebook:  <a href="#">www.facebook.com/rentandkeepit</a></span>
            </p>
            
        <div>
    </div>

</div>
