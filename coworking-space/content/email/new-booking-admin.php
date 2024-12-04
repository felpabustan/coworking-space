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
                          <p>Dear Mr./Ms. <?php echo $user->first_name.' '.$user->last_name;?>,</p>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <?php if($$non_bookable) {
                            echo '<p>See the details of the inquiry made below:</p>';
                          } else {
                            echo '<p>A booking request has been submitted. See details below:</p>';
                          }?>
                          
                        </td>
                        
                      </tr>
                      <tr>
                        <td>
                          <h3><strong>Information</strong></h3>
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
                              <td><?php //echo number_format($booking->get_base_rate(), 2, '.',',');?></td>
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
                      <?php if(!$non_bookable):?>
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
                              </tr>
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
                          <p>Please login to the <a href="http://intellidesk.test/wp-admin/post.php?post=<?php echo $booking->post->post_ID;?>&action=edit" target="_blank">website</a> to process this request.</p>
                        </td>
                      </tr>
                      <?php endif;?>
                    </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- END CENTERED WHITE CONTAINER -->
