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
use App\Http\Controllers\backend\CounsellorController;
use App\Http\Controllers\backend\HelplineController;
use App\Http\Controllers\backend\ReportController;
use App\Http\Controllers\backend\NoticeController;
use App\Http\Controllers\backend\lockController;
use App\Http\Controllers\backend\ManagerController;
use App\Http\Controllers\backend\TestimonialController;
use App\Http\Controllers\backend\NewsController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\SubadminController;
use App\Http\Controllers\backend\teacher\TeacherPanelController;
use App\Http\Controllers\backend\TeamLeaderPanelController;
use App\Http\Controllers\backend\TrainerPanelController;
use App\Http\Controllers\backend\WithdrawController;
use App\Http\Controllers\ReferralController;
use FontLib\Table\Type\name;

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

//course React Route...
Route::get('/course/wishlist/{id}', [FrontendController::class, 'toggleWishlist'])->name('course.wishlist');

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
    Route::get('/payment/delete/{id}', [PaymentController::class, 'paymentDelete']);
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
    Route::get('/student/certificate/delete/{id}', [CertificateController::class, 'destroy'])->name('certificate.delete');
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
    Route::post('/notice/toggle-status/{id}', [NoticeController::class, 'toggleStatus']);
    Route::get('/notice/delete/{id}', [NoticeController::class, 'noticeDelete']);
    Route::get('/notice/edit/{id}', [NoticeController::class, 'noticeEdit']);
    Route::post('/notice/update/{id}', [NoticeController::class, 'noticeUpdate']);

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
    Route::post('/testimonial/store', [TestimonialController::class, 'testimonialStore']);
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
    Route::get('/team-leader-withdraw-requests', [SubadminController::class, 'withdrawRequests'])->name('admin.team_leader.withdraw.requests');
    Route::post('/admin/withdraw/approve/{id}', [SubadminController::class, 'approveWithdraw'])->name('admin.team_leader.withdraw.approve');
    //Trainer...
    Route::get('/trainer', [SubadminController::class, 'trainer'])->name('admin.trainer_list');
    Route::post('/add-trainer-points', [SubadminController::class, 'addTrainerPoints'])->name('admin.add.trainer.points');
    Route::get('/trainer-withdraw-requests', [SubadminController::class, 'trainerwithdrawRequests'])->name('admin.trainer.withdraw.requests');
    Route::post('/admin/trainer/withdraw/approve/{id}', [SubadminController::class, 'approveTrainerWithdraw'])->name('admin.trainer.withdraw.approve');
    //Helpline...
    Route::get('/admin/helpline', [SubadminController::class, 'helpline'])->name('admin.helpline');
    Route::post('/admin/helpline/store', [SubadminController::class, 'store'])->name('admin.helpline.store');
    Route::get('/admin/helpline-staff/delete/{id}', [SubadminController::class, 'delete'])->name('admin.helpline.delete');
    Route::get('/admin/helpline-staff/edit/{id}', [SubadminController::class, 'edit'])->name('admin.helpline.edit');
    Route::post('/admin/helpline-staff/update', [SubadminController::class, 'update'])->name('admin.helpline.update');
    Route::post('/admin/add/helpline/points', [SubadminController::class, 'AddHelplinePoints'])->name('admin.add.helpline.points');
    Route::get('/withdraw/requests', [SubadminController::class, 'helplineWithdrawRequests'])->name('admin.helpline.withdraw.requests');
    Route::post('/withdraw/approve/{id}', [SubadminController::class, 'ApproveWithdrawHelpline'])->name('admin.helpline.withdraw.approve');
    Route::Post('/withdraw/reject/{id}', [SubadminController::class, 'RejectWithdraw'])->name('admin.helpline.withdraw.reject');
    //Counsellor...
    Route::get('/counsellor', [SubadminController::class, 'counsellor'])->name('admin.counsellor');
    Route::get('/counsellor/create', [SubadminController::class, 'counsellorCreate'])->name('admin.counsellor.create');
    Route::post('/counsellor/store', [SubadminController::class, 'counsellorStore'])->name('counsellor.store');
    Route::post('/counsellor/update/{id}', [SubadminController::class, 'counsellorUpdate'])->name('admin.counsellor.update');
    Route::get('/counsellor/delete/{id}', [SubadminController::class, 'counsellorDelete'])->name('admin.counsellor.delete');
    Route::get('/counsellor/assign-list/{counsellor_id}', [SubadminController::class, 'assignStudentList'])->name('admin.counsellor.assign.list');
    Route::get('/counsellor/assign-process/{counsellor_id}/{student_id}', [SubadminController::class, 'assignProcess'])->name('admin.counsellor.assign.process');
    Route::get('/counsellor/logs/{id}', [SubadminController::class, 'getCounsellorLogs'])->name('admin.counsellor.logs');
    Route::post('/counsellor/add-points', [SubadminController::class, 'addCounsellorPoints'])->name('admin.add.counsellor.points');
    Route::get('/counsellor/withdraw-request', [SubadminController::class, 'counsellorWithdrawRequest'])->name('admin.counsellor.withdraw.request');
    Route::post('/counsellor-withdraw/approve/{id}', [SubadminController::class, 'approveCounsellorWithdraw'])->name('admin.counsellor.withdraw.approve');
    Route::post('/counsellor-withdraw/reject/{id}', [SubadminController::class, 'rejectCounsellorWithdraw'])->name('admin.counsellor.withdraw.reject');
    //Manager...
    Route::get('/manager', [SubadminController::class, 'manager'])->name('admin.manager');
    Route::post('/manager/store', [SubadminController::class, 'managerStore'])->name('admin.manager.store');
    Route::get('/manager/edit/{id}', [SubadminController::class, 'managerEdit'])->name('edit');
    Route::post('/manager/update', [SubadminController::class, 'managerUpdate'])->name('admin.manager.update');
    Route::get('/manager/delete/{id}', [SubadminController::class, 'destroy'])->name('admin.manager.delete');
    Route::post('/manager/add-points', [SubadminController::class, 'addPoints'])->name('add.points');
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
    //passbook...
    Route::get('/passbook', [StudentController::class, 'passbook'])->name('student.passbook');
    Route::get('/passbook/download', [StudentController::class, 'downloadPassbookPDF'])->name('student.passbook.download');
    // স্টুডেন্টের সব নোটিফিকেশন পড়া হিসেবে মার্ক করার রাউট
    Route::get('/notifications/read', [StudentController::class, 'markAsRead'])->name('student.notifications.read');
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
        Route::get('/teacher/profile', [TeacherPanelController::class, 'profile'])->name('teacher.view-profile');
        Route::get('/teacher/profile/edit', [TeacherPanelController::class, 'editProfile'])->name('teacher.profile.edit');
        Route::post('/teacher/profile/update-process', [TeacherPanelController::class, 'updateProfile'])->name('teacher.profile.update');
        Route::post('/password/update', [TeacherPanelController::class, 'updatePassword'])->name('teacher.password.update');
        Route::get('/teacher/student-results', [TeacherPanelController::class, 'studentResults'])->name('teacher.student.results');
        Route::post('/gift-points', [TeacherPanelController::class, 'giftPoint'])->name('teacher.gift.point');
        Route::get('/passbook', [TeacherPanelController::class, 'passbook'])->name('passbook');
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
        Route::get('/profile', [TeamLeaderPanelController::class, 'profile'])->name('team_leader.profile');
        Route::post('/profile/update', [TeamLeaderPanelController::class, 'updateProfile'])->name('team_leader.profile.update');
        Route::post('/profile/password', [TeamLeaderPanelController::class, 'updatePassword'])->name('team_leader.password.update');
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
        Route::get('/trainer/withdraw', [TrainerPanelController::class, 'withdraw'])->name('trainer.withdraw');
        Route::post('/trainer/withdraw/store', [TrainerPanelController::class, 'withdrawStore'])->name('trainer.withdraw.store');
        Route::post('/trainer/gift-points', [TrainerPanelController::class, 'giftPoints'])->name('trainer.gift.points');
        Route::get('/trainer/transactions', [TrainerPanelController::class, 'transactions'])->name('trainer.transactions');
    });

    // Helpline Panel Route
    Route::group(['middleware' => 'subadmin.role:helpline'], function () {
        Route::get('/helpline/dashboard', [HelplineController::class, 'dashboard'])->name('helpline.dashboard');
        Route::get('/helpline/meeting', [HelplineController::class, 'meeting'])->name('helpline.meeting');
        Route::post('/meeting-desk/update', [HelplineController::class, 'UpdateMeetingDesk'])->name('meeting.update');
        Route::get('/helpline/earn-money', [HelplineController::class, 'EarnMoneyHistory'])->name('helpline.earn.money');
        Route::get('/helpline/withdraw', [HelplineController::class, 'WithdrawPage'])->name('helpline.withdraw');
        Route::post('/helpline/withdraw/store', [HelplineController::class, 'WithdrawStore'])->name('helpline.withdraw.store');
        Route::get('/helpline/profile', [HelplineController::class, 'HelplineProfile'])->name('helpline.profile');
        Route::post('/helpline/profile/update', [HelplineController::class, 'HelplineProfileUpdate'])->name('helpline.profile.update');
        Route::get('/helpline/change-password', [HelplineController::class, 'ChangePassword'])->name('helpline.change.password');
        Route::post('/helpline/password/update', [HelplineController::class, 'HelplinePasswordUpdate'])->name('helpline.password.update');
    });

    // Counsellor Panel Route
    Route::group(['middleware' => 'subadmin.role:counsellor'], function () {
        Route::get('/counsellor/dashboard', [CounsellorController::class, 'dashboard'])->name('counsellor.dashboard');
        Route::get('/counsellor/new-leads', [CounsellorController::class, 'leads'])->name('counsellor.new-leads');
        Route::post('/counsellor/student-update/{id}', [CounsellorController::class, 'updateStatus'])->name('counsellor.student.update');
        Route::post('/counsellor/student-update/{id}', [CounsellorController::class, 'updateStatus'])->name('counsellor.student.update');
        Route::get('/counsellor/active-leads', [CounsellorController::class, 'activeLeads'])->name('counsellor.active-leads');
        Route::get('/counsellor/my-earning', [CounsellorController::class, 'myEarning'])->name('counsellor.my-earning');
        Route::get('/counsellor/withdraw', [CounsellorController::class, 'withdraw'])->name('counsellor.withdraw');
        Route::post('/counsellor/withdraw-store', [CounsellorController::class, 'withdrawStore'])->name('counsellor.withdraw.store');
        Route::get('/counsellor/withdraw-history', [CounsellorController::class, 'withdrawHistory'])->name('counsellor.withdraw.history');
        Route::get('/counsellor/profile', [CounsellorController::class, 'profile'])->name('counsellor.profile');
        Route::get('/counsellor/profile/edit', [CounsellorController::class, 'editProfile'])->name('counsellor.profile.edit');
        Route::post('/counsellor/profile/update', [CounsellorController::class, 'updateProfile'])->name('counsellor.profile.update');
        Route::get('/counsellor/security', [CounsellorController::class, 'changePassword'])->name('counsellor.security');
        Route::post('/counsellor/password-update', [CounsellorController::class, 'updatePassword'])->name('counsellor.password.update');
    });

    // Manager Panel Route
    Route::group(['middleware' => 'subadmin.role:manager'], function () {
        Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
        Route::get('/manager/student/{status?}', [ManagerController::class, 'allStudent'])->name('manager.student');
        Route::post('/manager/students/update-points', [ManagerController::class, 'updatePoints'])->name('students.updatePoints');
        Route::get('/manager/students/view/{id}', [ManagerController::class, 'viewStudent'])->name('manager.students.view');
        Route::post('/manager/student/reset-password', [ManagerController::class, 'resetStudentPassword'])->name('manager.student.resetPassword');
        Route::get('/manager/trainer', [ManagerController::class, 'trainer'])->name('manager.trainer');
        Route::get('/manager/trainer/view/{id}', [ManagerController::class, 'viewTrainer'])->name('manager.trainer.view');
        Route::post('/manager/trainer/update-points', [ManagerController::class, 'updateTrainerPoints'])->name('manager.trainer.updatePoints');
        Route::post('/manager/trainer/reset-password', [ManagerController::class, 'resetTrainerPassword'])->name('manager.trainer.resetPassword');
        Route::get('/manager/team-leader', [ManagerController::class, 'teamLeader'])->name('manager.team-leader');
        Route::get('/manager/leader/view/{id}', [ManagerController::class, 'viewLeader']);
        Route::post('/manager/leader/update-points', [ManagerController::class, 'updateLeaderPoints'])->name('manager.leader.updatePoints');
        Route::post('/manager/leader/reset-password', [ManagerController::class, 'resetLeaderPassword'])->name('manager.leader.resetPassword');
        Route::get('/manager/counselor/all', [ManagerController::class, 'allCounselor'])->name('manager.counselor');
        Route::get('/manager/counselor/view/{id}', [ManagerController::class, 'viewCounselor']);
        Route::post('/manager/counselor/update-points', [ManagerController::class, 'updateCounselorPoints'])->name('manager.counselor.updatePoints');
        Route::post('/manager/counselor/reset-password', [ManagerController::class, 'resetCounselorPassword'])->name('manager.counselor.resetPassword');
        Route::get('/manager/teacher/all', [ManagerController::class, 'allTeacher'])->name('manager.teacher.all');
        Route::post('/panel/manager/teacher/update-points', [ManagerController::class, 'updateTeacherPoints'])->name('manager.teacher.updatePoints');
        Route::get('/manager/teachers/view/{id}', [ManagerController::class, 'viewTeacher']);
        Route::post('/manager/teacher/reset-password', [ManagerController::class, 'resetTeacherPassword'])->name('manager.teacher.resetPassword');
        Route::get('/manager/helpline/all', [ManagerController::class, 'allHelpline'])->name('manager.helpline.all');
        Route::get('/manager/helpline/view/{id}', [ManagerController::class, 'viewHelpline']);
        Route::post('/panel/manager/helpline/update-points', [ManagerController::class, 'updateHelplinePoints'])->name('manager.helpline.updatePoints');
        Route::post('/panel/manager/helpline/reset-password', [ManagerController::class, 'resetHelplinePassword'])->name('manager.helpline.resetPassword');
        Route::get('/panel/manager/course/all', [ManagerController::class, 'allCourses'])->name('manager.course.all');
        Route::get('/manager/course/edit/{id}', [ManagerController::class, 'editCourse']);
        Route::post('/manager/course/update', [ManagerController::class, 'updateCourse'])->name('manager.course.update');
        Route::get('/manager/payment', [ManagerController::class, 'payment'])->name('manager.payment.history');
        Route::get('/manager/withdraw-history', [ManagerController::class, 'withdrawHistory'])->name('manager.withdraw.history');
        Route::get('/manager/subadmin-withdraw-history', [ManagerController::class, 'subadminWithdrawHistory'])->name('manager.subadmin-withdraw.history');
        Route::get('/manager/notice', [ManagerController::class, 'notice'])->name('manager.notice');
        Route::get('/manager/notice/create', [ManagerController::class, 'noticeCreate'])->name('manager.notice.create');
        Route::post('/manager/notice/store', [ManagerController::class, 'noticeStore'])->name('manager.notice.store');
        Route::post('panel/manager/notice/status/{id}', [ManagerController::class, 'noticeStatus'])->name('manager.notice.status'); // এখানে 'manager.' যুক্ত করুন
        Route::get('/manager/notice/edit/{id}', [ManagerController::class, 'noticeEdit'])->name('manager.notice.edit');
        Route::post('/manager/notice/update/{id}', [ManagerController::class, 'noticeUpdate'])->name('[manager.notice.update');
        Route::get('/manager/notice/delete/{id}', [ManagerController::class, 'noticeDelete'])->name('manager.notice.delete');
        Route::get('/contacts', [ManagerController::class, 'contactList'])->name('manager.contacts');
    });
});
