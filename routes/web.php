<?php

Route::get('/', function () {
	
    return view('auth.login');
}); 

   Route::get('invitation-college/{ids}','StudentCollege\CollegeController@invitation_college'); 
   Route::get('invitation-School/{ids}','Student\StudentCompetitionController@invitation_School'); 
   Route::get('college_teamstatus/{ids}','StudentCollege\CollegeController@college_teamstatus'); 
  Route::get('college_teams_no/{ids}','StudentCollege\CollegeController@college_teams_no');

Route::get('downloadAlbum/{compidtest}','CompetitionController@downloadAlbum');
Route::get('viewplanshowT/{planid}','Trainerrole\Trainer_school@viewplanshowT');
Route::get('cronstartschool','SchoolController@cronstartschool');
Route::get('cronstratstudent','SchoolController@cronstratstudent');
Route::get('croncompetition','CompetitionController@croncompetition');
Route::post('studentlistformail','SchoolController@studentlistformail');
Route::post('invitebyemailstudentbulk','SchoolController@invitebyemailstudentbulk');

//student college register =================================================================

  Route::get('register/form','StudentCollege\CollegeController@register_form')->name('studentCollegeRegister');
  Route::post('studentCollegeRegister', 'StudentCollege\CollegeController@register');
  Route::get('studentCollegeLogin', 'StudentCollege\CollegeController@login_form');
  Route::post('studentCollegeLogin', 'StudentCollege\CollegeController@login');
  Route::any('student_collage_logout','StudentCollege\CollegeController@logout');
  Route::post('studentcollageloginview','StudentCollege\CollegeController@login');
  //  Route::get('studentcollagedashboard','StudentCollege\CollegeController@student_home');

  Route::get('get_city', 'StudentCollege\CollegeController@get_city');
  Route::post('materialperice','ManufactureController@materialperice');
  Route::post('cartsave','ManufactureController@cartsave');
  Route::post('payment','ManufactureController@payment');

  // create team student college
  // Route::get('student/create/team/{stschid}', 'StudentCollege\CollegeController@create_team');
  // Route::post('student/team/store', 'StudentCollege\CollegeController@team_store');
  // Route::get('student/team/show/{stschid}', 'StudentCollege\CollegeController@view_team');
  // Route::get('student/team/view_team_member/{stschid}', 'StudentCollege\CollegeController@view_team_member');
  // Route::get('student/team/edit_team/{stschid}', 'StudentCollege\CollegeController@edit_team');
  // Route::post('student/team/update_team', 'StudentCollege\CollegeController@update_team');
  
  // Route::post('student_colleget_search', 'StudentCollege\CollegeController@student_college_search');
  // Route::get('collage_teamstatus/{ids}','StudentCollege\CollegeController@collage_teamstatus'); 
  // Route::get('collage_teams_no/{ids}','StudentCollege\CollegeController@collage_teams_no');

  // Route::post('inviteUser', 'StudentCollege\CollegeController@inviteUser');
  // Route::get('user_invitation/{id}','StudentCollege\CollegeController@user_invitation');
  // Route::get('user_invitation_reject/{id}','StudentCollege\CollegeController@user_invitation_reject');

  // Route::post('college_pay', 'StudentCollege\CollegeController@college_pay');
  // Route::get('dashboard1', 'StudentCollege\CollegeController@RazorThankYou');


//===========================================================================================

  Route::get('product', 'RazorpayController@index');
  Route::post('paysuccess', 'RazorpayController@razorPaySuccess');
  Route::get('razor-thank-you', 'RazorpayController@RazorThankYou');

  Route::get('activateCollege/{school_id}', 'SchoolController@activateCollege');
  Route::post('activateAccount', 'RazorpayController@activateAccount');


  Route::get('passwordsendmail','Student\Students@emailSendPassword');
  
  Route::post('documentUpload', 'Student\Students@documentUpload');
 Route::get('invitation','Student\StudentCompetitionController@invitation');
 Route::get('teamstatus/{sttd}','Student\StudentCompetitionController@teamstatus');
 Route::get('teamstatusreject/{sttd}','Student\StudentCompetitionController@teamstatusreject');
 
 

Auth::routes();

// Route::group(['middleware'=>['PreventBackButton','auth']],function(){

Auth::routes(['register'=>false]);

Route::post('slogout','Student\Students@slogout');

Route::post('slogin','Student\Students@slogin');
Route::get('studentlogin','StudentController@studentlogin');

// New Login System
Route::any('student-login','Student\Students@slogin1');
Route::get('new-user','Student\Students@new_user');
Route::post('new_user_reg','Student\Students@new_user_reg');
// End Login System

// Trainer Login
Route::get('trainerlogin','TrainerController@trainerlogin');
Route::post('trlogin','TrainerController@trlogin');
Route::post('trlogout','TrainerController@trlogout');
// End Trainer Login



// Trainer School
Route::get('schoollogin','SchoolController@schoollogin');
Route::post('sclogin','SchoolController@sclogin');
Route::post('sclogout','SchoolController@sclogout');
// End School Login


//upanshu password reset routes
 Route::get('trainerpasswordreset','TrainerController@trainerpasswordreset');
 Route::post('tainernewpassword','TrainerController@tainernewpassword');

 Route::get('passwordreset','SchoolController@passwordreset');
 Route::post('newpassword','SchoolController@newpassword'); 


 Route::get('studentpasswordreset','SchoolController@studentpasswordreset');
 Route::post('studentnewpassword','SchoolController@studentnewpassword');

 //forget passwrod  Co-Admin
 Route::get('coforgetpasswordemail','CoadminController@coforgetpasswordemail');
 Route::post('Cocheckemail','CoadminController@Cocheckemail');
 Route::get('cotoresetpassword/{email}','CoadminController@cotoresetpassword');
 Route::post('coadmincpasswordreset','CoadminController@coadmincpasswordreset');


 //forget passwrod  Trainer
 Route::get('forgetpasswordemail','TrainerController@forgetpasswordemail');
 Route::post('checkemail','TrainerController@checkemail');
 Route::get('toresetpassword/{email}','TrainerController@toresetpassword');
 Route::post('cpasswordreset','TrainerController@cpasswordreset');

 //forget passwrod  School
 Route::get('Schoolforgetpasswordemail','SchoolController@forgetpasswordemail');
 Route::post('Schoolcheckemail','SchoolController@checkemail');
 Route::get('Schooltoresetpassword/{email}','SchoolController@toresetpassword');
 Route::post('Schoolcpasswordreset','SchoolController@cpasswordreset');

//forget password student
 Route::get('studentemailfpassword','StudentController@studentemailfpassword');
 Route::post('studentforgetpassword','StudentController@studentforgetpassword');
 Route::get('stududentforegetpass/{email}','StudentController@stududentforegetpass');
 Route::post('passwordresetstudent','StudentController@passwordresetstudent');

// Forgot Username And Password  28 May 2020
 Route::get('Forgot-UserName','Student\Students@forgotUserName');
 Route::post('Forgot-UserName','Student\Students@forgotUserNamePost');
 Route::get('Forgot-PassWord','Student\Students@forgotPassWord');
 Route::post('Forgot-PassWord','Student\Students@forgotPassWordPost');
 Route::get('verify-OTP-Username','Student\Students@verify_OTP_Username');
 Route::post('verify-OTP-Username-Post','Student\Students@verify_OTP_Username_Post');
 Route::get('Username-success-page','Student\Students@Username_success_page');
 Route::get('verify-OTP-Password','Student\Students@verify_OTP_Password');
  Route::post('verify-OTP-Password-Post','Student\Students@verify_OTP_Password_Post');
 Route::post('verify-OTP-Password-Postregister','Student\Students@verify_OTP_Password_Postregister');
 Route::post('generateuser','Student\Students@generateuser');
 
 Route::get('set-Password','Student\Students@set_Password');
 Route::post('reset-Password','Student\Students@reset_Password');
 Route::get('Password-success-page','Student\Students@Password_success_page');
 
 
// Jogi
//upanshu


// Route::get('slogin','Auth\LoginController@slogin');

Route::group(['middleware'=>['auth','Chkdemo']],function(){
	

	  
	
	Route::post('intimation','Trainerrole\Trainer_school@intimation');
	    //All Admin ROute
	   Route::group(['middleware'=>['is_admin']],function(){
       Route::get('viewstudentlist/{vcpid}','Trainerrole\Trainer_school@viewstudentlist'); 
       Route::get('viewcourseT/{schoolid}','Trainerrole\Trainer_school@viewcourseT');
       Route::get('viewplanshowT/{planid}','Trainerrole\Trainer_school@viewplanshowT');
       Route::get('viewplanshowTs/{schoolid}','Trainerrole\Trainer_school@viewplanshowT');
       Route::get('viewcourseinPlan/{vcpid}','Trainerrole\Trainer_school@viewcourseinPlan');

       Route::post('storeschoolplanmasterbytr','Trainerrole\Traineraction@storeschoolplanmasterbytr');
       Route::post('schoolplanfetchacademicyear_admin','Trainerrole\Traineraction@schoolplanfetchacademicyear_admin');

		Route::post('rejectedbyadminmanufacture','Student\Students@rejectedbyadminmanufacture');
		Route::post('addblock','admin\Team\TeamController@addblock');
		Route::post('removeblock','admin\Team\TeamController@removeblock');
		
		Route::post('approveData','Student\Students@approveData');
		Route::get('addrole', 'LabelController@addrole')->name('addrole');
		Route::post('addrole', 'LabelController@saverole');
		Route::get('listrole', 'LabelController@listrole');
		Route::get('role_define_module/{labelid}', 'LabelController@rolemodule');
		Route::post('role_define_module/{labelid}', 'LabelController@editrolemodule');
        Route::get('viewTeamad','admin\Trainerteamaction@viewTeamadd');
		Route::get('coadmin', 'CoadminController@index');
		Route::get('coadmincreate', 'CoadminController@create');
		Route::get('Invite-coadmin/{coid}', 'CoadminController@invite_coadmin');
		Route::post('create', 'CoadminController@store');
		Route::get('editcoadmin/{coadmin}', 'CoadminController@edit');
		Route::post('updatecoadmin/{coadmin}', 'CoadminController@update');
		Route::get('coadmins','HomeController@coadmins');
		Route::get('/', 'HomeController@index')->name('home');
		Route::get('/abc','SelectorController@getview');;
		Route::get('/home', 'HomeController@index')->name('home');
		Route::get('/abc','SelectorController@getview');
		Route::get('getcitylist/{id}','LocationController@getcitylist');
		Route::get('getcitylists/{id1}/{id2}','LocationController@getcitylists');
		Route::get('location','LocationController@index');
		Route::get('locationcr','LocationController@create');
		Route::post('locationcr','LocationController@store');
		Route::get('locationed/{id}','LocationController@edit');
		Route::post('locationed','LocationController@update');
		Route::get('locationdel/{id}','LocationController@destroy');
		Route::get('locationv/{id}','LocationController@show');
		Route::post('locationbyzone','LocationController@locationbyzone');
		Route::post('statebycity','LocationController@statebycity');
		Route::get('zone_list', 'LocationController@zone_list');
		Route::get('zone_Active_inctive','LocationController@zone_Active_inctive');
		Route::get('school','SchoolController@index');
		Route::get('schoolv/{id}','SchoolController@show');
		Route::get('schoolcr','SchoolController@create');
		Route::post('schoolcr','SchoolController@store');
		Route::get('schooled/{id}','SchoolController@edit');
		Route::post('schooled','SchoolController@update');
		Route::get('schooldel/{id}','SchoolController@destroy');
        Route::get('schoolplanmaster/{schoolid}','SchoolController@schoolplanmaster');
        Route::get('participantlist/{schooldp}','SchoolController@participantlist');
        Route::post('storeschoolplanmaster','SchoolController@storeschoolplanmaster');

        Route::post('schoolplanfetchacademicyear','SchoolController@schoolplanfetchacademicyear');

        Route::get('participanrshow','SchoolController@participanrshow'); 
        Route::get('menbershipsata','SchoolController@menbershipsata'); 
        Route::get('competitionTeamdata','CompetitionController@competitionTeamdata'); 
        
        Route::post('sbmitparticipant','SchoolController@sbmitparticipant'); 
        Route::post('submitnominatecomTeam','CompetitionController@submitnominatecomTeam');
        
         Route::get('addplan','PlanController@addplan'); 
		Route::post('addplan','PlanController@addplans'); 
		Route::get('listplan','PlanController@listplan');
		Route::get('editplan/{editplan}','PlanController@editplan');
		Route::post('editplan/{editplan}','PlanController@editplanpost');
        Route::get('downloadplan','PlanController@downloadplan');
		Route::post('uploadprice','PlanController@uploadprice');
		Route::get('viewplan/{id}','PlanController@viewplan');
		Route::get('view_meterial/{id}','PlanController@view_meterial');
		
    // creat Team by admin
    // Route::post('editbyTr','Trainerrole\Traineraction@editbyTr');
    // Route::get('createteambytr/{atssid}','Trainerrole\Trainerteamaction@createteambytr'); 
	//Route::post('teamstorebytr','Trainerrole\Trainerteamaction@teamstorebytr');
	//Route::post('studentseachbytr','Trainerrole\Trainerteamaction@studentseachbytr'); 
	//Route::get('deletestudentteamby/{setid}','Trainerrole\Trainerteamaction@deletestudentteamby');
       // Route::get('createteamadd/{ad_sc_id}','SchoolController@createteamadd');

        //upanshu 
        //school
        Route::post('sendemail','SchoolController@invitebyemail');
		 Route::post('sendemailbuk','SchoolController@invitebyemailbulk');
		 // Route::post('invitebyemailstudentbulk','SchoolController@invitebyemailstudentbulk');
        
        //liststudent
	    // Route::post('studentlistformail','SchoolController@studentlistformail');
	    //createTeam by Admin coursenameed
		 
        Route::get('createteambyad/{id}','CreateTeamController@createteambyad'); 
        Route::post('teamstorebyad','CreateTeamController@teamstorebyad');
        Route::post('studentseachbyad','CreateTeamController@studentseachbyad');
        Route::post('teamstorebyad','CreateTeamController@teamstorebyad');
        Route::get('viewTeamad/{id}','CreateTeamController@viewTeamad');
        Route::get('deleteteambyad/{id}','CreateTeamController@deleteteambyad');
        Route::get('editteambyad/{id}','CreateTeamController@editteambyad');
        Route::post('teamupdatebyad','CreateTeamController@teamupdatebyad');
        //createTeam by admin end here
       
	     //upanshu code end here
		Route::get('course','CourseController@index');
		Route::get('coursev/{id}','CourseController@show');
		Route::get('coursecr','CourseController@create');
		Route::post('coursecr','CourseController@store');
		Route::get('coursedel/{id}','CourseController@destroy');
		Route::get('courseed/{id}','CourseController@edit');
		Route::post('courseed','CourseController@update');
		Route::get('coursecs/{id}','CourseController@getbycs');

		Route::get('coursename','CourseMasterController@index');
		Route::get('coursenamecr','CourseMasterController@create');
		Route::post('coursenamecr','CourseMasterController@store');
		Route::get('coursenameed/{id}','CourseMasterController@edit');
		Route::post('coursenameed','CourseMasterController@update');
		Route::get('coursenamedel/{id}','CourseMasterController@destroy');


		Route::get('membership','MembershipController@index');
		Route::get('membershipcr','MembershipController@create');
		Route::post('membershipcr','MembershipController@store');
		Route::get('membershiped/{id}','MembershipController@edit');
		Route::post('membershiped','MembershipController@update');
		Route::get('membershipdel/{id}','MembershipController@destroy');
		Route::get('activitysrch/{id}','MembershipController@activitysrch');
	    Route::get('atrainer','TrainerController@index');
	    Route::get('trainercreate','TrainerController@create');
	    Route::post('trainercreate','TrainerController@store');
	    Route::get('edittrainer/{trainer}','TrainerController@edit');   
	    Route::post('updatetrainer/{trainers}','TrainerController@update');  
	    Route::get('trainerassigned/{trainers1}','TrainerController@assigned');  
	    Route::post('traineradd/{trainers1}','TrainerController@traineradd');  
	    Route::get('trainerschool','TrainerController@trainerschool');  
	    Route::resource('students', 'StudentController');
	    Route::get('viewstudentinfoadmin/{stid}','StudentController@viewstudentinfoadmin');
	    Route::get('downloadstudentupload', 'StudentController@downloadstudentupload');
        Route::get('downloadstudentbyschoolwhole', 'StudentController@downloadstudentbyschoolwhole');
	    
	    Route::get('downloadstudentbyschool/{schoolid}', 'StudentController@downloadstudentbyschool');
	    // bulk upload student.....
	    Route::post('uploadstudent', 'StudentController@uploadstudent');
	    // End bulk student

	    // Download School 
	     Route::get('downloadschool', 'StudentController@downloadschool');
	     Route::post('uploadschool', 'StudentController@uploadschool');
        // updated by Upanshu
	     Route::get('downloadstudentsheet','StudentController@downloadstudentsheet');
	     Route::get('download-school-report','StudentController@downloadschoolreport');

	     Route::get('viewTeams/{studentid}','StudentController@viewTeams');	
	     Route::get('cardesign/{studentid}','StudentController@cardesign');
	     Route::get('view_plan_student/{studentid}','PlanController@view_plan_student');
	     Route::get('Sponsorship_student/{studentid}','PlanController@Sponsorship_student');
         Route::get('show_courses_student/{planid}','PlanController@show_courses_student');
	      
	     


       // Student Opreration
	    Route::get('create/{schoolid}','StudentController@create');
	    Route::post('store','StudentController@store');
	    Route::get('show/{id}', 'StudentController@show');
        Route::get('studenteditbyadd/{ids}','StudentController@studenteditbyadd');
        Route::post('editbyadd','StudentController@editbyadd');
       //End student Operation

	    Route::get('assignplan/{id}','StudentController@assignplan');
	    Route::post('storestudentplanmaster','StudentController@storestudentplanmaster');
          //upanshu 
	    Route::post('taineremailpasswordreset','TrainerController@taineremailpasswordreset');

	   // Competition 
       Route::get('competition','CompetitionController@index');
       Route::get('competitioncr','CompetitionController@create');
	   Route::get('referencedocument/{comid}','CompetitionController@referencedocument');
       Route::post('storeCompetition','CompetitionController@storeCompetition');
       Route::get('editcompetition/{compid}','CompetitionController@edit');
       Route::post('updateCompetition','CompetitionController@update');
       Route::get('delcompetition/{compid}','CompetitionController@destroy');
       Route::get('nominate/{compid}','CompetitionController@nominate');
       Route::get('nominate-team-List/{compid}','CompetitionController@nominate_team_List');
       Route::post('nominateschoolteam','CompetitionController@nominateschoolteam');
       Route::get('nominatedschooldelete/{scid}','CompetitionController@nominatedschooldelete');
       Route::get('awards/{compid}','CompetitionController@awards');
       Route::get('add-awards/{compid}','CompetitionController@add_awards');
       Route::get('getnominateteams/{id}/{id1}/{id2}','CompetitionController@getnominateteams');
        Route::get('getnominateteamsadd/{id}/{id1}','CompetitionController@getnominateteamsadd');
       Route::post('awardsstroe','CompetitionController@awardsstroe');
       Route::get('editawards/{id}','CompetitionController@editawards');
       Route::post('editawardsstore','CompetitionController@editawardsstore');
       Route::get('deletewards/{awrdid}/{compid}/{teamid}','CompetitionController@deletewards');

       Route::get('downloadschoolcompitiiondocument/{schoolid}','CompetitionController@downloadschoolcompitiiondocument');
       
       Route::get('viewschoolincompition/{compid}','CompetitionController@viewschoolincompition');



       

       
       // 5 Septmber 2019
       Route::get('trainerviewstudents','Trainerrole\Traineraction@trainerviewstudents');


       //Manufacturing Application for admin to view trace data
	   Route::get('manufacturing-applications','ManufactureController@manufacturingapplication');
	   Route::get('placeorderList/{orderId}','ManufactureController@placeorderList');
	   Route::get('addcart/{ffff}','ManufactureController@addcart');
	   Route::get('addcart/{ffff}/{test}','ManufactureController@addcart');
	   Route::get('item/{studentid}','ManufactureController@item');
	   Route::post('cartdetails','ManufactureController@cartdetails');
	   
	   Route::post('meterialbodyprice','ManufactureController@meterialbodyprice');
	   Route::post('meterialbodypartprice','ManufactureController@meterialbodypartprice');
	   Route::post('deliveryaddressalldetails','ManufactureController@deliveryaddressalldetails');
	   Route::get('order-list','ManufactureController@orderListshowbyAdmin');
	   Route::post('orderstatusupdate','ManufactureController@orderstatusupdate');
	   Route::get('orderiddetails/{order_iD}','ManufactureController@orderiddetails');
	   Route::get('order-by/{order_iD}','ManufactureController@showdetailsstudentbyAdmin')->name('profile');
	   Route::get('viewmeterial/{meterialId}','ManufactureController@viewmeterial');
	   Route::get('viewPart/{partId}','ManufactureController@viewPart');
	   
	   
	   Route::get('removefromcartList','ManufactureController@removefromcartList');
	   Route::get('orderiddetails/{orderdetails}','ManufactureController@orderiddetails');

	   Route::get('downloadmanufacuturelist','ManufactureController@downloadmanufacuturelist');
	   
	   // Route::post('approvedbyadminmanufacture','Student\Students@approvedbyadminmanufacture');
	    Route::get('approvedbyadminmanufacture/{Appid}','Student\Students@approvedbyadminmanufacture');
       // Admin Sponsership 2DEC 2019 
	   Route::get('sponsershipadmin','admin\Sponsership\SponsershipadminController@sponsershipview');

	   //Assign  Price Master 
	   Route::get('assignpicemaster','admin\Sponsership\SponsershipadminController@assignpicemaster');
      Route::post('assignpricetoschool','admin\Sponsership\SponsershipadminController@assignpricetoschool');
       Route::get('viewpriceassignschool','admin\Sponsership\SponsershipadminController@viewpriceassignschool');

       // teamviewadd
     
       Route::get('teamviewadd','admin\Team\TeamController@teamviewadd');
       
       Route::get('viewteampage/{teamid}','admin\Team\TeamController@viewteampage');

       Route::get('viewSchTeamcompdetails/{schid}','admin\Team\TeamController@viewSchTeamcompdetails');
        Route::get('teamviewaddexport','admin\Team\TeamController@teamviewaddexport');

        // Manufacture Show School
        Route::get('school_show_manufacture/{school_id}','ManufactureController@school_show_manufacture');
        Route::get('invite-trainer/{idd}','TrainerController@invite_trainer');
        // View trainer Data

        Route::get('view-trainer/{schoodid}','TrainerController@view_trainer');

// Academic Year wise
      Route::any('academic-year-wise-info/{year}','AcademicYearController@academic_year_wise_info');

      Route::any('check-data-according-to-year-wise','AcademicYearController@check_data_according_to_year_wise');

      Route::get('available-student-in-plan/{info}','AcademicYearController@available_student_in_plan');

       Route::get('avaiable-student-in-School-plan/{info1}','AcademicYearController@avaiable_student_in_School_plan');

       Route::get('academic-year-competition-school-Team/{id}','AcademicYearController@academic_year_competition_school_Team');
      
      Route::get('academicYear-team-in-competition-School/{ds}','AcademicYearController@academicYear_team_in_competition_School');

      
     
      Route::get('change-academic-year/{ds}','AcademicYearController@change_academic_year');
      Route::post('Academic-year-submit','AcademicYearController@Academic_year_submit');
      
	  
	});

	

	// Trainar
	Route::group(['middleware'=>['is_trainer']],function(){

		Route::get('/trainer', 'HomeController@index')->name('trainer');
		

        Route::get('downloadtrainervsplan/{id}','HomeController@downloadtrainervsplan');
        

		Route::get('/assignedschool','Trainerrole\Trainer_school@assignedschool');
		Route::get('trschooinfo/{schoolid}','Trainerrole\Trainer_school@trschooinfo');
		Route::get('Participatestudentbytrainer/{ssid}','Trainerrole\Traineraction@Participatestudentbytrainer');
		Route::get('viewTeamtr/{tssid}','Trainerrole\Trainerteamaction@viewTeamtr');
		Route::get('viewteambytr/{atssid}','Trainerrole\Trainerteamaction@viewteambytr');
		Route::get('editteambytr/{tss_id}','Trainerrole\Trainerteamaction@editteambytr');

		Route::post('teamupdatebytr','Trainerrole\Trainerteamaction@teamupdatebytr');
	    Route::get('deleteteambytr/{deltssid}','Trainerrole\Trainerteamaction@deleteteambytr');

	    Route::get('showliststudent/{ids}','Trainerrole\Traineraction@showliststudent');
		Route::get('studenteditbyTrainer/{ids}','Trainerrole\Traineraction@studenteditbyTrainer');
		Route::post('editbyTr','Trainerrole\Traineraction@editbyTr');
		Route::get('createteambytr/{atssid}','Trainerrole\Trainerteamaction@createteambytr'); 

		Route::post('teamstorebytr','Trainerrole\Trainerteamaction@teamstorebytr');
	    Route::post('studentseachbytr','Trainerrole\Trainerteamaction@studentseachbytr'); 
	    Route::get('deletestudentteamby/{setid}','Trainerrole\Trainerteamaction@deletestudentteamby');

	    Route::post('sbmitparticipantbyTr','Trainerrole\Traineraction@sbmitparticipantbyTr'); 
	    Route::get('participanrshowbyTr','Trainerrole\Traineraction@participanrshowbyTr');
	    Route::get('menbershipsataby','Trainerrole\Traineraction@menbershipsataby');

	    Route::post('storeschoolplanmaster-trainer','Trainerrole\Traineraction@storeschoolplanmaster_trainer');

	   	Route::get('trdownloadstudentbyschool/{ids}', 'Trainerrole\Traineraction@trdownloadstudentbyschool');
	    Route::post('uploadstudentbytr', 'Trainerrole\Traineraction@uploadstudentbytr');

	    
	   Route::get('viewplanshow_trainer/{planid}','Trainerrole\Trainer_school@viewplanshow_trainer');
	   
       Route::get('viewplanshowT1/{planid}','Trainerrole\Trainer_school@viewplanshowT');
	   Route::get('viewcompetitionT/{schoolid}','Trainerrole\Trainer_school@viewcompetitionT');
	  
       Route::get('studentinfo/{ids}','Trainerrole\Traineraction@studentinfo');
        Route::get('viewTeams-trainer/{studentid}','Trainerrole\Traineraction@viewTeams');	
	    Route::get('cardesign-trainer/{studentid}','Trainerrole\Traineraction@cardesign');
      
Route::post('schoolplanfetchacademicyear_trainer','Trainerrole\Trainer_school@schoolplanfetchacademicyear_trainer');

// Academic Year 02 April

         Route::any('academic-year-trainer-wise/{year}','Trainerrole\Trainer_Academic_Year@academic_year_trainer_wise');

         Route::any('check-data-according-to-year-wise-trainer','Trainerrole\Trainer_Academic_Year@check_data_according_to_year_wise_trainer');


        //  Route::any('Academic-Year-Wise-System-School','Trainerrole\Trainer_Academic_Year@Academic_Year_Wise_System_School');
     
        //  Route::get('available-student-in-plan-school/{info}','Schoolaccess\SchoolaccessController@available_student_in_plan_school');

        // Route::get('avaiable-student-according-to-School-plan/{info1}','Schoolaccess\SchoolaccessController@avaiable_student_according_to_School_plan');
	   
Route::get('viewcourseT_trainer/{schoolid}','Trainerrole\Trainer_school@viewcourseT');
 Route::get('viewcourseinPlan_trainer/{vcpid}','Trainerrole\Trainer_school@viewcourseinPlan');
 
Route::get('viewstudentlist_trainer/{vcpid}','Trainerrole\Trainer_school@viewstudentlist'); 

// viewcourseinPlan_trainer
		   
// Route::get('viewcourseT/{schoolid}','Trainerrole\Trainer_school@viewcourseT');
// Route::get('viewplanshowT/{planid}','Trainerrole\Trainer_school@viewplanshowT');
// Route::get('viewplanshowTs/{schoolid}','Trainerrole\Trainer_school@viewplanshowT');

/*Start Edit profile for trainer 1 may 2020*/
Route::get('edit-profile-trainer','Trainerrole\Trainer_school@edit');
Route::post('update-trainer-profile','Trainerrole\Trainer_school@update');
/*End Edit profile for trainer 1 may 2020*/
	});

   // Route::get('studenteditbyTrainer/{ids}','Trainerrole\Traineraction@studenteditbyTrainer');
       
       
	   
	//Login_Student
	   Route::group(['middleware'=>['is_student']],function(){
	   Route::get('dashboard','Student\Students@student_home');

        // Route::get('studentlogin','Student\Students@studentlogin');
       Route::get('courseList','Student\Students@courseList');

	   Route::get('viewsCousrseS','Student\Students@viewsCousrseS');
	   Route::post('video_activity','Student\Students@video_activity');
	   Route::get('manufacturePage/{studentid}','Student\Students@manufactureS');
	   Route::get('newmanufatureCar/{stuschid}','Student\Students@newmanufatureCar');
	   Route::post('cartype','Student\Students@cartype');

	   Route::Post('body_Part','Student\Students@carbodypart');
	   Route::get('car_bodypart_type/{appid}','Student\Students@car_bodypart_type');
	   
	   Route::get('student/competition/{student_school_id}', 'Student\Students@student_competition');

	     Route::get('skipnewdesign/{skipid}','ManufactureController@skipnewdesign');  
       Route::get('cancledesign/{skipid}','ManufactureController@cancledesign');
	   

// Edit Profile Student
	   Route::post('studentprofileedit','Student\Students@studentprofileedit')->name('studentprofileedit');
       Route::post('updatestudentinfo','Student\Students@updatestudentinfo')->name('updatestudentinfo');
        Route::get('studentprofile/{studentid}','Student\Students@studentprofile')->name('studentprofile');
         Route::post('upload_image','Student\Students@uploadImage');

          Route::get('orderList/{stsch}','Student\Students@orderList')->name('orderList');
        Route::get('ordersdetails/{orderid}','Student\Students@ordersdetails');
// End Edit Profile Student
	   //Manufacture
	   Route::get('manufacturecaraplyList/{schoolidm}','Student\Students@manufacturecaraplyList');
	   Route::post('approvedbyadminmanufacture','Student\Students@approvedbyadminmanufacture');
	   // Route::post('rejectedbyadminmanufacture','Student\Students@rejectedbyadminmanufacture');
	   Route::get('carmanufacturestatus/{scid}','Student\Students@carmanufacturestatus');
	   Route::get('vediojs/{vdeioid}','Student\Students@vediojs');
	   Route::get('attempvediojs/{vdeioid}','Student\Students@attempvediojs');
	   Route::get('Attepmtplayvedio/{attemtid}','Student\Students@Attepmtplayvedio');
	   

       // create Team 22/09/2019
	   Route::get('createTeam/{stsc_id}','Student\StudentCompetitionController@createTeam');
       Route::post('teamstore','Student\StudentCompetitionController@teamstore');
       Route::get('viewTeam/{stsc_idd}','Student\StudentCompetitionController@viewTeam');
       Route::get('editteam/{tss_id1}','Student\StudentCompetitionController@editteam');
       Route::post('teamupdate','Student\StudentCompetitionController@teamupdate');
       Route::get('deleteteam/{deltssid}','Student\StudentCompetitionController@deleteteam');
       Route::post('studentseach','Student\StudentCompetitionController@studentseach');
// Sponsership Started 29 Nov 2019
       Route::get('add_sponsership/{scst_id}','Student\SponsershipController@add_sponsership');
       Route::post('storesponsership','Student\SponsershipController@storesponsership');
       
       Route::get('prviewsponsership/{sch_stu_id}','Student\SponsershipController@prviewsponsership');
        Route::get('deletesponsership/{company_name}/{sch_stid}','Student\SponsershipController@deletesponsership');
         Route::get('thankyou/{invo}/{pay}','ManufactureController@invoice');

        // Route::get('getDownloadAnnex','Student\SponsershipController@getDownloadAnnex');


        
       
// End Sponsership     
       

      
       Route::get('assignmember/{atssid}','Student\StudentCompetitionController@assignmember');
       Route::get('deletestudentteam/{setid}','Student\StudentCompetitionController@deletestudentteam'); 

       Route::get('placeorderList/{orderId}','ManufactureController@placeorderList');

       Route::get('manufacturingapplication','ManufactureController@manufacturingapplication');

	   Route::get('placeorderList/{orderId}','ManufactureController@placeorderList');
	   // Route::get('addcart/{ffff}','ManufactureController@addcart');
	   Route::get('addtocart/{appids}','ManufactureController@addcart');

	   Route::get('cart','ManufactureController@cart');
	   Route::post('materialperice','ManufactureController@materialperice');
	 

	   
	   Route::get('removeitem/{appids}','ManufactureController@removeitem');
	   
	   
	   Route::get('addcart/{ffff}/{test}','ManufactureController@addcart');
	   Route::get('item/{studentid}','ManufactureController@item');
	   Route::post('cartdetails','ManufactureController@cartdetails');
      
	   Route::post('meterialbodypartprice','ManufactureController@meterialbodypartprice');
	   Route::get('removefromcartList','ManufactureController@removefromcartList');
	   Route::post('deliveryaddressalldetails','ManufactureController@deliveryaddressalldetails');
	   Route::get('shippingorder','ManufactureController@shippingOrder');
	   Route::post('meterialbodyprice','ManufactureController@meterialbodyprice');

	   //kundan add to card

	   Route::get('productList/{orderId}','ManufactureController@productList');
	   // Route::get('addToCart/{carbody_id}/{carbody_application_id}','ManufactureController@addToCart');

	   Route::post('paymentInfo', 'ManufactureController@paymentInfo');
	   Route::get('removemanufactureitem','ManufactureController@removemanufactureitem');
	   


        

   });

 


    //School Login 
	    Route::group(['middleware'=>['is_school']],function(){

		Route::get('/home', 'HomeController@index')->name('home')->middleware('Label');
       
       Route::get('downloadschoolvsplan/{id}','HomeController@downloadschoolvsplan');

       Route::get('studentviewS','Schoolaccess\SchoolaccessController@studentviewS');

       Route::get('viewstudentinfo/{stid}','Schoolaccess\SchoolaccessController@viewstudentinfo');
       
       Route::get('vplan/{id}','Schoolaccess\SchoolaccessController@vplan');
       Route::get('studentCr/{schoolid}','Schoolaccess\SchoolaccessController@studentCr');
       Route::post('storestudent/','Schoolaccess\SchoolaccessController@storestudent');
       
       Route::get('downloadsstudent/{schoolid}', 'Schoolaccess\SchoolaccessController@downloadsstudent');
       Route::get('studenteditbyschool/{ids}','Schoolaccess\SchoolaccessController@studenteditbyschool');
       Route::post('studentupdatebyschool/','Schoolaccess\SchoolaccessController@studentupdatebyschool');
       Route::get('deletestudentbyschool/{ssid}','Schoolaccess\SchoolaccessController@deletestudentbyschool');
       Route::get('vTeamS','Schoolaccess\SchoolaccessController@vTeamS');
       Route::get('viewteambyschool/{atssid}','Schoolaccess\SchoolaccessController@viewteambyschool');
        Route::get('team-awards/{id}','Schoolaccess\SchoolaccessController@team_awards');

       // Academic Year Assign 28 
       Route::any('academic-year-school-wise/{year}','Schoolaccess\SchoolaccessController@academic_year_school_wise');
         Route::any('Academic-Year-Wise-System-School','Schoolaccess\SchoolaccessController@Academic_Year_Wise_System_School');
      Route::any('check-data-according-to-year-wise-school','Schoolaccess\SchoolaccessController@check_data_according_to_year_wise_school');

         Route::get('available-student-in-plan-school/{info}','Schoolaccess\SchoolaccessController@available_student_in_plan_school');

        Route::get('avaiable-student-according-to-School-plan/{info1}','Schoolaccess\SchoolaccessController@avaiable_student_according_to_School_plan');
        
        Route::get('team-show-by-school-competition/{ids}','Schoolaccess\SchoolaccessController@team_show_by_school_competition');

        /*Edit -school Profile*/
        Route::get('edit-profile-school','Schoolaccess\SchoolaccessController@edit_profile_school');
        Route::post('update-school','Schoolaccess\SchoolaccessController@update');

        /*End -school Profile*/
       
      
     });





   /*START  F1 SENIORNS LOGIN PROCESS */
  
  Route::post('inviteUser', 'StudentCollege\CollegeController@inviteUser');
  Route::get('user_invitation/{id}','StudentCollege\CollegeController@user_invitation');
  Route::get('user_invitation_reject/{id}','StudentCollege\CollegeController@user_invitation_reject');

    Route::group(['middleware'=>['is_F1Seniors']],function(){

   // Route::post('studentcollageloginview','StudentCollege\CollegeController@login');
   Route::get('studentcollagedashboard','StudentCollege\CollegeController@student_home');

  Route::get('student/create/team/{stschid}', 'StudentCollege\CollegeController@create_team');
  Route::post('student/team/store', 'StudentCollege\CollegeController@team_store');
  Route::get('student/team/show/{stschid}', 'StudentCollege\CollegeController@view_team');
  Route::get('student/team/view_team_member/{stschid}', 'StudentCollege\CollegeController@view_team_member');
  Route::get('student/team/edit_team/{stschid}', 'StudentCollege\CollegeController@edit_team');
  Route::post('student/team/update_team', 'StudentCollege\CollegeController@update_team');
  Route::post('upload_image_StudentCollage','StudentCollege\CollegeController@upload_image_StudentCollage');
  Route::post('student_Collage_profileedit','StudentCollege\CollegeController@student_Collage_profileedit');
  Route::post('updatestudentCollageinfo','StudentCollege\CollegeController@updatestudentCollageinfo');
  Route::post('student_colleget_search', 'StudentCollege\CollegeController@student_college_search');
  //************************************ Competition 30/06/2020*************************************
  Route::get('show-competition/{stschid}', 'StudentCollege\CollegeController@show_competition');
   //************************************End Competition 30/06/2020*************************************

  Route::post('college_pay', 'StudentCollege\CollegeController@college_pay');
  Route::get('dashboard1', 'StudentCollege\CollegeController@RazorThankYou');
    });
   /* START  F1 SENIORNS LOGIN PROCESS */



	});

// });


