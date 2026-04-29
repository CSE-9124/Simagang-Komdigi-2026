<?php

use App\Http\Controllers\Admin\AdminAttendanceController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminInternController;
use App\Http\Controllers\Admin\AdminMentorController;
use App\Http\Controllers\Admin\AdminMonitoringController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminLogbookController;
use App\Http\Controllers\Api\HolidayController;
use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\Intern\MicroSkillController as InternMicroSkillController;
use App\Http\Controllers\Mentor\MicroSkillController as MentorMicroSkillController;
use App\Http\Controllers\Admin\AdminMicroSkillController;
use App\Http\Controllers\Admin\AdminMicroSkillLeaderboardController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Mentor\InternController as MentorInternController;
use App\Http\Controllers\Mentor\AttendanceController as MentorAttendanceController;
use App\Http\Controllers\Mentor\LogbookController as MentorLogbookController;
use App\Http\Controllers\Mentor\ReportController as MentorReportController;
use App\Http\Controllers\Mentor\MicroSkillLeaderboardController as MentorMicroSkillLeaderboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Intern\AttendanceController;
use App\Http\Controllers\Intern\DashboardController;
use App\Http\Controllers\Intern\LogbookController;
use App\Http\Controllers\Intern\ReportController;
use App\Http\Controllers\Intern\MicroSkillLeaderboardController as InternMicroSkillLeaderboardController;
use App\Http\Controllers\Intern\ProfileController;
use App\Http\Controllers\Mentor\ProfileController as MentorProfileController;
use App\Http\Controllers\Mentor\CertificateController;
use App\Http\Controllers\Admin\AdminCertificateController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Institusi\DaftarInstitusiController;
use App\Http\Controllers\Institusi\DashboardController as InstitusiDashboardController;
use App\Http\Controllers\Institusi\PengajuanController;
use App\Http\Controllers\Admin\AdminPengajuanMagang;
use App\Http\Controllers\Institusi\AttendanceController as InstitusiAttendanceController;
use App\Http\Controllers\Institusi\InternController as InstitusiInternController;
use App\Http\Controllers\Institusi\LogbookController as InstitusiLogbookController;
use App\Http\Controllers\Institusi\MicroSkillController as InstitusiMicroSkillController;
use App\Http\Controllers\Institusi\ProfileController as InstitusiProfileController;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $partnerFiles = Storage::disk('public')->files('partners');
    $partners = collect($partnerFiles)
        ->filter(fn ($path) => preg_match('/\.(png|jpe?g|gif|svg|webp)$/i', $path))
        ->map(fn ($path) => asset('storage/' . str_replace('%2F', '/', rawurlencode($path))))
        ->values();

    $testimonials = Testimonial::with(['intern', 'finalReport'])->orderBy('created_at', 'desc')->limit(3)->get();

    return view('landingpage', compact('partners', 'testimonials'));
})->name('landing');

Route::get('/convert-font', function () {
    $fontPath = storage_path('app/fonts/Poppins-Extralight.ttf');

    TCPDF_FONTS::addTTFfont(
        $fontPath,
        'TrueTypeUnicode',
        '',
        32
    );

    return 'Poppins Extralight berhasil di-convert';
});



// API Routes for Institution Search
Route::get('/api/institutions/search', [InstitutionController::class, 'searchUniversities'])->name('api.institutions.search');
Route::get('/api/institutions/all', [InstitutionController::class, 'getAllUniversities'])->name('api.institutions.all');

// API Route cek hari libur (real-time, butuh auth)
Route::middleware('auth')->get('/api/attendance/is-holiday', [HolidayController::class, 'check'])->name('api.attendance.is-holiday');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Daftar Institusi
// Route::get('/institusi/dashboard', [InstitusiDashboardController::class, 'index'])->name('institusi.dashboard');
Route::middleware('auth', 'institusi')->group(function () {
    Route::get('/institusi/dashboard', [InstitusiDashboardController::class, 'index'])->name('institusi.dashboard');
    Route::get('/institusi/pengajuan', [PengajuanController::class, 'index'])->name('institusi.pengajuan.index');
    Route::get('/institusi/pengajuan/create', [PengajuanController::class, 'create'])->name('institusi.pengajuan.create');
    Route::post('/institusi/pengajuan', [PengajuanController::class, 'store'])->name('institusi.pengajuan.store');
    Route::get('/institusi/pengajuan/{id}', [PengajuanController::class, 'show'])->name('institusi.pengajuan.show');
    Route::delete('/institusi/pengajuan/{id}', [PengajuanController::class, 'destroy'])->name('institusi.pengajuan.destroy');

    // surat balasan untuk institusi
    Route::get('/institusi/surat-balasan/{pengajuan}', [PengajuanController::class, 'generateSuratBalasan'])->name('institusi.pengajuan.surat-balasan');
    
    // Profile routes for institusi
    Route::get('/institusi/profile', [InstitusiProfileController::class, 'show'])->name('institusi.profile.show');
    Route::get('/institusi/profile/edit', [InstitusiProfileController::class, 'edit'])->name('institusi.profile.edit');
    Route::put('/institusi/profile', [InstitusiProfileController::class, 'update'])->name('institusi.profile.update');
    // Attendance monitoring for institusi
    Route::get('/institusi/attendance', [InstitusiAttendanceController::class, 'index'])->name('institusi.attendance.index');
    // Intern management for institusi
    Route::get('/institusi/intern', [InstitusiInternController::class, 'index'])->name('institusi.intern.index');
    // Logbook monitoring for institusi
    Route::get('/institusi/logbook', [InstitusiLogbookController::class, 'index'])->name('institusi.logbook.index');
    Route::get('/institusi/logbook/{id}', [InstitusiLogbookController::class, 'show'])->name('institusi.logbook.show');
    // Mikro skill monitoring for institusi
    Route::get('/institusi/microskill', [InstitusiMicroSkillController::class, 'index'])->name('institusi.microskill.index');

}); 
Route::resource('institusi', DaftarInstitusiController::class);

// File Download Route
Route::get('/download/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (file_exists($fullPath)) {
        return response()->download($fullPath);
    }
    abort(404);
})->middleware('auth')->where('path', '.*')->name('download');

// Intern Routes
Route::middleware(['auth', 'intern'])->prefix('intern')->name('intern.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get(
            'certificates/{certificate}/print',
            [CertificateController::class, 'print']
        )->name('certificates.print');
    
    // Attendance Routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    
    // Logbook Routes
    Route::get('/logbook', [LogbookController::class, 'index'])->name('logbook.index');
    Route::get('/logbook/create', [LogbookController::class, 'create'])->name('logbook.create');
    Route::post('/logbook', [LogbookController::class, 'store'])->name('logbook.store');
    Route::get('/logbook/{logbook}/edit', [LogbookController::class, 'edit'])->name('logbook.edit');
    Route::put('/logbook/{logbook}', [LogbookController::class, 'update'])->name('logbook.update');
    Route::delete('/logbook/{logbook}', [LogbookController::class, 'destroy'])->name('logbook.destroy');

    // Micro Skill Routes
    Route::get('/microskill', [InternMicroSkillController::class, 'index'])->name('microskill.index');
    Route::get('/microskill/create', [InternMicroSkillController::class, 'create'])->name('microskill.create');
    Route::post('/microskill', [InternMicroSkillController::class, 'store'])->name('microskill.store');
    Route::get('/microskill/{submission}/edit', [InternMicroSkillController::class, 'edit'])->name('microskill.edit');
    Route::put('/microskill/{submission}', [InternMicroSkillController::class, 'update'])->name('microskill.update');
    Route::delete('/microskill/{submission}', [InternMicroSkillController::class, 'destroy'])->name('microskill.destroy');
    Route::get('/microskill/leaderboard', [InternMicroSkillLeaderboardController::class, 'index'])->name('microskill.leaderboard');
    
    // Final Report Routes
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
    Route::put('/report/{report}', [ReportController::class, 'update'])->name('report.update');
    Route::post('/report/{report}/testimonial', [ReportController::class, 'storeTestimonial'])->name('report.storeTestimonial');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Mentor Management Routes
    Route::get('/mentor', [AdminMentorController::class, 'index'])->name('mentor.index');
    Route::get('/mentor/create', [AdminMentorController::class, 'create'])->name('mentor.create');
    Route::post('/mentor', [AdminMentorController::class, 'store'])->name('mentor.store');
    Route::get('/mentor/{mentor}/edit', [AdminMentorController::class, 'edit'])->name('mentor.edit');
    Route::put('/mentor/{mentor}', [AdminMentorController::class, 'update'])->name('mentor.update');
    Route::delete('/mentor/{mentor}', [AdminMentorController::class, 'destroy'])->name('mentor.destroy');

    // Intern Management Routes
    Route::get('/intern', [AdminInternController::class, 'index'])->name('intern.index');
    Route::get('/intern/create', [AdminInternController::class, 'create'])->name('intern.create');
    Route::post('/intern', [AdminInternController::class, 'store'])->name('intern.store');
    Route::get('/intern/{intern}', [AdminInternController::class, 'show'])->name('intern.show');
    Route::get('/intern/{intern}/edit', [AdminInternController::class, 'edit'])->name('intern.edit');
    Route::put('/intern/{intern}', [AdminInternController::class, 'update'])->name('intern.update');
    Route::delete('/intern/{intern}', [AdminInternController::class, 'destroy'])->name('intern.destroy');
    
    // Attendance Monitoring Routes
    Route::get('/attendance', [AdminAttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/{attendance}', [AdminAttendanceController::class, 'show'])->name('attendance.show');
    Route::put('/attendance/{attendance}/document-status', [AdminAttendanceController::class, 'updateDocumentStatus'])->name('attendance.update-document-status');
    
    // Logbook Monitoring Routes
    Route::get('/logbook', [AdminLogbookController::class, 'index'])->name('logbook.index');
    Route::delete('/logbook/{logbook}', [AdminLogbookController::class, 'destroy'])->name('logbook.destroy');
    
    // Report Monitoring Routes
    Route::get('/report', [AdminReportController::class, 'index'])->name('report.index');
    Route::get('/report/{report}', [AdminReportController::class, 'show'])->name('report.show');
    Route::put('/report/{report}/status', [AdminReportController::class, 'updateStatus'])->name('report.update-status');
    
    // Micro Skill Routes
    Route::get('/microskill', [AdminMicroSkillController::class, 'index'])->name('microskill.index');
    Route::delete('/microskill/{submission}', [AdminMicroSkillController::class, 'destroy'])->name('microskill.destroy');
    Route::get('/microskill/leaderboard', [AdminMicroSkillLeaderboardController::class, 'index'])->name('microskill.leaderboard');
    
    // Monitoring Routes
    Route::get('/monitoring', [AdminMonitoringController::class, 'index'])->name('monitoring.index');
    Route::post('/monitoring/{intern}/mark-released', [AdminMonitoringController::class, 'markAsReleased'])->name('monitoring.mark-released');
    Route::post('/monitoring/{intern}/mark-active', [AdminMonitoringController::class, 'markAsActive'])->name('monitoring.mark-active');
    Route::get('/monitoring/export', [AdminMonitoringController::class, 'export'])->name('monitoring.export');

    // Certificate Management Routes
    Route::resource('certificates', AdminCertificateController::class)
            ->only(['index', 'create', 'store', 'show', "update"]);

    Route::get(
            'certificates/{certificate}/print',
            [AdminCertificateController::class, 'print']
        )->name('certificates.print');

    // Pengajuan Management Routes
    Route::get('/pengajuan', [AdminPengajuanMagang::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{id}', [AdminPengajuanMagang::class, 'show'])->name('pengajuan.show');
    Route::put('/pengajuan/{pengajuan}/update-status', [AdminPengajuanMagang::class, 'updateStatus'])
    ->name('pengajuan.update-status');
    Route::delete('/pengajuan/{id}', [AdminPengajuanMagang::class, 'destroy'])->name('pengajuan.destroy');

    // Manafe Tim Routes
    Route::get('/team', [TeamController::class, 'index'])->name('team.index');
    Route::get('/team/create', [TeamController::class, 'create'])->name('team.create');
    Route::post('/team', [TeamController::class, 'store'])->name('team.store');
    Route::get('/team/{team}/edit', [TeamController::class, 'edit'])->name('team.edit');
    Route::put('/team/{team}', [TeamController::class, 'update'])->name('team.update');
    Route::delete('/team/{team}', [TeamController::class, 'destroy'])->name('team.destroy');   
});

    
// Mentor Routes
Route::middleware(['auth', 'mentor'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/interns', [MentorInternController::class, 'index'])->name('intern.index');
    Route::get('/interns/{intern}', [MentorInternController::class, 'show'])->name('intern.show');
    Route::get('/attendance', [MentorAttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/logbook', [MentorLogbookController::class, 'index'])->name('logbook.index');
    Route::get('/logbook/{logbook}', [MentorLogbookController::class, 'show'])->name('logbook.show');
    Route::get('/report', [MentorReportController::class, 'index'])->name('report.index');
    Route::get('/report/{report}', [MentorReportController::class, 'show'])->name('report.show');
    Route::put('/report/{report}/grade', [MentorReportController::class, 'grade'])->name('report.grade');
    Route::get('/microskill', [MentorMicroSkillController::class, 'index'])->name('microskill.index');
    Route::get('/microskill/leaderboard', [MentorMicroSkillLeaderboardController::class, 'index'])->name('microskill.leaderboard');
    Route::resource('certificates', CertificateController::class)
            ->only(['index', 'create', 'store', 'show', "update"]);
    Route::get(
            'certificates/{certificate}/print',
            [CertificateController::class, 'print']
        )->name('certificates.print');
    
    // Profile Routes
    Route::get('/profile', [MentorProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [MentorProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [MentorProfileController::class, 'update'])->name('profile.update');
});