@extends('frontend.master')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Apply as a Teacher</h2>

    <form action="{{url('/teacer/application/store')}}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded">
        @csrf

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="Enter your phone number" required>
        </div>

        {{-- Address --}}
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="2" placeholder="Enter your address"></textarea>
        </div>

        {{-- Qualification --}}
        <div class="mb-3">
            <label class="form-label">Qualification</label>
            <input type="text" name="qualification" class="form-control" placeholder="e.g. B.Sc in CSE, M.A in English" required>
        </div>

        {{-- Skills --}}
        <div class="mb-3">
            <label class="form-label">Skills</label>
            <textarea name="skills" class="form-control" rows="2" placeholder="List your key skills"></textarea>
        </div>

        {{-- Experience --}}
        <div class="mb-3">
            <label class="form-label">Experience (Years)</label>
            <input type="number" name="experience" class="form-control" placeholder="Enter years of experience" min="0">
        </div>

        {{-- CV Upload --}}
        <div class="mb-3">
            <label class="form-label">Upload CV (Optional)</label>
            <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
        </div>

        {{-- image Upload --}}
        <div class="mb-3">
            <label class="form-label">Upload Your Photo</label>
            <input type="file" name="image" class="form-control" accept=".jpg ,.png,.webp">
        </div>

        {{-- Cover Letter --}}
        <div class="mb-3">
            <label class="form-label">Cover Letter</label>
            <textarea name="cover_letter" class="form-control" rows="3" placeholder="Why do you want to join as a teacher?"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit Application</button>
    </form>
</div>
@endsection
