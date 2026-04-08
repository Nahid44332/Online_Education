<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subadmin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<div class="min-h-screen flex flex-col justify-center py-6 sm:py-12 px-4 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <div class="h-12 w-12 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>
        
        <h2 class="mt-6 text-center text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
            Subadmin Login
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Sign in to access your dashboard
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-xl rounded-2xl border-t-4 border-indigo-600 sm:px-10">
            
            @if(Session::has('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-600 text-sm font-semibold border border-red-200">
                    {{ Session::get('error') }}
                </div>
            @endif

            <form action="{{ route('subadmin.login.submit') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label for="position" class="block text-sm font-semibold text-gray-700">Position</label>
                    <div class="mt-1">
                        <select id="position" name="position" required
                            class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 sm:text-sm text-gray-700">
                            <option value="">Choose your role...</option>
                            <option value="trainer">Trainer</option>
                            <option value="team_leader">Team Leader</option>
                            <option value="teacher">Teacher</option>
                            <option value="counsellor">Counsellor</option>
                            <option value="helpline">Helpline</option>
                            <option value="manager">Manager</option>
                            <option value="managing_director">Managing Director</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required 
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 sm:text-sm"
                            placeholder="name@company.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required 
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 sm:text-sm"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">Remember me</label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                        SIGN IN
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">
                    Need technical support? <a href="#" class="text-indigo-600 hover:underline font-bold">Contact Admin</a>
                </p>
            </div>
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to main website
            </a>
        </div>
    </div>
</div>
</body>
</html>