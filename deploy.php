<?php

namespace Deployer;

require 'recipe/laravel.php';

set('application', 'simgtkqomarul');
set('repository', 'git@github.com:isnunasrudin/simgtkqomarul.git');

host('qomarul')
    ->set('remote_user', 'root')
    ->set('deploy_path', '/srv/gtkqomarul');

task('docker:build', function () {
    run('cd {{deploy_path}}/release && docker compose build');
});
task('docker:up', function () {
    run('cd {{deploy_path}}/release && docker compose up -d');
});
task('docker:composer', function () {
    run('cd {{deploy_path}}/release && docker compose exec -T app composer install --no-dev --optimize-autoloader');
});
task('docker:artisan', function () {
    run('cd {{deploy_path}}/release && docker compose exec -T app php artisan {{command}}');
});

after('deploy:update_code', 'docker:build');
after('docker:build', 'docker:up');

task('artisan:migrate', function () {
    invoke('docker:artisan', ['command' => 'migrate --force']);
});

task('artisan:config:cache', function () {
    invoke('docker:artisan', ['command' => 'config:cache']);
});

task('artisan:route:cache', function () {
    invoke('docker:artisan', ['command' => 'route:cache']);
});

task('artisan:view:cache', function () {
    invoke('docker:artisan', ['command' => 'view:cache']);
});

task('artisan:event:cache', function () {
    invoke('docker:artisan', ['command' => 'event:cache']);
});

task('artisan:storage:link', function () {
    invoke('docker:artisan', ['command' => 'storage:link']);
});

task('deploy:vendors', function () {
    invoke('docker:composer');
});