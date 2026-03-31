<div class="container mt-5">
    <h3>Welcome, {{ Auth::guard('student')->user()->name }} 🎓</h3>
    <p>Email: {{ Auth::guard('student')->user()->email }}</p>

    <form action="{{ route('student.logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger mt-3">Logout</button>
    </form>
</div>