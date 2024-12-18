<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusher Test with Icons</title>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Toastr JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Pusher JavaScript -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <style>
        /* Custom style for Toastr notifications */
        .toast-info .toast-message {
            display: flex;
            align-items: center;
        }
        .toast-info .toast-message i {
            margin-right: 10px;
        }
        .toast-info .toast-message .notification-content {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
    <script>
        Pusher.logToConsole = true;

        // Initialize Pusher
        var pusher = new Pusher('8ab74dbb8b518f713da8', {
            cluster: 'ap2'
        });

        // Subscribe to the channel
        var channel = pusher.subscribe('notification');

        // Bind to the event
        channel.bind('test.notification', function(data) {
            console.log('Received data:', data); // Debugging line

            // Display Toastr notification with icons and inline content
            if (data.author && data.title) {
                toastr.info(
                    `<div class="notification-content">
                        <i class="fas fa-user"></i> <span>   ${data.author}</span>
                        <i class="fas fa-book" style="margin-left: 20px;"></i> <span>  ${data.title}</span>
                    </div>`,
                    'New Post Notification',
                    {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 0, // Set timeOut to 0 to make it persist until closed
                        extendedTimeOut: 0, // Ensure the notification stays open
                        positionClass: 'toast-top-right',
                        enableHtml: true
                    }
                );

                // Add data to the table
                var newRow = `<tr>
                    <td>${data.author}</td>
                    <td>${data.title}</td>
                    <td>${new Date().toLocaleString()}</td>
                </tr>`;
                $('#data-table tbody').append(newRow);
            } else {
                console.error('Invalid data received:', data);
            }
        });

        // Debugging line
        pusher.connection.bind('connected', function() {
            console.log('Pusher connected');
        });
    </script>
</head>
<body>
    <h1>Pusher Test with Table</h1>
    <p>
        Try publishing an event to channel <code>notification</code>
        with event name <code>test.notification</code>.
    </p>


    <?php
    $posts = App\Models\Post::all();
    // echo $delete = App\Models\Post::query()->delete();


    ?>
    <!-- Table to display data -->
    <table id="data-table">
        <thead>
            <tr>
                <th>Author</th>
                <th>Title</th>
                <th>Received At</th>
            </tr>
            @forelse($posts as $poss)
            <tr>
                <td>{{$poss->author}}</td>
                <td>{{$poss->title}}</td>
                <td>{{$poss->created_at->format('d-m-y')}}</td>


            </tr>
            @empty
            @endforelse
        </thead>
        <tbody>
            <!-- Data will be dynamically inserted here -->
        </tbody>
    </table>
</body>
</html>
