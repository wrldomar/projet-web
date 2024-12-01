<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="dash.css" />
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>
    <div class="sidebar">
      <div class="logo-details">
        <i class="bx bxl-google"></i>
        <a href="../front/home.html" class="logo-link">
          <span class="logo_name">GreenHarvest</span>
        </a>
      </div>
      <ul class="nav-links">
        <li>
          <a href="#" class="active">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-box"></i>
            <span class="links_name">Product</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-list-ul"></i>
            <span class="links_name">Order list</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-coin-stack"></i>
            <span class="links_name">Stock</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-book-alt"></i>
            <span class="links_name">Total order</span>
          </a>
        </li>
        <li>
          <a href="#" onclick="showChart()">
            <i class="bx bx-user"></i>
            <span class="links_name">Chart</span>
          </a>
        </li>
        <li>
          <a href="reser.php">
            <i class="bx bx-message"></i>
            <span class="links_name">Reservations</span>
          </a>
        </li>
        <li>
          <a href="eventlist.php">
            <i class="bx bx-calendar-event"></i>
            <span class="links_name">Events</span>
          </a>
        </li>
      </ul>
    </div>

    <section class="home-section">
      <nav>
        <div class="sidebar-button">
          <i class="bx bx-menu sidebarBtn"></i>
          <span class="dashboard">Dashboard</span>
        </div>
        <div class="search-box">
          <input type="text" placeholder="Search..." />
          <i class="bx bx-search"></i>
        </div>
      </nav>

      <div class="home-content">
        <div class="overview-boxes">
          <!-- Other overview boxes here -->
        </div>

        <!-- Chart Container (Initially Hidden) -->
        <div id="chartContainer" class="chart-container" style="display: none;">
          <!-- Chart content will be dynamically inserted here -->
          <?php
          require_once '../../controller/ReservationController.php';

          // Initialize the controller
          $reservationController = new ReservationController();

          // Fetch reservation data
          $reservationsData = $reservationController->listreservations();

          // Assume ticket price is constant for this example
          $ticketPrice = 20;

          // Prepare event data
          $eventsData = [];
          $eventNames = [];  // Array to store event names
          $db = config::getConnexion(); // Database connection

          foreach ($reservationsData as $reservation) {
              $eventId = $reservation['id_event'];
              $tickets = $reservation['nbr_tickets'];
              $totalPrice = $tickets * $ticketPrice;

              // Get event name based on event ID
              if (!isset($eventNames[$eventId])) {
                  $eventNameSql = "SELECT nom_event FROM event WHERE id_event = :id_event";
                  $stmt = $db->prepare($eventNameSql);
                  $stmt->execute(['id_event' => $eventId]);
                  $eventName = $stmt->fetch(PDO::FETCH_ASSOC);
                  $eventNames[$eventId] = $eventName['nom_event'];  // Store the event name by event ID
              }

              // Initialize event data if not already set
              if (!isset($eventsData[$eventId])) {
                  $eventsData[$eventId] = [
                      'tickets' => 0, 'revenue' => 0, 'reservations' => 0
                  ];
              }

              // Update event data
              $eventsData[$eventId]['tickets'] += $tickets;
              $eventsData[$eventId]['revenue'] += $totalPrice;
              $eventsData[$eventId]['reservations'] += 1;
          }

          // Prepare data for chart
          $eventIds = array_keys($eventsData);
          $eventTickets = array_column($eventsData, 'tickets');
          $eventRevenue = array_column($eventsData, 'revenue');
          $eventReservations = array_column($eventsData, 'reservations');
          $eventNamesArray = array_map(function($id) use ($eventNames) {
              return $eventNames[$id];
          }, $eventIds);  // Use the event names instead of event IDs
          ?>

          <div class="container">
            <h1>Event Reservation Analysis</h1>
            <div class="chart-container">
              <canvas id="eventChart"></canvas>
            </div>
          </div>

          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          <script>
            // Pass PHP arrays to JavaScript
            var eventNames = <?php echo json_encode($eventNamesArray); ?>;
            var eventTickets = <?php echo json_encode($eventTickets); ?>;
            var eventRevenue = <?php echo json_encode($eventRevenue); ?>;
            var eventReservations = <?php echo json_encode($eventReservations); ?>;

            // Create the chart
            var ctx = document.getElementById('eventChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: eventNames,  
                    datasets: [
                        {
                            label: 'Total Tickets Reserved',
                            data: eventTickets,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            yAxisID: 'y1'
                        },
                        {
                            label: 'Revenue ($)',
                            data: eventRevenue,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            yAxisID: 'y2'
                        },
                        {
                            label: 'Total Reservations',
                            data: eventReservations,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            yAxisID: 'y3'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y1: {
                            beginAtZero: true,
                            position: 'left',
                            ticks: {
                                color: 'rgba(54, 162, 235, 1)'
                            }
                        },
                        y2: {
                            beginAtZero: true,
                            position: 'right',
                            ticks: {
                                color: 'rgba(255, 99, 132, 1)'
                            }
                        },
                        y3: {
                            beginAtZero: true,
                            position: 'right',
                            ticks: {
                                color: 'rgba(75, 192, 192, 1)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    if (tooltipItem.datasetIndex === 0) {
                                        return 'Tickets: ' + tooltipItem.raw;
                                    } else if (tooltipItem.datasetIndex === 1) {
                                        return 'Revenue: $' + tooltipItem.raw;
                                    } else if (tooltipItem.datasetIndex === 2) {
                                        return 'Reservations: ' + tooltipItem.raw;
                                    }
                                }
                            }
                        }
                    }
                }
            });
          </script>
        </div>
      </div>
    </section>

    <script>
      function showChart() {
        var chartContainer = document.getElementById('chartContainer');
        chartContainer.style.display = 'block';  // Show chart container
      }
    </script>
  </body>
</html>
