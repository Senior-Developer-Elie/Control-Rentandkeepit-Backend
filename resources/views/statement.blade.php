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
        <img src="{{ public_path('statement.png') }}" width="680" height="150">
    </div>
    <div class="content">
        <div class='title'>
            <h2>Account Statement</h2>
        </div>
        <div class="body-content">
            <p>
                Sherrie Lynwood<br>
                3/20 Graff Ave<br>
                Toormina<br>
                NSW 2452    
            </p>
            <p>
                Customer account statement as of 28/12/2018<br>
                Client Number: 18309<br>
                For dates: 12/05/2018-28/12/2018
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
                @for($i = 0; $i < 4; $i++)
                <tr style="font-weight: none;">
                    <td>26994</td>
                    <td>21/07/2018</td>
                    <td>26/08/2020</td>
                    <td>New Heller Sise By Side
                        S/Steel Refrigerator with
                        Water Dispenser -
                        HSBS562W</td>
                    <td>24 Months</td>
                    <td>2</td>
                    <td>$70.00</td>
                    <td>$192.00</td>
                    <td>$3,448.00</td>
                    <td>Open</td>
                </tr>
                @endfor

                <tr>
                    <td colspan="7">&nbsp;&nbsp;&nbsp;Total</td>
                    <td>$750.00</td>
                    <td>$7,414.00</td>
                    <td></td>
                </tr>
            </table><br>
            <span style="font-weight: bold;">Payment History<span>
            <table width="100%">
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Paid to #24079</th>
                    <th>Paid to #25557</th>
                    <th>Paid to #26303</th>
                    <th>Paid to #26994</th>
                </tr>
                <tr style="font-weight: none;">
                    <td>16/05/2018</td>
                    <td colspan="5" style="font-weight: bold;">Contract started: 'Bundle of 2 x New Samsung Galaxy Tab A 8.0 WiFi 16GB (BLACK) - SM-T380NZKAXSA'</td>
                </tr>
                <tr style="font-weight: none;">
                    <td>16/05/2018</td>
                    <td>Payment: $48.00</td>
                    <td>$48.00</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="font-weight: none;">
                    <td>16/05/2018</td>
                    <td colspan="5" style="font-weight: bold;">Contract started: 'Bundle of 2 x New Samsung Galaxy Tab A 8.0 WiFi 16GB (BLACK) - SM-T380NZKAXSA'</td>
                </tr>
                <tr style="font-weight: none;">
                    <td>16/05/2018</td>
                    <td>Payment: $48.00</td>
                    <td>$48.00</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;Total</td>
                    <td>$120.00</td>
                    <td>$120.00</td>
                    <td>$120.00</td>
                    <td>$120.00</td>
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
                <span style="font-weight: none;">the Direct Appliance Rentals Team</span>
            </p>

            <p>
                <span style="font-weight: none;">Website:  <a href="#">www.directappliancerentals.com.au</a></span><br>
                <span style="font-weight: none;">Facebook:  <a href="#">www.facebook.com/directappliancerentals</a></span>
            </p>
            
        <div>
    </div>

</div>
