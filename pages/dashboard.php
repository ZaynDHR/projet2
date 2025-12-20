<?php
require_once '../config/config.php';
require_once '../classes/Auth.php';
require_once '../classes/Ticket.php';
require_once '../classes/User.php';

// Require authentication
Auth::requireAuth();

$currentUser = Auth::getUser();
$ticket = new Ticket();

// Get statistics
$stats = $ticket->getStatistics();

// Get recent activity
$recentActivity = $ticket->getRecentActivity(4);

// Get active tickets
$activeTickets = $ticket->getTickets(['limit' => 10]);

// Calculate percentages for donut charts
$totalTickets = $stats['total'] ?? 0;
$openTickets = $stats['open'] ?? 0;
$inProgressTickets = $stats['in_progress'] ?? 0;
$closedTickets = $stats['closed'] ?? 0;

$openPercentage = $totalTickets > 0 ? ($openTickets / $totalTickets) * 100 : 0;
$inProgressPercentage = $totalTickets > 0 ? ($inProgressTickets / $totalTickets) * 100 : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div class="dashboard-layout">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="dashboard-header">
                <div class="header-logo">
                     <div class="logo-text">BugTracker</div>
                 </div>
                 <div class="header-actions">
                     <a href="logout.php" class="icon-button" title="Logout">⏻</a>
                 </div>
            </header>

            <!-- Dashboard Container -->
            <div class="dashboard-container">
                <div class="dashboard-title-row">
                     <h1>Dashboard</h1>
                 </div>

                <!-- Two Column Layout -->
                <div class="dashboard-grid">
                    <!-- Column 1: Quick Filters and Ticket Description -->
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <!-- Quick Filters -->
                        <div class="card filters-section">
                            <h3>Quick Filters</h3>
                            <div class="filter-buttons">
                                <button class="filter-button active">All Tickets</button>
                                <button class="filter-button">My Tickets</button>
                                <button class="filter-button">High Priority</button>
                                <button class="filter-button">Open</button>
                                <button class="filter-button">Closed</button>
                                <button class="filter-button">Resolved</button>
                            </div>
                        </div>

                        <!-- Selected Ticket Description -->
                        <div class="card" id="selectedTicketCard" style="display: none;">
                            <div class="card-header">
                                <h3 id="selectedTicketTitle">Select a Ticket</h3>
                            </div>
                            <div class="ticket-description">
                                <div class="description-meta">
                                    <div class="meta-row">
                                        <span class="meta-label">Status:</span>
                                        <span id="selectedStatus" class="meta-value"></span>
                                    </div>
                                    <div class="meta-row">
                                        <span class="meta-label">Priority:</span>
                                        <span id="selectedPriority" class="meta-value"></span>
                                    </div>
                                </div>
                                <div style="margin-top: 16px;">
                                    <h4 style="font-size: 12px; font-weight: 600; color: #999; margin-bottom: 8px; text-transform: uppercase;">Description</h4>
                                    <p id="selectedDescription" style="font-size: 14px; color: #333; line-height: 1.6;"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Statistics and Tickets -->
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <!-- Statistics Grid -->
                        <div class="stats-grid">
                            <!-- Total Tickets -->
                             <div class="stat-card">
                                 <div class="stat-header">
                                     <div>
                                         <div class="stat-title">Total Tickets</div>
                                         <div class="stat-subtitle">All reported issues</div>
                                     </div>
                                 </div>
                                 <div class="chart-container">
                                     <svg class="donut-chart" viewBox="0 0 160 160">
                                         <circle cx="80" cy="80" r="70" fill="none" stroke="#f0f0f0" stroke-width="20"/>
                                         <circle cx="80" cy="80" r="70" fill="none" stroke="#5dd9c1" stroke-width="20"
                                                 stroke-dasharray="<?php echo ($totalTickets > 0 ? ($openTickets / $totalTickets) * 440 : 0); ?> 440"
                                                 transform="rotate(-90 80 80)" stroke-linecap="round"/>
                                         <circle cx="80" cy="80" r="70" fill="none" stroke="#ff9800" stroke-width="20"
                                                 stroke-dasharray="<?php echo ($totalTickets > 0 ? ($inProgressTickets / $totalTickets) * 440 : 0); ?> 440"
                                                 stroke-dashoffset="-<?php echo ($totalTickets > 0 ? ($openTickets / $totalTickets) * 440 : 0); ?>"
                                                 transform="rotate(-90 80 80)" stroke-linecap="round"/>
                                     </svg>
                                 </div>
                                 <div class="chart-legend">
                                     <div class="legend-item">
                                         <span class="legend-dot" style="background: #5dd9c1;"></span>
                                         <span>Open</span>
                                     </div>
                                     <div class="legend-item">
                                         <span class="legend-dot" style="background: #ff9800;"></span>
                                         <span>In Progress</span>
                                     </div>
                                     <div class="legend-item">
                                         <span class="legend-dot" style="background: #999;"></span>
                                         <span>Closed</span>
                                     </div>
                                 </div>
                                 <div style="margin-top: 12px; font-size: 13px; color: #666; text-align: center;">
                                     Tickets
                                 </div>
                             </div>

                            <!-- Open Tickets -->
                             <div class="stat-card">
                                 <div class="stat-header">
                                     <div>
                                         <div class="stat-title">Open Tickets</div>
                                         <div class="stat-subtitle">Currently active for resolution</div>
                                     </div>
                                 </div>
                                 <div class="chart-container">
                                     <svg class="donut-chart" viewBox="0 0 160 160">
                                         <circle cx="80" cy="80" r="70" fill="none" stroke="#f0f0f0" stroke-width="20"/>
                                         <circle cx="80" cy="80" r="70" fill="none" stroke="#5dd9c1" stroke-width="20"
                                                 stroke-dasharray="220 440"
                                                 transform="rotate(-90 80 80)" stroke-linecap="round"/>
                                     </svg>
                                 </div>
                                 <div class="chart-legend">
                                     <div class="legend-item">
                                         <span class="legend-dot" style="background: #f44336;"></span>
                                         <span>High Priority</span>
                                     </div>
                                     <div class="legend-item">
                                         <span class="legend-dot" style="background: #999;"></span>
                                         <span>Medium Priority</span>
                                     </div>
                                 </div>
                                 <div style="margin-top: 12px; font-size: 13px; color: #666; text-align: center;">
                                     Open
                                 </div>
                             </div>
                        </div>

                        <!-- Active Tickets -->
                        <div class="card tickets-section">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                                <h3 style="margin: 0;">Active Tickets</h3>
                                <a href="ticket-form.php" class="create-ticket-button">
                                    <span>➕</span>
                                    Create Ticket
                                </a>
                            </div>
                            <div class="tickets-list">
                                <?php if (empty($activeTickets)): ?>
                                    <p style="color: #999; text-align: center; padding: 20px;">No active tickets</p>
                                <?php else: ?>
                                    <?php foreach ($activeTickets as $t): ?>
                                        <div class="ticket-item" onclick="showTicketDetail(<?php echo $t['id']; ?>)" style="cursor: pointer;">
                                            <div class="ticket-header-row">
                                                <div class="ticket-title"><?php echo htmlspecialchars($t['title']); ?></div>
                                                <div class="ticket-badges">
                                                    <span class="badge badge-status <?php echo str_replace('_', '-', $t['status']); ?>">
                                                        <?php echo ucfirst(str_replace('_', ' ', $t['status'])); ?>
                                                    </span>
                                                    <span class="badge badge-priority <?php echo $t['priority']; ?>">
                                                        <?php echo ucfirst($t['priority']); ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ticket-id">ID: <?php echo htmlspecialchars($t['ticket_id']); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Detail Overlay Panel -->
    <div class="ticket-detail-overlay" id="ticketDetailOverlay">
        <div class="ticket-detail-panel">
            <div class="detail-header">
                <div class="detail-title-section">
                    <div class="detail-badges" id="detailBadges"></div>
                    <h2 id="detailTitle">Loading...</h2>
                </div>
                <div class="detail-actions">
                     <button class="action-button" title="Edit" id="editButton">
                         ✎
                     </button>
                     <button class="action-button delete" title="Delete" id="deleteButton">
                         ✕
                     </button>
                 </div>
            </div>

            <div class="detail-content">
                <div class="detail-section">
                    <div class="detail-section-title">Description</div>
                    <div class="detail-text" id="detailDescription">
                        Loading...
                    </div>
                </div>

                <div class="detail-meta" id="detailMeta">
                    <!-- Meta information will be loaded here -->
                </div>
            </div>

            <button class="close-panel-button" onclick="closeTicketDetail()">✕</button>
        </div>
    </div>

    <script>
        const ticketsData = <?php echo json_encode($activeTickets); ?>;
    </script>
    <script src="../js/dashboard.js"></script>
</body>
</html>
