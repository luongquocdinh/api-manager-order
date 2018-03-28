<?php
return [ 
        
        'driver' => 'smtp',
        
        'host' => 'smtp.sendgrid.net',
        
        'port' => 587,
        
        'encryption' => 'tls',

        'from' => ['address' => 'example@gmail.com', 'name' => 'example'],
        
        'username' => 'your-username-sendgrid',
        
        'password' => 'your-password-sendgrid',
        
        'sendmail' => '/usr/sbin/sendmail -bs' 
];