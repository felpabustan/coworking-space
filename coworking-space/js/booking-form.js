jQuery(document).ready(function($) {
  // Ensure bookedDates is available globally
  console.log('Booking dates:', bookedDates);  // Debugging

  // Track selected dates
  var selectedDates = [];

  // Monthly End Date Calculation
  function calculateEndDate() {
      var startDateValue = $('#start_date').val();
      var length = parseInt($('#length').val());
      if (!startDateValue || !length) return;

      var startDate = new Date(startDateValue);
      var endDate;
      
      if ('<?php echo $is_hotdesk; ?>') {
          startDate.setMonth(startDate.getMonth() + length); // Add months for Hotdesk
      } else {
          startDate.setFullYear(startDate.getFullYear() + length); // Add years for others
      }

      endDate = startDate.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
      $('#end_date').val(endDate);
  }

  $('#start_date, #length').on('change', calculateEndDate);

  // Block booked dates from booking
  function handleBeforeShowDay(date) {
      var day = date.getDay();
      var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);  // Format the date

      console.log('Checking date:', formattedDate);  // Debugging line to check formatted date

      // Block dates that are booked
      if (bookedDates.includes(formattedDate)) {
          console.log('Date is booked:', formattedDate);  // Debugging to check booked dates
          return [false, 'booked-date', 'Unavailable'];  // Apply the booked-date class here
      }

      // Block Wednesdays and weekends for conference and meeting rooms
      var isConferenceRoom = $('body').hasClass('postid-65'); // adjust as per your setup
      var isMeetingRoom = $('body').hasClass('postid-75'); // adjust as per your setup

      if (day === 3 || ((day === 0 || day === 6) && (isConferenceRoom || isMeetingRoom))) {
          return [false, '', 'Unavailable'];
      }

      // Highlight selected dates
      if (selectedDates.includes(formattedDate)) {
          return [true, 'selected-date', 'Selected'];
      }

      return [true, '', 'Available'];
  }

  // Initialize the multi-date datepicker
  $("#multi_date").datepicker({
      dateFormat: 'yy-mm-dd',
      minDate: +1,
      beforeShowDay: handleBeforeShowDay,
      onSelect: function(dateText, inst) {
          var formattedDate = $.datepicker.formatDate('d M yy', $.datepicker.parseDate('yy-mm-dd', dateText));
          var index = $.inArray(formattedDate, selectedDates);

          // Toggle date selection
          if (index === -1) {
              selectedDates.push(formattedDate);
          } else {
              selectedDates.splice(index, 1);
          }

          $(this).val(selectedDates.join(", "));

          // Keep the date picker open and refresh to apply selected-date styling
          setTimeout(function() {
              $("#multi_date").datepicker("show");
          }, 0);

          toggleHalfDayOptions();
          updateSingleDateOption();
          populateDateOptions();
          $(this).datepicker('refresh');
      }
  });

  // Toggle the half-day options and display multi-date options
  function toggleHalfDayOptions() {
      if (selectedDates.length > 1) {
          $('#single_date_option').prop('disabled', true).addClass('hidden');
          $('#multi_date_options').removeClass('hidden');
      } else {
          $('#single_date_option').prop('disabled', false).removeClass('hidden');
          $('#multi_date_options').addClass('hidden');
      }
  }

  // Populate selected date options with time slots and remove functionality
  function populateDateOptions() {
      var selectedDatesContainer = $('#selected_dates');
      selectedDatesContainer.empty();

      selectedDates.forEach(function(date) {
          var dateOptions = `
              <div class="grid grid-cols-3 gap-2 mb-2 selected-date-row" data-date="${date}">
                  <span>${date}</span>
                  <input type="hidden" name="multi_date[]" value="${date}" />
                  <select name="multi_date_option[]" class="w-full rounded-md border-gray-300">
                      <option value="full">Full Day</option>
                      <option value="8-12">8 AM - 12 PM</option>
                      <option value="1-5">1 PM - 5 PM</option>
                  </select>
                  <button type="button" class="text-red-500 remove-date-btn" data-date="${date}">&times;</button>
              </div>
          `;
          selectedDatesContainer.append(dateOptions);
      });

      // Event listener to remove selected dates
      $(".remove-date-btn").on("click", function() {
          var dateToRemove = $(this).data("date");
          selectedDates = selectedDates.filter(date => date !== dateToRemove);
          $(this).closest('.selected-date-row').remove();
          $("#multi_date").val(selectedDates.join(", "));
          toggleHalfDayOptions();
          $('#multi_date').datepicker('refresh');
      });
  }

  // Ensure correct display of single date option
  function updateSingleDateOption() {
      if (selectedDates.length > 1) {
          $('#single_date_option').prop('disabled', true).addClass('hidden');
      } else {
          $('#single_date_option').prop('disabled', false).removeClass('hidden');
      }
  }
});
