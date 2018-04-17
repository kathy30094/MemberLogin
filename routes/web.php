<?php

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


//for  tests

    // Route::get('testPHP',function(){
    //     phpinfo();
    // });

    // Route::get('testBytes','testController@testBytes');


    // Route::get('count/{id}',function($id){
    //     $selfID = (int)$id;
    //     $treeCount = 3;
    //     //-------------------------------pre
    //     $wholetreeID = [];
    //     $wholetree = \App\FamilyTree::get()->toArray();
    //     foreach($wholetree as $each)
    //         array_push($wholetreeID,$each['id']); 

    //     //toFindsID
    //     $halfKey = array_search($selfID, array_column($wholetree, 'halfID'));
    //     if($halfKey==true)
    //     {
    //         $selfHalfID = $wholetree[$halfKey]['id']; 
    //         $toFindsID = [$selfID,$selfHalfID];
    //     }
    //     else
    //         $toFindsID = [$selfID];
    //     //var_dump($toFindsID);

    //     $alreadyCount = [];
    //     $notCountYetID = $wholetreeID;
        
    //     //------------------------------------------------------------------------------------------------for run times
    //     for($i = 1; $i <= $treeCount; $i++)
    //     {
    //         //find parent
    //         $toFindParent = \App\FamilyTree::whereIn('id',$notCountYetID)->find($toFindsID)->toArray();
    //         $parent1IDs = [];
    //         if($toFindParent != null)
    //             foreach($toFindParent as $theFind)
    //                 if($theFind['parent1ID'] != null)
    //                     array_push($parent1IDs,$theFind['parent1ID']);
    //         //var_dump($parent1IDs);
    //         if($i>1)
    //             $notCountYetID = array_diff($notCountYetID,$halfIDs);
            
    //         //find child
    //         $childIDsCollect = \App\FamilyTree::whereNotIn('id', $alreadyCount)->select('id')->whereIn('parent1ID',$toFindsID)->get()->toArray();

    //         $childIDs = [];
    //         if($childIDsCollect != null)
    //             foreach($childIDsCollect as $idObj)
    //                 if($idObj['id']!=null)
    //                     array_push($childIDs,$idObj['id']);

    //         $alreadyCount = array_merge($alreadyCount,$toFindsID);

    //         //find half
    //         $toFindHalfIDs = array_merge($parent1IDs,$childIDs);
    //         $eachHalfs = \App\FamilyTree::whereNotIn('id', $alreadyCount)->whereIn('halfID',$toFindHalfIDs)->select('id')->get()->toArray();

    //         $halfIDs = [];
    //         if($eachHalfs != null)
    //             foreach($eachHalfs as $idObj)
    //                 array_push($halfIDs,$idObj['id']);

    //         //conclusions
    //         $doneThisRun = array_merge($parent1IDs,$childIDs,$halfIDs);
    //         echo 'doneThisRun';
    //         var_dump($doneThisRun);

    //         $alreadyCount = array_merge($doneThisRun,$toFindsID);

    //         $toFindsID = $doneThisRun;

    //         $notCountYetID = array_diff($wholetreeID,$alreadyCount);

    //         $stillNeedToCount = array_merge($notCountYetID,$halfIDs,$parent1IDs);
    //         $notCountYetID = array_merge($notCountYetID,$halfIDs,$parent1IDs);

    //     }
    //     return;



    // });

    //---------------------------------------------------不使用orm,尋找parent1ID
            // foreach($toFindsID as $theID)
            // {
            //     $self = $wholetree[$theID-1];
            //     $parent1ID = $self['parent1ID'];
            //     array_push($parentIDs, $parent1ID );
            // }
            // //////var_dump($parentIDs);
            //$toFindsID = [];
            //add $toFindsIDHalf and $eachHalf to $toFindsID
    ///

    // Route::post('testPost','TestController@testPost');


    // Route::get('tree',function(){

    //     $parentID = 21;
    //     $halfID = null;

    //     $familyMember = new \App\FamilyTree;

    //     if($parentID != null)
    //     {
    //         $familyMember->parent1ID = $parentID;

    //         $parent2 = \App\FamilyTree::where('halfID',$parentID)->get();
    //         if($parent2 != null)
    //         {
    //             $parent2ID = $parent2[0]->id;
    //             $familyMember->parent2ID = $parent2ID;
    //         }
    //     }
        
    //     if($halfID != null)
    //     {
    //         $familyMember->halfID = $halfID;

    //         $half = \App\FamilyTree::find($halfID);
    //         $half->$halfID = \App\FamilyTree::max('id');
    //     }
    //     $familyMember->name = "a";
    //     $familyMember->save();


    //     // return $familyMember;
    // });

    // Route::get('couple',function(){
    //     $AID = 18;
    //     $BID = 26;
        
    //     $A = \App\FamilyTree::find($AID);
    //     $A->halfID = $BID;
    //     $A->save();

    //     $B = \App\FamilyTree::find($BID);
    //     $B->halfID = $AID;
    //     $B->save();


    // });
//end tests




//for basic
Route::get('/', function () {
    return view('welcome');
});
Route::post('login','MembersController@loginSaveToken');

Route::post('token','MembersController@IsLogin');

// for Logined
Route::group(['middleware' => ['CheckToken']], function () {

    Route::post('logOut','MembersController@Logout');
});


//for player
Route::group(['middleware' => ['CheckIsPlayer']], function () {

    Route::get('playerpage',function(){
        return view('playerAlreadyLogin');
    });
});

//for agent
Route::group(['middleware' => ['CheckIsAgent']], function () {

    Route::get('agentpage',function(){
        return view('agentAlreadyLogin');
    });

    Route::post('newMember','MembersController@newMember');

    Route::post('search','MembersController@searchMember');

    Route::post('deleteMember','MembersController@deleteMember');

    Route::post('updateMember','MembersController@updateMember');


});



