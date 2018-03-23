<?php
return [ 
        
        'driver' => 'smtp',
        
        'host' => 'smtp.sendgrid.net',
        
        'port' => 587,
        
        'encryption' => 'tls',

        'from' => ['address' => 'example@gmail.com', 'name' => 'Example'],
        
        'username' => 'example',
        
        'password' => 'your-password',
        
        'sendmail' => '/usr/sbin/sendmail -bs' 
];
