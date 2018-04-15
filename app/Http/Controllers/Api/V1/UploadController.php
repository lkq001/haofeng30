<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    // 视屏上传
//    public function uploadImage(Request $request)
//    {
//        $file = $_FILES['file'];//得到传输的数据
//
//        //得到文件名称
//        $name = $file['name'];
//
//        $type = strtolower(substr($name, strrpos($name, '.') + 1)); //得到文件类型，并且都转化成小写
//        $allow_type = array('mp4', 'mp3', 'silk', 'rmvb', 'mkv', 'avi'); //定义允许上传的类型
//        //判断文件类型是否被允许上传
//        if (!in_array($type, $allow_type)) {
//            //如果不被允许，则直接停止程序运行
//            return false;
//        }
//        //判断是否是通过HTTP POST上传的
//        if (!is_uploaded_file($file['tmp_name'])) {
//            //如果不是通过HTTP POST上传的
//            return false;
//        }
//
//        $upload_path = "upload/"; //上传文件的存放路径
//
//        //开始移动文件到相应的文件夹
//        if (move_uploaded_file($file['tmp_name'], $upload_path . $file['name'])) {
//            return $file['name'];
//        } else {
//            echo "Failed!";
//        }
//
//    }

    // 图片上传
    public function uploadImage(Request $request)
    {
        return $_POST;

        $file = $_FILES['file'];//得到传输的数据

        // 其他参数数据
        $postData = $request->all();

        //得到文件名称
        $name = $file['name'];

        $type = strtolower(substr($name, strrpos($name, '.') + 1)); //得到文件类型，并且都转化成小写
        $allow_type = array('jpg', 'jpeg', 'gif', 'png'); //定义允许上传的类型
        //判断文件类型是否被允许上传
        if (!in_array($type, $allow_type)) {
            //如果不被允许，则直接停止程序运行
            return false;
        }
        //判断是否是通过HTTP POST上传的
        if (!is_uploaded_file($file['tmp_name'])) {
            //如果不是通过HTTP POST上传的
            return false;
        }

        $upload_path = "upload/"; //上传文件的存放路径

        //开始移动文件到相应的文件夹
        if (move_uploaded_file($file['tmp_name'], $upload_path . $file['name'])) {
            echo "Successfully!";
        } else {
            echo "Failed!";
        }

    }

}
