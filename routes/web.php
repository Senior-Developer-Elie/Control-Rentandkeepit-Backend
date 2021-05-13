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
                
                $firstPaymentDate_format = $firstPaymentDate;
                $firstPaymentDate_format = str_replace('-', '/',  $firstPaymentDate_format);
                
                $split_products = str_split($products, 55);
                $product_result_text = 'New ';
                $product_result_text .= $split_products[0];
                
                $idx = 0;
                for($idx === 0;  $idx  < count($split_products) - 1 ; $idx ++) 
                {
                    $addText = "<br>";
                    $i = 0;
                    for($i = 0; $i <= 80; $i++)
                        $addText .= '&nbsp;';

                    $product_result_text .= $addText;
                    $product_result_text .= $split_products[$idx + 1];
                }

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
                                ul, li {
                                    list-style-type: none;
                                }
                                p.MsoFooter, li.MsoFooter, div.MsoFooter{
                                    margin: 0cm;
                                    margin-bottom: 0001pt;
                                    font-size: 12.0 pt;
                                    text-align: left;
                                }
                                @page Section1{
                                    size: letter;
                                    margin: 1.5cm 1.5cm 1.5cm 1.5cm;
                                    font-family: Arial;
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
                                                    <span style="font-weight: bold;">Ref#: ' . $refKey . '</span>
                                                </div>
                                            </p>
                                            <p>
                                                Rent & Keep It Pty Ltd (ACN: 003 949 979) (Australian Credit License number 390807) of 41/464-480 Kent St, Sydney, NSW, 2000. 
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
                                                Rent & Keep It Pty Ltd (ACN 003 949 979) of 41/464-480 Kent St, Sydney, NSW, 2000&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">(“Provider”)</span>
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                <span style="font-weight: bold; font-size: 14px;">And</span>
                                            </div>
                                            <div>
                                                '. $customerName . ' of ' . $address . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel: ' . $phoneNumber . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;<span style="font-weight: bold;">(“Hirer”)</span>
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <hr>
                                                <span style="font-weight: bold; font-size: 14px;">GOODS:</span>
                                            </div>
                                            <div>
                                                The goods being hired are:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">' . $product_result_text . '</span><br>
                                                To be kept at:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $address . '       
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
                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        '. $term . '</span> commencing on the ' . $startDate_day . 'th day of ' . $startDate_month . ' ' . $startDate_year . ' (“commencement day”).
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                Amount of each repayment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;$' . $eachRepayment . '
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                Frequency of repayments&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;' . $frequency . '
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                Your First Payment Date is&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span style="font-weight: bold;">' . $firstPaymentDate_format . ' </span>
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                <span style="font-weight: bold;">The number of Payments under</span><br>
                                                <span style="font-weight: bold;">the lease is</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $leaseNumber . ' equal repayments
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                <span style="font-weight: bold;">The total amount of rental</span><br>
                                                <span style="font-weight: bold;">payable under the lease is &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;$' . $totalAmount . '</span>
                                            </div>

                                            <div style="margin-bottom: 8px;">
                                                <span style="font-weight: bold;">Early Termination fee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8 weeks of rental payments plus delivery fee for the return of the</span><br>
                                                <span style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;Goods unless a purchase price is negotiated</span>
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

                                        <br clear="all" style="page-break-before:always" />
                                        <img src="http://localhost:8000/heading.png" width="720" height="130" style="margin-top: -50px;">

                                        <div width="600" style="margin-top:50px;">
                                            <p style="text-align: center; margin-bottom: 70px;">
                                                <span style="font-size: 28px; font-weight: bold;"><u>TERMS AND CONDITIONS</u></span>
                                            </p>
                                            <p>
                                                <P>
                                                    <span style="font-size: 15px; font-weight: bold;">1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LEASE AGREEMENT</span>
                                                    <p style="margin-left: 35px;">
                                                        1.1&nbsp;&nbsp;&nbsp;&nbsp;We agree to lease the Goods to you on the terms and conditions set out in this Agreement.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        1.2&nbsp;&nbsp;&nbsp;&nbsp;We will not provide you with the Goods if:
                                                        <p style="margin-left: 70px;">
                                                            1.2.1&nbsp;&nbsp;&nbsp;you have not provided us with the documents and information we require with your Application;
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            1.2.2&nbsp;&nbsp;&nbsp;we assess that the lease will be unsuitable for you; or
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            1.2.3&nbsp;&nbsp;&nbsp;in our opinion, the information that you provided in your Application was inaccurate,<br> 
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;incomplete or was misleading or deceptive
                                                        </p>
                                                        <p style="margin-left: 35px;">
                                                            1.3&nbsp;&nbsp;&nbsp;&nbsp;The Agreement commences on the date set out in the Schedule and will run for the Term. If you are <br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;in default under this Agreement or we agreed to change the Payment schedule due to hardship, the<br> 
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Term of the agreement may be extended.  
                                                        </p>
                                                        <p style="margin-left: 35px;">
                                                            1.4&nbsp;&nbsp;&nbsp;&nbsp;We enter into this Agreement through an authorised credit representative as set out in the Schedule.<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The Rent & Keep It Pty Ltd authorised representative has the same rights as we do under this<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agreement in respect of collecting and or receiving Payments, managing the relationship with you and<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;enforcing the Agreement.  You must cooperate with the Rent & Keep It Pty Ltd<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;authorised representative at all times
                                                        </p>
                                                    </p>
                                                </P>
                                                <br>
                                                <p>
                                                    <span style="font-size: 15px; font-weight: bold;">2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PAYMENT </span>
                                                    <p style="margin-left: 35px;">
                                                        2.1&nbsp;&nbsp;&nbsp;&nbsp;You must make the Payments to us for the duration of the Term.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        2.2&nbsp;&nbsp;&nbsp;&nbsp;Your first Payment is due on or before the First Payment Date.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        2.3&nbsp;&nbsp;&nbsp;&nbsp;Subsequent Payments must be paid in advance at the frequency stated in the Schedule.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        2.4&nbsp;&nbsp;&nbsp;&nbsp;All Payments must be paid to us by:
                                                        <p style="margin-left: 70px;">
                                                            2.4.1&nbsp;&nbsp;&nbsp;Direct debit directly from Centrelink via the Centre pay facility; or
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            2.4.2&nbsp;&nbsp;&nbsp;Via direct debit from your bank; or
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            2.4.3&nbsp;&nbsp;&nbsp;Via direct deposit into our bank account, quoting your reference number
                                                        </p>
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        2.5&nbsp;&nbsp;&nbsp;&nbsp;You must complete and sign the relevant Direct Debit Authority or Centre pay forms.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        2.6&nbsp;&nbsp;&nbsp;&nbsp;If you fail to make a Payment by its due date or if the Goods are not able to be collected or returned,<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;we may apply default interest at the rate allowed under the Civil Procedure Act 2005 (NSW) will be<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;payable on any outstanding amounts accruing from the date of default (apply daily using the daily<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;percentage rate) until the Goods are recovered and or the amount owing is paid in full.    
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        2.7&nbsp;&nbsp;&nbsp;&nbsp;You may change the method that you wish to pay the Payments under the Agreement but you must<br> 
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;have in place alternative payment method or else you will be in default under this Agreement.      
                                                    </p>
                                                </p>
                                                <br>
                                                <p>
                                                    <span style="font-size: 15px; font-weight: bold;">3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;THE GOODS </span>
                                                    <p style="margin-left: 35px;">
                                                        3.1&nbsp;&nbsp;&nbsp;&nbsp;We represent and you acknowledge and agree that we either own the Goods or that we are<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;authorised by the owner of the Goods to enter into this lease agreement. Nothing in this Agreement,<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;shall be interpreted to vary the ownership of the leased Goods;  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        3.2&nbsp;&nbsp;&nbsp;&nbsp;If you have complied with all the terms and conditions of the Agreement, Rent & Keep It Pty Ltd may<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;in its sole and unfettered discretion, transfer title of the Goods to you or arrange for the transfer of the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goods to you or a person nominated by you, at the end of the Term  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        3.3&nbsp;&nbsp;&nbsp;&nbsp;You acknowledge that, subject to the Personal Property Security Act 2009 (PPSA), this Agreement<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;gives rise to a Security Interest (as defined in the PPSA) in the leased Goods. Either the owner of the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;leased Goods, we, or a person acting under our authority, may register a Security Interest in the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;leased Goods. You agree to do all things necessary to enable the owner of the leased Goods, us or<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;any person acting under our authority to effectively register the Security Interest and give the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;necessary notifications of such registration.    
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        3.4&nbsp;&nbsp;&nbsp;&nbsp;You assume the risk of the Goods from the date of delivery of the Goods to you and until the Goods<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;are returned to us.
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        3.5&nbsp;&nbsp;&nbsp;&nbsp;You must only use the Goods in accordance with their operating instructions ass issued by the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;manufacturer. You must not add or vary the functionality of the Goods unless we consent to it.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        3.6&nbsp;&nbsp;&nbsp;&nbsp;If you pay is the Payments on time for the Term, we warrant that you will have possession and<br> 
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;enjoyment of the goods.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        3.7&nbsp;&nbsp;&nbsp;&nbsp;The Goods are covered by a manufacturer’s warranty.  If the Goods are faulty you must advise us of<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;that fact and we will assist you in liaising with the manufacturer in order to repair the Goods.  We will<br> 
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;deal with the manufacturer directly if the manufacturer refuses to repair the Goods under the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;warranty.  Nothing in this clause shall limit your right under the Australian Competition and Consumer<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Act 2010 with respect to Goods. To the extent permitted by law, we limit our liability under this<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agreement to the resupply or the payment for the resupply of the Goods or the repair or the payment<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;for the repair of the Goods.    
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        3.8&nbsp;&nbsp;&nbsp;&nbsp;If it is determined that the Goods repairs are required because of your action and the warranty cannot<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;be relied upon then you will be liable for the repair of the Goods. 
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        3.9&nbsp;&nbsp;&nbsp;&nbsp;You must maintain possession of the Goods for the Term. If we ask, you must tell us the whereabouts<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;of the Goods. Failure to keep possession of the Goods or telling us the whereabouts of the Goods is a<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;breach of this Agreement.
                                                    </p>
                                                </p>
                                                <br>
                                                <p>
                                                    <span style="font-size: 15px; font-weight: bold;">4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LIABILITY</span>
                                                    <p style="margin-left: 35px;">
                                                        4.1&nbsp;&nbsp;&nbsp;&nbsp;You must take proper care of the Goods during the Term and keep them in good working condition<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;and in good repair.    
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        4.2&nbsp;&nbsp;&nbsp;&nbsp;You must use, service and maintain the Goods in accordance with the manufacturer’s instructions<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;and recommendations.    
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        4.3&nbsp;&nbsp;&nbsp;&nbsp;We will not accept any responsibility for loss, damage, destruction or theft of the Goods during the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Term.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        4.4&nbsp;&nbsp;&nbsp;&nbsp;You must arrange and keep the Goods insured against loss and all other normally insured risks for<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;their full replacement value during the Term. You must not do, or fail to do, anything which would<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;allow the insurer to refuse or reduce a claim, or enforce, conduct, settle or compromise any claim<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;without our consent. We are entitled to receive any amounts paid by an insurer relating to the Goods.<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If you receive such amounts, you hold those amounts on trust for us.     
                                                    </p>
                                                    
                                                    <p style="margin-left: 35px;">
                                                        4.5&nbsp;&nbsp;&nbsp;&nbsp;You must not without our prior written consent:
                                                        <p style="margin-left: 70px;">
                                                            4.5.1&nbsp;&nbsp;&nbsp;Sell, assign, sublet, let on hire or otherwise part with or attempt to part with the personal<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;possession of or otherwise deal with the Goods; or
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            4.5.2&nbsp;&nbsp;&nbsp;Change, alter, deface or conceal the Goods or make any addition to the Goods except<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;as required by this clause;
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            4.5.3&nbsp;&nbsp;&nbsp;Allow any pledge, mortgage, encumbrance, charge or lien of any kind to arise or remain<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;on the Goods or any part thereof.
                                                        </p> 
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        4.6&nbsp;&nbsp;&nbsp;&nbsp;The Hirer will be fully responsible at all times to Rent & Keep It Pty Ltd for any loss of or damage to<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the Goods however caused, fair wear and tear accepted.  Any Goods that are found to be faulty will<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;be replaced or repaired subject to the Goods’ manufacturer’s warranty, details of which can be<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;provided to the Hirer on request.
                                                    </p>
                                                </p>       
                                                <br>
                                                <p>
                                                    <span style="font-size: 15px; font-weight: bold;">5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INDEMNITY</span>
                                                    <p style="margin-left: 35px;">
                                                        5.1&nbsp;&nbsp;&nbsp;&nbsp;You shall be required to pay any reasonable collection, dishonour/re-presentation charges,<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;collection agency costs or legal fees incurred by us as a consequence of your breach of any<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;part of this Agreement.
                                                    </p>
                                                    
                                                    <p style="margin-left: 35px;">
                                                        5.2&nbsp;&nbsp;&nbsp;&nbsp;You will indemnity us and keep us indemnified in respect of:
                                                        <p style="margin-left: 70px;">
                                                            5.2.1&nbsp;&nbsp;&nbsp;Any loss or damage to the Goods; and
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            5.2.2&nbsp;&nbsp;&nbsp;Any claim, action, damage, loss, liability, cost, charge, expense or outgoing suffered<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;or incurred by us caused by you and/or any wilful, illegal or negligent act or omission by you. 
                                                        </p>
                                                    </p>
                                                    
                                                </p> 
                                                <br clear="all" style="page-break-before:always" /> 
                                                <p>
                                                    <span style="font-size: 15px; font-weight: bold;">6.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEFAULT</span>
                                                    <p style="margin-left: 35px;">
                                                        6.1&nbsp;&nbsp;&nbsp;&nbsp;If you are in default, we will issue you a default notice setting out your obligations to remedy the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;default within 30 days of the date of the default. If you fail to remedy the default within 30 days of<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;receiving a notice of default, we may: 
                                                        
                                                        <p style="margin-left: 70px;">
                                                            6.1.1&nbsp;&nbsp;&nbsp;terminate this Agreement;
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            6.1.2&nbsp;&nbsp;&nbsp;accelerate the repayment of the lease Payments; and
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            6.1.3&nbsp;&nbsp;&nbsp;list the default with a credit bureau.
                                                        </p>
                                                    </p>
                        
                                                    <p style="margin-left: 35px;">
                                                        6.2&nbsp;&nbsp;&nbsp;&nbsp;If we accelerate the lease Payments due to default, the total amount owing under the lease<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;agreement becomes due and payable immediately.  If a Default is lodged with a credit bureau, then<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the full amount owing on the lease will be listed with the credit bureau. The accelerated amount will be<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;provided to you as part of the default notices. 
                                                    </p>
                                                    
                                                    <p style="margin-left: 35px;">
                                                        6.3&nbsp;&nbsp;&nbsp;&nbsp;You will be in default of this Agreement if:
                                                        <p style="margin-left: 70px;">
                                                            6.3.1&nbsp;&nbsp;&nbsp;You do not comply with any of the terms and conditions of this Agreement;
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            6.3.2&nbsp;&nbsp;&nbsp;You do not make a Payment by its due date;
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            6.3.3&nbsp;&nbsp;&nbsp;We believe on reasonable grounds that you have induced us to enter into this Agreement with<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;you by false misrepresentations, fraud or any other deceptive manner; 
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            6.3.4&nbsp;&nbsp;&nbsp;The information that you provided us in your Application was inaccurate, incomplete or was<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;misleading or deceptive;  
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            6.3.5&nbsp;&nbsp;&nbsp;You become bankrupt, insolvent or commit an Act of Bankruptcy;  
                                                        </p>
                                                        <p style="margin-left: 70px;">
                                                            6.3.6&nbsp;&nbsp;&nbsp;You cease to have possession of the Goods.
                                                        </p>
                                                    </p>
                        
                                                    <p style="margin-left: 35px;">
                                                        6.4&nbsp;&nbsp;&nbsp;&nbsp;If you are in default and we terminated the Agreement, you must return the Goods to us in good<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;working order.  If you do not return the Goods to us, you will remain liable for the lease Payments until<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the Goods are returned.  We may need to gain access to your premises by seeking a court order to<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;repossess the Goods.  If that happens, enforcement costs will be added to the outstanding amount<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;under the Agreement.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        6.5&nbsp;&nbsp;&nbsp;&nbsp;If we commence an enforcement process against you, you may ask us to postpone the enforcement<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;due to hardship or other reason.  You must provide us with all the relevant information to enable us to<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;consider the request.  We will consider the request and respond to you within 21 days of your request.<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We do not have to comply with a request for postponement.
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        6.6&nbsp;&nbsp;&nbsp;&nbsp;If we agree to postpone the enforcement and or enter into a different Payment schedule, we will issue<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;you with a notice of variation of the Agreement.  
                                                    </p>
                                                </p>
                                                <br>
                                                <p>
                                                    <span style="font-size: 15px; font-weight: bold;">7.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EARLY TERMINATION</span>
                                                    <p style="margin-left: 35px;">
                                                        7.1&nbsp;&nbsp;&nbsp;&nbsp;You can terminate this Agreement at any time before the end of the Term by providing us with written<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;notice of your intention to return the Goods.  Termination of the Agreement before the expiry of the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Term is a breach of this Agreement
                                                    </p>
                                                </p>   
                                                <br clear="all" style="page-break-before:always" />
                                                <p>
                                                    <span style="font-size: 15px; font-weight: bold;">8.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CONSEQUENCES OF TERMINATION</span>
                                                    <p style="margin-left: 35px;">
                                                        8.1&nbsp;&nbsp;&nbsp;&nbsp;If this Lease Agreement is terminated pursuant to clause 6 or 7, you must immediately return the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goods to us in good working condition. You must also pay us the Early Termination Fee as set out in<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the Schedule.  If the Goods are not returned to us in good working order, the Hirer remains liable to<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;us for the full costs of the Goods.
                                                    </p>
                                                    
                                                    <p style="margin-left: 35px;">
                                                        8.2&nbsp;&nbsp;&nbsp;&nbsp;If you fail to return (or make available for collection) the Goods to us in accordance with clause 8.1, or<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;fail to return the Goods in good working condition, subject to your rights under the National Credit<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Code, we may:  
                                                        <p style="margin-left: 70px;">
                                                            8.2.1&nbsp;&nbsp;&nbsp;Enter the premises where the Goods are kept and take possession of same; and/or  (i)<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Require you to pay, by way of liquidated damages, the balance of Payments which we would<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;have received but for the termination; plus  (ii) The balance of all remaining Payments due<br>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;under this Agreement; plus  (iii) Any enforcement expenses.
                                                        </p>
                                                    </p>
                                                </p>
                                                <br/>
                                                <p>
                                                    <span style="font-size: 15px; font-weight: bold;">9.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STATEMENT OF ACCOUNTS AND CORRECTION OF ERRORS</span>
                                                    <p style="margin-left: 35px;">
                                                        9.1&nbsp;&nbsp;&nbsp;&nbsp;We will issue to you 2 types of statements.  We will issue to you a periodic statement of account not<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;later than 12 months from commencement date of the Agreement.  This statement will detail all the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payments and debits to your account and any adjustments made.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        9.2&nbsp;&nbsp;&nbsp;&nbsp;We will also issue you an end of lease statement no later than 90 days before the expiry of the Term.<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This statement will provide you with details concerning the end of the Agreement and what your rights<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;are with respect to the Goods.  The statement will also tell you if we are willing to negotiate the sale of<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the Goods to you and if so what the sale price is.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        9.3&nbsp;&nbsp;&nbsp;&nbsp;If you discover any error in a statement of account, you should advise us of the error without delay.<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We will look to remedy the error at the earliest opportunity and in any event no later than 30 days from<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the date of your notice.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        9.4&nbsp;&nbsp;&nbsp;&nbsp;You may request a statement of account from us at any time and we will issue you with such a<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;statement within 7 days of your request.  
                                                    </p>
                                                    <p style="margin-left: 35px;">
                                                        9.5&nbsp;&nbsp;&nbsp;&nbsp;You authorise us to complete any blanks or correct any errors in this Agreement or the Schedules<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;provided we subsequently notify you.      
                                                    </p>
                                                    
                                                </p>
                                                <br>
                                                <p>
                                                    <span style="font-size: 15px; font-weight: bold;">10.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HARDSHIP</span>
                                                    <p style="margin-left: 45px;">
                                                        10.1&nbsp;&nbsp;&nbsp;&nbsp;If you are experiencing difficulties in paying the Payments under this Agreement, you should notify us.<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We will collect relevant information from you in relation to your hardship which you must provide us.
                                                    </p>
                                                    <p style="margin-left: 45px;">
                                                        10.2&nbsp;&nbsp;&nbsp;&nbsp;If you are experiencing hardship we may agree:
                                                        <p style="margin-left: 85px;">
                                                            (a)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To extend the Term;  
                                                        </p>
                                                        <p style="margin-left: 85px;">
                                                            (b)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To reduce the Payments; or  
                                                        </p>
                                                        <p style="margin-left: 85px;">
                                                            (c)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To postpone or skip Payments.  
                                                        </p>
                                                    </p>
                                                    <br clear="all" style="page-break-before:always" />
                                                    <p style="margin-left: 45px;">
                                                        10.3&nbsp;&nbsp;&nbsp;&nbsp;If we amend the terms of this Agreement, we will issue you with notice setting out the change to the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agreement.  We do not have to agree to a variation of the Agreement on the ground of hardship.  We<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;must not amend the Agreement unless we consider that the variation will assist you in meeting your<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;obligations under the Agreement. 
                                                    </p>            
                                                </p>
                                                <br>
                                                <p>
                                                    <span style="font-size: 15px; font-weight: bold;">11.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GENERAL</span>
                                                    <p style="margin-left: 45px;">
                                                        11.1&nbsp;&nbsp;&nbsp;&nbsp;Our acceptance of any Payments after we become aware of an event of default or an event<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;constituting a repudiation of this Agreement by you will be without prejudice to our exercise of the<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;powers conferred upon us by this Agreement. The acceptance will not operate as an election by us<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;either to exercise or not to exercise any of our rights, powers or privileges under this Agreement.  
                                                    </p>
                                                    <p style="margin-left: 45px;">
                                                        11.2&nbsp;&nbsp;&nbsp;&nbsp;You cannot assign or transfer your rights or obligations under this Agreement without our express<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;prior written consent.  
                                                    </p>
                                                    <p style="margin-left: 45px;">
                                                        11.3&nbsp;&nbsp;&nbsp;&nbsp;We may, without your consent, assign novate or transfer any of its rights and obligations under, or<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;interest in, this Agreement to another person. If this Agreement has been assigned or transferred to a<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;person, a reference to “us”, “we” or “our” includes that person. That person may exercise our rights<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;under this Agreement.  
                                                    </p>
                                                    <p style="margin-left: 45px;">
                                                        11.4&nbsp;&nbsp;&nbsp;&nbsp;A statement in writing signed by a director, secretary or officer of ours stating the amount due or<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;owing by you to us, or any other act, matter or thing arising under this Agreement as at any date set<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;out in that statement will be prima facie evidence of the facts so stated.  
                                                    </p>
                                                    <p style="margin-left: 45px;">
                                                        11.5&nbsp;&nbsp;&nbsp;&nbsp;If any provision of this Agreement is or at any time becomes void or unenforceable the remaining<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;provisions will continue in full force and effect. All your obligations under this Agreement will survive<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the expiry or termination of this Agreement to the extent required for their full observance and<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;performance.
                                                    </p>
                                                    <p style="margin-left: 45px;">
                                                        11.6&nbsp;&nbsp;&nbsp;&nbsp;No failure or delay on our part to exercise any power or right under this Agreement will operate as a<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;waiver of that power or right.  
                                                    </p>
                                                    <p style="margin-left: 45px;">
                                                        11.7&nbsp;&nbsp;&nbsp;&nbsp;You must at your expense do any further act and execute any further document which we may<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;reasonably request in order to protect our title to the Goods and our rights, powers and remedies<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;under this Agreement.
                                                    </p>
                                                </p>
                                            </p>
                                        </div>
                                        
                                        <br clear="all" style="page-break-before:always" />
                                        <img src="http://localhost:8000/heading.png" width="720" height="130" style="margin-top: -50px;">

                                        <div width="600" style="margin-top:50px;">
                                            <p style="text-align: center; margin-bottom: 70px;">
                                                <span style="font-size: 24px; font-weight: bold;"><u>CREDIT GUIDE AND DISCLOSURE DOCUMENT UNDER THE</u><br>
                                                <u>NATIONAL CONSUMER CREDIT PROTECTION ACT 2009</u></span>
                                            </p>
                                            <p>
                                                Introduction
                                            </p>
                                            <br>
                                            <p>
                                                This Credit Guide tells you about:
                                            </p>
                                            <p>
                                                <ul>
                                                    <li>who we are </li>
                                                    <li>our obligations before entering into a contract with you  </li>
                                                    <li>how we resolve complaints</li>
                                                    <li>how we get paid </li>
                                                    <li>how you can contact us </li>
                                                </ul>
                                            </p>
                                            <br>
                                            <p>
                                                About us 
                                            </p>
                                            <br>
                                            <p>
                                                Name: RENT & KEEP IT PTY LTD (“we”, “us”, “our”)
                                            </p>
                                            <p>
                                                ACN: 003 949 979
                                            </p>
                                            <p>
                                                Address: Suite 560, 41/464-480 Kent St, Sydney, NSW, 2000
                                            </p>
                                            <p>
                                                Phone number: 1300 999 599
                                            </p>
                                            <p>
                                                Website: www.rentandkeepit.com.au 
                                            </p>
                                            <br>
                                            <p>
                                                We are an authorised credit provider (ACL 390807) under the National Consumer Credit Protection Act 2009.  We<br>
                                                facilitate the lease agreement between you, as the lessee, and Rent & Keep It Pty Ltd, as the lessor under the lease<br>
                                                agreement, and we administer and manage the lease agreement and the relationship with Rent & Keep It Pty Ltd.  
                                            </p>
                                            <br><br><br>
                                            <p>
                                                Assessment of unsuitability for credit – our obligations and your rights 
                                            </p>
                                            <p>
                                                Before we can provide credit to you, we are required to make an assessment as to whether the proposed credit is ‘not<br>
                                                unsuitable’ for you. To do this we must make reasonable inquiries about:  
                                            </p>
                                            <p>
                                                <ul>
                                                    <li>your requirements and objectives in relation to the credit;</li>
                                                    <li>your financial situation; and </li>
                                                    <li>any other relevant matters. </li>
                                                </ul>
                                            </p>
                                            <br>
                                            <p>
                                                We must also take reasonable steps to verify your financial situation. This will require you to provide certain<br>
                                                documents to us.
                                            </p>
                                            <br>
                                            <p>
                                                Requesting a copy of our assessment
                                            </p>
                                            <br>
                                            <p>
                                                Before entering into a credit contract, or at any time within 7 years of the date of the credit contract, you can request<br>
                                                a written copy of our assessment. There is no fee for requesting a copy of our assessment. If you ask to see our<br>
                                                assessment within the first 2 years of the credit contract, we will provide you with a written copy of our assessment<br>
                                                within 7 business days after we receive your request. Otherwise, we will provide you with a written copy of our<br>
                                                assessment within 21 business days after we receive your request. 
                                            </p>
                                            <br>
                                            <p>
                                                Resolving disputes 
                                            </p>
                                            <br>
                                            <p>
                                                If you have a concern or complaint about the service we provide to you, please contact us.  Call us on<br>
                                                1300 999 599 or Email us at info@rentandkeepit.com.au or Write to us at: 
                                            </p>
                                            <p>
                                                Complaints Department 
                                            </p>
                                            <p>
                                                Rent & Keep It Pty Ltd 
                                            </p>
                                            <p>
                                                Suite 560, 41/464-480 Kent St, Sydney, NSW, 2000 
                                            </p>
                                            <br>
                                            <p>
                                                We will acknowledge your complaint in writing within 24 hours of receipt and will provide you with a final response<br>
                                                within 45 days. 
                                            </p>
                                            <br>
                                            <p>
                                                We will endeavour to resolve your complaint quickly and fairly. Under the lease agreement with Rent & Keep It Pty<br>
                                                Ltd, if we are unable to resolve a dispute, you may request that Rent & Keep It Pty Ltd considers and assist in the<br>
                                                resolution of the dispute. Rent & Keep It Pty Ltd can be contacted on 1300 999 599. If you feel that your complaint has<br>
                                                not been dealt with to your satisfaction, you can contact the Australian Financial Complaints Authority (AFCA) of which<br>
                                                we are a member. 
                                            </p>
                                            <br><br>
                                            <p>
                                                Contact details for AFCA are as follows: 1800 931-678 (9am to 5pm weekdays) GPO Box 3 Melbourne Vic 3001 
                                            </p>
                                            <br>
                                            <p>
                                                How we get paid?
                                            </p>
                                            <br>
                                            <p>
                                                We provide you with credit assistance in relation to the proposed lease with Rent & Keep It Pty Ltd. Rent & Keep It Pty<br>
                                                Ltd is the lessor and credit provider under the lease agreement and we have entered into a referral services<br>
                                                agreement with Rent & Keep It. Under that agreement we are entitled to receive the lease repayments under the lease<br>
                                                agreement you will sign with Rent & Keep It Pty Ltd less the fees described below. 
                                            </p>
                                            <p>
                                                If you pay the lease repayments using EziDebit or Centrepay, we will collect the lease repayments and remit to Rent &<br>
                                                Keep It their fees.     
                                            </p>
                                            <br>
                                            <p>
                                                Privacy
                                            </p>
                                            <br>
                                            <p>
                                                We will collect your personal information in order for us to provide you with our services. We will limit the collection<br>
                                                and use of your information to the minimum we require to provide credit to you. We are committed to ensuring the<br>
                                                confidentiality and security of the personal information of our clients, and to complying with the Privacy Act 1988 (Cth).<br>
                                                The Privacy Policy detailing our handling of personal information is available on our website at<br>
                                                www.rentandkeepit.com.au. If you do not provide some or all of the personal information requested on our application<br>
                                                form, we may not be able to accept your application and provide you with credit. We will not provide your information<br>
                                                to any third party other than in accordance with our Privacy Policy. We will always maintain control over the<br>
                                                confidentiality of your personal information.
                                            </p>
                                        </div>

                                        <br clear="all" style="page-break-before:always" />
                                        <img src="http://localhost:8000/heading.png" width="720" height="130" style="margin-top: -50px;">

                                        <div width="600" style="margin-top:50px;">
                                            <p style="text-align: center; margin-bottom: 70px;">
                                                <span style="font-size: 28px; font-weight: bold;"><u>INFORMATION STATEMENT</u></span>
                                            </p>
                                            <p>
                                                Things you should know about your consumer lease.
                                            </p>
                                            <p>
                                                This statement tells you about some of the rights and obligations of yourself and your lessor. It does not state the<br>
                                                terms and conditions of your lease.  
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">THE LEASE</span>
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;How can I get details of my lease?
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your lessor must give you a copy of your consumer lease with this statement. Both documents must be given<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to you within 14 days after the lessor enters into the consumer lease, unless you already have a copy of the<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;consumer lease.  
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If you want another copy of your lease write to your lessor and ask for one. Your lessor may charge you a fee.<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your lessor has to give you a copy:
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;within 14 days of your written request if the contract came into existence 1 year<br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;or less before your request; or  
                                                </p>
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;otherwise within 30 days.
                                                </p>
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;What should my lease tell me?
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You should read your lease carefully.
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your lease should tell you about your obligations, and include information on matters such as:
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;details of the goods which have been hired; and  
                                                </p>
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;any amount you have to pay before the goods are delivered; and 
                                                </p>
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;stamp duty and other government charges you have to pay; and 
                                                </p>
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;charges you have to pay which are not included in the rental payments; and   
                                                </p>
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the amount of each rental payment; and 
                                                </p>
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the date on which the first rental payment is due and either the dates of the other rental payments or<br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the interval between them; and 
                                                </p>
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the number of rental payments; and   
                                                </p>
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the total amount of rent; and 
                                                </p>
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;when you can end your lease; and 
                                                </p>
                                                <p>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;what your obligations are (if any) when your lease ends.
                                                </p>
                                            </p>
                                            <br/>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This information only has to be included in your lease if it is possible to give it at the relevant times.  
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If your lease does not tell you all these details, contact your credit provider’s external dispute resolution<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;scheme, or get legal advice, for example from a community legal centre or Legal Aid, as you may have rights<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;against your lessor. 
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Can I end my lease early?
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes. Simply return the goods to your lessor. The goods may be returned in ordinary business hours or at any<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;other time you and the lessor agree on or the court decides.  
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;What will I have to pay if I end my lease early?
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The amount the lease says you have to pay.
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If you have made rental payments in advance then it is possible that your lessor might owe you money if you<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return the goods early.  
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Can my lease be changed by my lessor?
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes, but only if your lease says so.
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    6.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Is there anything I can do if I think that my lease is unjust?
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes. You should talk to your lessor. Discuss the matter and see if you can come to some arrangement.  
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If that is not successful, you may contact your credit provider’s external dispute resolution scheme.
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EXTERNAL DISPUTE RESOLUTION IS A FREE SERVICE ESTABLISHED TO PROVIDE YOU WITH AN<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INDEPENDENT MECHANISM TO RESOLVE SPECIFIC COMPLAINTS. YOUR CREDIT PROVIDER’S<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EXTERNAL DISPUTE RESOLUTION PROVIDER IS AFCA AND CAN BE CONTACTED AT 1800 931 678 or<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WWW.AFCA.ORG.AU.  
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alternatively, you can go to court. You may also wish to get legal advice, for example from a community legal<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;centre or Legal Aid, and/or make a complaint to ASIC. ASIC can be contacted on 1300 300 630 or through<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASIC’s website at http://www.asic.gov.au.  
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">THE GOODS</span>
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    7.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If my lessor writes asking me where the goods are, do I have to say where they are?  
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes. You have 7 days after receiving your lessor’s request to tell your lessor. If you do not have the goods you<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;must give your lessor all the information you have so they can be traced.  
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    8.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;When can my lessor or its agent come into a residence to take possession of the goods?    
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your lessor can only do so if it has the court’s approval or the written consent of the occupier which is given<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;after the occupier is informed in writing of the relevant section in the National Credit Code.  
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">GENERAL</span>
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    9.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;What do I do if I cannot make a rental payment?  
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Get in touch with your lessor immediately. Discuss the matter and see if you can come to some arrangement.
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You can ask your lessor to change your lease in a number of ways:
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to extend the term of your lease and reduce rental payments; or 
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to extend the term of your lease and delay rental payments for a set time; or   
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to delay rental payments for a set time.   
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    10.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;What if my lessor and I cannot agree on a suitable arrangement?    
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If the lessor refuses your request to change the rental payments, you can ask your lessor to review<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;this decision if you think it is wrong.  
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If the lessor still refuses your request, you can complain to the external dispute resolution scheme that your<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;lessor belongs to. Further details about this scheme are set out below in question 12. 
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    11.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Can my lessor take action against me?    
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes, if you are in default under your lease. But the law says that you cannot be unduly harassed or threatened<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;for rental payments. If you think you are being unduly harassed or threatened, contact your credit provider’s<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;external dispute resolution scheme or ASIC, or get legal advice.  
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">
                                                    12.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Do I have any other rights and obligations?   
                                                </span>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes. The law will give you other rights and obligations. You should also READ YOUR LEASE carefully.
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IF YOU HAVE ANY DOUBTS, OR WANT MORE INFORMATION, CONTACT YOUR CREDIT PROVIDER.<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;YOU MUST ATTEMPT TO RESOLVE YOUR COMPLAINT WITH YOUR CREDIT PROVIDER BEFORE<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CONTACTING YOUR CREDIT PROVIDER’S EXTERNAL DISPUTE RESOLUTION SCHEME. IF YOU HAVE<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A COMPLAINT WHICH REMAINS UNRESOLVED AFTER SPEAKING TO YOUR CREDIT PROVIDER YOU<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CAN CONTACT YOUR CREDIT PROVIDER’S EXTERNAL DISPUTE RESOLUTION SCHEME OR GET<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LEGAL ADVICE.
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PLEASE KEEP THIS INFORMATION STATEMENT. YOU MAY WANT SOME INFORMATION FROM IT AT<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A LATER DATE.
                                            </p>
                                        </div>
                                        
                                        <br clear="all" style="page-break-before:always" />
                                        <img src="http://localhost:8000/heading.png" width="720" height="130" style="margin-top: -50px;">
                        
                                        <div width="600" style="margin-top:50px;">
                                            <p style="text-align: center; margin-bottom: 70px;">
                                                <span style="font-size: 28px; font-weight: bold;"><u>Dispute Resolution</u></span>
                                            </p>
                                            <p>
                                                If you have a complaint about your contract or your dealings with us, you should contact us to see if your complaint<br>
                                                can be resolved simply and quickly.  
                                            </p>
                                            <p>
                                                <span style="font-weight: bold;">How do I lodge a complaint? </span>
                                            </p>
                                            <p>
                                                You can provide us with details of your complaint in any of the following ways: 
                                            </p>
                                            <p>
                                                By telephone: 1300 999-599
                                            </p>
                                            <p>
                                                By Fax: (02) 94750995	
                                            </p>
                                            <p>
                                                By email: info@rentandkeepit.com.au
                                            </p>
                                            <p>
                                                By letter to:
                                            </p>
                                            <p>
                                                Customer Feedback<br> 
                                                Rent & Keep It Pty Ltd<br>
                                                Suite 560/41,<br>
                                                464-480 Kent Street<br>
                                                SYDNEY NSW, 2000<br>
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">Initial Resolution</span>
                                            </p>
                                            <p>
                                                We will endeavour to resolve your complaint by the end of the business day after the complaint is received.  
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">What happens if my complaint is not resolved?</span>
                                            </p>
                                            <p>
                                                If your complaint is not resolved by the end of the business day after it is received then the complaint will be referred<br>
                                                to the Rent & Keep It Pty Ltd Disputes Manager for review.  
                                            </p>
                                            <br clear="all" style="page-break-before:always" />
                                            <p>
                                                <span style="font-weight: bold;">When will I receive the details of the outcome of my complaint?</span>
                                            </p>
                                            <p>
                                                Complaints will be addressed within 14 days of receipt by Rent & Keep It Pty Ltd or where the complaint involves a<br>
                                                default notice within 7 days.  
                                            </p>
                                            <p>
                                                We will notify you in writing both at the time the complaint is referred and once a determination of the complaint has<br>
                                                been made. Where either financial or non-financial redress is offered shall be disclosed in the determination letter. 
                                            </p>
                                            <p>
                                                Rent & Keep It Pty Ltd aims to settle all complaints fairly and promptly. Should your complaint could not be resolved in<br>
                                                your favour, you will be provided with details of the basis upon which Rent & Keep It Pty Ltd came to its decision and<br>
                                                your rights regarding the decision.  
                                            </p>
                                            <br>
                                            <p>
                                                <span style="font-weight: bold;">What if I am not happy with the decision? </span>
                                            </p>
                                            <p>
                                                If your complaint has gone through the Rent & Keep It Pty Ltd complaint procedure and has not been resolved to your<br>
                                                satisfaction you have the right to take your complaint to an External Dispute Resolution (EDR) Scheme.  
                                            </p>
                                            <p>
                                                Rent & Keep It Pty Ltd is a member of the Australian Financial Complaints Authority (AFCA), they are independent<br>
                                                EDR Schemes approved by the Australian Securities and Investments Commission.  
                                            </p>
                        
                                            <p>
                                                Your complaint must be lodged with AFCA within three (3) months of our decision.
                                            </p>
                                            <p>
                                                AFCA can be contacted by:
                                            </p>
                                            <p>
                                                Telephone on 1800 931 678 (9.00am-5.00pm, Monday to Friday, Sydney time);     
                                            </p>
                                            <p>
                                                By email to info@afca.org.au; or
                                            </p>
                                            <p>
                                                By submitting your complaint online at www.afca.org.au  
                                            </p>
                                        </div>

                                        <div style="mso-element:footer" id="f1">
                                            <p class=MsoFooter>
                                                &nbsp;
                                            </p>
                                        </div>
                                    </div>
                                </body>
                            </html>';
                
                return \Response::make($content, 200, $headers);

});

Route::get('/statement/{id}',  [\App\Http\Controllers\StatementManagementController::class, 'generatePDF']);
