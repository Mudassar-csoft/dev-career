<?php
use App\Http\Controllers\admin\LeadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilityBillController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LimitController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WebsiteController;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WebsiteAdmin\GalleryTagsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RegisterationController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AllcampusController;
use App\Http\Controllers\BatchTimeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\OtherEnquiryController;
use App\Http\Controllers\ProgramManageController;
use App\Http\Controllers\OtherAdmissionController;
use App\Http\Controllers\WebsiteAdmin\FAQController;
use App\Http\Controllers\WebsiteAdmin\TourController;
use App\Http\Controllers\WebsiteAdmin\EventController;
use App\Http\Controllers\WebsiteAdmin\GalleryController;
use App\Http\Controllers\WebsiteAdmin\PartnerController;
use Illuminate\Support\Facades\Auth as LoginAuth;
use App\Http\Controllers\WebsiteAdmin\WebBatchController;
use App\Http\Controllers\WebsiteAdmin\ContectUsController;
use App\Http\Controllers\WebsiteAdmin\AmbassadorController;
use App\Http\Controllers\WebsiteAdmin\CurriculamController;
use App\Http\Controllers\Websiteadmin\extensionrequest;
use App\Http\Controllers\WebsiteAdmin\NewsUpdateController;
use App\Http\Controllers\WebsiteAdmin\StudyAbroadController;
use App\Http\Controllers\WebsiteAdmin\JobPlacementController;
use App\Http\Controllers\WebsiteAdmin\VerificationController;
use App\Http\Controllers\WebsiteAdmin\WebsiteAdminController;
use App\Http\Controllers\WebsiteAdmin\SharworkSpaceController;
use App\Http\Controllers\WebsiteAdmin\WebsiteAnnouncementController;
use App\Http\Controllers\CoworkingSpaceController;
use App\Http\Controllers\WebsiteBlogController;
use App\Http\Controllers\CourseCategoryController;
use App\Models\BillType;
use App\Http\Controllers\JobAndCareerController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Clear All data & cache routes start
Route::get('/storage-path', function () {

    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('storage:link');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
});
// Clear All data & cache routes end


// website routes start ================================================
Route::get('/', [WebsiteController::class, 'index'])->name('index');
Route::get('/blog', [WebsiteController::class, 'blogshow'])->name('blogshow');
Route::get('/blog/{id}/{title}', [WebsiteController::class, 'blogsingle'])->name('blogsingle');
Route::get('/course/{id}/{title}', [WebsiteController::class, 'showCourse'])->name('showCourse');
Route::get('/about-us', [WebsiteController::class, 'aboutUs'])->name('aboutUs');
Route::get('/short-courses', [WebsiteController::class, 'shortCourses'])->name('shortCourses');
Route::get('/courses', [WebsiteController::class, 'courses'])->name('courses');
Route::post('/searchcourse', [WebsiteController::class, 'searchcourse'])
    ->name('searchcourse');


Route::get('/pearson-testing', [WebsiteController::class, 'pearsonTesting'])->name('pearsonTesting');
Route::get('/psi-exam-center', [WebsiteController::class, 'psiExamCenter'])->name('psiExamCenter');
Route::get('/kryterion-testing-center', [WebsiteController::class, 'kryterionTestingCenter'])->name('kryterionTestingCenter');
Route::get('/Workspace', [WebsiteController::class, 'Workspace'])->name('Workspace');
Route::get('/coworking', [WebsiteController::class, 'coworking'])->name('coworking');
Route::get('/slip', [WebsiteController::class, 'slip'])->name('slip');
Route::get('/study-abroad', [WebsiteController::class, 'studyAbroad'])->name('studyAbroad');
Route::get('/how-to-pay', [WebsiteController::class, 'howToPay'])->name('howToPay');
Route::get('/verification', [WebsiteController::class, 'verification'])->name('verification');
Route::post('/req-verification', [WebsiteController::class, 'reqVerification'])->name('reqVerification');
Route::get('/job-placement', [WebsiteController::class, 'jobPlacement'])->name('jobPlacement');
Route::get('/postjob', [WebsiteController::class, 'postjob'])->name('postjob');
Route::get('/career-job', [WebsiteController::class, 'careerjob'])->name('career-job');
// Route::resource('/post-job', PostJobController::class);    // Job Placement Route End=================
Route::resource('/jobs', JobAndCareerController::class);    // Job Placement Route End=================

Route::patch('/jobs/{id}/approve', [JobAndCareerController::class, 'approve'])->name('jobs.approve');
Route::patch('/jobs/{id}/decline', [JobAndCareerController::class, 'decline'])->name('jobs.decline');
Route::get('/approvedjobs', [JobAndCareerController::class, 'approved'])->name('jobs.approved');
Route::get('/rejectedjobs', [JobAndCareerController::class, 'rejected'])->name('jobs.rejected');
Route::get('/expiredjobs', [JobAndCareerController::class, 'expired'])->name('jobs.expired');
Route::get('/ambassador-program', [WebsiteController::class, 'ambassadorProgram'])->name('ambassadorProgram');
Route::get('/contact-us', [WebsiteController::class, 'contactUs'])->name('contactUs');
Route::get('/events', [WebsiteController::class, 'events'])->name('events');
Route::get('/search_bar_course', [WebsiteController::class, 'search_bar_course'])->name('search_bar_course');

Route::get('/event_detail/{id}', [WebsiteController::class, 'event_detail'])->name('event_detail');


// blogs
Route::get('/blogdetails/{id}', [WebsiteController::class, 'blogdetails'])->name('blogdetails');
// end blogs
Route::get('/blogs', [WebsiteController::class, 'blogs'])->name('blogs');
// gallery

Route::get('/gallery', [WebsiteController::class, 'gallery'])->name('gallery');





// Route::get('/blogs', [WebsiteController::class, 'blogs'])->name('blogs');
// Route::get('/courses', [WebsiteController::class, 'courses'])->name('courses');
Route::post('/brochuredata', [WebsiteController::class, 'brochuredata'])->name('brochuredata');
Route::get('/all-news', [WebsiteController::class, 'allNews'])->name('allNews');
Route::get('/all-batches', [WebsiteController::class, 'allBatches'])->name('allBatches');
Route::get('/events/single/{id}', [WebsiteController::class, 'singleevents'])->name('singleevents');
Route::get('/news/single/{id}', [WebsiteController::class, 'singlnews'])->name('singlenews');

Route::post('/leads', [WebsiteController::class, 'leads'])->name('leads');
Route::get('/leads/profile/{id}', [WebsiteController::class, 'leadeshow'])->name('leadeshow');
Route::get('/courses-by-category/{categoryId?}', [WebsiteController::class, 'getCoursesByCategory']);

// verification routes
Route::get('show/verification', [VerificationController::class, 'index'])->name('index.verification');
Route::get('cnic/verification', [WebsiteController::class, 'cnic'])->name('cnic.verification');
// Route::get('verifycnic/verification', [WebsiteController::class, 'verifycnic'])->name('verifycnic.verification');
Route::get('roll-number/verification', [WebsiteController::class, 'rollNumber'])->name('rollNumber');
Route::post('roll-number/verification', [WebsiteController::class, 'rollNumberstore'])->name('rollNumberstore');

Route::post('/verification', [WebsiteController::class, 'verifyrollNumberstore'])->name('verifyrollNumberstore');

// website routes end ================================================



// portal routes start ================================================
// Auth::routes();
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Route::post('/website-admin-login', function (\Illuminate\Http\Request $request) {

    $credentials = $request->only('email', 'password');

    if (LoginAuth::attempt($credentials)) {
        return redirect()->intended('/website/dashboard');
    }
    return redirect()->route('login')
        ->withErrors(['email' => 'The provided credentials do not match our records.'])
        ->withInput();
})->name('login.submit');
Route::get('/website-admin-login', function () {
    return view('auth.login');
})->name('login');
Route::get('/login', function () {
    return redirect('https://new-portal.csoft.live/');
});

Route::middleware(['preventBackHistory'])->group(function () {
    // dashoboard route
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // search route all project
    Route::post('/search', [DashboardController::class, 'search'])->name('search');
    Route::get('/search/result', [DashboardController::class, 'searchResult'])->name('searchResult');
    // this month collection
    Route::get('/this/month/collection', [DashboardController::class, 'thisMonthCollection'])->name('thisMonthCollection');
    Route::get('/this/month/pending-recovery', [DashboardController::class, 'thisMonthPendingRecovery'])->name('thisMonthPendingRecovery');

    // enquiry management
    Route::get('/daily-report', [ReportController::class, 'dailyreport'])->name('dailyreport');
    Route::resource('lead', EnquiryController::class);

    // all other enquiries
    // all other enquiries
    Route::post('/filter-all-enquiry', [OtherEnquiryController::class, 'filterallenquir'])->name('filter-all-enquiry');
    Route::get('/follow-up', [OtherEnquiryController::class, 'followUp'])->name('followUp');
    Route::get('/today-enquiry', [OtherEnquiryController::class, 'todayEnquiry'])->name('todayEnquiry');
    Route::get('/successfully-enrolled', [OtherEnquiryController::class, 'successfullyEnrolled'])->name('successfullyEnrolled');
    Route::get('/not-interested', [OtherEnquiryController::class, 'notInterested'])->name('notInterested');
    Route::get('/pipeline-enquiries', [OtherEnquiryController::class, 'pipelineEnquiry'])->name('pipelineEnquiry');
    Route::get('/all-enquiries', [OtherEnquiryController::class, 'allEnquiry'])->name('allEnquiry');
    Route::get('/select-id', [OtherEnquiryController::class, 'selectId'])->name('selectId');
    Route::get('/add-follow-up/{id}', [OtherEnquiryController::class, 'addFollowUp'])->name('addFollowUp');
    Route::post('/save-follow-up', [OtherEnquiryController::class, 'saveFollowUp'])->name('saveFollowUp');
    Route::post('/transfer-lead', [OtherEnquiryController::class, 'transferLead'])->name('transferLead');
    Route::get('/transferred-lead', [OtherEnquiryController::class, 'transferredLead'])->name('transferredLead');
    Route::get('/enroll-now/{id?}', [RegisterationController::class, 'create'])->name('enrollNow');
    Route::post('/store-enroll/{id}', [OtherEnquiryController::class, 'storeEnroll'])->name('storeEnroll');
    Route::get('/notintrested/{id}', [OtherEnquiryController::class, 'notInterestedAction'])->name('notInterestedAction');
    Route::get('/create-old-lead/{id}', [OtherEnquiryController::class, 'createOldLead'])->name('createOldLead');
    Route::get('/check-number/{num}', [OtherEnquiryController::class, 'checkNumber'])->name('checkNumber');


    Route::get('/web-leads/show', [OtherEnquiryController::class, 'leadsshow'])->name('leadsshow');
    Route::get('/add-web/leads/{id}', [OtherEnquiryController::class, 'addweblead'])->name('addweblead');
    Route::get('/add-web/admession/{id}', [OtherEnquiryController::class, 'addwebadmission'])->name('addwebadmission');
    Route::get('/web/not-interested/{id}', [OtherEnquiryController::class, 'webnotinterested'])->name('webnotinterested');
    Route::get('old-leads', [OtherEnquiryController::class, 'oldLeads'])->name('oldLeads');
    Route::get('/new-admission/{id?}', [RegisterationController::class, 'admissioncreate'])->name('admissioncreate');

    Route::get('/new-registeration', [RegisterationController::class, 'create'])->name('create.registeration');
    Route::get('/recepit-registeration', [RegisterationController::class, 'regandreceptapi'])->name('regrecept');
    Route::post('/store-registeration', [RegisterationController::class, 'store'])->name('store.registeration');

    //
    Route::get('/today-registeration', [RegisterationController::class, 'todayregistration'])->name('todayregistration');
    Route::get('/current-month-registeration', [RegisterationController::class, 'currentmonthRegisteration'])->name('currentmonthRegisteration');
    Route::get('/current-year-registeration', [RegisterationController::class, 'currentyearRegisteration'])->name('currentyearRegisteration');
    // admission management
    // admission management
    Route::get('/new-admission/{id?}', [RegisterationController::class, 'admissioncreate'])->name('admissioncreate');
    Route::post('/new-admission-store', [RegisterationController::class, 'admissionstore'])->name('admissionstore');

    Route::resource('admission', AdmissionController::class);
    // Route::get('extension-requests', [extensionrequest::class, 'extensionrequestsshow'])->name('show-extension-requests');
    // Route::get('approve-extension-rqeuest/{id}', [extensionrequest::class, 'approveextensionrequest'])->name('approveextensionrequest');
    // all other admission routes
    Route::get('todays-admission', [OtherAdmissionController::class, 'todayAdmission'])->name('todayAdmission');
    Route::get('current-month-admissions', [OtherAdmissionController::class, 'currentMonthAdmission'])->name('currentMonthAdmission');
    Route::get('current-year-admissions', [OtherAdmissionController::class, 'currentYearAdmission'])->name('currentYearAdmission');
    Route::get('all-admissions', [OtherAdmissionController::class, 'allAdmission'])->name('allAdmission');
    Route::get('fetch-badge/{id}/{campus_id?}', [OtherAdmissionController::class, 'fetchBadge'])->name('fetchBadge');
    Route::get('fetch-registeration-number/{id}', [OtherAdmissionController::class, 'fetchregforadmin'])->name('fetchregforadmin');
    Route::get('fetch-rollno/{id}/{campus_id?}', [OtherAdmissionController::class, 'fetchRollNo'])->name('fetchRollNo');
    Route::get('new-admission/{id}', [OtherAdmissionController::class, 'newAdmission'])->name('newAdmission');
    Route::post('store-new-admission', [OtherAdmissionController::class, 'storeNewAdmission'])->name('storeNewAdmission');
    Route::get('collect-installment/{id}', [OtherAdmissionController::class, 'collectInstallment'])->name('collectInstallment');
    Route::post('request-for-spliting', [OtherAdmissionController::class, 'requestforspliting'])->name('requestforspliting');
    Route::post('update-installment/{id}', [OtherAdmissionController::class, 'updateInstallment'])->name('updateInstallment');
    Route::get('fee-receipt/{id}', [OtherAdmissionController::class, 'feeReceipt'])->name('feeReceipt');
    Route::get('/register-check-number/{num}', [OtherAdmissionController::class, 'RegisterCheckNumber'])->name('RegisterCheckNumber');


    //new routes for student actions
    Route::get('setenrolled/{id}', [StudentController::class, 'setenrolled'])->name('setenrolled');
    Route::get('freeze/{id}', [StudentController::class, 'freezestudent'])->name('freezestudent');
    Route::get('notcompleted/{id}', [StudentController::class, 'notcompleted'])->name('notcompleted');
    Route::get('suspendst/{id}', [StudentController::class, 'suspendst'])->name('suspendst');

    // old admissions
    Route::get('/old-admissions', [OtherAdmissionController::class, 'oldAdmissions'])->name('oldAdmissions');
    Route::get('/old-admissions-certified/{id}', [OtherAdmissionController::class, 'oldAdmissionsCertified'])->name('oldAdmissionsCertified');
    Route::get('/add-old-admissions', [OtherAdmissionController::class, 'addOldAdmission'])->name('addOldAdmission');
    Route::post('/store-old-admissions', [OtherAdmissionController::class, 'storeOldAdmission'])->name('storeOldAdmission');


    // student management
    Route::get('current-students', [StudentController::class, 'currentStudents'])->name('currentStudents');
    Route::get('freeze-students', [StudentController::class, 'freezeStudents'])->name('freezeStudents');
    Route::get('concluded-students', [StudentController::class, 'concludedStudents'])->name('concludedStudents');
    Route::get('not-completed-students', [StudentController::class, 'notCompletedStudents'])->name('notCompletedStudents');
    Route::get('suspended-students', [StudentController::class, 'suspendedStudents'])->name('suspendedStudents');
    Route::get('conclude/{id}', [StudentController::class, 'conclude'])->name('conclude');


    // batch management
    Route::resource('batch', BatchController::class);

    // batch & time routes
    Route::get('upcoming-batch', [BatchTimeController::class, 'upcomingBatch'])->name('upcomingBatch');
    Route::get('recently-started-batch', [BatchTimeController::class, 'recentBatch'])->name('recentBatch');
    Route::get('inprogress-batch', [BatchTimeController::class, 'inprogressBatch'])->name('inprogressBatch');
    Route::get('suspended-batch', [BatchTimeController::class, 'suspendedBatch'])->name('suspendedBatch');
    Route::get('recently-end-batch', [BatchTimeController::class, 'recentlyEndBatch'])->name('recentlyEndBatch');
    Route::get('ended-batch', [BatchTimeController::class, 'endedBatch'])->name('endedBatch');
    Route::get('/batch-code/{id}', [BatchTimeController::class, 'batchCode'])->name('batchCode');


    // course management
    Route::resource('program', ProgramController::class);
    Route::get('ongoing-program', [ProgramManageController::class, 'ongoingProgram'])->name('ongoingProgram');
    Route::get('suspended-program', [ProgramManageController::class, 'suspendedProgram'])->name('suspendedProgram');
    Route::get('restore-program/{id}', [ProgramManageController::class, 'restoreProgram'])->name('restoreProgram');
    Route::get('delete-program/{id}', [ProgramManageController::class, 'deleteProgram'])->name('deleteProgram');

    // campus management
    Route::resource('campus', CampusController::class);
    Route::get('select-city/{city}', [AllcampusController::class, 'selectCity'])->name('selectCity');

    // all campus routes
    Route::get('owned-campus', [AllcampusController::class, 'ownedCampus'])->name('ownedCampus');
    Route::get('franchise-campus', [AllcampusController::class, 'franchiseCampus'])->name('franchiseCampus');
    Route::get('suspended-campus', [AllcampusController::class, 'suspendedCampus'])->name('suspendedCampus');
    Route::get('restore-campus/{id}', [AllcampusController::class, 'restoreCampus'])->name('restoreCampus');
    Route::get('force-delete-campus/{id}', [AllcampusController::class, 'forceDeleteCampus'])->name('forceDeleteCampus');
    Route::get('all-campus', [AllcampusController::class, 'allCampus'])->name('allCampus');


    // human resource management
    Route::get('add-employee', [EmployeeController::class, 'addEmployee'])->name('addEmployee');
    Route::post('save-employee', [EmployeeController::class, 'saveEmployee'])->name('saveEmployee');
    Route::get('/edit-employee/{id}', [EmployeeController::class, 'editEmployee'])->name('editEmployee');
    Route::post('update-employee/{id}', [EmployeeController::class, 'updateEmployee'])->name('updateEmployee');
    Route::get('/show-employee/{id}', [EmployeeController::class, 'showEmployee'])->name('showEmployee');
    Route::get('current-employee', [EmployeeController::class, 'currentEmployee'])->name('currentEmployee');
    Route::get('terminated-employee', [EmployeeController::class, 'terminatedEmployee'])->name('terminatedEmployee');
    Route::get('resigned-employee', [EmployeeController::class, 'resignedEmployee'])->name('resignedEmployee');


    // expense management
    Route::get('add-expense', [ExpenseController::class, 'addExpense'])->name('addExpense');
    Route::get('pay-bills', [ExpenseController::class, 'paybills'])->name('paybills');
    Route::get('pay-roll', [ExpenseController::class, 'payroll'])->name('payroll');
    Route::get('add-expense-type', [ExpenseController::class, 'addExpenseType'])->name('addExpenseType');
    Route::get('add-expense-type-ajax', [ExpenseController::class, 'addexpensetypajax'])->name('addexpensetypajax');
    Route::get('add-bill-type-ajax', [UtilityBillController::class, 'addbilltype'])->name('addbilltype');
    Route::get('payee-expense', [ExpenseController::class, 'payeeExpense'])->name('payeeExpense');
    Route::post('payee-expense', [ExpenseController::class, 'payeeExpenseStore'])->name('payeeExpenseStore');
    Route::get('payee-expense/edit', [ExpenseController::class, 'payeeExpenseEdit'])->name('payeeExpenseEdit');
    Route::post('payee-expense/update', [ExpenseController::class, 'payeeExpenseUpdate'])->name('payeeExpenseUpdate');
    Route::get('payee-expense/Destroy/{id}', [ExpenseController::class, 'payeeExpenseDestroy'])->name('payeeExpenseDestroy');

    // Expense Type Route
    Route::post('add-expense-type', [ExpenseController::class, 'addExpenseTypeUpdate'])->name('addExpenseTypeUpdate');
    Route::get('add-expense-type/edit', [ExpenseController::class, 'addExpenseTypeEdit'])->name('addExpenseTypeEdit');
    Route::post('add-expense-type/Update', [ExpenseController::class, 'addExpenseupdate'])->name('ExpenseUpdate');
    Route::get('expense-type/destroy/{id}', [ExpenseController::class, 'ExpenseDestroy'])->name('ExpenseDestroy');
    Route::get('/payee-details/{id}', [ExpenseController::class, 'showempayee'])->name('showpayee');
    Route::get('/get-ref-by-campus', [ExpenseController::class, 'getrefbycampus'])->name('getrefbycampus');

    // Add Expense Route
    Route::post('add-expense/add', [ExpenseController::class, 'ExpenseStore'])->name('ExpenseStore');
    Route::get('all-expense', [ExpenseController::class, 'index'])->name('allexpenseindex');
    // Route::get('all-expense/refno', [ExpenseController::class, 'expenseRefNo'])->name('expenseRefNo');

    Route::get('/add-refference-number', [UtilityBillController::class, 'addrefferencenumner'])->name('refferencenumber.add');
    Route::get('/get-reff-number', [UtilityBillController::class, 'getReferenceByCampusId'])->name('reff.no');
    Route::get('/ad-bil-type', [UtilityBillController::class, 'addd_bill_type'])->name('add.biltype');
    Route::post('/store-bil-type', [UtilityBillController::class, 'store_bill_type'])->name('store.biltype');
    //new bill

    Route::get('/ad-new-bill', [UtilityBillController::class, 'addnewBill'])->name('add.newbill');
    Route::post('/store-new-bill', [UtilityBillController::class, 'storenewbill'])->name('store.newbill');
    //api for bill type and campus mathc an getting reffernce number
    Route::get('/get-refference-numnber', [UtilityBillController::class, 'refferencenumberapi'])->name('ajax.refferencenumber');

    Route::post('add-bill/add', [UtilityBillController::class, 'store'])->name('bill.store');

    // user management
    Route::get('add-user', [UserController::class, 'addUser'])->name('addUser');
    Route::get('manage-users', [UserController::class, 'manageUser'])->name('manageUser');
    Route::get('user-profile/{id}', [UserController::class, 'userProfile'])->name('userProfile');
    Route::get('/edit-user/{id}', [UserController::class, 'edit'])->name('editUser');
    Route::post('/update-user/{id}', [UserController::class, 'update'])->name('updateUser');
    Route::get('/login/as/{id}', [UserController::class, 'loginAs'])->name('loginAs');
    Route::get('/verification/{id}', [UserController::class, 'verificationEmail'])->name('verificationEmail');
    Route::post('/verification/{id}', [UserController::class, 'verifyEmail'])->name('verifyEmail');
    Route::get('/resend-email/{id}', [UserController::class, 'resendEmail'])->name('resendEmail');
    // each campus in depth report

    Route::get('/campus_pending_report/{id}', [ReportController::class, 'campuspending'])->name('campuspending');
    // report management
    Route::get('/recovery-report', [ReportController::class, 'recovery'])->name('recovery');
    Route::post('/recovery', [ReportController::class, 'recoveryRequest'])->name('recoveryRequest');
    Route::get('/enquiry-report', [ReportController::class, 'enquiry'])->name('enquiry');
    Route::post('/enquiry', [ReportController::class, 'enquiryRequest'])->name('enquiryRequest');
    Route::get('/admission-report', [ReportController::class, 'admission'])->name('admission');
    Route::post('/admissionRequest', [ReportController::class, 'admissionRequest'])->name('admissionRequest');
    // Active Report Route
    Route::get('/active-report', [ReportController::class, 'activeReport'])->name('activeReport');
    Route::post('/active-report', [ReportController::class, 'searchReport'])->name('searchReport');
    // country state city
    Route::post('api/fetch-states', [DropdownController::class, 'fetchState']);
    Route::post('api/fetch-cities', [DropdownController::class, 'fetchCity']);
    Route::get('/certification', [WebsiteController::class, 'certification'])->name('certification');




    // Website News Route End ============================


    //Website Coworking Space Routes Start  ============================

    Route::resource('/coworking', CoworkingSpaceController::class);

    //Website Coworking Space Routes End  ============================

    //Website Blog Routes Start  ============================
    Route::middleware(['auth', 'role:Super Admin'])->group(function () {
        Route::get('/website/admin/create_blog', [WebsiteBlogController::class, 'create'])->name('blog.create');
        Route::post('/website/admin/save_blog', [WebsiteBlogController::class, 'store'])->name('blog.store');
        Route::post('/website/admin/upload', [WebsiteBlogController::class, 'uploadimage'])->name('ckeditor.upload');
        Route::get('/website/admin/blog/update/{id}', [WebsiteBlogController::class, 'edit'])->name('blog.edit');
        Route::post('/website/admin/blog/update', [WebsiteBlogController::class, 'update'])->name('blog.update');
        Route::get('/website/admin/blog/destory/{id}', [WebsiteBlogController::class, 'destory'])->name('blog.destory');

        //blog category manage 
        Route::get('/website/admin/category', [WebsiteBlogController::class, 'index_cat'])->name('category.list');
        Route::get('/website/admin/blog/categoryadd', [WebsiteBlogController::class, 'categoryadd'])->name('blogcategory.add');
        Route::post('/website/admin/create_category', [WebsiteBlogController::class, 'create_category'])->name('category.store');
        Route::get('/website/admin/blogcategory/update/{id}', [WebsiteBlogController::class, 'edit_cat'])->name('blogcategory.edit');
        Route::post('/website/admin/blogcategory/update', [WebsiteBlogController::class, 'update_cat'])->name('blogcategory.update');
        Route::get('/website/admin/blogcategory/destory/{id}', [WebsiteBlogController::class, 'destory_cat'])->name('blogcatory.destory');
        // Website  Gallery Route Start ==========================
        Route::get('/website/admin/gallery', [GalleryController::class, 'index'])->name('website.gallery');
        Route::get('/website/admin/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
        Route::post('/website/admin/gallery/store', [GalleryController::class, 'store'])->name('gallery.store');
        Route::get('/website/admin/gallery/edit/{id}', [GalleryController::class, 'edit'])->name('gallery.edit');
        Route::post('/website/admin/gallery/update', [GalleryController::class, 'update'])->name('gallery.update');
        Route::get('/website/admin/gallery/destory/{id}', [GalleryController::class, 'destory'])->name('gallery.destory');
        // Website  Gallery Route End ==========================
        Route::get('/website/admin/gallerytags/create', [GalleryTagsController::class, 'create'])->name('website.gallerytags');
        Route::post('/website/admin/gallerytags/store', [GalleryTagsController::class, 'store'])->name('gallerytags.store');
        Route::get('/website/admin/gallerytags/edit/{id}', [GalleryTagsController::class, 'edit'])->name('gallerytags.edit');
        Route::post('/website/admin/gallerytags/update', [GalleryTagsController::class, 'update'])->name('gallerytags.update');
        Route::get('/website/admin/gallery/open/{id}', [GalleryController::class, 'open'])->name('gallery.open');
        Route::delete('/delete-image/{id}/{key}', [GalleryController::class, 'deleteImage'])->name('delete.image');
        Route::post('/add-image/{id}', [GalleryController::class, 'addImage'])->name('add.image');


        // Website  Event Route Start ==========================
        Route::get('/website/admin/event', [EventController::class, 'index'])->name('website.event');
        Route::get('/website/admin/event/create', [EventController::class, 'create'])->name('event.create');
        Route::post('/website/admin/event/store', [EventController::class, 'store'])->name('event.store');
        Route::get('/website/admin/event/edit/{id}', [EventController::class, 'edit'])->name('event.edit');
        Route::post('/website/admin/event/update', [EventController::class, 'update'])->name('event.update');
        Route::get('/website/admin/event/destory/{id}', [EventController::class, 'destory'])->name('event.destory');
        // Website  Event Route End ==========================
        // Website  Partner Route Start ==========================
        Route::post('/website/partner', [PartnerController::class, 'store'])->name('partner.store');
        Route::get('/website/partner/show', [PartnerController::class, 'show'])->name('partner.show');
        // Website  Partner Route End ==========================

        // Website  Latest New & Update Route Start ==========================
        Route::post('/website/latest-news', [NewsUpdateController::class, 'store'])->name('update.store');
        Route::get('/website/latest-news/show', [NewsUpdateController::class, 'show'])->name('update.show');
        // Website  Latest New & Update Route End ==========================

        Route::get('/web-batch', [WebBatchController::class, 'index'])->name('webBatch');
        Route::get('/add-web-batch', [WebBatchController::class, 'addWebBatch'])->name('addWebBatch');
        Route::post('/store-web-batch', [WebBatchController::class, 'storeWebBatch'])->name('storeWebBatch');
        Route::get('/edit-web-batch/{id}', [WebBatchController::class, 'editWebBatch'])->name('editWebBatch');
        Route::post('/update-web-batch', [WebBatchController::class, 'updateWebBatch'])->name('updateWebBatch');
        Route::get('/delete-web-batch/{id}', [WebBatchController::class, 'deleteWebBatch'])->name('deleteWebBatch');
        Route::resource("faqs", FAQController::class);
        Route::resource('curriculum', CurriculamController::class);
        // Website  Latest Contect Us Route Start ==========================
        Route::post('/website/contect-us/store', [ContectUsController::class, 'contectStore'])->name('contectStore');
        Route::get('/website/contect-us/index', [ContectUsController::class, 'contectindex'])->name('contectindex');
        Route::post('job-placement', [JobPlacementController::class, 'store'])->name('store.job-placement');
        Route::post('study-abroad', [StudyAbroadController::class, 'store'])->name('store.study-abroad');
        Route::post('shared-workspace', [SharworkSpaceController::class, 'store'])->name('store.shared-workspace');
        Route::post('/book-tour', [TourController::class, 'store'])->name('store.tour');
        Route::post('ambassador-program', [AmbassadorController::class, 'store'])->name('store.ambassador');
        Route::get('/create-lead', [LeadController::class, 'index'])->name('leadcreate');
        Route::post('/create-lead', [LeadController::class, 'save'])->name('savelead');
        Route::get('/all-leads', [LeadController::class, 'allleads'])->name('allleads');
        Route::get('/pipeline-leads', [LeadController::class, 'pipelineenquiry'])->name('pipeline-enquiry');
        Route::get('/today-follow-ups', [LeadController::class, 'followUp'])->name('todayfollowUp');
        Route::get('/pending-follow-ups', [LeadController::class, 'pendingfollowups'])->name('pendingfollowups');
        Route::get('/successfully-enrolled', [LeadController::class, 'successfullyEnrolled'])->name('successfullyEnrolledleadss');
        //routes for limit management
        Route::get('/add-discount', [LimitController::class, 'create'])->name('limit.create');
        Route::post('/add-new-discount', [LimitController::class, 'store'])->name('limit.store');
        Route::get('/edit-discount', [LimitController::class, 'edit'])->name('limit.edit');
        Route::post('/update-discount', [LimitController::class, 'update'])->name('limit.update');
        // Route::get('/edit-limit',)

        // Api routes
        Route::post('/check-user-exists', [LimitController::class, 'checkuserexists'])->name('checkuserexists');
        Route::post('/get-disocunt-percentage', [LimitController::class, 'getDiscountPercentage'])->name('getDiscountPercentage');
        // Website News Route Start ============================
        Route::get('/website/admin/news', [WebsiteAnnouncementController::class, 'index'])->name('website.news');
        Route::get('/website/admin/news/create', [WebsiteAnnouncementController::class, 'create'])->name('news.create');
        Route::post('/website/admin/news/store', [WebsiteAnnouncementController::class, 'store'])->name('news.store');
        Route::get('/website/admin/news/create/{id}', [WebsiteAnnouncementController::class, 'edit'])->name('news.edit');
        Route::post('/website/admin/news/update', [WebsiteAnnouncementController::class, 'update'])->name('news.update');
        Route::get('/website/admin/news/destory/{id}', [WebsiteAnnouncementController::class, 'destory'])->name('news.destory');
        // WebsiteAdmin route start ======================================

        Route::get('/website/dashboard', [WebsiteAdminController::class, 'websiteDashboard'])->name('websiteDashboard');
        Route::get('/website/admin', [WebsiteAdminController::class, 'index'])->name('websiteadmincourse');
        Route::get('/website/admin/course-add', [WebsiteAdminController::class, 'crete'])->name('addcourse');
        Route::post('/website/admin/store', [WebsiteAdminController::class, 'srote'])->name('storecourse');
        Route::get('/website/admin/edit/{id}', [WebsiteAdminController::class, 'edit'])->name('editcourse');
        Route::post('/website/admin/update', [WebsiteAdminController::class, 'update'])->name('updatecourse');
        Route::get('/website/admin/destory/{id}', [WebsiteAdminController::class, 'destroy'])->name('destorycourse');
        Route::resource('/coursecategory', CourseCategoryController::class);
        // certificate management
        Route::get('certificate/pending-for-approval', [CertificateController::class, 'pendingForApproval'])->name('pendingForApproval');
        Route::get('certificate/approve/{id}', [CertificateController::class, 'certificateApprove'])->name('certificateApprove');
        Route::get('certificate/on-printing', [CertificateController::class, 'onPrinting'])->name('onPrinting');
        Route::get('certificate/print/{id}', [CertificateController::class, 'certificatePrint'])->name('certificatePrint');
        Route::get('printed/{id}', [CertificateController::class, 'printed'])->name('printed');
        Route::get('certificate/ready', [CertificateController::class, 'certificateReady'])->name('certificateReady');
        Route::post('certificate/collected-by', [CertificateController::class, 'certificateCollectedBy'])->name('certificateCollectedBy');
        Route::get('certificate/delivered', [CertificateController::class, 'certificateDelivered'])->name('certificateDelivered');
        Route::get('certificate/request/{id}', [CertificateController::class, 'certificateRequest'])->name('certificateRequest');
        Route::get('certificate/reprinting', [CertificateController::class, 'certificateReprinting'])->name('certificateReprinting');
        Route::post('certificate/reprinting/request', [CertificateController::class, 'certificateReprintingRequest'])->name('certificateReprintingRequest');
        Route::get('certificate/reprinting/approve/{id}', [CertificateController::class, 'certificateReprintingApprove'])->name('certificateReprintingApprove');
        Route::get('certificate/reprinting/printing/{id}', [CertificateController::class, 'certificateReprintingPrinting'])->name('certificateReprintingPrinting');
        Route::post('certificate/reprinting/collected', [CertificateController::class, 'certificateReprintingCollected'])->name('certificateReprintingCollected');
        Route::get('certificate/download-pdf/{id}', [CertificateController::class, 'certificatedownloadpdf'])->name('certificatedownloadpdf');
        Route::get('certificate/email/{id}', [CertificateController::class, 'certificateemail'])->name('certificateemail');
        Route::get('certificate/reprinting/cnic', [CertificateController::class, 'certificateReprintingCinc'])->name('certificateReprintingCinc');
        Route::get('certificate/reprinting/roll-number', [CertificateController::class, 'certificateReprintingRollNumber'])->name('certificateReprintingRollNumber');

    });
    Route::get('/website/admin/blog', [WebsiteBlogController::class, 'index'])->name('website.blog')->middleware('role:Super Admin');
    // Job Placement Route Start=================
    Route::get('show-job-placement', [JobPlacementController::class, 'index'])->name('index.job-placement')->middleware('auth');
    // Job Placement Route End=================
    Route::get('show-study-abroad', [StudyAbroadController::class, 'index'])->name('index.study-abroad')->middleware('auth');
    // Study Abrad Route End======================
    Route::get('show/shared-workspace', [SharworkSpaceController::class, 'index'])->name('show.shared-workspace')->middleware('auth');
    // Share Workspace Route End ============
    Route::get('show/book-tour', [TourController::class, 'index'])->name('index.tour')->middleware('auth');
    Route::get('show/ambassador-tour', [AmbassadorController::class, 'index'])->name('index.ambassador')->middleware('auth');
    // new portal round





});

Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    return "Optimize Cleared";
});

// portal routes end ================================================

Route::get('/storage-clear', function () {
    Artisan::call('storage:link');
    return "Storage Linked";
});
Route::get('/cache', function () {
    Artisan::call('cache:clear');
    return "Cache Cleared";
});
Route::get('/route-clear', function () {
    Artisan::call('route:clear');
    return "Route Cached";
});

Route::any('{query}', function () {
    return redirect('/');
})->where('query', '.*');
