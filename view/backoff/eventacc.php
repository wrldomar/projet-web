<?php
include '../../Controller/eventC.php';

$eventC = new eventController();

// Get search query and date range inputs
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Handle pagination
$eventsPerPage = 5;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $eventsPerPage;

// Fetch filtered events
$list = $eventC->searchAndPaginateEvents($searchQuery, $startDate, $endDate, $eventsPerPage, $offset);

// Fetch total number of filtered events for pagination
$totalEvents = $eventC->countFilteredEvents($searchQuery, $startDate, $endDate);
$totalPages = ceil($totalEvents / $eventsPerPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Events - Tunisia Tour</title>
    <link rel="stylesheet" href="taccc.css">
</head>
<body>
    <div id="main-content">
        <header id="header">
            <div class="header-content">
                <div class="left-content">
                    <a href="../frontoff/home.html" class="link">Home</a>
                    <div class="dropdown">
                        <a href="../frontoff/listcategories.php" class="link">Shop</a>
                        
                    </div>
                </div>
                <div class="logo">
                    <h1>
                        <span class="green">Green</span><span class="harvest">Harvest</span>
                    </h1>
                </div>
                <div class="right-content">
                    <div class="dropdown">
                        <a href="#" class="link">Events</a>
                        <div ></div>
                    </div>
                   
                    <div class="dropdown">
                        <a href="#" class="logo-link">
                            <img src="Group 8.png" alt="Group 8 Logo" class="logo-img" />
                        </a>
                    </div>
                    <a href="../frontoff/displaypanier.php" class="logo-link">
                        <img src="Group 7.png" alt="Group 7 Logo" class="logo-img" />
                    </a>
                </div>
            </div>
        </header>
    </div>

    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search events..." value="<?= htmlspecialchars($searchQuery); ?>">
            <input type="date" name="start_date" value="<?= htmlspecialchars($startDate); ?>">
            <input type="date" name="end_date" value="<?= htmlspecialchars($endDate); ?>">
            <button type="submit">Filter</button>
        </form>
        <!-- Add a button that links to the calendar -->
        <a href="calendar.php" class="go-to-calendar-btn">Go to Calendar</a>
    </div>

    <div class="events-container">
        <h2>Events Between Your Selected Dates</h2>
        <div class="event-list">
        <?php if (!empty($list)) { ?>
            <?php foreach ($list as $event) { ?>
                <div class="event-item">
                    <?php if (!empty($event['image_url'])): ?>
                        <img src="<?= htmlspecialchars($event['image_url']); ?>" alt="Image">
                    <?php else: ?>
                        <p>No image available</p>
                    <?php endif; ?>
                    <div class="event-details">
                        <h3><?= htmlspecialchars($event['nom_event']); ?></h3>
                        <p><strong>Date:</strong> <?= $event['Date']; ?></p>
                        <p><strong>Time:</strong> <?= $event['heure']; ?></p>
                        <p><strong>Duration:</strong> <?= $event['duration']; ?> hours</p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($event['location_event']); ?></p>
                        <p><strong>Description:</strong> <?= htmlspecialchars($event['describtion']); ?></p>
                        <p><strong>Price:</strong> <?= $event['Ticket_price']; ?> DT</p>
                        <p><strong>Capacity:</strong> <?= $event['Max_Tickets']; ?> people</p>
                        <a href="../frontoff/addreservation.php?id_event=<?= htmlspecialchars($event['id_event']); ?>" class="reserve-btn">RESERVE</a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No events found for the selected dates.</p>
        <?php } ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="?search=<?= htmlspecialchars($searchQuery); ?>&start_date=<?= htmlspecialchars($startDate); ?>&end_date=<?= htmlspecialchars($endDate); ?>&page=<?= $currentPage - 1; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?search=<?= htmlspecialchars($searchQuery); ?>&start_date=<?= htmlspecialchars($startDate); ?>&end_date=<?= htmlspecialchars($endDate); ?>&page=<?= $i; ?>" 
                   class="<?= $i === $currentPage ? 'active' : ''; ?>">
                   <?= $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?search=<?= htmlspecialchars($searchQuery); ?>&start_date=<?= htmlspecialchars($startDate); ?>&end_date=<?= htmlspecialchars($endDate); ?>&page=<?= $currentPage + 1; ?>">Next</a>
            <?php endif; ?>
        </div>

        <!-- Make a Reclamation Button -->
        <div class="reclamation-btn-container">
            <a href="../frontoff/addreclamation.php" class="reclamation-btn">Make a Reclamation</a>
        </div>

    </div>
    
    <footer>
        <p>&copy; 2024 Tunisia Agriculture Tours | All Rights Reserved</p>
    </footer>
</body>
</html>
