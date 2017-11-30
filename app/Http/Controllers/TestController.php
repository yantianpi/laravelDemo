<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request) {
        ob_start();
        echo 'abc';//存入ob缓存
        header('content-type:text/html;charset=utf-8'); //存入程序缓存
        echo 'hello'; //存入ob缓存
        ob_flush();//将ob缓存中的内容输出到程序缓存，清空ob缓存，不关闭ob缓存
//        ob_end_flush(); //将ob缓存中的内容输出到程序缓存，清空ob缓存，关闭ob缓存
        echo 'bb'; //存入ob缓存
//        file_put_contents('test.txt', ob_get_contents());
        die;
        /* ob_flush 输出abchellobb test.txt bb */
        /* ob_end_flush 输出abchellobb test.txt abchellobb */
    }
}
