<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Settings - FilmWave</title>
    
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
</head>
<body class="bg-film-dark text-white">
    <!-- Include navbar -->
    @include('partials.navbar')
    
    <div class="container mx-auto pt-24 px-4 md:px-6 lg:px-8 pb-12">
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <h1 class="text-3xl font-bold">Account Settings</h1>
                <p class="text-gray-400 mt-1">Manage your account preferences and personal information</p>
            </div>
            
            <!-- Settings navigation with Alpine.js tabs -->
            <div x-data="{ activeTab: 'profile' }" class="bg-film-gray rounded-lg overflow-hidden shadow-xl">
                <div class="flex border-b border-gray-700">
                    <button 
                        @click="activeTab = 'profile'" 
                        :class="activeTab === 'profile' ? 'border-film-red text-film-red' : 'border-transparent text-gray-400 hover:text-white'"
                        class="px-6 py-4 font-medium border-b-2 text-sm focus:outline-none transition"
                    >
                        <i class="fas fa-user mr-2"></i> Profile
                    </button>
                    <button 
                        @click="activeTab = 'security'" 
                        :class="activeTab === 'security' ? 'border-film-red text-film-red' : 'border-transparent text-gray-400 hover:text-white'"
                        class="px-6 py-4 font-medium border-b-2 text-sm focus:outline-none transition"
                    >
                        <i class="fas fa-lock mr-2"></i> Security
                    </button>
                    <button 
                        @click="activeTab = 'notifications'" 
                        :class="activeTab === 'notifications' ? 'border-film-red text-film-red' : 'border-transparent text-gray-400 hover:text-white'"
                        class="px-6 py-4 font-medium border-b-2 text-sm focus:outline-none transition"
                    >
                        <i class="fas fa-bell mr-2"></i> Notifications
                    </button>
                </div>
                
                <!-- Profile Settings Tab -->
                <div x-show="activeTab === 'profile'" class="p-6">
                    <form id="profile-form" class="space-y-6" action="#" method="post">
                        @csrf
                        <div class="mb-6 flex items-center">
                            <div class="w-20 h-20 rounded-full mr-4 overflow-hidden bg-gray-700 flex-shrink-0">
                                <img 
                                    src="https://ui-avatars.com/api/?name={{ $user->name }}&background=e50914&color=fff&size=256"
                                    alt="{{ $user->name }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <div>
                                <div class="flex space-x-2">
                                    <button type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded text-sm transition">
                                        Change Photo
                                    </button>
                                    <button type="button" class="px-4 py-2 bg-transparent hover:bg-gray-700 text-gray-400 hover:text-white rounded text-sm transition border border-gray-700">
                                        Remove
                                    </button>
                                </div>
                                <p class="text-xs text-gray-400 mt-2">Upload a new avatar. JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Full Name</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ $user->name }}"
                                    class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-film-red"
                                >
                            </div>
                            
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Username</label>
                                <input 
                                    type="text" 
                                    id="username" 
                                    name="username" 
                                    value="{{ $user->name }}"
                                    class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-film-red"
                                >
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ $user->email }}"
                                    class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-film-red"
                                >
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-300 mb-1">Phone Number</label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    placeholder="Optional"
                                    class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-film-red"
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-300 mb-1">Bio</label>
                            <textarea 
                                id="bio" 
                                name="bio" 
                                rows="3" 
                                placeholder="Tell us a bit about yourself..."
                                class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-film-red"
                            ></textarea>
                            <p class="text-xs text-gray-400 mt-1">Brief description for your profile.</p>
                        </div>
                        
                        <div class="flex justify-end">
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-film-red hover:bg-red-700 text-white rounded font-medium transition"
                            >
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Security Settings Tab -->
                <div x-show="activeTab === 'security'" class="p-6" style="display: none;">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold">Change Password</h2>
                        <p class="text-sm text-gray-400">Ensure your account is using a secure password</p>
                    </div>
                    
                    <form id="security-form" class="space-y-6" action="#" method="post">
                        @csrf
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-300 mb-1">Current Password</label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password" 
                                class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-film-red"
                            >
                        </div>
                        
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-300 mb-1">New Password</label>
                            <input 
                                type="password" 
                                id="new_password" 
                                name="new_password" 
                                class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-film-red"
                            >
                            <p class="text-xs text-gray-400 mt-1">Password must be at least 8 characters long with 1 uppercase letter, 1 number, and 1 special character</p>
                        </div>
                        
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">Confirm New Password</label>
                            <input 
                                type="password" 
                                id="new_password_confirmation" 
                                name="new_password_confirmation" 
                                class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-film-red"
                            >
                        </div>
                        
                        <div class="pt-2">
                            <h3 class="text-sm font-semibold text-gray-300 mb-2">Two-Factor Authentication</h3>
                            
                            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">Two-factor authentication is not enabled yet.</p>
                                        <p class="text-sm text-gray-400">Add additional security to your account using two-factor authentication.</p>
                                    </div>
                                    <button 
                                        type="button"
                                        class="px-4 py-2 bg-film-gray hover:bg-gray-700 text-white rounded font-medium transition border border-gray-700"
                                    >
                                        Setup 2FA
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-film-red hover:bg-red-700 text-white rounded font-medium transition"
                            >
                                Update Password
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-10 pt-6 border-t border-gray-700">
                        <h2 class="text-xl font-semibold text-red-500">Danger Zone</h2>
                        <p class="text-sm text-gray-400 mt-1">Permanent actions with serious consequences</p>
                        
                        <div class="mt-4">
                            <div x-data="{ showModal: false }">
                                <button 
                                    @click="showModal = true"
                                    class="px-4 py-2 bg-transparent hover:bg-red-900/20 text-red-500 hover:text-red-400 rounded font-medium transition border border-red-900"
                                >
                                    Delete Account
                                </button>
                                
                                <!-- Modal -->
                                <div 
                                    x-show="showModal" 
                                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    style="display: none;"
                                >
                                    <div 
                                        @click.away="showModal = false" 
                                        class="bg-film-gray rounded-lg shadow-xl max-w-md w-full p-6"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="transform scale-95 opacity-0"
                                        x-transition:enter-end="transform scale-100 opacity-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="transform scale-100 opacity-100"
                                        x-transition:leave-end="transform scale-95 opacity-0"
                                    >
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-xl font-bold text-white">Confirm Deletion</h3>
                                            <button @click="showModal = false" class="text-gray-400 hover:text-white">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="mb-6">
                                            <p class="text-gray-300 mb-2">This action cannot be undone. This will permanently delete your account and remove all your data from our servers.</p>
                                            <p class="text-gray-400 text-sm">Please type <span class="font-bold text-white">delete my account</span> to confirm.</p>
                                            
                                            <div class="mt-3">
                                                <input 
                                                    type="text" 
                                                    id="delete-confirmation" 
                                                    class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-film-red"
                                                    placeholder="Type 'delete my account'"
                                                >
                                            </div>
                                        </div>
                                        <div class="flex justify-end space-x-3">
                                            <button 
                                                @click="showModal = false"
                                                class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded transition"
                                            >
                                                Cancel
                                            </button>
                                            <button 
                                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded transition"
                                            >
                                                Delete Account
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Notifications Settings Tab -->
                <div x-show="activeTab === 'notifications'" class="p-6" style="display: none;">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold">Notification Preferences</h2>
                        <p class="text-sm text-gray-400">Manage how we communicate with you</p>
                    </div>
                    
                    <form id="notifications-form" action="#" method="post">
                        @csrf
                        <div class="space-y-6">
                            <div x-data="{ enabled: true }">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium">New Releases</h3>
                                        <p class="text-sm text-gray-400">Get notified when new movies or shows are added</p>
                                    </div>
                                    <button 
                                        type="button"
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
                            
                            <div x-data="{ enabled: true }">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium">Recommendations</h3>
                                        <p class="text-sm text-gray-400">Get personalized movie and show recommendations</p>
                                    </div>
                                    <button 
                                        type="button"
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
                                        <h3 class="font-medium">Special Offers & Promotions</h3>
                                        <p class="text-sm text-gray-400">Receive discounts and special offers</p>
                                    </div>
                                    <button 
                                        type="button"
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
                                        <h3 class="font-medium">FilmWave Newsletter</h3>
                                        <p class="text-sm text-gray-400">Stay updated with FilmWave news and updates</p>
                                    </div>
                                    <button 
                                        type="button"
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
                            
                            <div class="border-t border-gray-700 pt-6">
                                <h3 class="font-medium mb-3">Communication Methods</h3>
                                
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input 
                                            type="checkbox" 
                                            id="email_notifications" 
                                            name="email_notifications" 
                                            checked
                                            class="rounded bg-gray-800 border-gray-700 text-film-red focus:ring-film-red"
                                        >
                                        <label for="email_notifications" class="ml-2 text-sm">Email</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input 
                                            type="checkbox" 
                                            id="push_notifications" 
                                            name="push_notifications" 
                                            class="rounded bg-gray-800 border-gray-700 text-film-red focus:ring-film-red"
                                        >
                                        <label for="push_notifications" class="ml-2 text-sm">Push Notifications</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input 
                                            type="checkbox" 
                                            id="sms_notifications" 
                                            name="sms_notifications" 
                                            class="rounded bg-gray-800 border-gray-700 text-film-red focus:ring-film-red"
                                        >
                                        <label for="sms_notifications" class="ml-2 text-sm">SMS</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                <button 
                                    type="submit"
                                    class="px-4 py-2 bg-film-red hover:bg-red-700 text-white rounded font-medium transition"
                                >
                                    Save Preferences
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Include footer if you have one -->
    @if(View::exists('partials.footer'))
        @include('partials.footer')
    @endif

    <script>
        // Additional JavaScript for form handling
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // Simulate form submission with a success message
                    const formId = form.id;
                    
                    // Here you would normally submit the form via AJAX
                    // For now we're just showing an alert
                    alert('Settings saved successfully!');
                });
            });
        });
    </script>
</body>
</html>