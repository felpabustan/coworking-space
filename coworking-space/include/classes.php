<?php

class User
{
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $company;
    public $position;
    public $phone;
    public $birthdate;
    public $billing_street;
    public $billing_city;
    public $billing_state;
    public $billing_zip;
    public $billing_country;

    public function __construct($user)
    {
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->username = $user->user_login;
        $this->email = $user->user_email;
        $this->company = get_user_meta($user->ID, 'company', true);
        $this->position = get_user_meta($user->ID, 'position', true);
        $this->phone = get_user_meta($user->ID, 'phone', true);
        $this->birthdate = get_user_meta($user->ID, 'birthdate', true);
        $this->billing_street = get_user_meta($user->ID, 'billing_street', true);
        $this->billing_city = get_user_meta($user->ID, 'billing_city', true);
        $this->billing_state = get_user_meta($user->ID, 'billing_state', true);
        $this->billing_zip = get_user_meta($user->ID, 'billing_zip', true);
        $this->billing_country = get_user_meta($user->ID, 'billing_country', true);
    }

    // public function updateMeta($meta_key, $meta_value) {
    //     return update_user_meta($this->user_id, $meta_key, sanitize_text_field($meta_value));
    // }

}

class Space
{
    public $ID;
    public $post_title;
    public $post_status;
    public $post_name;
    public $price_type;

    // Conditional properties
    public $weekday_rate;
    public $weekend_rate;
    public $halfday_rate;
    public $halfday_rate_weekend;
    public $monthly_rate;
    public $seats;
    public $vat_included;
    public $inclusions;
    public $with_window;
    public $non_bookable;

    public $booked_dates = [];

    public function __construct($post)
    {
        if ($post instanceof WP_Post) {
            $this->ID = $post->ID;
            $this->post_title = $post->post_title;
            $this->post_status = $post->post_status;
            $this->post_name = $post->post_name;
            $this->get_custom_space_meta();
            $this->get_inclusions();
        } else {
            throw new InvalidArgumentException('Invalid post object.');
        }
    }

    private function get_custom_space_meta()
    {
        $this->price_type = get_post_meta($this->ID, '_space_rate_type', true);
        $this->weekday_rate = get_post_meta($this->ID, '_space_price_weekday', true);
        $this->weekend_rate = get_post_meta($this->ID, '_space_price_weekend', true);
        $this->halfday_rate = get_post_meta($this->ID, '_space_halfday_rate', true);
        $this->halfday_rate_weekend = get_post_meta($this->ID, '_space_halfday_rate_weekend', true);
        $this->monthly_rate = get_post_meta($this->ID, '_space_price_monthly', true);
        $this->seats = get_post_meta($this->ID, '_space_seats', true);
        $this->vat_included = get_post_meta($this->ID, '_space_vat_included', true);
        $this->with_window = get_post_meta($this->ID, '_space_with_window', true);
        $this->non_bookable = get_post_meta($this->ID, '_space_non_bookable', true);
    }

    private function get_inclusions()
    {
        // Retrieve the image-text pairs from the post meta
        $image_text_pairs = get_post_meta($this->ID, 'image_text_pairs', true);

        // Initialize the result array
        $this->inclusions = [];

        // Check if the meta data exists and is an array
        if (!empty($image_text_pairs) && is_array($image_text_pairs)) {
            foreach ($image_text_pairs as $pair) {
                // Get the image URL using the attachment ID
                $image_url = wp_get_attachment_url($pair['image']);

                // Check if the image URL exists, otherwise assign null
                if ($image_url) {
                    $this->inclusions[] = [
                        'img' => $image_url, // Image URL
                        'txt' => $pair['text'] // Associated text
                    ];
                } else {
                    $this->inclusions[] = [
                        'img' => null, // No image available
                        'txt' => $pair['text'] // Associated text
                    ];
                }
            }
        }
        return $this->inclusions; // Return the result array
    }

    private function get_booking_days($start_date, $end_date)
    {
        if (empty($start_date) || empty($end_date)) {
            return []; // Return empty array if no start/end dates
        }

        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1D'),
            (new DateTime($end_date))->modify('+1 day')
        );

        $days = [];
        foreach ($period as $date) {
            $day = $date->format('Y-m-d');
            $days[$day] = ['am' => true, 'pm' => true]; // Assume full-day booking by default
        }

        return $days;
    }

    public function get_booked_dates()
    {
        // Get booking data using the space ID
        $booking_data = get_all_booking_data($this->ID);
        $booked_dates = [];
        $today = new DateTime();
    
        // Loop through each booking data entry
        foreach ($booking_data as $booking) {
            //get pending, on going status only 
            // For daily bookings with multiple dates, add each date to the booked_dates array
            if (isset($booking['meta']['_booking_multi_dates'])) {
                $booking_multi_dates = $booking['meta']['_booking_multi_dates'];
                $multi_dates_array = maybe_unserialize($booking_multi_dates);
                if (is_array($multi_dates_array)) {
                    foreach ($multi_dates_array as $date_data) {
                        if (isset($date_data['date'])) {
                            $date = $date_data['date'];
                            $formatted_date = date('Y-m-d', strtotime($date));
                            if (strtotime($formatted_date) >= $today->getTimestamp()) {
                                $booked_dates[] = $formatted_date;
                            }
                        }
                    }
                }
            }
    
            // If no multi dates are in the meta, assume booking is monthly
            if (!isset($booking['meta']['_booking_multi_dates']) || empty($booking['meta']['_booking_multi_dates'])) {
                if (isset($booking['meta']['_booking_start_date']) && isset($booking['meta']['_booking_booking_length'])) {
                    $start_date = new DateTime($booking['meta']['_booking_start_date']);
                    $booking_length = (int)$booking['meta']['_booking_booking_length'];
                    
                    array_push($booked_dates, $start_date->format('Y-m-d'));

                    $end_date = (clone $start_date)->modify("+$booking_length months");
                    $end_date->setDate($end_date->format('Y'), $end_date->format('m'), 30);
                    
                    if ($end_date >= $today) {
                        array_push($booked_dates, $end_date->format('Y-m-d'));
                    }
                }
            }
        }
    
        return $booked_dates;
    }
    
    // public function get_booked_dates()
    // {
    //     // get booking data using the space id
    //     $booking_data = get_all_booking_data($this->ID);

    //     $booked_dates = [];
    //     $today = new DateTime();

    //     // loop thru each booking data
    //     foreach ($booking_data as $booking) {
    //         // for daily bookings that use multi dates, loop thru each date and insert to the booked dates array
    //         if (isset($booking['meta']['_booking_multi_dates'])) {
    //             $booking_multi_dates = $booking['meta']['_booking_multi_dates'];

    //             $multi_dates_array = maybe_unserialize($booking_multi_dates);
    //             if (is_array($multi_dates_array)) {
    //                 foreach ($multi_dates_array as $date_data) {
    //                     if (isset($date_data['date'])) {
    //                         // format the date for client-side use
    //                         $date = $date_data['date'];
    //                         $formatted_date = date('Y-m-d', strtotime($date));
    //                         if (strtotime($formatted_date) >= $today->getTimestamp()) {
    //                             $booked_dates[] = $formatted_date;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //         // if no multi dates is in the meta, means booking is monthly, insert booking start date
    //         if (!isset($booking['meta']['_booking_multi_dates']) || empty($booking['meta']['_booking_multi_dates'])) {
    //             if (isset($booking['meta']['_booking_start_date']) && isset($booking['meta']['_booking_booking_length'])) {
    //                 $start_date = $booking['meta']['_booking_start_date'];
    //                 // use booking length to multiply as the length of months from start date
    //                 // example if $booking['meta']['_booking_booking_length'] = 2, the booking dates should be 2 months from start date
    //                 // and for example the start date is January 10, 2025 and length is 2, booking dates should be from January 10, 2025 up to March 10, 2025
    //                 // from the end date, we should include the remaining dates of the month.
    //                 // so for example end date is march 10, 2025, we should include the dates from the 11th to the 30th day only(we only end on the 30th even if the month has 31st day)

    //                 // format the date for client-side use
    //                 $formatted_date = date('Y-m-d', strtotime($start_date));
    //                 if (strtotime($formatted_date) >= $today->getTimestamp()) {
    //                     $booked_dates[] = $formatted_date;
    //                 }
    //             }
    //         }
    //     }

    //     return $booked_dates;
    // }
}

class Booking
{
    public $post; // WP_Post object
    public $start_date;
    public $end_date;
    public $selected_dates;
    public $single_date_options;
    public $booking_length;
    public $vat_included;
    public $booking_status;
    public $user_id;
    public $space;

    public function __construct($post)
    {
        if ($post instanceof WP_Post) {
            $this->post = $post;
            $this->get_booking_meta();
            $this->space = new Space(get_post($this->get_space_id()));
        } else {
            throw new InvalidArgumentException('Invalid post object.');
        }
    }

    public function get_space_id()
    {
        return get_post_meta($this->post->ID, '_booking_space_id', true);
    }

    private function get_booking_meta()
    {
        $this->start_date = get_post_meta($this->post->ID, '_booking_start_date', true);
        $this->end_date = get_post_meta($this->post->ID, '_booking_end_date', true);
        $this->single_date_options = get_post_meta($this->post->ID, '_booking_single_date_options', true);
        $this->booking_length = get_post_meta($this->post->ID, '_booking_booking_length', true);
        $this->user_id = get_post_meta($this->post->ID, '_booking_user_id', true);
        $this->vat_included = get_post_meta($this->post->ID, '_space_vat_included', true);
        $this->booking_status = get_post_meta($this->post->ID, '_booking_status', true);

        $this->selected_dates = get_post_meta($this->post->ID, '_booking_multi_dates', true);

        //modify selected_dates property
        if (!empty($this->single_date_options)) {
            $this->selected_dates[0]['option'] = $this->single_date_options;
        }
    }

    public function calculate_booking_rate()
    { //KEEP
        $price_type = $this->space->price_type; // 'daily' or 'monthly'
        $vat_included = $this->space->vat_included; // '1' or '0'

        if ($price_type === 'daily') {
            return $this->calculate_daily_rate();
        } elseif ($price_type === 'monthly') {
            return $this->calculate_monthly_rate();
        } else {
            throw new Exception('Invalid price type specified.');
        }
    }

    public function get_base_rate()
    { //KEEP
        $price_type = $this->space->price_type; // 'daily' or 'monthly'

        // Retrieve rate labels for display
        $weekday_rate = $this->space->weekday_rate;
        $weekend_rate = $this->space->weekend_rate;
        $halfday_rate = $this->space->halfday_rate;
        $halfday_weekend_rate = $this->space->halfday_rate_weekend ? $this->space->halfday_rate_weekend : $halfday_rate;

        // Handle daily pricing
        if ($price_type === 'daily') {
            $applied_rates = [
                'weekday_full' => false,
                'weekend_full' => false,
                'weekday_half' => false,
                'weekend_half' => false
            ];

            // Process multi-date selections
            if (!empty($this->selected_dates)) {
                foreach ($this->selected_dates as $date_info) {
                    $date = $date_info['date'];
                    $option = $date_info['option']; // 'full', '8-12', '1-5'
                    $is_weekend = $this->is_weekend($date);

                    if ($option === 'full') {
                        if ($is_weekend) {
                            $applied_rates['weekend_full'] = true;
                        } else {
                            $applied_rates['weekday_full'] = true;
                        }
                    } else {
                        if ($is_weekend) {
                            $applied_rates['weekend_half'] = true;
                        } else {
                            $applied_rates['weekday_half'] = true;
                        }
                    }
                }
            }

            // Process single date selections
            elseif (!empty($this->single_date_options)) {
                $option = $this->single_date_options; // 'full', '8-12', '1-5'
                $is_weekend = $this->is_weekend($this->selected_dates[0]['date']); //get the first array index then the 'date' key 

                if ($option === 'full') {
                    if ($is_weekend) {
                        $applied_rates['weekend_full'] = true;
                    } else {
                        $applied_rates['weekday_full'] = true;
                    }
                } else {
                    if ($is_weekend) {
                        $applied_rates['weekend_half'] = true;
                    } else {
                        $applied_rates['weekday_half'] = true;
                    }
                }
            }

            // Build a list of the applied rate descriptions
            $applied_rate_descriptions = [];
            if ($applied_rates['weekday_full']) {
                $applied_rate_descriptions[] = "$weekday_rate (weekday full)";
            }
            if ($applied_rates['weekend_full']) {
                $applied_rate_descriptions[] = "$weekend_rate (weekend full)";
            }
            if ($applied_rates['weekday_half']) {
                $applied_rate_descriptions[] = "$halfday_rate (weekday half-day)";
            }
            if ($applied_rates['weekend_half']) {
                $applied_rate_descriptions[] = "$halfday_weekend_rate (weekend half-day)";
            }

            // Return the applied rates as a comma-separated string
            return implode(', ', $applied_rate_descriptions);
        }

        // Handle monthly pricing
        if ($price_type === 'monthly') {
            return $this->space->monthly_rate;
        }

        throw new Exception('Invalid price type specified.');
    }

    // Helper method to check if a date is a weekend
    private function is_weekend($date)
    { //KEEP
        $timestamp = strtotime($date);
        $day_of_week = date('N', $timestamp); // 1 (Monday) to 7 (Sunday)
        return ($day_of_week >= 6); // Return true if Saturday or Sunday
    }

    public function display_selected_dates()
    {
        // Sample data for options to time conversion
        $time_options = [
            'full' => '8 AM - 5 PM',
            '8-12' => '8 AM - 12 PM',
            '1-5' => '1 PM - 5 PM'
        ];

        // Sort the selected dates array by date in ascending order
        usort($this->selected_dates, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        // Array to store the formatted date list
        $formatted_dates = [];

        // Loop through selected dates
        foreach ($this->selected_dates as $date_info) {
            $date = $date_info['date'];
            $option = (!empty($this->single_date_options)) ? $this->single_date_options : $date_info['option']; // 'full', '8-12', '1-5'

            // Convert date to a human-readable format like "20 October 2024"
            $formatted_date = date('d F Y', strtotime($date));

            // Get the day of the week (e.g., "Sunday")
            $day_of_week = date('l', strtotime($date));

            // Get the time range from the option
            $time_range = isset($time_options[$option]) ? $time_options[$option] : '8 AM - 5 PM'; // Default to full day if option is unknown

            // Combine the formatted date, day of week, and time range into a bullet item
            $formatted_dates[] = "$formatted_date ($day_of_week) | $time_range";
        }

        // Output as a bullet list
        return "<ul><li>" . implode('</li><li>', $formatted_dates) . "</li></ul>";
    }


    public function get_booking_length()
    { //KEEP
        $price_type = $this->space->price_type; // 'daily' or 'monthly'
        if ($price_type === 'daily') {
            return count($this->selected_dates);
        } elseif ($price_type === 'monthly') {
            return ($this->booking_length ? $this->booking_length : 1);
        } else {
            throw new Exception('Invalid price type specified.');
        }
    }

    private function calculate_daily_rate()
    { //KEEP //total daily

        // Determine weekend and half-day rate labels
        $halfday_weekend_rate = $this->space->halfday_rate_weekend ? $this->space->halfday_rate_weekend : $this->space->halfday_rate;
        $weekend_rate = $this->space->weekend_rate ? $this->space->weekend_rate : $this->space->weekday_rate;
        $halfday_rate = $this->space->halfday_rate;
        $weekday_rate = $this->space->weekday_rate;

        // Handle multi-date selection
        if (!empty($this->selected_dates) && count($this->selected_dates) > 1) {
            $total_rate = 0;
            foreach ($this->selected_dates as $date_info) {
                $option = $date_info['option']; // 'full', '8-12', '1-5'
                $date = $date_info['date'];
                $is_weekend = $this->is_weekend($date);

                // Check if half-day or full-day
                if ($option === 'full') {
                    $total_rate += $is_weekend ? $weekend_rate : $weekday_rate;
                } else {
                    $total_rate += $is_weekend ? $halfday_weekend_rate : $halfday_rate;
                }
            }
            return $total_rate;
        }

        // Handle single-date selection
        if (!empty($this->single_date_options)) {
            $option = $this->single_date_options; // 'full', '8-12', '1-5'
            $is_weekend = $this->is_weekend($this->selected_dates[0]['date']); //get the first array index then the 'date' key 

            // Check if half-day or full-day
            if ($option === 'full') {
                return $is_weekend ? $weekend_rate : $weekday_rate;
            } else {
                return $is_weekend ? $halfday_weekend_rate : $halfday_rate;
            }
        }
    }

    private function calculate_monthly_rate()
    { //KEEP
        $start_date = $this->start_date;
        $booking_length = $this->get_booking_length(); // We'll implement this method next
        $monthly_rate = $this->space->monthly_rate;
        $seats = $this->space->seats;
        // $length = $booking_length * 12; //remove total years for now

        $total_rate = $monthly_rate * $seats; // * $length;

        // Add VAT if not included
        if (!$this->space->vat_included) {
            $total_rate *= 1.12; // Adding 12% VAT
        }

        return $total_rate;
    }

    public function get_deposit_for_monthly()
    { //KEEP
        return $this->get_base_rate() * 2;
    }

    public function get_total_for_monthly()
    { //KEEP
        return $this->get_deposit_for_monthly() + $this->calculate_booking_rate();
    }

    public function get_payment_deadline()
    {
        $date = new DateTime($this->post->post_date);
        $date->modify('+24 hours');
        return $date->format('j M Y');
    }

    public function get_all_booked_dates()
    {
        $booked_dates = [];
        $args = [
            'post_type'      => 'booking',
            'meta_query'     => [
                [
                    'key'   => '_booking_space_id',
                    'value' => $this->get_space_id(), 
                    'compare' => '='
                ],
                [
                    'key'   => '_booking_status',
                    'value' => 'confirmed',
                    'compare' => '='
                ],
            ],
            'posts_per_page' => -1,
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                $dates = get_post_meta($post->ID, '_booking_multi_dates', true);
                if (!empty($dates) && is_array($dates)) {
                    foreach ($dates as $date_info) {
                        if (!empty($date_info['date'])) {
                            $booked_dates[] = $date_info['date'];
                        }
                    }
                }
            }
        }
        wp_reset_postdata();

        $booked_dates = array_unique($booked_dates);
        sort($booked_dates);

        return $booked_dates;
    }
}

class Inquiry {
  public $post;
  public $name;
  public $email;
  public $phone;
  public $subject;
  public $date;
  public $message;
  public $space;
  public $company;
  public $pax;

  public function __construct($post) {
      if ($post instanceof WP_Post) {
          $this->post = $post;
          $this->get_inquiry_meta();
          $this->space = new Space(get_post($this->get_space_id()));
      } else {
          throw new InvalidArgumentException('Invalid post object.');
      }
  }

  private function get_inquiry_meta() {
    $this->name   = get_post_meta($this->post->ID, '_inquiry_name', true);
    $this->company  = get_post_meta($this->post->ID, '_inquiry_company', true);
    $this->email   = get_post_meta($this->post->ID, '_inquiry_email', true);
    $this->phone   = get_post_meta($this->post->ID, '_inquiry_phone', true);
    $this->subject = get_post_meta($this->post->ID, '_inquiry_subject', true);
    $this->inquiry_date = get_post_meta($this->post->ID, '_inquiry_date', true);
    $this->inquiry_time  = get_post_meta($this->post->ID, '_inquiry_time', true);
    $this->message = get_post_meta($this->post->ID, '_inquiry_message', true);
    $this->pax = get_post_meta($this->post->ID, '_inquiry_pax', true);
  }

  public function get_space_id()
  {
    return get_post_meta($this->post->ID, '_inquiry_space_id', true);
  }

  public function get_date_and_time() {
    $datetime_string = $this->inquiry_date . ' ' . $this->inquiry_time;
    $datetime = DateTime::createFromFormat('Y-m-d H:i', $datetime_string);

    if ($datetime) {
        return $datetime->format('F j, Y \a\t g:i A');
    }

    return ''; 
  }
}