<?php
$page_title = 'Analytics Dashboard';
include('header.php');
include('config.php');  // database connection
?>

<h2>📊 Analytics Dashboard</h2>
<p>Live statistics from your contact form submissions.</p>

<?php
// 1. Total messages
$total_query = "SELECT COUNT(*) as total FROM contacts";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_messages = $total_row['total'];

// 2. Latest 5 messages
$recent_query = "SELECT name, email, message, submitted_at FROM contacts ORDER BY submitted_at DESC LIMIT 5";
$recent_result = mysqli_query($conn, $recent_query);

// 3. Messages per day (last 7 days)
$daily_query = "SELECT DATE(submitted_at) as date, COUNT(*) as count FROM contacts 
                WHERE submitted_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                GROUP BY DATE(submitted_at) ORDER BY date DESC";
$daily_result = mysqli_query($conn, $daily_query);
?>

<!-- Stats Cards -->
<div style="display: flex; gap: 1rem; margin: 2rem 0; flex-wrap: wrap;">
    <div style="background: #1abc9c; color: white; padding: 1rem; border-radius: 8px; flex: 1; text-align: center;">
        <h3>Total Messages</h3>
        <p style="font-size: 2rem;"><?php echo $total_messages; ?></p>
    </div>
    <div style="background: #3498db; color: white; padding: 1rem; border-radius: 8px; flex: 1; text-align: center;">
        <h3>Last 7 Days</h3>
        <p style="font-size: 2rem;"><?php echo mysqli_num_rows($daily_result); ?> days with activity</p>
    </div>
</div>

<!-- Recent Messages Table -->
<h3>📨 Latest 5 Messages</h3>
<table border="1" cellpadding="8" style="width: 100%; border-collapse: collapse; background: white;">
    <tr style="background: #2c3e50; color: white;">
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Submitted At</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($recent_result)): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
        <td><?php echo $row['submitted_at']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- Simple Bar Chart (CSS only) -->
<h3>📅 Messages Per Day (Last 7 Days)</h3>
<div style="display: flex; gap: 1rem; align-items: flex-end; margin-top: 1rem; flex-wrap: wrap;">
<?php 
// Reset the daily result pointer to loop again (optional – we already looped? No, we only fetched rows above but didn't store them. Better to re-run the query or store in array.)
// Simpler: re-run the daily query or store results. Let's re-run:
$daily_result2 = mysqli_query($conn, $daily_query);
while ($row = mysqli_fetch_assoc($daily_result2)): 
    $bar_height = $row['count'] * 40; // scale factor (max 40px per message)
?>
    <div style="text-align: center;">
        <div style="background: #e67e22; width: 60px; height: <?php echo $bar_height; ?>px; border-radius: 4px;"></div>
        <span style="font-size: 0.8rem;"><?php echo $row['date']; ?><br>(<?php echo $row['count']; ?>)</span>
    </div>
<?php endwhile; ?>
</div>

<?php
mysqli_close($conn);
include('footer.php');
?>