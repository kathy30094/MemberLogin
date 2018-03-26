<?php

namespace App\Functions;

use App\MembersID;

class MembersBellow 
{
    //ID --int
    public static function MembersBellow($ID)
    {
        $finalArrayIsUnder =[];
        $treeList = \App\MembersID::all()->toArray();

        MembersBellow::searchEach($ID,$finalArrayIsUnder,$treeList);
        return $finalArrayIsUnder;
    }

    private static function searchEach($ID,&$finalArrayIsUnder,&$treeList)
    {
        array_push($finalArrayIsUnder, $ID);

        $theUnders =[];
        foreach($treeList as $leaf) //找出parentID是指定的ID者  放入$theUnders
        {
            if ($leaf['parentID'] == $ID)
            {
                array_push($theUnders, $leaf);
            }
        }
        //return $theUnders;
        if($theUnders != null)  //如果$theUnders沒有直了的話  代表已經找到底
        {
           //$treeList = array_diff($treeList, $theUnders); //從$treeList中拿掉已經被抓出來要處理的東西
           for($i=0;$i<Count($theUnders);$i++)
           {
                MembersBellow::searchEach($theUnders[$i]['id'],$finalArrayIsUnder, $treeList);  ///往下再做處理  把還沒被處理過得資料傳下去
           }
        }
    }
}

    

