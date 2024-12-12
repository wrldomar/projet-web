<?php
include '../../Controller/eventC.php';
$eventC = new eventController();

// Fetch all events
$events = $eventC->listevent();  // Assuming you have a method for fetching all events

// Prepare events for FullCalendar
$calendarEvents = [];
foreach ($events as $event) {
    // Convert each event's Date into the required format (YYYY-MM-DD)
    $calendarEvents[] = [
        'title' => $event['nom_event'],        // Event title
        'start' => date('Y-m-d', strtotime($event['Date'])), // Event date
        'id' => $event['id_event'],  // Assuming you have an 'id_event' to identify the event
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>

    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    
    <!-- Bootstrap for styling -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>

    <!-- jQuery and FullCalendar JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <!-- Custom CSS -->
    <style>
        /* Header Styling */
        #header {
            background-color: #2e7d32;
            background-image: url('backG.png'); /* Green color to match agriculture theme */
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: space-between;
        }

        .left-content, .right-content {
            display: flex;
            align-items: center;
        }

        .left-content a, .right-content a {
            color: #fff;
            text-decoration: none;
            margin-right: 15px;
            font-size: 16px;
            font-weight: 500;
        }

        .left-content .logo-link {
            margin-right: 30px;
        }

        .logo {
            font-size: 28px;
            color: #fff;
            font-weight: bold;
        }

        .green {
            color: #66bb6a; /* Lighter green for contrast */
        }

        .harvest {
            color: #fff;
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 35px;
            background-color: #388e3c;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            padding: 10px;
            min-width: 150px;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-link {
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            display: block;
        }

        .dropdown-link:hover {
            background-color: #66bb6a;
        }

        /* Back Button Styling */
        .back-btn {
            display: inline-block;
            background-color: #388e3c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: #66bb6a;
        }

        /* Calendar Styling */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .fc-event {
            background-color: #388e3c;  /* Green background for events */
            color: #fff;
            border-radius: 5px;
            padding: 5px;
        }

        .fc-event:hover {
            background-color: #66bb6a; /* Lighter green on hover */
        }

        .fc-toolbar {
            background-color: #388e3c;  /* Toolbar with the green theme */
            border: none;
            color: #fff;
            padding: 10px;
        }

        .fc-toolbar h2 {
            color: white;
        }

        .fc-button {
            background-color: #388e3c;
            border: 1px solid #66bb6a;
            color: white;
        }

        .fc-button:hover {
            background-color: #66bb6a;
            border: 1px solid #388e3c;
        }

        .fc-state-default {
            background-color: #388e3c;
            color: white;
        }

        .fc-state-highlight {
            background-color: #66bb6a;
        }

        /* Responsive calendar */
        @media (max-width: 768px) {
            #calendar {
                padding: 10px;
            }

            .fc-toolbar {
                font-size: 14px;
            }

            .back-btn {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header id="header">
        <div class="header-content">
            <div class="left-content">
                <a href="dashboard.html" class="logo-link">
                    <img src="Group 6.png" alt="Group 6 Logo" class="logo-img" />
                </a>
                <a href="../front/home.html" class="link">Home</a>
                <div class="dropdown">
                    <a href="../Shop/shop1.html" class="link">Shop</a>
                    <div class="dropdown-menu">
                        <a href="../produit_management/view/front/addingproduct.php" class="dropdown-link">Sell Product</a>
                    </div>
                </div>
            </div>
            <div class="logo">
                <h1>
                    <span class="green">Green</span><span class="harvest">Harvest</span>
                </h1>
            </div>
            <div class="right-content">
                <div class="dropdown">
                    <a href="../back/eventacc.php" class="link">Events</a>
                    <div class="dropdown-menu">
                        <a href="add_event.php" class="dropdown-link">Create Event</a>
                        <a href="../back/eventacc.php" class="dropdown-link">View Events</a>
                    </div>
                </div>
                <a href="../contact/contact.html" class="link">Contact</a>
                <div class="dropdown">
                    <a href="#" class="logo-link">
                        <img src="Group 8.png" alt="Group 8 Logo" class="logo-img" />
                    </a>
                    <div class="dropdown-menu">
                        <a href="../user/signup.html" class="dropdown-link">Sign Up</a>
                        <a href="../user/login.html" class="dropdown-link">Log In</a>
                    </div>
                </div>
                <a href="../panier/index.html" class="logo-link">
                    <img src="Group 7.png" alt="Group 7 Logo" class="logo-img" />
                </a>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <h2><center>Event Calendar</center></h2>
    <div class="container">
        <div id="calendar"></div>
    </div>
    <br>
    <a href="../back/eventacc.php" class="back-btn">Back to Events</a>

    <script>
    $(document).ready(function() {
        // Initialize FullCalendar
        $('#calendar').fullCalendar({
            events: <?php echo json_encode($calendarEvents); ?>,  // Pass PHP events to FullCalendar

            // When an event is clicked, redirect to reservation.php with the event ID
            eventClick: function(event) {
                // Redirect to reservation.php, passing the event ID as a query parameter
                window.location.href = '../front/addreservation.php?id_event=' + event.id;
            }
        });
    });
    </script>

</body>
</html>
