@extends('backend.teacher-panel.TS-master')
@section('content')

<style>
    /* প্রিমিয়াম শ্যাডো এবং বর্ডার রেডিয়াস */
    .result-card { 
        border-radius: 24px; 
        border: none; 
        background: #ffffff; 
        box-shadow: 0 20px 40px rgba(0,0,0,0.04); 
        overflow: hidden;
    }

    /* গ্রেডিয়েন্ট হেডার */
    .premium-header {
        background: linear-gradient(135deg, #ffffff 0%, #f9faff 100%);
        padding: 25px 30px;
        border-bottom: 1px solid #f1f4f8;
    }

    /* স্টাইলিশ টেবিল */
    .table-container { padding: 20px 30px; }
    .table thead { background-color: #f8faff; }
    .table thead th { 
        border: none; 
        font-size: 11px; 
        text-transform: uppercase; 
        letter-spacing: 1.2px; 
        color: #8a94ad; 
        padding: 18px; 
        font-weight: 700;
    }

    .table tbody tr { transition: all 0.3s ease; border-bottom: 1px solid #f8f9fc; }
    .table tbody tr:hover { background-color: #fcfdff; transform: scale(1.002); }
    .table tbody td { vertical-align: middle; padding: 20px 18px; border: none; }

    /* স্টুডেন্ট প্রোফাইল স্টাইল */
    .student-avatar { 
        width: 45px; 
        height: 45px; 
        border-radius: 14px; 
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        color: #fff; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-weight: 700; 
        margin-right: 15px;
        font-size: 18px;
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.2);
    }

    /* প্রিমিয়াম ব্যাজ */
    .badge-grade { 
        padding: 8px 16px; 
        border-radius: 10px; 
        font-weight: 700; 
        font-size: 11px; 
        text-transform: uppercase;
        display: inline-block;
    }
    
    .bg-soft-success { background: #e6f9f1; color: #00c971; }
    .bg-soft-warning { background: #fff8eb; color: #ffb822; }
    .bg-soft-danger { background: #fff1f1; color: #ff5252; }

    /* এক্সপোর্ট বাটন */
    .btn-export {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #4a5568;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-export:hover { background: #f8faff; color: #667eea; border-color: #667eea; }
</style>

<div class="container-fluid mt-4 pb-5">
    <div class="row">
        <div class="col-12">
            <div class="card result-card">
                <div class="premium-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Student Performance</h4>
                        <p class="text-muted small mb-0">Manage and track student exam results efficiently</p>
                    </div>
                    <button class="btn btn-export">
                        <i class="mdi mdi-cloud-download-outline me-2"></i> Export CSV
                    </button>
                </div>
                
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Student Info</th>
                                    <th>Exam Title</th>
                                    <th class="text-center">Score</th>
                                    <th class="text-center">Performance</th>
                                    <th class="text-center">Submission Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($results as $result)
                                <tr>
                                    <td>
                                        <div class="student-info">
                                            <div class="student-avatar text-uppercase">
                                                {{ substr($result->student->name ?? 'S', 0, 1) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">{{ $result->student->name ?? 'Unknown Student' }}</h6>
                                                <small class="text-muted">UID: #{{ $result->student->id ?? '00' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $result->exam_title ?? 'Final Assessment' }}</div>
                                        <small class="text-muted">{{ $result->course->course_title ?? 'Course Archive' }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="fw-extrabold fs-5 text-dark">{{ $result->marks_obtained ?? '0' }}</div>
                                        <small class="text-muted fw-bold">Out of 100</small>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $gradeLabel = $result->grade ?? 'N/A';
                                            $marks = $result->marks ?? 0;
                                            $statusClass = 'bg-soft-success';
                                            if($marks < 40) $statusClass = 'bg-soft-danger';
                                            elseif($marks < 60) $statusClass = 'bg-soft-warning';
                                        @endphp
                                        <span class="badge-grade {{ $statusClass }}">
                                            {{ $gradeLabel }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="text-dark fw-semibold small">
                                            {{ $result->created_at ? $result->created_at->format('d M, Y') : 'N/A' }}
                                        </div>
                                        <small class="text-muted">{{ $result->created_at ? $result->created_at->format('h:i A') : '' }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3">
                                        <h5 class="text-muted">মামা, এখনো কোনো রেজাল্ট জমা পড়েনি!</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection