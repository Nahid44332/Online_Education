<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ Auth::guard('student')->user()->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex h-screen">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 text-gray-100 flex flex-col">
        <div class="p-6 text-center border-b border-gray-700">
            <h2 class="text-2xl font-bold">🎓 {{ Auth::guard('student')->user()->name }}</h2>
            <h2>Student Id: {{ Auth::guard('student')->user()->id }}</h2>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('student.dashboard') }}" class="block py-2 px-3 rounded hover:bg-gray-700 {{ request()->routeIs('student.dashboard') ? 'bg-gray-700' : '' }}">
                Dashboard
            </a>
            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">My Course</a>
            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">Live Class</a>
            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">Exam</a>
            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">Admit Card</a>
            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">Notices</a>

            <form action="{{ route('student.logout') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 py-2 rounded text-white font-semibold">Logout</button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Navbar -->
        <div class="bg-white h-16 flex items-center justify-between px-6 shadow">
            <h1 class="text-xl font-semibold">Dashboard</h1>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button id="profileBtn" class="flex items-center space-x-2 focus:outline-none">
                    <img src="{{ asset('backend/images/students/'.Auth::guard('student')->user()->image) }}" 
                         alt="Profile" 
                         class="w-10 h-10 rounded-full border-2 border-blue-500">
                    <span class="font-medium">{{ Auth::guard('student')->user()->name }}</span>
                </button>

                <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg overflow-hidden z-50">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                    <form action="{{ route('student.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-semibold">📚 My Course</h3>
                <p class="mt-2 text-gray-500">View your enrolled courses</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-semibold">🎥 Live Class</h3>
                <p class="mt-2 text-gray-500">Join your live sessions</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-semibold">📝 Exam</h3>
                <p class="mt-2 text-gray-500">Start your exam</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-semibold">🎫 Admit Card</h3>
                <p class="mt-2 text-gray-500">Download your admit card</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-semibold">📢 Notices</h3>
                <p class="mt-2 text-gray-500">Check latest notices</p>
            </div>

        </div>

        <!-- Student Info Table -->
        <div class="p-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Student Information</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-2 font-medium">Name</td>
                            <td class="px-4 py-2">{{ Auth::guard('student')->user()->name }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-medium">Email</td>
                            <td class="px-4 py-2">{{ Auth::guard('student')->user()->email }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-medium">Phone</td>
                            <td class="px-4 py-2">{{ Auth::guard('student')->user()->phone }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-medium">Course</td>
                            <td class="px-4 py-2">
                                @if($courses)
                                    @foreach($courses as $course)
                                        {{ $course->name }}
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<script>
    // Profile Dropdown Toggle
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    profileBtn.addEventListener('click', () => {
        profileDropdown.classList.toggle('hidden');
    });

    // Close dropdown on click outside
    window.addEventListener('click', function(e) {
        if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.add('hidden');
        }
    });
</script>

</body>
</html>