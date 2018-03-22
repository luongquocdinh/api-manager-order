<?php
return [ 
        
        'driver' => 'smtp',
        
        'host' => 'smtp.sendgrid.net',
        
        'port' => 587,
        
        'encryption' => 'tls',

        'from' => ['address' => 'ppmsvn@gmail.com', 'name' => 'PPMS VN'],
        
        'username' => 'ppmsvn',
        
        'password' => 'ppmsvn@1234',
        
        'sendmail' => '/usr/sbin/sendmail -bs' 
];