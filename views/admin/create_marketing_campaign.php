<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Marketing Campaign - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
    function updatePreview() {
        var html = document.getElementById('html_body').value;
        document.getElementById('preview').innerHTML = html;
    }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-2 sm:px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Create Marketing Campaign</h1>
        <a href="?page=admin&action=marketing_campaigns" class="text-google-blue underline mb-4 inline-block">&larr; Back to Campaigns</a>
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 max-w-2xl mx-auto">
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?php echo htmlspecialchars($error); ?></div>
            <?php elseif (!empty($success)): ?>
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-4">
                    <label class="block font-medium mb-1">Subject</label>
                    <input type="text" name="subject" class="w-full border rounded px-3 py-2" required value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">HTML Body</label>
                    <textarea id="html_body" name="html_body" class="w-full border rounded px-3 py-2 h-32" required oninput="updatePreview()" onchange="updatePreview()"><?php echo htmlspecialchars($_POST['html_body'] ?? ''); ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">Plain Text Body (optional)</label>
                    <textarea name="text_body" class="w-full border rounded px-3 py-2 h-20"><?php echo htmlspecialchars($_POST['text_body'] ?? ''); ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">Recipient Segment</label>
                    <select name="segment" class="w-full border rounded px-3 py-2">
                        <option value="all" <?php if (($_POST['segment'] ?? '') === 'all') echo 'selected'; ?>>All Users</option>
                        <option value="card_owners" <?php if (($_POST['segment'] ?? '') === 'card_owners') echo 'selected'; ?>>Card Owners Only</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">Schedule Send Time</label>
                    <input type="datetime-local" name="scheduled_at" class="w-full border rounded px-3 py-2" required value="<?php echo htmlspecialchars($_POST['scheduled_at'] ?? ''); ?>">
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="send_now" id="send_now" class="mr-2" <?php if (!empty($_POST['send_now'])) echo 'checked'; ?>>
                    <label for="send_now" class="font-medium">Send Now</label>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-lg shadow-lg transition duration-200">Submit Campaign</button>
            </form>
            <div class="mt-8">
                <h2 class="text-lg font-semibold mb-2">Live HTML Preview</h2>
                <div id="preview" class="border-2 border-google-blue rounded p-2 sm:p-4 bg-gradient-to-br from-white via-blue-50 to-green-50" style="min-height:100px;"></div>
            </div>
        </div>
    </div>
    <script>updatePreview();</script>
</body>
</html> 