<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::pattern('id', '[0-9]+');
Route::pattern('slug', '.*[^0-9].*');

Route::any('/', array('as'=>'home','uses'=>'HomeController@index'));
//Route::any('/news', array('as'=>'news','uses'=>'HomeController@news'));
Route::any('/news/{slug?}', array('as'=>'news','uses'=>'HomeController@news'));
Route::any('/article/{slug?}', array('as'=>'article','uses'=>'HomeController@article'));
Route::any('/announcement/{slug?}', array('as'=>'announcement','uses'=>'HomeController@announcement'));
Route::any('/addcomment/{id}', array('as'=>'addcomment','uses'=>'ContentController@addcomment'));

Route::any('login',  array('as'=>'login','before'=>'signed_in','uses'=>'UserController@login') );
Route::any('gym/new',array('before'=>'authened','as'=>'gymadd','uses'=>  'GymController@newgym'));
Route::any('gym/add',array('as'=>'newgym','uses'=> 'GymController@add'));
Route::any('gym/edit/{id}',array('as'=>'gymedit','uses'=> 'GymController@edit'));
Route::any('gym/update/{id}',array('as'=>'gymupdate','uses'=> 'GymController@update'));
Route::any('gym/{id}/{slug?}',array('as'=>'gym','uses'=> 'GymController@index'));
Route::any('gym/report/{id}',array('as'=>'gymreport','uses'=> 'GymController@report'));
Route::any('gym/remove/{id}',array('as'=>'gymremove','uses'=> 'GymController@remove'));

Route::any('profile/{username?}', array('as'=>'profile','uses'=> 'UserController@profile'));
Route::any('user/add', array('before' => 'csrf', 'uses' => 'UserController@add') );
Route::any('user/signup', array('before'=>'signed_in','uses'=>'UserController@signup') );
Route::any('user/signin', 'UserController@signin');
Route::any('user/signinfb',  array('as'=>'fbsignin','uses'=>'UserController@signinfb'));
Route::any('user/connectfb',  array('as'=>'fbconnect','uses'=>'UserController@connectfb'));
Route::any('user/edit/{id}', array('as'=>'useredit','uses'=>'UserController@edit') );
Route::any('user/update/{id}', array('as'=>'userupdate','uses'=>'UserController@update') );
Route::any('user/activate/{token}', array('as'=>'activate','uses'=>'UserController@activate') );

Route::any('team/add', array('as'=>'addteam','uses'=>'TeamController@newteam') );
Route::any('team/insert', array('as'=>'insertteam','uses'=>'TeamController@add') );
Route::get('team/edit/{id}', array('as'=>'editteam','uses'=>'TeamController@edit') );
Route::any('team/update/{id}', array('as'=>'updateteam','uses'=>'TeamController@update') );
Route::any('team/{id}/{slug?}', array('as'=>'team','uses'=>'TeamController@index') );
Route::any('team/join/{id}', array('as'=>'jointeam','uses'=>'TeamController@join') );
Route::any('team/report/{id}', array('as'=>'reportteam','uses'=>'TeamController@report') );
Route::any('team/remove/{id}', array('as'=>'removeteam','uses'=>'TeamController@remove') );

Route::any('user/autocomplete/{kw}', array('as'=>'userautocomplete','uses'=>'UserController@typeahead') );

Route::any('gym/autocomplete/{kw}', array('as'=>'gymautocomplete','uses'=>'GymController@autocomplete') );

Route::any('user/message',  array('as'=>'usermsg','uses'=>'UserController@message'));

Route::get('where',  array('as'=>'where','uses'=>'HomeController@where'));

Route::get('profile',  array('as'=>'profile','uses'=>'HomeController@profile'));
Route::get('about',  array('as'=>'about','uses'=>'HomeController@about'));

Route::get('webboard',  array('as'=>'forums','uses'=>'ForumsController@home'));
Route::get('category/{id}/{slug?}',  array('as'=>'category','uses'=>'ForumsController@category'));
Route::get('topic/{id}/{slug?}',  array('as'=>'topic','uses'=>'ForumsController@topic'));
Route::get('newtopic/{cat}',  array('as'=>'newtopic','uses'=>'ForumsController@newtopic'));
Route::any('forums/insert',  array('as'=>'inserttopic','uses'=>'ForumsController@insert'));
Route::any('forums/update/{id}',  array('as'=>'updatetopic','uses'=>'ForumsController@update'));
Route::any('forums/remove/{id}',  array('as'=>'removetopic','uses'=>'ForumsController@removetopic'));
Route::any('forums/insertreply',  array('as'=>'insertreply','uses'=>'ForumsController@insertreply'));
Route::any('forums/updatereply/{id}',  array('as'=>'updatereply','uses'=>'ForumsController@updatereply'));
Route::any('forums/removereply/{id}',  array('as'=>'removereply','uses'=>'ForumsController@removereply'));


Route::any('create',  array('as'=>'create','uses'=>'HomeController@create'));

Route::any('jsconnect',  array('as'=>'jsconnect','uses'=>'VanillaController@index'));

Route::any('getlocation',  array('as'=>'getlocation','uses'=>'LocationController@index'));
Route::any('getlocationbyday',  array('as'=>'getlocationbyday','uses'=>'LocationController@getlocationbyday'));
Route::any('getgym',  array('as'=>'getgym','uses'=>'LocationController@getgym'));


Route::any('admin',array('before' => 'isadmin','as'=>'admin','uses'=>'ContentController@index'));
Route::any('new_content',array('as'=>'new_content','uses'=>'ContentController@newcontent'));
Route::any('edit_content/{id}',array('as'=>'edit_content','uses'=>'ContentController@edit'));
Route::any('remove_content/{id}',array('as'=>'remove_content','uses'=>'ContentController@remove'));
Route::any('add_content',array('as'=>'add_content','uses'=>'ContentController@add'));

Route::get('sitemap', function(){

    $sitemap = App::make("sitemap");

    // set item's url, date, priority, freq
    //$sitemap->add(URL::to(), '2012-08-25T20:10:00+02:00', '1.0', 'daily');
    $sitemap->add(URL::to('page'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');

    $sitemap->add(route('home'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    $sitemap->add(route('login'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    $sitemap->add(route('where'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    $sitemap->add(route('about'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');


    $posts = DB::table('contents')->orderBy('created_at', 'desc')->get();
    foreach ($posts as $post)
    {
        $sitemap->add(route('news',array($post->slug)), $post->updated_at);
    }

    $users = DB::table('users')->orderBy('created_at', 'desc')->get();
    foreach ($users as $user)
    {
        $sitemap->add(route('home')."/profile/".$user->username, $user->updated_at);
    }

    $teams = DB::table('teams')->orderBy('created_at', 'desc')->get();
    foreach ($teams as $team)
    {
        $sitemap->add(route('team',array($team->id,$team->name)), $team->updated_at);
    }

    $gyms = DB::table('gyms')->orderBy('created_at', 'desc')->get();
    foreach ($gyms as $gym)
    {
        $sitemap->add(route('gym',array($gym->id,$gym->name)), $gym->updated_at);
    }

    $topics = DB::table('forumstopics')->orderBy('created_date', 'desc')->get();
    foreach ($topics as $topic)
    {
        $sitemap->add(route('topic',array($topic->id,$topic->subject)), $topic->last_updated);
    }

    $categories = DB::table('forumscategories')->orderBy('created_date', 'desc')->get();
    foreach ($categories as $category)
    {
        $sitemap->add(route('category',array($category->id,$category->title)), $category->created_date);
    }
   /* $teams=DB::table('teams')->orderBy('created_at', 'desc')->get();
    foreach ($teams as $team)
    {
        $sitemap->add($team->name.":".$team->description, $team->updated_at);
    }*/ 

    // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
    return $sitemap->render('xml');

});

Route::filter('isadmin', function()
{
	
	
    if (!Auth::user()||Auth::user()->username!='admin')
    {
        return Redirect::route('home');
    }
});


Route::filter('authened', function()
{

    if (!Auth::user())
    {
        return Redirect::to('login');
    }
});

Route::filter('signed_in', function()
{
    if (Auth::user())
    {
        return Redirect::to('/');
    }
});

Route::get('logout',array('as'=>'logout',
function() {
    Auth::logout();
    return Redirect::to('/');
} ) );