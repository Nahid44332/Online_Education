@extends('frontend.master')
@section('title', 'Privacy Policy') {{-- ✅ টাইটেল সেট করা হলো --}}
@section('content')
<section class="privacy-policy-section py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">Admission Policy</h2>
            <p class="text-muted">Please read our policy carefully to understand how we handle your data.</p>
        </div>

        <div class="privacy-policy-content bg-light p-4 rounded shadow-sm">
            <p>
                {{$privacyPolicy->admission_policy}}
            </p>
        </div>
    </div>
</section>
@endsection
