<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube OAuth Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
                <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-4">YouTube OAuth Authorized!</h1>
            <p class="text-gray-600 mb-6">
                Your YouTube channel has been successfully connected. AI comment replies are now enabled!
            </p>
            <div class="bg-blue-50 rounded-lg p-4 text-left">
                <p class="text-sm text-gray-700 mb-2">
                    <strong>Next step:</strong> Run the following command to sync comments and post AI replies:
                </p>
                <code class="block bg-gray-900 text-green-400 p-3 rounded text-sm">
                    php artisan sync:youtube-comments --with-replies
                </code>
            </div>
            <div class="mt-6">
                <a href="/" class="inline-block bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
