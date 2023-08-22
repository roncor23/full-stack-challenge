

    $(document).ready(function() {

        $('.custom-table').DataTable();

        $('#director_records').hide();
        $('#last100RecordBtn').hide();
        $('#business_records').hide();
        $('#homeBtn').hide();

        $("#directorBtn").click(function(){
            $('#director_records').show();
            $('#business_records').hide();
            $('#last100RecordBtn').show();
            $('#directorBtn').hide();
            $('#homeBtn').show();
            $('#all_records').hide();
        });

        $("#businessBtn").click(function(){
            $('#business_records').show();
            $('#directorBtn').show();
            $('#businessBtn').hide();
            $('#director_records').hide();
            $('#homeBtn').show();
            $('#all_records').hide();
            $('#last100RecordBtn').hide();
        });

        $("#homeBtn").click(function() {
            $('#directorBtn').show();
            $('#businessBtn').show();
            $('#homeBtn').hide();
            $('#all_records').show();
            $('#director_records').hide();
            $('#business_records').hide();
            $('#last100RecordBtn').hide();
        });

        // Attach click event to "Get Director" cells
        $(document).on('click', '.get-director', function() {
                // Retrieve director ID from the data attribute
                var directorId = $(this).data('director-id');
                
                // Send AJAX request to the server
                $.ajax({
                    type: 'POST',
                    url: 'request.php', 
                    data: { action: 'getSingleDirectorRecord', id: directorId },
                    success: function(response) {
                        // Handle the server's response

                        // Parse the JSON response data
                        var responseData = JSON.parse(response);

                        if (responseData.success) {
                            // Output the data to the console (for debugging)
                            console.log("debug",responseData.data);


                            Swal.fire({
                                title: 'Director Info',
                                html: `
                                    <p><span style="font-weight: bold">Full Name:</span> ${responseData.data.first_name} ${responseData.data.last_name}</p>
                                    <br>
                                    <p style="margin-top: -30px;"><span style="font-weight: bold">Date of Birth:</span> ${responseData.data.date_of_birth}</p>
                                    <br>
                                    <p style="margin-top: -30px;"><span style="font-weight: bold">Occupation:</span> ${responseData.data.occupation}</p>
                                `,
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });

                        } else {
                            alert('Failed to retrieve director record.');
                        }
                    },
                    error: function() {
                        // Handle error if the AJAX request fails
                        alert('An error occurred.');
                    }
                });
            });
        // Attach click event to "Get last 100 records" cells
        $(document).on('click', '#last100RecordBtn', function() {
                
                // Send AJAX request to the server
                $.ajax({
                    type: 'POST',
                    url: 'request.php', 
                    data: { action: 'getLast100Records' },
                    success: function(response) {
                        // Handle the server's response

                        // Parse the JSON response data
                        var responseData = JSON.parse(response);

                        if (responseData.success) {
                            // Output the data to the console (for debugging)
                            console.log("debug",responseData.data);

                            // Update the table rows with the retrieved data
                            var tableBody = $('.custom-table tbody');
                                tableBody.empty();
                                $.each(responseData.data, function(index, record) {
                                    var row = `<tr>
                                        <td>${record.id}</td>
                                        <td>${record.first_name} ${record.last_name}</td>
                                        <td>${record.occupation}</td>
                                        <td>${record.date_of_birth}</td>
                                        <td class="get-business" data-business-id="${record.id}">
                                            <button class="button button-secondary">Business Info</button>
                                        </td>
                                    </tr>`;
                                    tableBody.append(row);
                                });


                        } else {
                            alert('Failed to retrieve last 100 records.');
                        }
                    },
                    error: function() {
                        // Handle error if the AJAX request fails
                        alert('An error occurred.');
                    }
                });
            });
        // Attach click event to "Get Business" cells
        $(document).on('click', '.get-business', function() {
                // Retrieve business ID from the data attribute
                var businessId = $(this).data('business-id');
                
                // Send AJAX request to the server
                $.ajax({
                    type: 'POST',
                    url: 'request.php',
                    data: { action: 'getSingleBusinessRecord', id: businessId },
                    success: function(response) {
                        // Handle the server's response

                        // Parse the JSON response data
                        var responseData = JSON.parse(response);

                        if (responseData.success) {
                            // Output the data to the console (for debugging)
                            console.log("debug",responseData.data);
                            
                            Swal.fire({
                                title: 'Business Info',
                                html: `
                                    <p><span style="font-weight: bold">Name:</span> ${responseData.data.name}</p>
                                    <br>
                                    <p style="margin-top: -30px;"><span style="font-weight: bold">Registered Address:</span> ${responseData.data.registered_address}</p>
                                    <br>
                                    <p style="margin-top: -30px;"><span style="font-weight: bold">Registration Date:</span> ${responseData.data.registration_date}</p>
                                    <br>
                                    <p style="margin-top: -30px;"><span style="font-weight: bold">Registration #:</span> ${responseData.data.registration_number}</p>
                                `,
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });

                        } else {
                            alert('Failed to retrieve business record.');
                        }
                    },
                    error: function() {
                        // Handle error if the AJAX request fails
                        alert('An error occurred.');
                    }
                });
            });

            // Search business registered year
            $('#year').on('keyup', function(event) {
                if (event.keyCode === 13) { // Check if Enter key was pressed
                    var year = $(this).val();
                    if (year !== '') {
                        $.ajax({
                            url: 'request.php',
                            method: 'GET',
                            data: { action: 'getBusinessesRegisteredInYear', year: year },
                            success: function(response) {

                                // Parse the JSON response data
                                var responseData = JSON.parse(response);

                                console.log("response business", responseData);

                                if (responseData.success) {

                                    // Update the table rows with the retrieved data
                                    var tableBody = $('.custom-table tbody');
                                    tableBody.empty();
                                    $.each(responseData.data, function(index, record) {
                                        var row = `<tr>
                                            <td>${record.id}</td>
                                            <td>${record.name}</td>
                                            <td>${record.registered_address}</td>
                                            <td>${record.registration_date}</td>
                                            <td>${record.registration_number}</td>
                                            <td class="get-director" data-director-id="${record.id}">
                                                <button class="button button-secondary">Director Info</button>
                                            </td>
                                        </tr>`;
                                        tableBody.append(row);
                                    });

                                } else {
                                    alert('Failed to retrieve business record.');
                                }


                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                console.error(error);
                            }
                        });
                    } else {
                        // Clear the table if no year is provided
                        $('.custom-table tbody').empty();
                    }
                }
            });

    });