<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\user\homecontroller;
use App\Http\Controllers\admin\admincontroller;
use App\Http\Controllers\admin\universitycontroller;
use App\Http\Controllers\admin\collegecontroller;
use App\Http\Controllers\user\usercontroller;
use App\Http\Controllers\admin\clientcontroller;
use App\Http\Controllers\admin\privilegescontroller;
use App\Http\Controllers\admin\approvedcontroller;
use App\Http\Controllers\admin\datahistorycontrollet;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\user\programcontroller;
use App\Http\Controllers\aboutcontroller;
use App\Http\Controllers\facilitycontroller;
use App\Http\Controllers\bordcontroller;
use App\Http\Controllers\coursecontroller;
use App\Http\Controllers\deletecontroller;
use App\Http\Controllers\articlecontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserTypeMiddleware;


Route::controller(homecontroller::class)->group(function(){
    Route::match(['get', 'post'], 'get-event-data', 'geteventdatabycollege')->name('get-event-data');
    Route::match(['get', 'post'], 'get-bord-data', 'getbordofdatacollege')->name('get-bord-data');
    Route::match(['get', 'post'], 'get-all-progmas', 'allprgmrsbyajax')->name('get-all-progmas');
    Route::match(['get', 'post'], 'add-counsilling', 'addcounsilling')->name('add-counsilling');
    Route::match(['get', 'post'], 'view-all-news', 'viewallnews')->name('get-all-news');
    Route::match(['get', 'post'], 'news-list_daata', 'news_list_daata')->name('news-list_daata');
    Route::match(['get', 'post'], 'top-college-ajax', 'TopCollegeajax')->name('top-college-ajax');
    Route::match(['get', 'post'], 'get-allTop-collge', 'getallTopcollege')->name('get-allTop-collge');
    Route::match(['get', 'post'], 'get-allTop-collgeStatewise', 'getallTopcollegeStateWise')->name('get-allTop-collgeStatewise');
    Route::match(['get', 'post'], 'view-course-stream-header', 'getallTopcollegeStateWisehedaer')->name('view-course-stream-header');

    
    Route::match(['get', 'post'], 'top-city', 'gettopcity')->name('get-top-city');
    Route::match(['get', 'post'], 'view-course-stream-search', 'getstreamcourse')->name('view-course-stream-search');
    Route::match(['get', 'post'], 'all-city', 'getallcity')->name('get-all-city');
    Route::match(['get', 'post'], 'view-list', 'gettopcitybyid')->name('city-top-get');
    Route::match(['get', 'post'], 'view-details', 'viewdetailsgetdata')->name('view-details');
    Route::match(['get', 'post'], 'view/college/search', 'viewdetailsgeturl')->name('view-college-search');
    // Route::match(['get', 'post'], 'view/college/search/get', 'viewdetailsgeturlget')->name('view-college-searchdata');
    Route::match(['get', 'post'], 'view/college/load/filter', 'getfilterload')->name('get-filter-search');
    Route::match(['get', 'post'], 'view/state/load/filter', 'statefilterload')->name('state-filter-search');
    Route::match(['get', 'post'], 'view/course/load/filter', 'coursefilterload')->name('course-filter-search');

    // details //////////////////////////
    Route::match(['get', 'post'], 'get-view-details', 'viewdetailsgetbyid')->name('get-view-details');
    Route::match(['get', 'post'], 'get-facility-data/a', 'faciltydataget')->name('get-facility-data');
    Route::match(['get', 'post'], 'get-facility-data-trans/f', 'faciltydatagettrans')->name('get-facility-data-trans');
    Route::match(['get', 'post'], 'get-tbl-data/a', 'tbldata')->name('get-tbl-data');
    Route::match(['get', 'post'], 'get-accreditationsdata-data/b', 'accreditationsdata')->name('get-accreditations-data');
    Route::match(['get', 'post'], 'get-Recognition-data/b', 'Recognitiondata')->name('get-Recognition-data');
    // Route::match(['get', 'post'], 'get-Recognition-data/b', 'Recognitiondata')->name('view-college-searchbystate');live-search

    Route::match(['get', 'post'], 'live-search', 'livesearchrecord')->name('live-search');

    Route::match(['get', 'post'], 'get-program-level', 'getprogramlavel')->name('get-program-level');
    Route::match(['get', 'post'], 'view-lavel-search', 'getlavelsearch')->name('view-lavel-search');
    Route::match(['get', 'post'], 'view-state-search', 'getstatesearch')->name('view-state-search');
    Route::match(['get', 'post'], 'get-course-type', 'coursetypedata')->name('get-course-type');
    Route::match(['get', 'post'], 'get-stream-type', 'getstreamtype')->name('get-stream-type');
    Route::match(['get', 'post'], 'view-course-fill-search', 'coursefilterdatasearch')->name('view-course-fill-search');
    Route::match(['get', 'post'], 'view-course-search', 'viewcoursetypeajax')->name('view-course-search');
    Route::match(['get', 'post'], 'get-footer-college', 'getfootertopcollege')->name('get-footer-college');
    Route::match(['get', 'post'], 'get-footer-universiry', 'getfooteruniversity')->name('get-footer-universiry');

});

    Route::controller(articlecontroller::class)->group(function(){
        Route::match(['get', 'post'], 'add-articles', 'addArticles')->name('add-articles');
        Route::match(['get', 'post'], 'articles-view', 'articlesview')->name('articles-view');
        Route::match(['get', 'post'], 'delete-articles', 'deletearticles')->name('delete-articles');
        Route::match(['get', 'post'], 'edit-articles', 'updatearticles')->name('edit-articles');
        Route::match(['get', 'post'], 'update-articles', 'updatearticlesdata')->name('update-articles');
        Route::match(['get', 'post'], 'artical-top-data', 'articaltopdata')->name('artical-top-data');
        Route::match(['get', 'post'], 'artical-get-data', 'articlegetdatabyid')->name('get-article-data');
        Route::match(['get', 'post'], 'artical-list-view', 'artcleslistdata')->name('article-list');
        Route::match(['get', 'post'], 'artical/list-view', 'listarticle')->name('article-list_daata');

        // news //////////
        Route::match(['get', 'post'], 'add-news', 'addnews')->name('add-news');
        Route::match(['get', 'post'], 'news-view', 'newsview')->name('news-view');
        Route::match(['get', 'post'], 'news-delete', 'deletenews')->name('delete-news');
        Route::match(['get', 'post'], 'edit-news', 'editnews')->name('edit-news');
        Route::match(['get', 'post'], 'update-news', 'updatenews')->name('update-news');
        Route::match(['get', 'post'], 'get-news-data', 'getnewsdata')->name('get-news-data');
        Route::match(['get', 'post'], 'news/details', 'getnewssingle')->name('news-single-data');
        Route::match(['get', 'post'], 'get-news-getbyid', 'getnewsgetbyId')->name('get-news-getbyid');

    });

Route::controller(logincontroller::class)->group(function(){
    //   Route::get('login' , 'login')->name('login');
      Route::match(['get', 'post'], 'login', 'login')->name('login');
      Route::get('forgot/password' , 'forgotpassword')->name('forgotpassword');
        Route::match(['get', 'post'], 'admin/someMethod', 'someMethod')->name('someMethod');
          Route::match(['get', 'post'], 'admin/login-report', 'loginReport')->name('loginReport');
          Route::match(['get', 'post'], 'change-update-image', 'changeUpdate')->name('change-update-image');
          
});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(deletecontroller::class)->group(function(){

        Route::match(['get', 'post'], 'admin/about/reject', 'aboutreject')->name('about-delete-reject');
        Route::match(['get', 'post'], 'admin/about/delete', 'aboutdeletedata')->name('about-data-delete');

        Route::match(['get', 'post'], 'admin/gallery/delete/approve', 'gallerydeltedata')->name('delete-gallery-approved');
        Route::match(['get', 'post'], 'admin/gallery/approve/delete', 'gallerydeltedataajax')->name('approved-delete-gallery');
        Route::match(['get', 'post'], 'admin/gallery/approve/data/delete', 'gallerydataajaxdelete')->name('gallery-data-delete');
        Route::match(['get', 'post'], 'admin/gallery/approve/data/reject', 'gallerydataajaxreject')->name('gallery-delete-reject');

        Route::match(['get', 'post'], 'admin/facility/delete/approve', 'facilitydeleteapprovel')->name('delete-facility-approved');
        Route::match(['get', 'post'], 'admin/facility/view/approve', 'facilitydeleteapprovelview')->name('approved-delete-facility');
        Route::match(['get', 'post'], 'admin/facility/delete/approve/data', 'facilitydeleteapproveldelete')->name('facility-data-delete');
        Route::match(['get', 'post'], 'admin/facility/reject/approve', 'facilitydeleteapprovelreject')->name('facility-delete-reject');

        Route::match(['get', 'post'], 'admin/course/delete/approve', 'coursedeleteapprovel')->name('delete-course-approved');
        Route::match(['get', 'post'], 'admin/course/view/approve', 'coursedeleteapprovelview')->name('approved-delete-course');
        Route::match(['get', 'post'], 'admin/course/delete/approve/a', 'coursedeleteapproveldelete')->name('courses-data-delete');
        Route::match(['get', 'post'], 'admin/course/reject/approve/a', 'coursedeleteapprovelreject')->name('courses-delete-reject');

        Route::match(['get', 'post'], 'admin/events/delete/approve', 'eventsdeleteapprovel')->name('delete-events-approved');
        Route::match(['get', 'post'], 'admin/events/view/approve', 'eventsdeleteapprovelview')->name('approved-delete-events');
        Route::match(['get', 'post'], 'admin/events/view/reject', 'eventsdeleteapprovelreject')->name('events-delete-reject');
        Route::match(['get', 'post'], 'admin/events/view/delete', 'eventsdeleteapproveldelete')->name('events-data-delete');

        Route::match(['get', 'post'], 'admin/admission/delete/approve', 'admissiondeleteapprovel')->name('delete-admission-approved');
        Route::match(['get', 'post'], 'admin/admission/view/approve', 'admissiondeleteapprovelview')->name('approved-delete-admission');
        Route::match(['get', 'post'], 'admin/admission/view/approve/delete', 'admissiondeleteapproveldata')->name('admission-data-delete');
        Route::match(['get', 'post'], 'admin/admission/view/approve/reject', 'admissiondeleteapprovelreject')->name('admission-delete-reject');
       
        Route::match(['get', 'post'], 'admin/tbl/delete/approve', 'tbldeleteapprovel')->name('delete-tbl-approved');
        Route::match(['get', 'post'], 'admin/tbl/view/approve', 'tbldeleteapprovelview')->name('approved-delete-tbl');
        Route::match(['get', 'post'], 'admin/tbl/view/approve/delete', 'tbldeleteapproveldata')->name('tbl-data-delete');
        Route::match(['get', 'post'], 'admin/tbl/view/approve/reject', 'tbldeleteapprovelreject')->name('tbl-delete-reject');
    
        Route::match(['get', 'post'], 'admin/accreditations/delete/approve', 'accreditationsdeleteapprovel')->name('delete-accreditations');
        Route::match(['get', 'post'], 'admin/accreditations/view/approve', 'accreditationsdeleteapprovelview')->name('approved-delete-accreditations');
        Route::match(['get', 'post'], 'admin/accreditations/view/reject', 'accreditationsdeleteapprovelreject')->name('accreditations-delete-reject');
        Route::match(['get', 'post'], 'admin/accreditations/view/delete', 'accreditationsdeleteapproveldata')->name('accreditations-data-delete');

    });

    Route::controller(datahistorycontrollet::class)->group(function(){

        Route::match(['get', 'post'], 'admin/history/view', 'history')->name('history');
        Route::match(['get', 'post'], 'admin/history/user/view', 'historyview')->name('history-view');

        Route::match(['get', 'post'], 'admin/history', 'adminhistory')->name('admin-history');
        Route::match(['get', 'post'], 'admin/history/admin/view', 'adminhistoryview')->name('admin-history-view');

      
        Route::match(['get', 'post'], 'admin/history/content', 'userhistpryview')->name('history-edit-view');
        Route::match(['get', 'post'], 'admin/history/content/view', 'adminhistpryview')->name('adminhistory-edit-view');
        
    });


    Route::controller(privilegescontroller::class)->group(function(){

        Route::match(['get', 'post'], 'admin/Privilege', 'Privilege')->name('privilege');
        Route::match(['get', 'post'], 'admin/Privilege/view', 'Privilegeview')->name('privilege-view');
        Route::match(['get', 'post'], 'admin/getUserPrivilegePermission', 'getUserPrivilegePermission')->name('getUserPrivilegePermission');
        Route::match(['get', 'post'], 'admin/handleprivilege', 'handleprivilege')->name('handleprivilege');
        Route::match(['get', 'post'], 'admin/createUserPrivilege', 'createUserPrivilege')->name('createUserPrivilege');
        Route::match(['get', 'post'], 'admin/getUserPrivilegeById', 'getUserPrivilegeById')->name('getUserPrivilegeById');
        Route::match(['get', 'post'], 'admin/exceptionpPivilegeHandling', 'exceptionpPivilegeHandling')->name('exceptionpPivilegeHandling');
        // Route::match(['get', 'post'], 'admin/rolesave', 'rolesave')->name('role-master-save');

    });

    Route::controller(approvedcontroller::class)->group(function(){

    Route::match(['get', 'post'], 'admin/approved/bord', 'Approvedbord')->name('bord-approved');
    Route::match(['get', 'post'], 'admin/approved/bord/view', 'bordapproved')->name('approved-bord');
    Route::match(['get', 'post'], 'admin/approved/bord/change.status', 'bordapprovedchange')->name('change-bord-status');
        
    Route::match(['get', 'post'], 'admin/approved/delete', 'Approvedaboutdelete')->name('delete-about-approved');
    Route::match(['get', 'post'], 'admin/approved/delete/view', 'Approvedaboutrecord')->name('approved-delete-about');
    
    Route::match(['get', 'post'], 'admin/approved', 'Approved')->name('Approved');
    Route::match(['get', 'post'], 'admin/approved/about/list', 'Approvedlist')->name('approved-view');
    Route::match(['get', 'post'], 'admin/approved/about/data', 'getaboutbydatabyid')->name('get-about-data-byid');
    Route::match(['get', 'post'], 'admin/approved/about/update', 'approvedaboutupdate')->name('approved-about-update');
    Route::match(['get', 'post'], 'admin/approved/about/change/status', 'aboutchangestatus')->name('change-about-status');

    ///////////////////// facility approved /////////
    Route::match(['get', 'post'], 'admin/approved/facility', 'facilityapproved')->name('facility-approved');
    Route::match(['get', 'post'], 'admin/approved/facility/view', 'facilityapprovedview')->name('approved-facility-view');
    Route::match(['get', 'post'], 'admin/approved/facility/data', 'getfacilitydatabyid')->name('get-facility-data-byid');
    Route::match(['get', 'post'], 'admin/approved/facility/update', 'facilitychangestatus')->name('change-facility-status'); //toogle
    Route::match(['get', 'post'], 'admin/approved/facility/change/status', 'approvedfacilityupdate')->name('approved-facility-update');
    
    //////////////////////// course approve /////////////////// course-approved
    Route::match(['get', 'post'], 'admin/approved/course', 'courseapproved')->name('course-approved');
    Route::match(['get', 'post'], 'admin/approved/course/view', 'courseapprovedview')->name('approved-course-view');
    Route::match(['get', 'post'], 'admin/approved/course/data', 'courseapprovedgetbyid')->name('get-courses-data-byid');
    Route::match(['get', 'post'], 'admin/approved/course/update', 'courseschangestatus')->name('change-courses-status');
    Route::match(['get', 'post'], 'admin/approved/course/change/status', 'approvedcoursesupdate')->name('approved-courses-update');

    /////////////////////////////  events-approved /////////////////
    Route::match(['get', 'post'], 'admin/approved/events', 'eventsapproved')->name('events-approved');
    Route::match(['get', 'post'], 'admin/approved/events/view', 'eventsapprovedview')->name('approved-events-view');
    Route::match(['get', 'post'], 'admin/approved/events/data', 'eventsapprovedgetdatabyid')->name('get-events-data-byid');
    Route::match(['get', 'post'], 'admin/approved/events/update', 'eventschangestatus')->name('change-events-status');
    Route::match(['get', 'post'], 'admin/approved/events/change/status', 'approvedevntsupdate')->name('approved-events-update');

    ////////////////////////////////   admission-approved ///////////////////
    Route::match(['get', 'post'], 'admin/approved/admission', 'admissionapproved')->name('admission-approved');
    Route::match(['get', 'post'], 'admin/approved/admission/view', 'admissionapprovedview')->name('admission-approved-view');
    Route::match(['get', 'post'], 'admin/approved/admission/data', 'admissionapprovedgetdatabyid')->name('get-admission-data-byid');
    Route::match(['get', 'post'], 'admin/approved/admission/update', 'admissionchangestatus')->name('change-admission-status');
    Route::match(['get', 'post'], 'admin/approved/admission/change/status', 'approvedadmissionupdate')->name('approved-admission-update');

    /////////////////////////      tbl-approved ///////////
    Route::match(['get', 'post'], 'admin/approved/tbl/placement', 'tblapproved')->name('tbl-approved');
    Route::match(['get', 'post'], 'admin/approved/tbl/placement/view', 'tblapprovedview')->name('tbl-approved-view');
    Route::match(['get', 'post'], 'admin/approved/tbl/placement/data', 'tblapprovedgetdatabyid')->name('get-tbl-data-byid');
    Route::match(['get', 'post'], 'admin/approved/tbl/placement/update', 'tblchangestatus')->name('change-tbl-status');
    Route::match(['get', 'post'], 'admin/approved/tbl/placement/change/status', 'approvedtblupdate')->name('approved-tbl-update');

    /////////////////////////////////    accreditations-approved //////////////////////
    Route::match(['get', 'post'], 'admin/approved/accreditations', 'accreditationsapproved')->name('accreditations-approved');
    Route::match(['get', 'post'], 'admin/approved/accreditations/view', 'accreditationsapprovedview')->name('accreditation-approved-view');
    Route::match(['get', 'post'], 'admin/approved/accreditations/data', 'accreditationsapproveddetdata')->name('get-accreditation-data-byid');
    Route::match(['get', 'post'], 'admin/approved/accreditations/update', 'accreditationchangestatus')->name('change-accreditation-status');
    Route::match(['get', 'post'], 'admin/approved/accreditations/change/status', 'approvedaccreditationupdate')->name('approved-accreditation-update');


    /////////////////////////////////    accreditations-approved //////////////////////
    Route::match(['get', 'post'], 'admin/approved/recognitions', 'recognitionsapproved')->name('recognitions-approved');
    Route::match(['get', 'post'], 'admin/approved/recognitions/view', 'recognitionsapprovedview')->name('recognitions-approved-view');
    Route::match(['get', 'post'], 'admin/approved/recognitions/data', 'recognitionsapprovedGETDATA')->name('get-recognitions-data-byid');
    Route::match(['get', 'post'], 'admin/approved/recognitions/update', 'recognitionschangestatus')->name('change-recognitions-status');
    Route::match(['get', 'post'], 'admin/approved/recognitions/change/status', 'approvedrecognitionsupdate')->name('approved-recognitions-update');

    });
    Route::controller(admincontroller::class)->group(function(){
        
        Route::match(['get' , 'post'],'/admin' , 'admin')->name('admin_index');
        Route::match(['get' , 'post'],'/admin/contact/info' , 'contact')->name('contact');
        Route::match(['get' , 'post'],'/admin/top-exam' , 'Topeaxm')->name('top-exam');
        Route::match(['get' , 'post'],'/admin/articles' , 'articles')->name('articles');
        Route::match(['get' , 'post'],'/admin/news' , 'news')->name('news');
        Route::match(['get' , 'post'],'admin/profile' , 'profile')->name('profile');
        Route::match(['get' , 'post'],'admin/university' , 'university')->name('university');
        Route::match(['get' , 'post'],'admin/college' , 'college')->name('college');
        Route::match(['get' , 'post'],  'admin/user' , 'user')->name('user');
        
        Route::match(['get', 'post'], 'admin/login-report-view', 'loginReportview')->name('loginReport-view');
        Route::match(['get', 'post'], 'admin/login-report-list', 'loginReportlist')->name('loginReport-list');
        Route::match(['get', 'post'], 'admin/city-change-status', 'citychangestatus')->name('change-city-status');

        // country state
        Route::match(['get' , 'post'],'admin/contact-get-data' , 'contactgetdata')->name('contact-get-data');
        Route::match(['get' , 'post'],'admin/contact-getbyid' , 'contactgetbyid')->name('contact-getbyid');


        Route::match(['get' , 'post'],'admin/country' , 'country')->name('country');
        Route::match(['get' , 'post'],'admin/country/view' , 'country_data')->name('country_data');
        Route::match(['get' , 'post'],'admin/country/delete' , 'country_delete')->name('country-delete');
        Route::match(['get' , 'post'],'admin/country/edit' , 'country_edit')->name('country-edit');
        Route::match(['get' , 'post'],'admin/country/update' , 'country_update')->name('country-update');
        Route::match(['get' , 'post'],'admin/addcountry' , 'addcountry')->name('addcountry');
        Route::match(['get' , 'post'],'admin/city' , 'city')->name('city');
        Route::match(['get' , 'post'],'admin/city_data' , 'city_data')->name('city_data');
        Route::match(['get' , 'post'],'admin/city/add' , 'cityadd')->name('city-add');
        Route::match(['get' , 'post'],'admin/city/delete' , 'citydelete')->name('city-delete');
        Route::match(['get' , 'post'],'admin/city/edit' , 'cityedit')->name('city-edit');
        Route::match(['get' , 'post'],'admin/city/update' , 'cityupdate')->name('city-update');

        // test route start
        Route::match(['get' , 'post'],'admin/email' , 'email')->name('test-email');
        // test route end

        //  program 
         Route::match(['get' , 'post'],'admin/program' ,'program')->name('program');
         Route::match(['get' , 'post'],'admin/program/view' ,'programview')->name('program-view');
         Route::match(['get' , 'post'],'admin/program/add' ,'addprogram')->name('add-program');
         Route::match(['get' , 'post'],'admin/program/delete' ,'deleteprogram')->name('delete-program');
         Route::match(['get' , 'post'],'admin/program/edit' ,'editprogram')->name('edit-program');
         Route::match(['get' , 'post'],'admin/program/update' ,'updateprogram')->name('update-program');
        // endprogram

        // state start
        Route::match(['get' , 'post'],'admin/state' , 'state')->name('state');
        Route::match(['get' , 'post'],'admin/state/view' , 'state_data')->name('state_data');
        Route::match(['get' , 'post'],'admin/state/delete' , 'state_delete')->name('state-delete');
        Route::match(['get' , 'post'],'admin/state/edit' , 'state_edit')->name('state-edit');
        Route::match(['get' , 'post'],'admin/state/update' , 'state_update')->name('state-update');
        Route::match(['get' , 'post'],'admin/addstate' , 'addstate')->name('addstate');

        // state end
    });

    Route::controller(universitycontroller::class)->group(function(){
        Route::match(['get' , 'post'],'admin/university/add' , 'universityadd')->name('university-add');
        Route::match(['get', 'post'], 'admin/university/change/top/status', 'universitytopstatus')->name('university-status-change');
        Route::match(['get' , 'post'],'admin/university/data' , 'universitydata')->name('university-data');
        Route::match(['get' , 'post'],'admin/university/delete' , 'universitydelete')->name('university-delete');
        Route::match(['get' , 'post'],'admin/university/edit' , 'universityedit')->name('university-edit');
        Route::match(['get' , 'post'],'admin/university/update' , 'universityupdate')->name('university-update');
        Route::match(['get' , 'post'],'admin/university/getstate-bycountry-id' , 'getstate')->name('getstate-bycountry-id');
        Route::match(['get' , 'post'],'admin/university/getcity-bystate-id' , 'getcity')->name('getcity-bystate-id');
    });

    

    Route::controller(collegecontroller::class)->group(function(){
        Route::post('admin/college/add' , 'collegeadd')->name('college-add');
        Route::get('admin/college/view' , 'college_view')->name('college-view');
        Route::get('admin/college/delete' , 'college_delete')->name('college-delete');
        // Route::get('admin/college/list' , 'college_list')->name('college-list');
        Route::match(['get', 'post'], 'admin/college/list', 'college_list')->name('college-list');
        Route::match(['get', 'post'], 'admin/college-top-status', 'college_topstatus')->name('college-top-status');
        Route::match(['get' , 'post'],'admin/college/edit' , 'collegeedit')->name('college-edit');
        Route::match(['get' , 'post'],'admin/college/update' , 'collegeupdate')->name('college-update');
        Route::match(['get' , 'post'],'admin/college/getstate-byuniversity-id' , 'getuniversityid')->name('getstate-byuniversity-id');

        Route::match(['get', 'post'], 'admin/facility', 'facilityajax')->name('view-facility');
        Route::match(['get', 'post'], 'admin/facility/list', 'facilityajaxlist')->name('list-facility');
        Route::match(['get', 'post'], 'admin/facility/add', 'facilityajaxadd')->name('add-facility');
        Route::match(['get', 'post'], 'admin/facility/edit', 'facilityajaxedit')->name('facility-edit');
        Route::match(['get', 'post'], 'admin/facility/delete', 'facilityajaxdelete')->name('facility-delete');
        Route::match(['get', 'post'], 'admin/facility/update', 'facilityajaxupdate')->name('facility-update');
    });

    Route::controller(clientcontroller::class)->group(function(){

        Route::match(['get' , 'post'],'admin/user/destails', 'userlist')->name('user-list');
        Route::match(['get' , 'post'],'admin/user/create', 'usercreate')->name('user-create');
        Route::match(['get' , 'post'],'admin/user/delete', 'userdelete')->name('user-delete');
        Route::match(['get' , 'post'],'admin/user/edit', 'useredit')->name('user-edit');
        Route::match(['get' , 'post'],'admin/user/get-byuniversity-id', 'universityid')->name('get-byuniversity-id');
        Route::match(['get' , 'post'],'admin/user/get-bycollege-id', 'collegeid')->name('get-bycollege-id');
        Route::match(['get' , 'post'],'admin/user/getcollege-byuni-id', 'getcollegebyuniid')->name('getcollege-byuni-id');
        Route::match(['get' , 'post'],'admin/user/user-update', 'userupdate')->name('user-update');
        Route::match(['get' , 'post'],'admin/change-password', 'changepassword')->name('change-password');
        Route::match(['get' , 'post'],'admin/update-password', 'update_password')->name('update-password');

        Route::match(['get', 'post'], 'admin/user/view/list', 'viewdata')->name('view-data');
        Route::match(['get', 'post'], 'admin/user/view/address', 'viewaddress')->name('view-address');
        Route::match(['get', 'post'], 'admin/user/view/college', 'viewcollege')->name('view-college');
        Route::match(['get', 'post'], 'admin/user/change/status', 'changestatus')->name('change-status');
        Route::match(['get', 'post'], 'admin/user/all/details', 'viewall')->name('view-all');
    });

});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'user'])->group(function () {
   
    Route::controller(usercontroller::class)->group(function(){
        Route::match(['get' , 'post'],'/user' , 'user_index')->name('user_index');
        Route::match(['get' , 'post'],'/yourProtectedFunction' , 'yourProtectedFunction')->name('yourProtectedFunction');
        Route::match(['get' , 'post'],'/user/about' , 'useruniversity')->name('user-university');
        Route::match(['get' , 'post'],'/user/update-password', 'userchangepassword')->name('user-change-password');
        Route::match(['get' , 'post'],'/user/updatepassword', 'updatechangepassword')->name('update-change-password');
        Route::match(['get' , 'post'],'/user/programs', 'userprograms')->name('user-programs');
        Route::match(['get' , 'post'],'/user/about/add', 'addabout')->name('add-about');
        Route::match(['get' , 'post'],'/user/bord/of/deirector', 'bordofdirector')->name('bord-of-director');
        Route::match(['get' , 'post'],'/user/assign/', 'assigndata')->name('assign-data');

        ///////////////  profile /////////////////////
        Route::match(['get', 'post'], 'user/user-profile', 'user_profile')->name('user-profile');

    });

    Route::controller(programcontroller::class)->group(function(){
        Route::match(['get', 'post'], '/user/program', 'addprogramajax')->name('add-program-ajax');
        Route::match(['get', 'post'], '/user/program/view', 'programlist')->name('program-list');
        Route::match(['get', 'post'], '/user/program/save', 'saveprogram')->name('save-program');
        Route::match(['get', 'post'], '/user/program/delete', 'deleteprogram')->name('delete-program-data');
        Route::match(['get', 'post'], '/user/program/data', 'getprogramview')->name('get-programby-id');
        Route::match(['get', 'post'], '/user/program/data/update', 'updateprogramdata')->name('single-program-update');
        Route::match(['get', 'post'], '/user/program/data/search', 'searchprogram')->name('search-program');
        
    });

    Route::controller(aboutcontroller::class)->group(function(){
        Route::match(['get', 'post'], 'user/assign/view', 'assignview')->name('assign-view');
        Route::match(['get', 'post'], 'user/about/data', 'getaboutdata')->name('get-about-data');
        Route::match(['get', 'post'], 'user/about/update', 'updateabout')->name('update-about');
        Route::match(['get', 'post'], 'user/about/delete', 'deleteabout')->name('delete-about');
    });
    
    Route::controller(bordcontroller::class)->group(function(){
        Route::match(['get', 'post'], 'user/bord/of/list', 'borddata')->name('bord-data');
        Route::match(['get', 'post'], 'user/bord/add', 'addbord')->name('add-bord-data');
        Route::match(['get', 'post'], 'user/bord/delete', 'deletebord')->name('delete-bord');
        Route::match(['get', 'post'], 'user/bord/single/data', 'getidborddata')->name('get-bordid-data');
        Route::match(['get', 'post'], 'user/bord/update', 'updatebord')->name('update-bord');

        // gallery start
        Route::match(['get', 'post'], 'user/gallery', 'gallery')->name('gallery');
        Route::match(['get', 'post'], 'user/gallery/add', 'uploadimage')->name('uplaod-image');
        Route::match(['get', 'post'], 'user/gallery/list', 'gallerylist')->name('gallery-list');
        Route::match(['get', 'post'], 'user/gallery/delete', 'gallerydelete')->name('gallery-delete');
        Route::match(['get', 'post'], 'user/gallery/edit', 'galleryedit')->name('gallery-edit');
        Route::match(['get', 'post'], 'user/gallery/update', 'galleryupdate')->name('gallery-update');

        // gallery end
    });
    
    Route::controller(facilitycontroller::class)->group(function(){
        Route::match(['get', 'post'], 'user/facility', 'facility')->name('facility');
        Route::match(['get', 'post'], 'user/facility/list', 'facilitylist')->name('facility-list');
        Route::match(['get', 'post'], 'user/facility/add', 'facilityadd')->name('facility-add');
        Route::match(['get', 'post'], 'user/facility/search', 'facilityserach')->name('search-facility');
        Route::match(['get', 'post'], 'user/facility/update', 'facilityupdate')->name('update-facility');
        Route::match(['get', 'post'], 'user/facility/save', 'facilitysave')->name('save-facility');
        Route::match(['get', 'post'], 'user/facility/save/add', 'facilityaddsave')->name('add-facility-ajax');
        Route::match(['get', 'post'], 'user/facility/edit/update', 'facilityeditajax')->name('facility-edit-ajax');
        Route::match(['get', 'post'], 'user/facility/delete/t', 'facilitydeleteajax')->name('facility-delete-ajax');
        Route::match(['get', 'post'], 'user/facility/update/t', 'facilityupdateajax')->name('facility-update-ajax');

        // upcoming start  

        Route::match(['get', 'post'], 'user/events/', 'upcoming')->name('upcoming');
        Route::match(['get', 'post'], 'user/events/list', 'upcominglist')->name('upcoming-list');
        Route::match(['get', 'post'], 'user/events/add', 'upcomingadd')->name('upcoming-add');
        Route::match(['get', 'post'], 'user/events/delete', 'upcomingdelete')->name('upcoming-delete');
        Route::match(['get', 'post'], 'user/events/edit', 'upcomingedit')->name('upcoming-edit');
        Route::match(['get', 'post'], 'user/events/update', 'upcomingupdate')->name('upcoming-update');
       
    });

    Route::controller(coursecontroller::class)->group(function(){
        Route::match(['get', 'post'], 'user/course', 'course')->name('course');
        Route::match(['get', 'post'], 'user/course/add', 'courseadd')->name('course-add');
        Route::match(['get', 'post'], 'user/course/list', 'courselist')->name('course-list');
        Route::match(['get', 'post'], 'user/course/delete', 'coursedelte')->name('course-delete');
        Route::match(['get', 'post'], 'user/course/edit', 'courseedit')->name('course-edit');
        Route::match(['get', 'post'], 'user/course/update', 'courseupdate')->name('course-update');


        /////////////////////////////    Admission  start ///////////////////////////////////

        Route::match(['get', 'post'], 'user/admission', 'addmission')->name('addmission');
        Route::match(['get', 'post'], 'user/admission/add', 'addmissionadd')->name('admission-add');
        Route::match(['get', 'post'], 'user/admission/list', 'addmissionlist')->name('adission-list');
        Route::match(['get', 'post'], 'user/admission/delete', 'addmissiondelete')->name('admission-delete');
        Route::match(['get', 'post'], 'user/admission/edit', 'addmissionedit')->name('admission-edit');
        Route::match(['get', 'post'], 'user/admission/update', 'addmissionupdate')->name('admission-update');

        /////////////////////////////    tbl && placement  start ///////////////////////////////////

        Route::match(['get', 'post'], 'user/training/placement', 'tbl')->name('tbl');
        Route::match(['get', 'post'], 'user/training/placement/add', 'tbladd')->name('tbl-add');
        Route::match(['get', 'post'], 'user/training/placement/list', 'tbllist')->name('tbl-list');
        Route::match(['get', 'post'], 'user/training/placement/delete', 'tbldelete')->name('tbl-delete');
        Route::match(['get', 'post'], 'user/training/placement/edit', 'tbledit')->name('tbl-edit');
        Route::match(['get', 'post'], 'user/training/placement/update', 'tableupdate')->name('tbl-update');

        ///////////////   acceleartion /////////////
       
        Route::match(['get', 'post'], 'user/acceditations', 'acceditations')->name('acceditations');
        Route::match(['get', 'post'], 'user/acceditations/add', 'acceditationsadd')->name('acceditations-add');
        Route::match(['get', 'post'], 'user/acceditations/list', 'acceditationslist')->name('acceditations-list');
        Route::match(['get', 'post'], 'user/acceditations/delete', 'acceditationsdelete')->name('accreditations-delete');
        Route::match(['get', 'post'], 'user/acceditations/edit', 'acceditationsedit')->name('accreditations-edit');
        Route::match(['get', 'post'], 'user/acceditations/update', 'acceditationsupdate')->name('accreditations-update');


        ///////////////////////   Recognization //////////////////////

        Route::match(['get', 'post'], 'user/Recognization', 'Recognization')->name('Recognization');
        Route::match(['get', 'post'], 'user/Recognization/update', 'Recognizationupdate')->name('Recognization-update');

    });


});

require __DIR__.'/auth.php';

Route::controller(homecontroller::class)->group(function(){
    Route::match(['get' , 'post'] ,'/' , 'index')->name('index'); 
});
