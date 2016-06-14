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
    '/admin/photo/store'=>'//Backend/StorePhoto',
    '/admin/photo/edit/<1>' => '//Backend/EditPhoto(id=<1>)',
    '/admin/photo/update/<1>' => '//Backend/UpdatePhoto(id=<1>)',
    '/admin/photo/delete/<1>' => '//Backend/DeletePhoto(id=<1>)',
    '/admin/user' => '//Backend/AllUser',
    '/admin/user/delete/<1>' => '//Backend/DeleteUser(id=<1>)',
    '/admin/comment' => '//Backend/AllComment',
    '/admin/comment/delete/<1>' => '//Backend/DeleteComment(id=<1>)'


];