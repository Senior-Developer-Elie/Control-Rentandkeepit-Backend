<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::get('/', [\App\Http\Controllers\ApiDocsController::class, 'index']);

Route::get('/download/{refKey}/{customerName}/{address}/{phoneNumber}/{postCode}/{products}/{term}/{startDate_day}/{startDate_month}/{startDate_year}/{eachRepayment}/{firstPaymentDate}/{frequency}/{leaseNumber}/{totalAmount}
', 
            
            function($refKey, $customerName, $address, $phoneNumber, 
                     $postCode, $products, $term, $startDate_day, 
                     $startDate_month, $startDate_year, $eachRepayment, 
                     $firstPaymentDate, $frequency, $leaseNumber, $totalAmount) {

                $headers = array(
                    "Content-type"=>"text/html",
                    "Content-Disposition"=>"attachment;Filename=Rent & Keep It Lease Schedule(" . $customerName . ").doc"
                );
                $image = URL::to('heading.png'); //"http://localhost:8000/heading.png";

                $content = '<html
                            xmlns:o="urn:schemas-microsoft-com:office:office"
                            xmlns:w="urn:schemas-microsoft-com:office:word"
                            xmlns="http://www.w3.org/TR/REC-html40">
                            <head>
                            <meta charset="utf-8">
                            <xml>
                                <w:WordDocument>
                                    <w:View>Print</w:View>
                                    <w:Zoom>90</w:Zoom>
                                    <w:DoNotOptimizeForBrowser/>
                                </w:WordDocument>
                            </xml>
                            <!-- [endif]-->
                            <style>
                                p.MsoFooter, li.MsoFooter, div.MsoFooter{
                                    margin: 0cm;
                                    margin-bottom: 0001pt;
                                    mso-pagination:widow-orphan;
                                    font-size: 12.0 pt;
                                    text-align: left;
                                }
                                @page Section1{
                                    size: letter;
                                    margin: 1.5cm 1.5cm 1.5cm 1.5cm;
                                    mso-page-orientation: portrait;
                                    mso-footer:f1;
                                }
                                div.Section1 { page:Section1;}
                            </style>
                            </head>
                                <body>
                                    <div class="Section1" style="font-size: 13px; margin: 5px;">
                                        <img src="http://localhost:8000/heading.png" width="720" height="130" style="margin-top: -50px;">
                                        <div style="border-color: black; border-style: solid; padding: 10px; border-width: 2px;" width="600">
                                            <p style="text-align: center;">
                                                <span style="font-size: 20px; font-weight: bold; color: blue;">SCHEDULE <br>LEASE AGREEMENT</span><br>
                                                <div style="text-align: right;">
                                                    <span style="font-weight: bold;">ref#: ' . $refKey . '</span>
                                                </div>
                                            </p>
                                            <p>
                                                Rent & Keep It Pty Ltd (ACN: 003 949 979) (Australian Credit License number 390807) of 41/464-480 Kent St, Sydney, NSW 2000. 
                                                Tel: 1300 999 599 Fax: (02) 9475 0995 (“provider”) agrees to 
                                                lease to the “Hirer” the Goods described below on the terms and conditions contained in this Schedule and the document titled Terms & Conditions. 
                                            </p>
                                            <p>
                                                The Lease Agreement between Rent & Keep It Pty Ltd/Provider and the Hirer consist of the following documents;
                                            </p>
                                            <p>
                                                a.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;this Schedule;<br>
                                                b.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the document titled Terms and Conditions; and<br>
                                                c.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;any direct debit agreement as executed by the Hirer from time to time.<br>
                                            </p>
                                            <div style="margin-bottom: 8px;">
                                                <span style="font-weight: bold; font-size: 14px;">This Lease Agreement is between:</span>
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                Rent & Keep It Pty Ltd (ACN 003 949 979) of 41/464-480 Kent St, Sydney, NSW 2000&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">(“Provider”)</span>
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                <span style="font-weight: bold; font-size: 14px;">And</span>
                                            </div>
                                            <div>
                                                [ '. $customerName . ' ] of [ ' . $address . ' ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel: [ ' . $phoneNumber . ' ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">(“Hirer”)</span>
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <hr>
                                                <span style="font-weight: bold; font-size: 14px;">GOODS:</span>
                                            </div>
                                            <div>
                                                The goods being hired are:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">New ' . $products . '</span><br>
                                                To be kept at:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[ ' . $address . ' ]      
                                            </div>
                                            <hr >
                                            
                                            <p>
                                                <span style="font-weight: bold; font-size: 14px;">THE LEASE AGREEMENT – </span><span style="font-weight: bold;">Summary of financial Information: </span>
                                            </p>
                                            <div style="margin-bottom: 8px;">
                                                <span style="font-weight: bold;">Term&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        '. $term . '</span> commencing on the ' . $startDate_day . ' day of ' . $startDate_month . ' ' . $startDate_year . ' (“commencement day”).
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                Amount of each repayment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$' . $eachRepayment . '
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                Frequency of repayments&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $frequency . '
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                Your First Payment Date is&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;<span style="font-weight: bold;">[' . $firstPaymentDate . '] </span>
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                <span style="font-weight: bold;">The number of Payments under</span><br>
                                                <span style="font-weight: bold;">the lease is</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $leaseNumber . ' equal repayments
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                <span style="font-weight: bold;">The total amount of rental</span><br>
                                                <span style="font-weight: bold;">payable under the lease is &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$' . $totalAmount . '</span>
                                            </div>

                                            <div style="margin-bottom: 8px;">
                                                <span style="font-weight: bold;">Early Termination fee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8 weeks of rental payments plus delivery fee for the return of the Goods unless </span><br>
                                                <span style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a purchase price is negotiated</span>
                                            </div>
                                            <br>
                                        </div>              
                                        <br><br>
                                        <div>
                                            <span style="font-weight: bold;">Owner of Goods</span>
                                        </div>
                                        <div style="border-color: black; border-style: solid; padding: 10px; border-width: 2px; margin-bottom: 20px;" width="600">
                                            <span style="font-weight: bold;">
                                                Rent & Keep It Pty Ltd is the owner of the Goods or is authorized to lease the Goods to you. 
                                                This lease <br>agreement is not an offer by Rent & Keep It Pty Ltd to pass ownership of the Goods to you nor is it an agreement to purchase the Goods by 
                                                installments. Your rights at the end of the lease will be described in the end of lease statement or you can ask us at any time. 
                                            </span>
                                        </div>

                                        <div style="border-color: black; border-style: solid; padding: 10px; border-width: 2px; margin-bottom: 20px;" width="600">
                                            <P>
                                                By signing this Agreement, the Hirer acknowledges that they have received, read and agree with:
                                            </P>
                                            <p>
                                                a.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the Lease Terms & Conditions and this Schedule;<br>
                                                b.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rent & Keep It Pty Ltd Credit Guide; and<br>
                                                c.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Information Statement.<br>
                                            </p>
                                            <p style="background-color: yellow;">
                                                The hirer also authorizes Rent & Keep It Pty Ltd, and/or its authorised representative, 
                                                to complete any blanks or correct any errors in this Rental Agreement (including but not limited to, leased equipment, serial numbers, model numbers, the Start Date and Payment Date).
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold; font-size: 14px;">SIGNED AND ACCEPTED BY THE HIRER</span>
                                            </p>
                                            <div style="margin-bottom: 13px;">
                                                Signed by the Hirer:
                                            </div>
                                            <div style="margin-bottom: 13px;">
                                                Signature:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                Signature:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________
                                            </div>
                                            <div style="margin-bottom: 13px;">
                                                Print Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; __________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                Print Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; __________________________
                                            </div>
                                            <div style="margin-bottom: 13px;">
                                                Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; __________________________ 
                                            </div>
                                            <p>
                                                If more than one Hirer signing this Schedule, each Hirer is severally and jointly liable for the lease repayments.
                                            </p>
                                        </div>
                                        
                                        <div style="border-color: black; border-style: solid; padding: 10px; border-width: 2px; " width="600">
                                            <p style="background-color: yellow; width: 420px;">
                                                <span style="font-weight: bold; font-size: 14px;">&nbsp;&nbsp;REFERENCE 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REFERENCE 2
                                                </span>
                                            </p>
                                            <div style="margin-bottom: 13px; background-color: yellow; width: 570px;">
                                                Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________
                                            </div>
                                            <div style="margin-bottom: 13px; background-color: yellow;  width: 570px;">
                                                Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________
                                            </div>
                                            <div style="margin-bottom: 13px; background-color: yellow;  width: 570px;">
                                                Address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                Address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________
                                            </div>
                                            <div style="margin-bottom: 13px; background-color: yellow;  width: 570px;">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________
                                            </div>
                                            <br>
                                            <div style="margin-bottom: 13px; background-color: yellow; width: 570px;">
                                                Relation:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                Relation:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________
                                            </div>
                                        </div>
                                        
                                        <br clear=all style="mso-special-character:line-break;page-break-after:always" />
                                        <div style="mso-element:footer" id="f1">
                                            <p class=MsoFooter>
                                                Page <span style="mso-field-code:" PAGE "">1</span>
                                            </p>
                                        </div>
                                    </div>
                                </body>
                            </html>';
                
                return \Response::make($content, 200, $headers);

});
