<head>
    <title>FilmWave - Streaming Movies</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">
</head>
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-2xl">
        <div class="md:flex">
            <div class="p-8 w-full">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Cancel Your Subscription</h1>
                    <p class="text-gray-600 mt-2">We're sorry to see you go</p>
                </div>

                <div class="mb-6 bg-yellow-50 border border-yellow-200 p-4 rounded-md">
                    <h2 class="font-semibold text-yellow-800 mb-2">What happens when you cancel:</h2>
                    <ul class="list-disc pl-5 text-yellow-700 text-sm">
                        <li class="mb-1">Your subscription will remain active until the end of your current billing period</li>
                        <li class="mb-1">You won't be charged again</li>
                        <li class="mb-1">You'll lose access to premium features after the current period ends</li>
                        <li class="mb-1">You can resubscribe anytime</li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="font-medium text-gray-800 mb-2">Would you mind telling us why you're leaving?</h3>
                    <form action="#" method="POST">
                        @csrf
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input id="reason_price" name="reason" type="radio" value="price" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                                <label for="reason_price" class="ml-3 text-sm text-gray-700">Too expensive</label>
                            </div>
                            <div class="flex items-center">
                                <input id="reason_features" name="reason" type="radio" value="features" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                                <label for="reason_features" class="ml-3 text-sm text-gray-700">Missing features</label>
                            </div>
                            <div class="flex items-center">
                                <input id="reason_unused" name="reason" type="radio" value="unused" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                                <label for="reason_unused" class="ml-3 text-sm text-gray-700">Not using it enough</label>
                            </div>
                            <div class="flex items-center">
                                <input id="reason_other" name="reason" type="radio" value="other" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                                <label for="reason_other" class="ml-3 text-sm text-gray-700">Other reason</label>
                            </div>
                            <div class="mt-3">
                                <label for="comments" class="block text-sm font-medium text-gray-700">Additional comments (optional)</label>
                                <textarea id="comments" name="comments" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            </div>
                        </div>

                        <div class="mt-8 space-y-3">
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Cancel My Subscription
                            </button>
                            <a href="{{route('subscribe.checkout')}}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Keep My Subscription
                            </a>
                        </div>
                    </form>
                </div>
                
                <p class="text-xs text-gray-500 text-center">
                    Need help? <a href="#" class="text-indigo-600 hover:text-indigo-500">Contact our support team</a>
                </p>
            </div>
        </div>
    </div>
</div>
