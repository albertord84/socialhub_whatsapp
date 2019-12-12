	git init
	git remote add origin https://github.com/albertord84/socialhub_whatsapp.git/
	git add .
	git commit -m "adding files"
	git pull -u origin master
	git push -u origin master
	git config credential.helper store
	git remote show origin

create .env file from .env.example file
	create new database schema
	edit database datas in .env file
	sudo composer install
	chmod -R 777 storage
	chmod 777 bootstrap/cache
	php artisan key:generate
	php artisan jwt:secret
	php artisan migrate:refresh --seed (php artisan migrate:refresh+php artisan db:seed= some tables and admin@admin.com|admin user)
	sudo npm install
	go to node_modules/vue2-dropzone/dist, duplicate vue2Dropzone.min.css, and rename the copy as vue2Dropzone.css
	npm run dev
	npm run watch
	http://localhost:8000/#/attendant

cd /var/www/html/socialhub
	sudo /opt/lampp/lampp startmysql
	sudo service apache2 restart
	nohup php artisan serve &
	php artisan websocket:serve 
	sudo npm run watch
	http://localhost:8000/


	#############################
	php artisan infyom:scaffold MessageType --fromTable --tableName=message_types
	php artisan infyom:scaffold User
	php artisan infyom:scaffold Role
	php artisan infyom:scaffold Status
	php artisan infyom:scaffold AttendantsContact



        $Contacts = DB::table('contacts')->get();
        $Contacts->each(function(Contact $Contact) {
            $Contact->Status = $Contact->status();
            $Contact->lastAttendant = $Contact->attendantsContacts()->latest();
        });

        return $Contacts;


# Atualizar cache e ficheiros
rm -rf node_modules
composer dump-autoload 

php artisan cache:clear
## if error:
mkdir storage/framework/cache/data

php artisan config:clear


php artisan serve --host=192.168.25.6

# Advanced Elloquent Querys
https://m.dotdev.co/writing-advanced-eloquent-search-query-filters-de8b6c2598db





### https://github.com/beyondcode/laravel-websockets/issues/285
Nothing work with https :(  only work with http!

I tried almost all combinations:
     ////  My .vue component on start
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: process.env.MIX_PUSHER_APP_KEY,
                cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                wsHost: process.env.MIX_APP_HOST,
                // wsHost: window.location.hostname,
                wsPort: 6001,
                wssPort: 6001,
                // enabledTransports: ['ws'],
                enabledTransports: ['ws', 'wss'],
                // encrypted: true,
                encrypted: false,
                disableStats: false
            });

    ///// config/broadcasting.php
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                // 'encrypted' => true,
                // 'scheme' => 'https',       
                'useTLS' => false,
                'encrypted' => false,
                'host' => env('APP_HOST'),
                'port' => 6001,
                'scheme' => 'http',       

                'curl_options' => [
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                ]         
            ],

     ///// config/websockets.php
    'ssl' => [

        'local_cert' => env('LARAVEL_WEBSOCKETS_SSL_LOCAL_CERT', null),

        'local_pk' => env('LARAVEL_WEBSOCKETS_SSL_LOCAL_PK', null),

        // 'passphrase' => env('LARAVEL_WEBSOCKETS_SSL_PASSPHRASE', null),
        'passphrase' => null,

        'verify_peer' => false,
    ],

Clear all laravel cache, npm run dev, composer dump-autoload -o, clear navigator cache, restart supervisor and websockets, and I still having websocket with https erros like:

WebSocket connection to 'wss://[MYDOMINE]:6001/app/NNN?protocol=7&client=js&version=5.0.3&flash=false' failed: WebSocket is closed before the connection is established. 