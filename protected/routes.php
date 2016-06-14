<?php
return [
    //Frontend
    '/photo' => '//Frontend/AllPhoto',
    '/photo/<1>/add-comment' => '//Frontend/StoreComment(id=<1>)',
    '/photo/<1>' => '//Frontend/ShowPhoto(id=<1>)',

    //Backend
    '/admin' => '//Backend/Index',
    '/admin/photo' => '//Backend/AllPhoto',
    '/admin/photo/add' => '//Backend/AddPhoto',
    '/admin/photo/store'=>'//Backend/StorePhoto'

];