<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\adminAuthController;
use App\Http\Controllers\backend\adminController;
use App\Http\Controllers\backend\AdminProfileController;
use App\Http\Controllers\backend\StudentController;
use App\Http\Controllers\backend\teachersController;
use App\Http\Controllers\backend\CourseController;
use App\Http\Controllers\backend\PaymentController;
use App\Http\Controllers\backend\admitCardController;
use App\Http\Controllers\backend\ExamController;
use App\Http\Controllers\backend\resultController;
use App\Http\Controllers\backend\CertificateController;
use App\Http\Controllers\backend\ReportController;
use App\Http\Controllers\backend\NoticeController;
use App\Http\Controllers\backend\lockController;
use App\Http\Controllers\backend\TestimonialController;
use App\Http\Controllers\backend\NewsController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\SubadminController;
use App\Http\Controllers\backend\teacher\TeacherPanelController;
use App\Http\Controllers\backend\TeamLeaderPanelController;
use App\Http\Controllers\backend\TrainerPanelController;
use App\Http\Controllers\backend\WithdrawController;
use App\Http\Controllers\ReferralController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class, 'index']);
Route::get('/about-us', [FrontendController::class, 'aboutUs']);
Route::get('/courses', [FrontendController::class, 'courses']);
Route::get('/teachers', [FrontendController::class, 'teachers']);
Route::get('/teacher-info/{id}', [FrontendController::class, 'teacherInfo']);
Route::get('/teacer/application', [FrontendController::class, 'teacherApplication']);
Route::post('/teacer/application/store', [FrontendController::class, 'teacherApplicationStore']);
Route::get('/contact-us', [FrontendController::class, 'contactUs']);
Route::post('/contact-us/store', [FrontendController::class, 'contactUsStore']);
Route::get('/course-details/{id}', [FrontendController::class, 'courseDetails']);
Route::get('/admission', [FrontendController::class, 'admission']);
Route::post('/admission/store', [FrontendController::class, 'admissionStore']);
Route::get('/admission/print/{id}', [FrontendController::class, 'print']);

// Common Frontend Features (Result, Certificate, Notice)
Route::get('/teacher/application/success/{application_id}', [FrontendController::class, 'teacherApplicationSuccess'])->name('frontend.application.success');
Route::get('/teacher/application/status', [FrontendController::class, 'showApplicationStatusForm'])->name('teacher.application.status.form');
Route::post('/teacher/application/status', [FrontendController::class, 'checkApplicationStatus'])->name('teacher.application.status.check');
Route::get('/student-result', [FrontendController::class, 'studentResult']);
Route::post('/student-result', [FrontendController::class, 'showResult']);
Route::get('/result/download/{id}', [FrontendController::class, 'downloadResult'])->name('result.download');
Route::get('/certificate/check', [FrontendController::class, 'checkForm']);
Route::post('/certificate/check', [FrontendController::class, 'checkStatus']);
Route::get('/notice', [FrontendController::class, 'notice']);
Route::get('/notice/{id}', [FrontendController::class, 'show']);

// Policy Routes
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy']);
Route::get('/trams-condiotion', [FrontendController::class, 'tramsCondition']);
Route::get('/admission-policy', [FrontendController::class, 'admissionPolicy']);
Route::get('/payment-policy', [FrontendController::class, 'paymentPolicy']);

// Student Login (Public)
Route::get('/student/login', [FrontendController::class, 'studentLogin'])->name('student.login');
Route::post('/student/login', [FrontendController::class, 'loginSubmit'])->name('student.login.submit');

//Subadmin Login Route
Route::get('/subadmin/login', [FrontendController::class, 'subadminLogin']);
Route::post('/subadmin/login/submit', [FrontendController::class, 'subadminLoginSubmit'])->name('subadmin.login.submit');
Route::get('/subadmin/logout', [FrontendController::class, 'subadminLogout'])->name('subadmin.logout');


/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [adminAuthController::class, 'adminLogin'])->name('admin.login');
Route::get('/admin/logout', [adminAuthController::class, 'adminLogOut'])->name('admin.logout');
Auth::routes(['register' => false]);

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Middleware Protected)
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    Route::get('/dashboard', [adminController::class, 'adminDashboard'])->name('admin.dashboard');

    // Students Management
    Route::get('/student/list', [adminController::class, 'studentList']);
    Route::post('/student/status/{id}', [adminController::class, 'updateStatus']);
    Route::get('/student/delete/{id}', [adminController::class, 'deleteStudent']);
    Route::get('/student/edit/{id}', [adminController::class, 'editStudent']);
    Route::post('/student/update/{id}', [adminController::class, 'updateStudent']);

    // Teachers Management
    Route::get('/teacher/add', [teachersController::class, 'addTeacher']);
    Route::post('/teacher/store', [teachersController::class, 'teacherStore']);
    Route::get('/teacher/list', [teachersController::class, 'teacherList']);
    Route::get('/teacher/view/{id}', [teachersController::class, 'teacherView']);
    Route::get('/teacher/delete/{id}', [teachersController::class, 'teacherDelete']);
    Route::get('/teacher/edit/{id}', [teachersController::class, 'teacherEdit']);
    Route::post('/teacher/update/{id}', [teachersController::class, 'updateTeacher']);
    Route::get('/teacher/assign-course/{id}', [teachersController::class, 'assignCourse']);
    Route::post('/teacher/assign-course/store', [teachersController::class, 'storeAssignCourse']);
    Route::get('/teacher/featured', [teachersController::class, 'teacherFeatured']);
    Route::post('/teacher/featured/update', [teachersController::class, 'teacherFeaturedUpdate']);
    Route::get('/teacher/cendidate', [teachersController::class, 'teacherCendidate']);

    // Course Management
    Route::get('/course', [CourseController::class, 'course']);
    Route::get('/course/create', [CourseController::class, 'courseCreate']);
    Route::post('/course/store', [CourseController::class, 'courseStore']);
    Route::get('/course/delete/{id}', [CourseController::class, 'courseDelete']);
    Route::get('/course/edit/{id}', [CourseController::class, 'courseEdit']);
    Route::post('/course/update/{id}', [CourseController::class, 'courseUpdate']);


    // Payments, Exams, Results, Certificates
    Route::get('/payment/list', [PaymentController::class, 'paymentList']);
    Route::get('/payments/create/{student_id}', [PaymentController::class, 'createPayment'])->name('admin.payments.create');
    Route::post('/payments/store/{student_id}', [PaymentController::class, 'paymentStore'])->name('admin.payments.store');
    Route::get('/student/payments/{id}', [PaymentController::class, 'getStudentPayments']);
    Route::get('/payment/download/{id}', [PaymentController::class, 'paymentPrint']);
    Route::get('/admit-card', [admitCardController::class, 'admitCard']);
    Route::get('/admit-card/create', [admitCardController::class, 'admitCardCreate']);
    Route::get('/admit-card/delete/{id}', [admitCardController::class, 'admitDelete']);
    Route::get('/admit-card/edit/{id}', [admitCardController::class, 'admitEdit']);
    Route::post('/admit-card/update/{id}', [admitCardController::class, 'admitUpdate']);
    Route::get('/admit-card/download/{id}', [admitCardController::class, 'downloadAdmitCard'])->name('admin.admit-card.download');
    Route::get('/get-student-course/{id}', [admitCardController::class, 'getStudentCourse']);
    Route::post('/admit-card/create/store', [admitCardController::class, 'admitCardStore']);
    Route::get('/exam-list', [ExamController::class, 'examList'])->name('admin.exam.list');
    Route::get('/exam-approve/{id}', [ExamController::class, 'approveExam'])->name('admin.exam.approve');
    Route::get('/exam-delete/{id}', [ExamController::class, 'examDelete'])->name('admin.exam.delete');
    Route::get('/student/result', [resultController::class, 'studentResult']);
    Route::get('/student/result-create', [resultController::class, 'createResult']);
    Route::post('/student/result/store', [resultController::class, 'storeResult']);
    Route::get('/student/certificate', [CertificateController::class, 'studentCertificate']);
    Route::get('/student/certificate/create', [CertificateController::class, 'studentCertificateCreate']);
    Route::post('/student/certificate/store', [CertificateController::class, 'certificateStore']);
    Route::get('/student/certificate/{id}', [CertificateController::class, 'certificateView']);
    Route::get('/student/certificate/download/{id}', [CertificateController::class, 'downloadCertificate']);


    //Reports
    Route::get('/reports', [ReportController::class, 'allReports']);
    Route::get('/reports/students', [ReportController::class, 'studentReports']);
    Route::get('/reports/teachers', [ReportController::class, 'teacherReports']);
    Route::get('/reports/courses', [ReportController::class, 'courseReports']);
    Route::get('/reports/payments', [ReportController::class, 'paymentReports']);
    Route::get('/reports/certificates', [ReportController::class, 'certificateReports']);

    // Notices
    Route::get('/notice', [NoticeController::class, 'Notice']);
    Route::get('/notice/create', [NoticeController::class, 'noticeCreate']);
    Route::post('/notice/create/store', [NoticeController::class, 'noticeStore']);

    //Lock
    Route::get('/lock', [lockController::class, 'studentLock']);
    Route::get('/admin/student/lock/{id}', [lockController::class, 'lock'])->name('student.lock');
    Route::get('/admin/student/unlock/{id}', [lockController::class, 'unlock'])->name('student.unlock');

    //contact-us
    Route::get('/contact-us', [adminController::class, 'contactUs']);
    Route::get('/contact-us/delete/{id}', [adminController::class, 'contactUsDelete']);

    //Testimonial
    Route::get('/testimonial', [TestimonialController::class, 'testimonial']);
    Route::get('/testimonial/create', [TestimonialController::class, 'testimonialCreate']);
    Route::get('/testimonial/store', [TestimonialController::class, 'testimonialStore']);
    Route::get('/testimonial/edit/{id}', [TestimonialController::class, 'testimonialEdit']);
    Route::post('/testimonial/update/{id}', [TestimonialController::class, 'testimonialUpdate']);
    Route::get('/testimonial/delete/{id}', [TestimonialController::class, 'testimonialDelete']);

    //News
    Route::get('/news', [NewsController::class, 'news']);
    Route::get('/news/create', [NewsController::class, 'newsCreate']);
    Route::post('/news/store', [NewsController::class, 'newsStore']);
    Route::post('/news/status/{id}', [NewsController::class, 'changeStatus'])->name('news.status');

    //Withwraw
    Route::get('/withdraw/list', [adminController::class, 'withdrawList']);
    Route::get('/withdraw/approve/{id}', [adminController::class, 'withdrawApprove']);
    Route::get('/withdraw/reject/{id}', [adminController::class, 'withdrawReject']);

    // Settings & Profile
    Route::get('/profile', [AdminProfileController::class, 'profile']);
    Route::get('/site-seeting', [SettingController::class, 'siteSetting']);
    Route::get('/policy-seeting', [SettingController::class, 'policySetting']);
    Route::post('/policy-seeting/update', [SettingController::class, 'policySettingStore']);
    Route::get('/about-us', [SettingController::class, 'aboutUs']);
    Route::post('/about-us/update/{id}', [SettingController::class, 'aboutUsUpdate']);
    Route::get('/banner-settings', [SettingController::class, 'bannerSetting']);
    Route::get('/edit-banner/{id}', [SettingController::class, 'editBanner']);
    Route::post('/update-banner/{id}', [SettingController::class, 'updateBanner']);

    //Add Points Routes...
    Route::post('/admin/add-points', [adminController::class, 'addPoints'])->name('admin.add.points');

    //withdraw....
    Route::get('/teacher-withdraw-requests', [adminController::class, 'withdrawRequests'])->name('admin.withdraw.requests');
    Route::post('/withdraw-approve/{id}', [adminController::class, 'approveWithdraw'])->name('admin.withdraw.approve');
    Route::post('/withdraw-reject/{id}', [adminController::class, 'rejectWithdraw'])->name('admin.withdraw.reject');

    //Subadmin Route....
    Route::get('/team-leader', [SubadminController::class, 'teamLeader']);
    Route::post('/team-leader/store', [SubadminController::class, 'storeTeamLeader'])->name('admin.team_leader.store');
    Route::post('/team-leader/update/{id}', [SubadminController::class, 'updateTeamLeader'])->name('admin.team_leader.update');
    Route::get('/team-leader/delete/{id}', [SubadminController::class, 'deleteTeamLeader'])->name('admin.team_leader.delete');
    Route::get('/team-leader/assign-student/{id}', [SubadminController::class, 'assignStudentPage'])->name('admin.assign_page');
    Route::get('/team-leader/add-to-team/{tl_id}/{student_id}', [SubadminController::class, 'confirmAssign'])->name('admin.do_assign');
    Route::post('/admin/team-leader/add-points', [SubadminController::class, 'addTlPoints'])->name('admin.add.tl.points');
    Route::get('/admin/withdraw/requests', [SubadminController::class, 'withdrawRequests'])->name('admin.team_leader.withdraw.requests');
    Route::post('/admin/withdraw/approve/{id}', [SubadminController::class, 'approveWithdraw'])->name('admin.team_leader.withdraw.approve');
    Route::get('/trainer', [SubadminController::class, 'trainer'])->name('admin.trainer_list');
    Route::post('/add-trainer-points', [SubadminController::class, 'addTrainerPoints'])->name('admin.add.trainer.points');
});


/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/


// Student Dashboard & Panel (Protected by Student Guard)
Route::group(['prefix' => 'student', 'middleware' => ['auth:student']], function () {

    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::post('/logout', [StudentController::class, 'logout'])->name('student.logout');

    // Profile
    Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
    Route::get('/profile/edit', [StudentController::class, 'profileEdit'])->name('student.profile.edit');
    Route::post('/profile/update', [StudentController::class, 'profileUpdate'])->name('student.profile.update');
    Route::post('/password/update', [StudentController::class, 'passwordUpdate'])->name('student.password.update');

    // Referral & Withdraw
    Route::get('/referral', [ReferralController::class, 'referral'])->name('student.referral');
    Route::get('/referral-history', [ReferralController::class, 'referralHistroy'])->name('student.referral-histroy');
    Route::get('/withdraw', [WithdrawController::class, 'withdrawPage'])->name('student.withdraw.page');
    Route::post('/withdraw', [WithdrawController::class, 'withdrawRequest'])->name('student.withdraw');

    // Academic
    Route::get('/course', [StudentController::class, 'Course'])->name('student.course');
    Route::get('/admit-card', [StudentController::class, 'viewAdmitCard'])->name('student.admit-card');
    Route::get('/admit-card/download/{id}', [StudentController::class, 'downloadAdmitCard'])->name('student.admit-card.download');

    //Exam, Result, Certificate
    Route::get('/student/exams', [StudentController::class, 'myExams'])->name('student.exams');
    Route::get('/my-results', [StudentController::class, 'viewResult'])->name('student.result');
    Route::get('/my-certificates', [StudentController::class, 'myCertificates'])->name('student.certificates');
    Route::get('/certificate/download/{id}', [StudentController::class, 'downloadCertificate'])->name('student.certificate.download');
});


// ===============================
//Subadmin Route Group.......
Route::group(['prefix' => 'panel', 'middleware' => 'auth:subadmin'], function () {

    // শুধুমাত্র টিচারদের জন্য রাউট
    Route::group(['middleware' => 'subadmin.role:teacher'], function () {
        Route::get('/teacher/dashboard', [TeacherPanelController::class, 'teacherDashboard'])->name('teacher.dashboard');
        Route::get('/teacher/live-class', [TeacherPanelController::class, 'liveClass'])->name('teacher.live-class');
        Route::post('/live-class/store', [TeacherPanelController::class, 'store'])->name('live.class.store');
        Route::get('/live-class/delete/{id}', [TeacherPanelController::class, 'destroy'])->name('live.class.delete');
        Route::get('/live-class/status/{id}', [TeacherPanelController::class, 'toggleStatus'])->name('live.class.status');
        Route::get('/teacher/student-list', [TeacherPanelController::class, 'studentList'])->name('stdent.list');
        Route::get('/withdraw', [TeacherPanelController::class, 'withdraw'])->name('teacher.withdraw');
        Route::post('/withdraw-request', [TeacherPanelController::class, 'withdrawStore'])->name('teacher.withdraw.store');
        Route::get('/transactions', [TeacherPanelController::class, 'transactionHistory'])->name('teacher.transactions');
        Route::get('/exam/create', [TeacherPanelController::class, 'examCreate'])->name('exam.create');
        Route::post('/exam/store', [TeacherPanelController::class, 'examStore'])->name('exam.store');
        Route::get('/exam/my-list', [TeacherPanelController::class, 'myExams'])->name('exam.list');
        Route::get('/panel/teacher/exam/delete/{id}', [TeacherPanelController::class, 'examDelete'])->name('exam.delete');
    });

    //Team Leader Panel Route
    Route::group(['middleware' => 'subadmin.role:team_leader'], function () {    
        Route::get('/team-leader/dashboard', [TeamLeaderPanelController::class, 'dashboard'])->name('team_leader.dashboard');
        Route::get('/team-leader/my-students', [TeamLeaderPanelController::class, 'myStudents'])->name('team_leader.students');
        Route::get('/team-leader/transactions', [TeamLeaderPanelController::class, 'transactions'])->name('team_leader.transactions');
        Route::get('/team-leader/withdraw', [TeamLeaderPanelController::class, 'withdraw'])->name('team_leader.withdraw');
        Route::post('/team-leader/withdraw-request', [TeamLeaderPanelController::class, 'withdrawStore'])->name('team_leader.withdraw.store');
        Route::get('/team-leader/withdraw-history', [TeamLeaderPanelController::class, 'withdrawHistory'])->name('team_leader.withdraw.history');
        Route::post('/team-leader/gift-points', [TeamLeaderPanelController::class, 'giftPoints'])->name('team_leader.gift.points');
        Route::get('/trainers', [TeamLeaderPanelController::class, 'trainer'])->name('team_leader.trainers.list');
        Route::get('/trainers/create', [TeamLeaderPanelController::class, 'create'])->name('team_leader.trainers.create');
        Route::post('/trainers/store', [TeamLeaderPanelController::class, 'store'])->name('team_leader.trainers.store');
        Route::get('/trainers/assign/{id}', [TeamLeaderPanelController::class, 'assignPage'])->name('team_leader.trainers.assign');
        Route::post('/trainers/assign-process', [TeamLeaderPanelController::class, 'assignProcess'])->name('team_leader.trainers.assignProcess');
        Route::put('/trainers/update/{id}', [TeamLeaderPanelController::class, 'update'])->name('team_leader.trainers.update');
        Route::delete('/trainers/delete/{id}', [TeamLeaderPanelController::class, 'destroy'])->name('team_leader.trainers.delete');
    });

    // Trainer Panel Route
    Route::group(['middleware' => 'subadmin.role:trainer'], function () {    
        Route::get('/trainer/dashboard', [TrainerPanelController::class, 'dashboard'])->name('trainer.dashboard');
        Route::get('/trainer/students', [TrainerPanelController::class, 'studentList'])->name('trainer.stdent.list');
        Route::get('/trainer/profile', [TrainerPanelController::class, 'profile'])->name('trainer.profile');
        Route::get('/trainer/profile/edit', [TrainerPanelController::class, 'profileEdit'])->name('trainer.profile.edit');
        Route::post('/trainer/profile/update', [TrainerPanelController::class, 'profileUpdate'])->name('trainer.profile.update');
        Route::get('/trainer/change-password', [TrainerPanelController::class, 'changePassword'])->name('trainer.password.change');
        Route::post('/trainer/update-password', [TrainerPanelController::class, 'updatePassword'])->name('trainer.password.update');
    });
});
