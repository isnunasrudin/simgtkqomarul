<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:isnunasrudin/simgtkqomarul.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('qomarul')
    ->set('remote_user', 'root')
    ->set('deploy_path', '/srv/gtkqomarul');


task('deploy:vendors', function () {
    run('cd {{release_path}} && docker-compose exec -T app composer install --no-dev --optimize-autoloader');
});

task('artisan:storage:link', function () {
    run('cd {{release_path}} && docker-compose exec -T app php artisan storage:link');
});

task('artisan:config:cache', function () {
    run('cd {{release_path}} && docker-compose exec -T app php artisan config:cache');
});

task('artisan:route:cache', function () {
    run('cd {{release_path}} && docker-compose exec -T app php artisan route:cache');
});

task('artisan:view:cache', function () {
    run('cd {{release_path}} && docker-compose exec -T app php artisan view:cache');
});

task('artisan:event:cache', function () {
    run('cd {{release_path}} && docker-compose exec -T app php artisan event:cache');
});

task('artisan:migrate', function () {
    run('cd {{release_path}} && docker-compose exec -T app php artisan migrate --force');
});

task('docker:down', function () {
    // Gunakan current_path karena aplikasi yang sedang jalan ada di sana
    run('if [ -d {{current_path}} ]; then cd {{current_path}} && docker-compose exec -T app php artisan down; fi');
});

task('docker:up', function () {
    run('cd {{current_path}} && docker-compose exec -T app php artisan up');
});

before('deploy:prepare', 'docker:down');
after('deploy:vendors', 'artisan:storage:link');
after('artisan:storage:link', 'artisan:config:cache');
after('artisan:config:cache', 'artisan:route:cache');
after('artisan:route:cache', 'artisan:view:cache');
after('artisan:view:cache', 'artisan:event:cache');
after('artisan:event:cache', 'artisan:migrate');

after('deploy:symlink', 'docker:up');
after('deploy:failed', 'deploy:unlock');
