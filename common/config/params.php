<?php
return [
    'adminEmail'                    => 'admin@example.com',
    'supportEmail'                  => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'absoluteStaticBasePath'        => dirname(dirname(__DIR__)) . '/statics/web/uploads',
    //'staticHost'                    => 'http://static.example.com',
    //'staticBaseUrl'                 => 'http://static.example.com/uploads',
    'staticHost'                    => 'http://statics.mywork.loc',
    'staticBaseUrl'                 => 'http://statics.mywork.loc/uploads',
    'staticPathUserAvatar'          => 'user/avatar',
    'staticUserAvatarDefault'       => 'img/default_avatar.png',
];
