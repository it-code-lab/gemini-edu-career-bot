<?php
$conn = new mysqli("localhost", "root", "", "youtube_db");

// Handle Status Updates
if(isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $new_status = $_POST['status'];
    $conn->query("UPDATE community_vault SET status='$new_status' WHERE id=$id");
}

$result = $conn->query("SELECT * FROM community_vault ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Creator Dashboard</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; padding: 40px; }
        .dashboard-card { background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; background: #f1f5f9; padding: 12px; color: #475569; }
        td { padding: 12px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        .tag { padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; }
        .tag-intent { background: #dcfce7; color: #166534; }
        .tag-theme { background: #dbeafe; color: #1e40af; }
        .status-select { padding: 5px; border-radius: 4px; border: 1px solid #cbd5e1; }
        audio { height: 30px; width: 200px; }
    </style>
</head>
<body>

<div class="dashboard-card">
    <h2>Community Content Inbox</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>User & Stage</th>
                <th>Category</th>
                <th>Input / Audio</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                <td>
                    <strong><?php echo htmlspecialchars($row['user_name'] ?: 'Anonymous'); ?></strong> 
                    <?php if($row['user_region']): ?>
                        <small>(<?php echo htmlspecialchars($row['user_region']); ?>)</small>
                    <?php endif; ?><br>
                    <small><?php echo htmlspecialchars($row['user_email']); ?></small><br>
                    <hr style="border:0; border-top:1px solid #eee; margin:5px 0;">
                    <strong><?php echo htmlspecialchars($row['user_type']); ?></strong><br>
                    <small><?php echo htmlspecialchars($row['current_stage']); ?></small>
                    <?php if($row['can_feature']): ?> 
                        <br><span style="color:green; font-size:10px;">✅ OK to Feature</span> 
                    <?php endif; ?>
                </td>
                <td>
                    <span class="tag tag-intent"><?php echo $row['intent_type']; ?></span><br>
                    <span class="tag tag-theme"><?php echo $row['theme_area']; ?></span>
                </td>
                <td>
                    <?php if($row['audio_path']): ?>
                        <audio controls src="<?php echo $row['audio_path']; ?>"></audio>
                    <?php else: ?>
                        <div style="max-width:300px; font-size:0.9rem;"><?php echo nl2br(htmlspecialchars($row['user_query'])); ?></div>
                    <?php endif; ?>
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <select name="status" class="status-select" onchange="this.form.submit()">
                            <option value="New" <?php if($row['status'] == 'New') echo 'selected'; ?>>New</option>
                            <option value="Planned" <?php if($row['status'] == 'Planned') echo 'selected'; ?>>Planned</option>
                            <option value="Filmed" <?php if($row['status'] == 'Filmed') echo 'selected'; ?>>Filmed</option>
                        </select>
                        <input type="hidden" name="update_status" value="1">
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>