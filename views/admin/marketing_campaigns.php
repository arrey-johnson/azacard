<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marketing Campaigns - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Marketing Campaigns</h1>
            <a href="?page=admin&action=create_marketing_campaign" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg shadow transition duration-200">+ Create Campaign</a>
        </div>
        <div class="bg-white rounded-lg shadow p-6 overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Subject</th>
                        <th class="px-4 py-2">Segment</th>
                        <th class="px-4 py-2">Scheduled At</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($campaigns as $campaign): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2 font-medium"><?php echo htmlspecialchars($campaign['subject']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $campaign['segment']))); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($campaign['scheduled_at']); ?></td>
                            <td class="px-4 py-2">
                                <?php if ($campaign['status'] === 'sent'): ?>
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Sent</span>
                                <?php elseif ($campaign['status'] === 'scheduled'): ?>
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Scheduled</span>
                                <?php elseif ($campaign['status'] === 'cancelled'): ?>
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Cancelled</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="?page=admin&action=view_campaign&id=<?php echo $campaign['id']; ?>" class="text-google-blue underline">View</a>
                                <?php if ($campaign['status'] === 'scheduled'): ?>
                                    <a href="?page=admin&action=send_campaign_now&id=<?php echo $campaign['id']; ?>" class="bg-google-green text-white px-2 py-1 rounded text-xs font-semibold">Send Now</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($campaigns)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-gray-500">No campaigns found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 