@extends('backend.student-panel.st-master')

@section('content')
    <div class="content-wrapper">

        <div class="row">

            <div class="col-md-8 mx-auto grid-margin stretch-card">

                <div class="card">

                    <div class="card-body text-center">

                        <h3 class="mb-4">Referral Program</h3>

                        <p>Your Referral Code</p>

                        <h4 class="text-primary">{{ $student->referral_code }}</h4>

                        <hr>

                        <p>Share your referral link and earn money</p>

                        <div class="input-group mb-3">

                            <input type="text" id="refLink" class="form-control"
                                value="{{ url('/admission?ref=' . $student->referral_code) }}" readonly>

                            <button class="btn btn-primary" onclick="copyLink()">
                                Copy
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
@push('script')
     <script>
        function copyLink() {
            let copyText = document.getElementById("refLink");
            copyText.select();
            document.execCommand("copy");
            alert("Referral link copied!");
        }
    </script>
@endpush