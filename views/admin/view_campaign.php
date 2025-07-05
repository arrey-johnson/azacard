<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Campaign Details - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-2 sm:px-4 py-8">
        <a href="?page=admin&action=marketing_campaigns" class="text-google-blue underline mb-4 inline-block">&larr; Back to Campaigns</a>
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold mb-4">Campaign Details</h1>
            <?php if (!empty($_GET['success'])): ?>
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">Action completed successfully.</div>
            <?php endif; ?>
            <div class="mb-4">
                <span class="font-medium">Subject:</span> <?php echo htmlspecialchars($campaign['subject']); ?>
            </div>
            <div class="mb-4">
                <span class="font-medium">Segment:</span> <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $campaign['segment']))); ?>
            </div>
            <div class="mb-4">
                <span class="font-medium">Scheduled At:</span> <?php echo htmlspecialchars($campaign['scheduled_at']); ?>
            </div>
            <div class="mb-4">
                <span class="font-medium">Status:</span>
                <?php if ($campaign['status'] === 'sent'): ?>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Sent</span>
                <?php elseif ($campaign['status'] === 'scheduled'): ?>
                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Scheduled</span>
                <?php elseif ($campaign['status'] === 'cancelled'): ?>
                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Cancelled</span>
                <?php endif; ?>
            </div>
            <div class="mb-6">
                <span class="font-medium">HTML Preview:</span>
                <div class="border-2 border-google-blue rounded p-4 bg-gradient-to-br from-white via-blue-50 to-green-50 mt-2" style="min-height:100px;">
                    <?php echo $campaign['html_body']; ?>
                </div>
            </div>
            <?php if ($campaign['status'] === 'scheduled'): ?>
                <a href="?page=admin&action=send_campaign_now&id=<?php echo $campaign['id']; ?>" class="bg-gradient-to-r from-google-blue to-google-green hover:from-google-green hover:to-google-blue text-white px-6 py-2 rounded-lg font-medium shadow-lg transition duration-200">Send Now</a>
            <?php endif; ?>
            <h2 class="text-lg font-semibold mt-8 mb-2">Recipient Log</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Sent At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recipients as $r): ?>
                            <tr class="border-b">
                                <td class="px-4 py-2"><?php echo htmlspecialchars($r['name']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($r['email']); ?></td>
                                <td class="px-4 py-2">
                                    <?php if ($r['sent_status'] === 'sent'): ?>
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Sent</span>
                                    <?php elseif ($r['sent_status'] === 'failed'): ?>
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Failed</span>
                                    <?php else: ?>
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($r['sent_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recipients)): ?>
                            <tr><td colspan="4" class="text-center py-4 text-gray-500">No recipients logged yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html> 