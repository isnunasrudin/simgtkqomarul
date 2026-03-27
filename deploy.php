<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config dasar
set('application', 'simgtkqomarul');
set('repository', 'git@github.com:isnunasrudin/simgtkqomarul.git');

set('deploy_path', '/var/www/simgtkqomarul');

// Shared
add('shared_files', ['.env']);
add('shared_dirs', ['storage']);

// Writable
add('writable_dirs', ['storage']);

// Host
host('qomarul')
    ->set('remote_user', 'root')
    ->set('deploy_path', '/srv/gtkqomarul');

// ==========================
// Override default behavior
// ==========================

// ❌ disable vendor bawaan (karena pakai docker)
task('deploy:vendors', function () {
    // kosongkan (override)
});

// ==========================
// Custom Docker Tasks
// ==========================

// Build image
task('docker:build', function () {
    run('cd {{release_path}} && docker compose build');
});

// Up container
task('docker:up', function () {
    run('cd {{release_path}} && docker compose up -d');
});

// Composer di container
task('docker:composer', function () {
    run('cd {{release_path}} && docker compose exec -T app composer install --no-dev --optimize-autoloader');
});

// Artisan wrapper
task('docker:artisan', function () {
    run('cd {{release_path}} && docker compose exec -T app php artisan {{command}}');
});

// ==========================
// Hook ke lifecycle resmi
// ==========================

// Setelah code di-update → build & up container
after('deploy:update_code', 'docker:build');
after('docker:build', 'docker:up');

// Setelah container jalan → install vendor
after('docker:up', 'docker:composer');

// Replace artisan tasks ke container
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

// ==========================
// Main deploy flow (ikuti official)
// ==========================

desc('Deploy Laravel via Docker');
// setelah code diupdate
after('deploy:update_code', 'docker:build');

// setelah build → jalankan container
after('docker:build', 'docker:up');

// setelah container jalan → composer
after('docker:up', 'docker:composer');

after('deploy:failed', 'deploy:unlock');