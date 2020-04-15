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
    php artisan migrate:generate tracking --connection=socialhub_mvp.tracking

	#############################

    php artisan infyom:scaffold Tracking --fromTable --tableName=tracking --connection=socialhub_mvp.tracking

    php artisan migrate:generate sales --connection=socialhub_mvp.sale

	php artisan infyom:scaffold MessageType --fromTable --tableName=message_types --connection=connectionName
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


# Commnads
nm-connection-editor

sudo install/scripts/chroot-to-pi.sh /dev/mmcblk0


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


## Create command abreviators
alias pu='clear && vendor/bin/phpunit'
alias pf='clear && vendor/bin/phpunit --filter'

// Git commit with message
function gcm() { git add . && git commit -m "$1"; }

alias npmd='npm run dev'

alias gc='git add . && git commit -m "Auto message"'
alias gp='git add . && git commit -m "Auto message" && git pull origin develop'
alias gpp='git pull origin develop && git push origin develop'

## Auto create laravel project .bash script
https://gist.github.com/DCzajkowski/9ebaeaa09d136e77497e060449b03171


## InfyonLabs skip options
php artisan infyom:scaffold User --skip=migration,repository,model,controllers,api_controller,scaffold_controller,scaffold_requests,routes,api_routes,scaffold_routes,views,menu,dump-autoload

skip options:
migration,repository,model,controllers,api_controller,scaffold_controller,scaffold_requests,routes,api_routes,scaffold_routes,views,tests,menu,dump-autoload


## Testing Laravel APP
CREATE DATABASE `socialhub_mvp.test` /*!40100 DEFAULT CHARACTER SET utf8 */;
php artisan migrate:refresh --database=socialhub_mvp.test --seed

# Set RPI 1 NGrok to in
http://localhost/RPI/tests
OR
http://[localdomine]/RPI/tests

# Create attendans tables
  Copy create dabase script of tables 4 and 5 from socialhub_mvp.chats DB
and create its into socialhub_mvp.chats.test

CREATE DATABASE `socialhub_mvp.chats.test` /*!40100 DEFAULT CHARACTER SET utf8 */;
Create base chats table
Create attendants base chats table


Configure test db connections into laravel database.php


## Add this to phpunit.xml between php tags
    <env name="DB_CONNECTION" value="socialhub_mvp.test"/>


# Laravel Autocomplete
https://stackoverflow.com/questions/48211622/intellisense-autocompletion-for-model-in-laravel-for-visual-studio-code-or-ano

https://github.com/bmewburn/vscode-intelephense/issues/123

https://github.com/bmewburn/vscode-intelephense/issues/708

https://github.com/barryvdh/laravel-ide-helper


# Laravel Maintenance Message
php artisan down --message="Upgrading Database" --retry=60
php artisan up


#  Ativar ambiente de test no RPi
export RPI_DEV=true ele usa o endpoint http://test.app.socialhub.pro/, e para voltar ao endpoint app.socialhub.pro só rodar export RPI_DEV=



## Utils Arquivo

# Procurar texto em pasta
grep -iRl "laravel-websockets" ./

# Procurar arquivo em pasta
find "xxx" .


arp -p
nmap -sn 192.168.0.0/24
sudo ssh pi@192.168.0.107


# Copy server log to local disk
scp albertord@app.socialhub.pro:/var/www/html/app.socialhub.pro/storage/logs/laravel.log /var/www/html/app.socialhub.local/storage/logs/laravel-server.log

scp /var/www/html/app.socialhub.local/storage/logs/laravel-server.log albertord@app.socialhub.pro:/var/www/html/app.socialhub.pro/storage/logs/laravel.log