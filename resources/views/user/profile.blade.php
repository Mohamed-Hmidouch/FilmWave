<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile - FilmWave</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'film-dark': '#0f0f0f',
                        'film-gray': '#1a1a1a',
                        'film-red': '#e50914',
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Radix UI Icons -->
    <script src="https://unpkg.com/@radix-ui/icons@1.x.x/index.umd.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@radix-ui/colors@latest/gray.css">
    <link rel="stylesheet" href="https://unpkg.com/@radix-ui/colors@latest/blue.css">
</head>
<body class="bg-film-dark text-white">
    <!-- Include navbar -->
    @include('partials.navbar')
    
    <div class="container mx-auto pt-24 px-4 md:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-film-gray rounded-lg overflow-hidden shadow-xl">
                <!-- Profile Header -->
                <div class="relative">
                    <!-- Cover image -->
                    <div class="h-48 bg-gradient-to-r from-purple-900 to-film-red"></div>
                    
                    <!-- Profile image -->
                    <div class="absolute bottom-0 left-6 transform translate-y-1/2">
                        <div class="relative">
                            <div class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-film-gray overflow-hidden bg-film-gray">
                                <img 
                                    src="https://ui-avatars.com/api/?name={{ $user->name }}&background=e50914&color=fff&size=256"
                                    alt="{{ $user->name }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            
                            <!-- Edit profile image button -->
                            <button 
                                class="absolute bottom-0 right-0 bg-film-red p-2 rounded-full shadow-md hover:bg-red-700 transition"
                                x-data
                                @click="alert('Profile photo upload functionality will be implemented')"
                            >
                                <i class="fas fa-camera text-white text-sm"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Edit cover button -->
                    <button 
                        class="absolute top-4 right-4 bg-black/50 hover:bg-black/80 transition text-white px-3 py-1 rounded-md text-sm"
                        x-data
                        @click="alert('Cover photo upload functionality will be implemented')"
                    >
                        <i class="fas fa-edit mr-1"></i> Edit Cover
                    </button>
                </div>
                
                <!-- Profile info -->
                <div class="pt-16 px-6 pb-6">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                        <div>
                            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                            <p class="text-gray-400">{{ $user->email }}</p>
                            
                            <!-- User Role Badge -->
                            <div class="mt-2">
                                @foreach($user->roles as $role)
                                    <span class="bg-film-red/20 text-film-red text-xs px-2 py-1 rounded-md">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('settings') }}" class="inline-flex items-center bg-film-gray hover:bg-gray-800 border border-gray-700 text-white px-4 py-2 rounded-md transition">
                                <i class="fas fa-cog mr-2"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tabs for different sections -->
            <div class="mt-6" x-data="{ activeTab: 'overview' }">
                <!-- Tab navigation -->
                <div class="border-b border-gray-700">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="mr-2">
                            <button 
                                @click="activeTab = 'overview'" 
                                :class="activeTab === 'overview' ? 'border-film-red text-film-red' : 'border-transparent hover:border-gray-600 text-gray-400 hover:text-gray-300'"
                                class="inline-flex items-center px-4 py-2 border-b-2 font-medium text-sm focus:outline-none">
                                <i class="fas fa-user mr-2"></i> Overview
                            </button>
                        </li>
                        <li class="mr-2">
                            <button 
                                @click="activeTab = 'watchlist'" 
                                :class="activeTab === 'watchlist' ? 'border-film-red text-film-red' : 'border-transparent hover:border-gray-600 text-gray-400 hover:text-gray-300'"
                                class="inline-flex items-center px-4 py-2 border-b-2 font-medium text-sm focus:outline-none">
                                <i class="fas fa-list mr-2"></i> Watchlist
                            </button>
                        </li>
                        <li class="mr-2">
                            <button 
                                @click="activeTab = 'activity'" 
                                :class="activeTab === 'activity' ? 'border-film-red text-film-red' : 'border-transparent hover:border-gray-600 text-gray-400 hover:text-gray-300'"
                                class="inline-flex items-center px-4 py-2 border-b-2 font-medium text-sm focus:outline-none">
                                <i class="fas fa-history mr-2"></i> Activity
                            </button>
                        </li>
                        <li>
                            <button 
                                @click="activeTab = 'membership'" 
                                :class="activeTab === 'membership' ? 'border-film-red text-film-red' : 'border-transparent hover:border-gray-600 text-gray-400 hover:text-gray-300'"
                                class="inline-flex items-center px-4 py-2 border-b-2 font-medium text-sm focus:outline-none">
                                <i class="fas fa-id-card mr-2"></i> Membership
                            </button>
                        </li>
                    </ul>
                </div>
                
                <!-- Tab content -->
                <div class="py-6">
                    <!-- Overview tab -->
                    <div x-show="activeTab === 'overview'" class="space-y-6">
                        <div class="bg-film-gray rounded-lg p-6">
                            <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-400 text-sm mb-1">Full Name</label>
                                    <div class="text-white">{{ $user->name }}</div>
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-sm mb-1">Email Address</label>
                                    <div class="text-white">{{ $user->email }}</div>
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-sm mb-1">Member Since</label>
                                    <div class="text-white">{{ $user->created_at->format('F j, Y') }}</div>
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-sm mb-1">Last Login</label>
                                    <div class="text-white">{{ now()->subDays(rand(0, 7))->format('F j, Y, g:i a') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-film-gray rounded-lg p-6">
                            <h2 class="text-xl font-semibold mb-4">Preferences</h2>
                            <div class="space-y-4">
                                <div x-data="{ enabled: true }">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-medium">Email Notifications</h3>
                                            <p class="text-sm text-gray-400">Receive emails about new releases and recommendations</p>
                                        </div>
                                        <button 
                                            @click="enabled = !enabled" 
                                            :class="enabled ? 'bg-film-red' : 'bg-gray-700'"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full transition-colors duration-200 ease-in-out focus:outline-none"
                                        >
                                            <span 
                                                :class="enabled ? 'translate-x-5' : 'translate-x-1'"
                                                class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out mt-1"
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                                
                                <div x-data="{ enabled: false }">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-medium">Push Notifications</h3>
                                            <p class="text-sm text-gray-400">Get notified when new content is available</p>
                                        </div>
                                        <button 
                                            @click="enabled = !enabled" 
                                            :class="enabled ? 'bg-film-red' : 'bg-gray-700'"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full transition-colors duration-200 ease-in-out focus:outline-none"
                                        >
                                            <span 
                                                :class="enabled ? 'translate-x-5' : 'translate-x-1'"
                                                class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out mt-1"
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Watchlist tab -->
                    <div x-show="activeTab === 'watchlist'" class="space-y-6">
                        <div class="bg-film-gray rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-semibold">My Watchlist</h2>
                                <div class="flex space-x-2">
                                    <button class="bg-transparent hover:bg-gray-700 text-gray-300 px-3 py-1 rounded border border-gray-700 text-sm">
                                        <i class="fas fa-sort mr-1"></i> Sort
                                    </button>
                                    <button class="bg-transparent hover:bg-gray-700 text-gray-300 px-3 py-1 rounded border border-gray-700 text-sm">
                                        <i class="fas fa-filter mr-1"></i> Filter
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Empty state for watchlist -->
                            <div class="text-center py-10">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-film-gray border-2 border-gray-700 mb-4">
                                    <i class="fas fa-film text-2xl text-gray-500"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-300">Your watchlist is empty</h3>
                                <p class="text-gray-400 mt-2">Start adding movies and shows to your watchlist</p>
                                <a href="{{ route('movies') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-film-red hover:bg-red-700 text-white rounded transition">
                                    Browse Movies
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Activity tab -->
                    <div x-show="activeTab === 'activity'" class="space-y-6">
                        <div class="bg-film-gray rounded-lg p-6">
                            <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
                            
                            <div class="space-y-4">
                                <!-- Sample activity items -->
                                <div class="flex items-start space-x-3 pb-4 border-b border-gray-700">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                                        <i class="fas fa-eye text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-white">You watched <span class="text-film-red font-medium">Inception</span></p>
                                        <p class="text-xs text-gray-400">2 days ago</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3 pb-4 border-b border-gray-700">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center">
                                        <i class="fas fa-plus text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-white">You added <span class="text-film-red font-medium">Stranger Things</span> to your watchlist</p>
                                        <p class="text-xs text-gray-400">1 week ago</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-600 flex items-center justify-center">
                                        <i class="fas fa-star text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-white">You rated <span class="text-film-red font-medium">The Dark Knight</span> 5 stars</p>
                                        <p class="text-xs text-gray-400">2 weeks ago</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <button class="text-sm text-film-red hover:text-red-400 transition">
                                    View All Activity
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Membership tab -->
                    <div x-show="activeTab === 'membership'" class="space-y-6">
                        <div class="bg-film-gray rounded-lg p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                                <div>
                                    <h2 class="text-xl font-semibold">Current Plan</h2>
                                    <p class="text-gray-400 mt-1">Manage your subscription</p>
                                </div>
                                
                                @foreach($user->roles as $role)
                                    @if($role->name === 'PremiumUser')
                                        <div class="mt-4 md:mt-0 bg-gradient-to-r from-amber-600 to-amber-400 text-white px-4 py-2 rounded-md font-medium">
                                            Premium Subscription
                                        </div>
                                    @else
                                        <div class="mt-4 md:mt-0 bg-gradient-to-r from-gray-600 to-gray-500 text-white px-4 py-2 rounded-md font-medium">
                                            Free Account
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            
                            <div class="bg-film-dark/50 rounded-lg p-4 mb-6">
                                @foreach($user->roles as $role)
                                    @if($role->name === 'PremiumUser')
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                            <div>
                                                <h3 class="font-medium">Premium Plan</h3>
                                                <p class="text-gray-400 text-sm">Renewal date: {{ now()->addMonths(1)->format('F j, Y') }}</p>
                                            </div>
                                            <div class="mt-2 md:mt-0">
                                                <span class="text-2xl font-bold">$12.99</span>
                                                <span class="text-gray-400">/month</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                            <div>
                                                <h3 class="font-medium">Free Plan</h3>
                                                <p class="text-gray-400 text-sm">Limited access to content</p>
                                            </div>
                                            <div class="mt-2 md:mt-0">
                                                <span class="text-2xl font-bold">$0.00</span>
                                                <span class="text-gray-400">/month</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            
                            @foreach($user->roles as $role)
                                @if($role->name === 'FreeUser')
                                    <div class="bg-gradient-to-r from-film-red/10 to-purple-900/10 rounded-lg p-6 border border-film-red/20">
                                        <h3 class="text-lg font-semibold mb-2">Upgrade to Premium</h3>
                                        <ul class="mt-4 space-y-2">
                                            <li class="flex items-center">
                                                <i class="fas fa-check text-film-red mr-2"></i>
                                                <span>Unlimited access to all movies and TV shows</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-check text-film-red mr-2"></i>
                                                <span>Watch in 4K UHD when available</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-check text-film-red mr-2"></i>
                                                <span>Download content for offline viewing</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-check text-film-red mr-2"></i>
                                                <span>Ad-free streaming experience</span>
                                            </li>
                                        </ul>
                                        <div class="mt-6">
                                            <a href="{{ route('subscribe') }}" class="inline-flex items-center justify-center px-6 py-3 bg-film-red hover:bg-red-700 text-white font-medium rounded-md transition w-full md:w-auto">
                                                Upgrade Now
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        <button class="text-film-red hover:text-red-400 font-medium">
                                            Cancel Subscription
                                        </button>
                                        <p class="text-sm text-gray-400">
                                            Your subscription will continue until the end of the current billing period.
                                        </p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Include footer if you have one -->
    @if(View::exists('partials.footer'))
        @include('partials.footer')
    @endif
</body>
</html>