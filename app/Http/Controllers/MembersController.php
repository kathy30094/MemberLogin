<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use DB;
use App\MembersID;
use App\Employees;
use App\Http\Requests;
use App\Functions\MembersBellow;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\ruleID;
use Session;



class MembersController extends Controller
{
    //更新member資料
    public function updateMember(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|regex: /^[0-9]*$/',
            'name' => 'required|alpha_num',
            'psd' => 'required|alpha_dash',
            'phone' => 'nullable|regex: /^[0]{1}[0-9]{1}[0-9]{7,8}$/ ',
            'email' => 'nullable|email',
        ]);

        $theID = MembersController::getTheID($request);

        $isIn = MembersController::isInValidList($theID, $request->id);
        
        if($isIn == 't')  //有權限
        {
            $memberToUpdate = \App\Employees::find((int)$request->id);
            $memberToUpdate->Password = $request->psd;
            $memberToUpdate->Phone = $request->phone;
            $memberToUpdate->Email = $request->email;
            $memberToUpdate->Name = $request->name;
            $memberToUpdate->save();

            $retData['ret']=0;
            return $retData;
        }
        else
        {
            $retData['ret']=1;
            return $retData;
        }
    }

    //delete
    public function deleteMember(ruleID $request)
    {   
        $theID = $request->id;//要刪除的ID
        $IDsToDelete = \App\Functions\MembersBellow::MembersBellow($theID); //該ID下的整棵樹刪除
        \App\Employees::destroy($IDsToDelete);
        \App\MembersID::destroy($IDsToDelete);

        $retData['ret']=0;
        return $retData;
    }

    //檢查有沒有登入了
    public function IsLogin(Request $request)
    {
        $theToken = $request->session()->get('_token');
        $retData = [];

        if(Redis::exists($theToken))
        {
            $retData['ret']=0;
            $retData['token'] = $request->session()->get('_token');
            $theSession = json_decode(Redis::get($request->session()->get('_token')),true);
            $retData['status']=$theSession['Status'];
            return $retData;
        }
        else
        {
            $retData['token'] = $request->session()->get('_token');
            $retData['ret']=1;
            return $retData;
        }
    }

     //登出
    public function Logout(Request $request)
    {
        $theToken = $request->session()->get('_token');

        if(Redis::exists($theToken))
        {
        Redis::del($theToken);
        $retData['token'] = $request->session()->get('_token');
        $retData['ret']=0;
        
        return $retData;
        }
    }

    //新增會員到自己下  testBlock
    public function newMember(Request $request)
    {
        $this->validate($request,[
            'acc' => 'required|alpha_num',
            'psd' => 'required|alpha_dash',
            'name' => 'required|alpha_num',
            'phone' => 'nullable|regex: /^[0]{1}[0-9]{1}[0-9]{7,8}$/ ',
            'email' => 'nullable|email',
            'status' => 'required|regex: /^[0-1]{1}$/ ',
        ]);
        
        //新增資料到資料庫  /transaction
        $memberID = new \App\MembersID;
        $memberID->parentID = MembersController::getTheID($request);

        $memberData = new \App\Employees;
        $memberData->Account = $request->acc;
        $memberData->Password = $request->psd;
        $memberData->Name = $request->name;
        $memberData->Email = $request->email;
        $memberData->Phone = $request->phone;
        $memberData->Status = $request->status;

        DB::transaction(function() use ($memberID,$memberData){
            $memberID->save();
            $memberData->save();
        });

        $retData['session'] = $request->session()->all();
        $retData['token'] = $request->session()->get('_token');
        $retData['ret']=0;
        return $retData;
    }

    //登入
    public function loginSaveTocken(Request $request)
    {
        $this->validate($request,[
            'acc' => 'required|alpha_num',
            'psd' => 'required|alpha_dash',
        ]);
        Session::regenerate(true);

        //look into MySql find if member is exit
        $member = \App\Employees::where('Account',$request->acc)->where('Password',$request->psd)->get();
        
        $retData = [];
        
        //if exit
        if($member != null )
        {
            $theToken = $request->session()->get('_token');
            $theSessionsArray = array_merge($request->session()->all(),$member[0]->toArray());

            //put token and session into RedisDB
            Redis::set($theToken,json_encode($theSessionsArray));
            $value = Redis::get($theToken);

            $retData['ret'] = 0;
            $retData['session'] = $request->session()->all();
            $retData['token'] = $theToken;
            $retData['id'] = $member[0]->id;

            return $retData;
        }
        else
        {
            $retData['ret'] = 1;
            return $retData;
        }
    }

    //回傳指定ID下的所有member Collection
    public function searchMember(ruleID $request)
    {
        $theID = MembersController::getTheID($request);
      
        //前端指定的ID，若前端不指定，則為自己
        $idToSearch = $request->id;

        if($idToSearch == null)
        {
            $idToSearch = $theID;
        }

        //檢查$idToSearch是否在$theID下
        $isIn = MembersController::isInValidList($theID, $idToSearch);
        
        if($isIn == 't')  //有權限  開始搜尋
        {
            $arrayOfIDs = \App\Functions\MembersBellow::MembersBellow($idToSearch);
            $membersCollection = \App\Employees::SearchMembersByID($arrayOfIDs);

            //test 回傳全部給前端判斷
            $retData['ret'] = 0;
            //$retData['session'] = $request->session()->all();
            $retData['token'] = $request->session()->get('_token');
            $retData['membersCollection'] = $membersCollection->get();//all
            return $retData;
        }
        else //不合權限的操作
        {
            $retData = [];
            $retData['ret'] = 1;
            return $retData;
        }
    }

    //從Redis取得自己的id
    public function getTheID(&$request)
    {
        $theSession = json_decode(Redis::get($request->session()->get('_token')),true);
        $theID = (int)$theSession['id']; 
        return $theID;
    }

    //private   檢查 $idToSearch 是否在 $theID 下
    private function isInValidList($theID,$idToSearch)
    {
        $isIn = 'f';

        $idToSearch = (int)$idToSearch;

        if($idToSearch == $theID) //如果有指定要搜什麼  把$theID改成要搜的ID
        {
            $isIn ='t';
        }
        else
        {
            $arrayOfIDs = \App\Functions\MembersBellow::MembersBellow($theID);  // 得到自己有權限的ID表

            if(in_array($idToSearch, $arrayOfIDs))
                $isIn = 't';

            // foreach($arrayOfIDs as $memberID)  //int //巡迴查看idToSearch是否有在自己的ID權限內
            // {
            //     if($memberID == $idToSearch)
            //     {   
            //         $isIn = 't'; //在有權限的ID表內
            //     }
            // }
        }
        return $isIn;
    }
}