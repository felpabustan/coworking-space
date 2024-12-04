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
                          <p>Good day <?php echo $full_name?>,</p>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <p>We received your inquiry and it is now being processed. You are now one step closer to securing your <?php echo $space_name;?> with us.</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <h3><strong>Inquiry Summary</strong></h3>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <img src="<?php echo $space_image_url;?>" class="max-w-full h-auto mx-auto rounded-lg shadow-md mb-6" />
                        </td>
                      <tr>
                        <td>
                          <div class="">
                            <?php echo '<p><b>' .  $space_name . '</b></p>';?>
                            <?php echo '<p>Visit Date and Time: '. $inquiry_date_and_time .'</p>';?>
                            <?php echo '<p>Number of People: ' . $pax . '</p>';?>
                            <?php echo '<p>Address: 19F Parkway Corporate Center, Alabang, Muntinlupa City</p>';?>
                            <hr class="my-6"/>
                            <h3 class="font-semibold font-display text-xl">Client Details</h3>
                            <?php echo '<p>Company: ' . $company . '</p>';?>
                            <?php echo '<p>Name: ' . $full_name . '</p>';?>
                            <?php echo '<p>Phone: ' . $phone . '</p>';?>
                            <?php echo '<p>Email: ' . $email . '</p>';?>
                          </div>
                        </td>
                      </tr>
                    </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- END CENTERED WHITE CONTAINER -->
