@extends('backend.helpline-panel.help-master')
@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div class="card shadow-sm border-0 mt-4" style="border-radius: 15px;">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        {{-- প্রোফাইল ছবি ও নাম --}}
                        <div class="col-md-4 text-center border-end">
                            <img src="{{ asset($data->image ?? 'backend/images/no_image.jpg') }}" alt="Profile"
                                class="rounded-circle img-thumbnail shadow-sm"
                                style="width: 180px; height: 180px; object-fit: cover;">
                            <h4 class="mt-3 mb-1 fw-bold">{{ $data->name }}</h4>
                            <p class="text-muted small">Helpline Member (ID: #{{ $data->id }})</p>
                        </div>

                        {{-- পার্সোনাল ইনফরমেশন ভিউ --}}
                        <div class="col-md-8 ps-md-5">
                            <h4 class="text-primary mb-4">Personal Information</h4>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Email:</div>
                                <div class="col-sm-8 text-secondary">{{ Auth::guard('subadmin')->user()->email }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Phone:</div>
                                <div class="col-sm-8 text-secondary">{{ $data->phone ?? 'Not Set' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Address:</div>
                                <div class="col-sm-8 text-secondary">{{ $data->address ?? 'Not Set' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Blood Group:</div>
                                <div class="col-sm-8"><span class="badge bg-danger">{{ $data->blood ?? 'N/A' }}</span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Duty Shift:</div>
                                <div class="col-sm-8 text-capitalize text-primary fw-bold">{{ $data->shift ?? 'N/A' }}</div>
                            </div>

                            <div class="mt-4 d-flex gap-2">
                                {{-- এডিট প্রোফাইল বাটন --}}
                                <button type="button" class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#editProfileModal">
                                    <i class="fas fa-edit me-1"></i> Edit Profile
                                </button>

                                {{-- পাসওয়ার্ড চেঞ্জ পেজে যাওয়ার বাটন --}}
                                <a href="{{ route('helpline.change.password') }}"
                                    class="btn btn-outline-danger px-4 shadow-sm">
                                    <i class="fas fa-key me-1"></i> Change Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Profile Modal --}}
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('helpline.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold">Edit Your Profile</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            {{-- নাম --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $data->name }}"
                                    required>
                            </div>
                            {{-- ফোন --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ $data->phone }}">
                            </div>
                            {{-- ব্লাড গ্রুপ --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Blood Group</label>
                                <select name="blood" class="form-control">
                                    <option value="A+" {{ $data->blood == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="B+" {{ $data->blood == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="O+" {{ $data->blood == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="AB+" {{ $data->blood == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="O-" {{ $data->blood == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                            </div>
                            {{-- ডিউটি শিফট (এখানেই আপনার শিফট এডিট অপশন) --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Duty Shift</label>
                                <select name="shift" class="form-control border-primary">
                                    <option value="day" {{ $data->shift == 'day' ? 'selected' : '' }}>Day Shift</option>
                                    <option value="night" {{ $data->shift == 'night' ? 'selected' : '' }}>Night Shift
                                    </option>
                                </select>
                            </div>
                            {{-- ঠিকানা --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ $data->address }}</textarea>
                            </div>
                            {{-- ইমেজ --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Profile Image</label>
                                <input type="file" name="image" class="form-control">
                                <small class="text-muted">লোগো বা ছবি পরিবর্তন করতে এখানে সিলেক্ট করুন</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary px-4 shadow">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
