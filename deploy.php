<?php

namespace Deployer;

require 'recipe/laravel.php';

set('application', 'simgtkqomarul');
set('repository', 'git@github.com:isnunasrudin/simgtkqomarul.git');

host('qomarul')
    ->set('remote_user', 'root')
    ->set('deploy_path', '/srv/simgtkqomarul');

task('docker:build', function () {
    run('cd {{deploy_path}}/release && docker compose build');
});
task('docker:up', function () {
    run('cd {{deploy_path}}/release && docker compose up -d');
});
task('docker:composer', function () {
    run('cd {{deploy_path}}/release && docker compose exec -T app sh -c "cd {{deploy_path}}/release && composer install --no-dev --optimize-autoloader"');
});
task('docker:artisan', function () {
    $command = input('artisan_command');
    run('cd {{deploy_path}}/release && docker compose exec -T app sh -c "cd {{deploy_path}}/release && php artisan '.$command.'"');
});

after('deploy:update_code', 'docker:build');
after('docker:build', 'docker:up');

task('artisan:migrate', function () {
    set('artisan_command', 'migrate --force');
    invoke('docker:artisan');
});

task('artisan:config:cache', function () {
    set('artisan_command', 'config:cache');
    invoke('docker:artisan');
});

task('artisan:route:cache', function () {
    set('artisan_command', 'route:cache');
    invoke('docker:artisan');
});

task('artisan:view:cache', function () {
    set('artisan_command', 'view:cache');
    invoke('docker:artisan');
});

task('artisan:event:cache', function () {
    set('artisan_command', 'event:cache');
    invoke('docker:artisan');
});

task('artisan:storage:link', function () {
    set('artisan_command', 'storage:link');
    invoke('docker:artisan');
});

task('deploy:vendors', function () {
    invoke('docker:composer');
});

after('deploy:failed', 'deploy:unlock');