<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use DB;
use App\MembersID;
use App\Employees;
use App\Http\Requests;
use App\Functions\MembersBellow;


class TestController extends Controller
{


  public function testPost(Request $request)
  {

    //http://localhost:8000/api/testPost

    $a = new \App\FamilyTree;
    $a->name = $request->name;
    $a->save();
    
    return $request;
  }

  public function testPut(Request $request, $id)
  {
    //http://localhost:8000/api/testPut/34

    $a = \App\FamilyTree::find($id);
    $a->name = $request->name;
    $a->save();
    return $id;
  }


  public function testGet(Request $request)
  {
    //http://localhost:8000/api/testGet/?id=1&name=abc
    //$request將會是{"id":"1","name":"abc"}

    $a = \App\FamilyTree::where('id',$request->id);
    return $request;
  }

  public function testDelete($id)
  {
    //http://localhost:8000/api/delete/34

    $a = \App\FamilyTree::find($id);
    $a->delete();
    return $id;
  }
  public function testCountBits()
  {
    //     String
    // Integer
    // Float (floating point numbers - also called double)
    // Boolean
    // Array
    // Object
    // NULL
    // Resource
    $startMemory = memory_get_usage();
    $array = range(1, 10);
    echo memory_get_usage() - $startMemory, ' bytes';

    echo strlen(123);

    echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";
    $num = PHP_INT_MAX;
    var_dump($num);  // int(2147483647)
    echo "<br>";

    echo 'add 1 to PHP_INT_MAX ,溢位(Overflow) = ';
    $num++;
    var_dump($num);  // float(2147483648)
    echo "<br>";

    echo 'var_dump(28/7) = ';
    var_dump(28/7);  // int(4)
    echo "<br>";

    echo 'var_dump(25/7) = ';
    var_dump(25/7);  // float(3.5714285714286)
    echo "<br>";echo "<br>";echo "<br>";echo "<br>";


    $a = 123; // decimal number
    // var_dump($a);
    // echo "<br>";

    // $b = -123; // a negative number
    // var_dump($b);
    // echo "<br>";

    // $c = 0x1A; // hexadecimal number
    // var_dump($c);
    // echo "<br>";

    // $d = 0123; // octal number
    // var_dump($d);
    // echo "<br>";

    // $e = 'abcasjdfo';
    // var_dump($e);
    //     echo '<br>';echo '<br>';echo '<br>';
    // function float_max($mul = 2, $affine = 1) {
    //     $max = 1; $omax = 0;
    //     while((string)$max != 'INF') { $omax = $max; $max *= $mul; }

    //     for($i = 0; $i < $affine; $i++) {
    //       $pmax = 1; $max = $omax;
    //       while((string)$max != 'INF') {
    //         $omax = $max;
    //         $max += $pmax;
    //         $pmax *= $mul;
    //       }
    //     }
    //     echo $omax;
    // }
    // float_max();

    //     echo '<br>';echo '<br>';echo '<br>';




    echo 'PHP_INT_MAX '.PHP_INT_MAX;
    echo '<br>';
    echo 'PHP_INT_SIZE '.PHP_INT_SIZE ;
    echo '<br>';
    echo 'PHP_INT_MIN '.PHP_INT_MIN;
    echo '<br>';echo '<br>';echo '<br>';

    ////////////////////////////////////////////////////////////////////////////array memory size
    /////http://pankaj-k.net/weblog/2008/03/did_you_know_that_each_integer.html
    // class EmptyObject { };
    // class NonEmptyObject {
    // var $int1;
    // var $int2;
    // function NonEmptyObject($a1, $a2){
    // $this->int1= $a1;
    // $this->int2= $a2;
    // }
    // };
    // $num = 1;
    // $u1 = memory_get_usage();
    // $int_array = array();
    // for ($i = 0; $i < $num; $i++){
    // $int_array[$i] = $i;
    // }
    // $u2 = memory_get_usage();
    // $str_array = array();
    // for ($i = 0; $i < $num; $i++){
    // $str_array[$i] = "$i";
    // }
    // $u3 = memory_get_usage();
    // $arr_array = array();
    // for ($i = 0; $i < $num; $i++){
    // $arr_array[$i] = array();
    // }
    // $u4 = memory_get_usage();
    // $obj_array = array();
    // for ($i = 0; $i < $num; $i++){
    // $obj_array[$i] = new EmptyObject();
    // }
    // $u5 = memory_get_usage();
    // $arr2_array = array();
    // for ($i = 0; $i < $num; $i++){
    // $arr2_array[$i] = array('int1' => $i, 'int2' => $i + $i);
    // }
    // $u6 = memory_get_usage();
    // $obj2_array = array();
    // for ($i = 0; $i < $num; $i++){
    // $obj2_array[$i] = new NonEmptyObject($i, $i + $i);
    // }
    // $u7 = memory_get_usage();
    // echo '<br>';
    // echo "Space Used by int_array: " . ($u2 - $u1) . "\n";
    // echo '<br>';
    // echo "Space Used by str_array: " . ($u3 - $u2) . "\n";
    // echo '<br>';
    // echo "Space Used by arr_array: " . ($u4 - $u3) . "\n";
    // echo '<br>';
    // echo "Space Used by obj_array: " . ($u5 - $u4) . "\n";
    // echo '<br>';
    // echo "Space Used by arr2_array: " . ($u6 - $u5) . "\n";
    // echo '<br>';
    // echo "Space Used by obj2_array: " . ($u7 - $u6) . "\n";
  }
}