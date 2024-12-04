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
                  <img src="https://intellideskcoworking.com/wp-content/uploads/2024/09/intellidesk-logo.jpg" alt="Intellidesk Coworking Space" width="220" height="40" class="" alt="Intellidesk Coworking logo">
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
                          <p>Dear Mr./Ms. <?php echo $user->first_name.' '.$user->last_name;?>,</p>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <p>We received your booking request and it is now being processed. You are now one step closer to securing your <?php echo $booking->space->post_title;?> with us.</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <h3><strong>Booking Information</strong></h3>
                        </td>
                      </tr>
                      <tr>
                        <img src="<?php echo $image_url;?>" class="max-w-full h-auto mx-auto rounded-lg shadow-md mb-6" style="margin: 0 auto; border-radius: 20px; height: 400px; object-position: center; object-fit: cover; width: 100%; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); border-radius: 0.5rem;"/>
                      </tr>
                      <tr>
                        <td>
                          <table cellpadding="0" border="1">
                            <tr>
                              <td><strong>Booking ID</strong>:</td>
                              <td><?php echo $booking->post->ID;?></td>
                            </tr>
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
                            <?php if($booking->space->price_type == 'monthly'):?>
                            <tr>
                              <td><strong>Start Date</strong>:</td>
                              <td><?php echo $booking->start_date;?></td>
                            </tr>
                            <?php else:?>
                              <tr>
                                <td><strong>Date & Time</strong>:</td>
                                <td><?php echo $booking->display_selected_dates();?></td>
                              </tr>
                            <?php endif;?>
                            <tr>
                              <td><strong>Room Type</strong>:</td>
                              <td><?php echo $booking->space->post_title;?></td>
                            </tr>
                            <tr>
                              <td><strong>Rate</strong>:</td>
                              <td><?php echo $booking->get_base_rate();?></td>
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
                        <td>
                          <h3><strong>Payment Breakdown</strong></h3>
                        </td>
                      </tr>
                      <tr>
                        <?php if($booking->space->price_type == 'daily'):?>
                          <td align="center" style="">
                            <table border="0" class="wrapper" style="margin-bottom:0;">
                              <tr>
                                <td>
                                  <p><?php echo '1. '.$booking->space->post_title;?></p>
                                </td>
                                <td>
                                  <p><?php echo '₱ '.$booking->get_base_rate(); ?></p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <p><?php echo '2. Total (for '.$booking->get_booking_length().' day/s): ' ;?></p>
                                </td>
                                <td>
                                  <?php
                                    echo '₱ '.number_format($booking->calculate_booking_rate(), 2, '.',',');
                                  ?>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <p style="font-size: 10px: padding-top:10px;">Note: Please pay the total amount within 24 hours (before <?php echo $booking->get_payment_deadline();?> | 5 PM) to avoid cancellation.</p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        <?php else:?>
                          <td align="center" style="">
                            <table border="0" class="wrapper" style="margin-bottom:0;">
                              <tr>
                                <td>
                                  <p>1 month advance +12% VAT</p>
                                </td>
                                <td>
                                <p><?php echo '₱ '.number_format($booking->calculate_booking_rate(), 2, '.',','); ?></p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <p>2 months security deposit</p>
                                </td>
                                <td>
                                  <p><?php echo '₱ '.number_format($booking->get_deposit_for_monthly(), 2, '.',','); ?></p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <p>3. TOTAL</p>
                                </td>
                                <td>
                                  <p><?php echo '₱ '.number_format($booking->get_total_for_monthly(), 2, '.',',');?></p>
                                </td>
                              <tr>
                                <td colspan="2">
                                  <p style="font-size: 10px: padding-top:10px;">Note: Please pay the total amount within 24 hours (before <?php echo $booking->get_payment_deadline();?> | 5 PM) to avoid cancellation.</p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        <?php endif;?>
                      </tr>
                      <tr>
                        <td>
                          <p><strong>Payment Options</strong></p>
                          <ol>
                            <li>Cash through online bank transfer/ over the counter deposit</li>
                            <ol type="A">
                              <li>
                                BDO<br/>
                                Account Name: HSB ASIA PACIFIC HOLDINGS, INC.<br/>
                                Account Number: 0063 4802 2060
                              </li>
                              <?php if($booking->space->price_type == 'monthly'):?>
                              <li>FOR INTERNATIONAL bank remittance / wire transfer <br/> Intellidesk will only allow wire transfers or international remittance payments for bookings made for at least 2 weeks ahead of start date. Payment is subject to clearing period and corresponding charges might be deducted by the bank from your actual total payment.<br/>
                              Intellidesk will only acknowledge the net payment received on our bank account after this period. We must receive the complete payment on or before your start date to avoid cancellation.</li>
                              <?php endif;?>
                            </ol>
                            <?php if($booking->space->price_type == 'daily'):?>
                              <li style="padding-bottom: 10px;">
                                Payment via Gcash<br/>
                                Account Name:		SUNG CHUL HONG<br/>
                                Mobile Number: 	0966-4415000
                              </li>
                            <?php endif;?>
                            <?php if($booking->space->price_type == 'monthly'):?>
                            <li>
                              Check payment<br/>
                              Intellidesk will only allow check payments for bookings made for at least 2 weeks ahead of start date. Please give us time to process check for clearing and verification.
                            </li>
                            <?php endif;?>
                          </ol>
                          <p><strong>IMPORTANT NOTICE</strong>:Kindly send back a copy of proof of payment before the start date for verification purposes, unverified payments will not be honored on our end. Payment must be made on or before <?php echo $booking->get_payment_deadline();?> | 5 PM to confirm the booking. If payment is not settled by then, it will mean automatic cancellation of your booking.</p>
                          <p>We hope this letter meets your requirements. Should you need further information or assistance, please do not hesitate to contact us at +63968 891 9789 or email at hello@intellideskcoworking.com 
                          <?php if($booking->space->post_title =='Events Area'):?>
                          <p>We look forward to hosting a successful event for you and your guests at Intellidesk!</p>
                          <?php endif;?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p><strong>Cancellation Policy</strong></p>
                          <p>Non-Refundable<br/>Non-Rebookable<br/>Non-Cancellable</p>
                          <p>This booking is Non-Refundable and cannot be amended or modified.</p>
                          <p>Failure to arrive at the coworking office will be treated as No-Show and will incur a charge of 100% of the booking value. Your room/s shall also be released subject to the terms and conditions of the Cancellation/No-Show Policy.</p>
                        </td>
                      </tr>
                    </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- END CENTERED WHITE CONTAINER -->
