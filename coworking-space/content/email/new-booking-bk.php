     <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">
            <!-- START CENTERED WHITE CONTAINER -->
            <table role="presentation" class="logo" style="margin-bottom:0;">
              <tbody>
                <tr>
                  <td>                    
                  <img src="http://intellideskcoworking.com/wp-content/uploads/2024/09/intellidesk-logo.jpg" alt="Intellidesk Coworking Space" width="220" height="40" class="" alt="Intellidesk Coworking logo">
                  </td>
                </tr>
              </tbody>
            </table>
            <table role="presentation" class="main">
              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="">
                  
                   <table class="" width="100%" align="center" border="0" >
                      <tr>
                        <td>
                          <p>Dear Mr./Ms. <?php echo $user->last_name.' '.$user->last_name;?>,</p>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <?php if($$non_bookable) {
                            echo '<p>We received your booking request and it is now being processed. You are now one step closer to securing your' . $booking->space->post_title .' with us.</p>';
                          } else {
                            echo '<p>Thank you for your inquiry, we will get in touch with you as soon as possible.</p>';
                          }?>
                          
                        </td>
                        
                      </tr>
                      <tr>
                        <td>
                          <h3><strong>Booking Details</strong></h3>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <table cellpadding="0" border="1">
                            <tr>
                              <td><strong>Company Name</strong>:</td>
                              <td><?php echo $user->company;?></td>
                            </tr>
                            <tr>
                              <td><strong>Authorized Person</strong>:</td>
                              <td><?php echo $user->first_name .' ' .$user->last_name;?></td>
                            </tr>
                            <tr>
                              <td><strong>Phone</strong>:</td>
                              <td><?php echo $user->phone;?></td>
                            </tr>
                            <tr>
                              <td><strong>Start Date</strong>:</td>
                              <td><?php echo $booking->start_date;?></td>
                            </tr>
                            <tr>
                              <td><strong>Room Type</strong>:</td>
                              <td><?php echo $booking->space->post_title;?></td>
                            </tr>
                            <tr>
                              <td><strong>Time</strong>:</td>
                              <td><?php //echo $booking->space->post_title;?></td>
                            </tr>
                            <tr>
                              <td><strong>Rate</strong>:</td>
                              <td><?php echo number_format($booking->get_base_rate(), 2, '.',',');?></td>
                            </tr>
                            <tr>
                              <td><strong>Occupancy</strong>:</td>
                              <td><?php echo $booking->space->seats.' seater';?></td>
                            </tr>
                            <tr>
                              <td><strong>Inclusions</strong>:</td>
                              <td>
                                <ul>
                                    <?php foreach ($space_inclusions as $item):?>
                                      <li><?php echo $item['txt'];?></li>
                                    <?php endforeach;?>
                                  </ul>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>                      
                      <tr>
                        <td align="center" style="">
                          <table border="0" class="wrapper" style="margin-bottom:0;">
                            <tr>
                              <td>
                                <?php
                                  if($booking->space->price_type == 'daily') {
                                   
                                  } else {
                                   
                                  }
                                  ?>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>Any electrical equipment brought in by contractors or members must undergo a safety check by our technicians and clients must secure a gate pass from Parkway Corporate Center. Costs for any necessary replacements will be charged to the member.</td>
                      </tr>
                      <tr>
                        <td>
                          <h3 style="margin-bottom: 0;">Ocular Visit</h3>
                          We would be happy to arrange a site visit at your convenience. Please let us know your preferred date and time.
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <h3 style="margin-bottom: 0;">Set-Up</h3>
                          Standard set-up time is one (1) hour before the event. Any additional setup requirements outside this period should be coordinated with us to avoid any inconvenience. Intellidesk will not be liable for delays or additional expenses due to non-compliance with this rule. Standard egress time is one (1) hour after the event. Standard egress time is one (1) hour after the event.
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <h3 style="margin-bottom: 0;">Access & Security</h3>
                          Only members and guests are allowed to enter the premises. Firearms (of any type) are strictly prohibited in the premises.
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <h3 style="margin-bottom: 0;">Billing Arrangement</h3>
                          To confirm your reservation, please return a signed copy of this letter with complete reservation details by (<?php echo $booking->get_payment_deadline();?>) If another client requests the same space before this date, you will have a 24-hour option period to confirm your reservation. Full payment is required either in cash or via bank deposit. If we do not receive your payment within 24 hours, we will cancel your reservation and make it available to others.
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <h3 style="margin-bottom: 0;">Incidental Deposit</h3>
                          Intellidesk Inc. also requires a refundable incidental fee of PHP 2,000 upon arrival, which will be returned at the end of your booking.
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <h3 style="margin-bottom: 0;">Tax Compliance</h3>
                          In accordance with BIR Tax Code Title IX Sec. 237, invoices will be issued under the name of the individual or corporate account. The invoice must reflect the same details as the Events Registration Form. Alterations or issuance of multiple invoices with different payors are prohibited.
                        </td>
                      </tr>
                      <tr>
                        <?php if($booking->space->price_type == 'daily'):?>
                          <td align="center" style="">
                            <table border="0" class="wrapper" style="margin-bottom:0;">
                              <tr>
                                <td colspan="2">
                                  <?php  echo 'Total: ' . $booking->space->post_title . ' ' . $booking->get_base_rate() .' x ' . $booking->get_booking_length() .'days = ' . number_format($booking->calculate_booking_rate(), 2, '.',',') ;?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <p>1.<?php echo $booking->space->post_title;?></p>
                                </td>
                                <td>
                                  P<?php echo number_format($booking->get_base_rate(),2,'.',',') ;?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <p>2. Incidental Deposit</p>
                                </td>
                                <td>
                                  P 2,000
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <p>3. TOTAL</p>
                                </td>
                                <td>
                                  <?php
                                    $total = $booking->get_base_rate() * $booking->get_booking_length() + 2000;
                                    echo number_format($total, 2, '.',',') ;
                                  ?>
                                </td>
                              <tr>
                                <td colspan="2">
                                  <p style="font-size: 10px: padding-top:10px;">Note: Please pay the total amount within 24 hours to avoid cancellation.</p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        <?php else:?>
                          <td align="center" style="">
                            <table border="0" class="wrapper" style="margin-bottom:0;">
                              <tr>
                                <td colspan="2">
                                  <?php  echo 'Total: ' . $booking->space->post_title .' x ' . $booking->space->seats .'seats = ' . $booking->get_base_rate() . '+ 12% VAT = ' . number_format($booking->calculate_booking_rate(), 2, '.',',');?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <p>1. 2months security deposit</p>
                                </td>
                                <td>
                                  P<?php echo number_format($booking->get_base_rate()*2,2,'.',',') ;?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <p>2. 1 month advance rental</p>
                                </td>
                                <td>
                                  P<?php echo number_format($booking->get_base_rate(),2,'.',',') ;?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <p>3. TOTAL</p>
                                </td>
                                <td>
                                  <?php
                                    $total = $booking->get_base_rate() * 3 + $booking->calculate_booking_rate();
                                    echo number_format($total, 2, '.',',') ;
                                  ?>
                                </td>
                              <tr>
                                <td colspan="2">
                                  <p style="font-size: 10px: padding-top:10px;">Note: Please pay the total amount within 24 hours to avoid cancellation.</p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        <?php endif;?>
                      </tr>
                      <tr>
                        <td>
                          <p><strong>PAYMENT OPTIONS</strong></p>
                          <ol>
                            <li>Cash through online bank transfer/ over the counter deposit</li>
                            <ol type="A">
                              <li>
                                BDO<br/>
                                Account Name: HSB ASIA PACIFIC HOLDINGS, INC.<br/>
                                Account Number: 0063 4802 2060
                              </li>
                              <li>FOR INTERNATIONAL bank remittance / wire transfer – payment is subject to clearing period within 7 to 15 banking days and corresponding charges might be deducted by the bank from your actual total payment. Intellidesk will only acknowledge the net payment received on our bank account after this period. We must receive the complete payment on or before your start date to avoid cancellation.</li>
                            </ol>
                            <li style="padding-bottom: 10px;">
                              Payment via Gcash<br/>
                              Account Name:		SUNG CHUL HONG<br/>
                              Mobile Number: 	0966-4415000
                            </li>
                            <li>
                              Check payment<br/>
                              Intellidesk will only allow check payments for bookings made for at least 2 weeks ahead of start date. Please give us time to process check for clearing and verification.
                            </li>
                          </ol>
                          <p><strong>IMPORTANT NOTICE</strong>: Please be informed that failure to make payment within the specified deadline will result to automatic cancellation of your reservation. Should you wish to reinstate your booking, it will be subject to availability at the time of inquiry.</p>
                          <p>We hope this letter meets your requirements. Should you need further information or assistance, please do not hesitate to contact us at +63968 891 9789 or email at hello@intellideskcoworking.com 
                          <p>We look forward to hosting a successful event for you and your guests at Intellidesk!</p>
                        </td>
                      </tr>
                    </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- END CENTERED WHITE CONTAINER -->
