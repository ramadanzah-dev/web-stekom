<?php

declare(strict_types=1);

use App\Controllers\Admin\AdminAuthController;
use App\Controllers\Admin\AdminBeritaController;
use App\Controllers\Admin\AdminDashboardController;
use App\Controllers\Admin\AdminDivisiController;
use App\Controllers\Admin\AdminPengaturanController;
use App\Controllers\Admin\AdminPengurusController;
use App\Controllers\BeritaController;
use App\Controllers\HomeController;
use App\Controllers\OrganisasiController;

/** @var App\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('/berita', [BeritaController::class, 'index']);
$router->get('/berita/{slug}', [BeritaController::class, 'show']);
$router->get('/organisasi', [OrganisasiController::class, 'index']);

// Autentikasi admin.
$router->get('/admin/login', [AdminAuthController::class, 'showLogin']);
$router->post('/admin/login', [AdminAuthController::class, 'login']);
$router->post('/admin/logout', [AdminAuthController::class, 'logout']);

// Dashboard.
$router->get('/admin', [AdminDashboardController::class, 'index']);

// CRUD berita.
$router->get('/admin/berita', [AdminBeritaController::class, 'index']);
$router->get('/admin/berita/create', [AdminBeritaController::class, 'create']);
$router->post('/admin/berita', [AdminBeritaController::class, 'store']);
$router->get('/admin/berita/{id}/edit', [AdminBeritaController::class, 'edit']);
$router->post('/admin/berita/{id}', [AdminBeritaController::class, 'update']);
$router->post('/admin/berita/{id}/delete', [AdminBeritaController::class, 'destroy']);

// CRUD pengurus.
$router->get('/admin/pengurus', [AdminPengurusController::class, 'index']);
$router->get('/admin/pengurus/create', [AdminPengurusController::class, 'create']);
$router->post('/admin/pengurus', [AdminPengurusController::class, 'store']);
$router->get('/admin/pengurus/{id}/edit', [AdminPengurusController::class, 'edit']);
$router->post('/admin/pengurus/{id}', [AdminPengurusController::class, 'update']);
$router->post('/admin/pengurus/{id}/delete', [AdminPengurusController::class, 'destroy']);

// CRUD divisi.
$router->get('/admin/divisi', [AdminDivisiController::class, 'index']);
$router->get('/admin/divisi/create', [AdminDivisiController::class, 'create']);
$router->post('/admin/divisi', [AdminDivisiController::class, 'store']);
$router->get('/admin/divisi/{id}/edit', [AdminDivisiController::class, 'edit']);
$router->post('/admin/divisi/{id}', [AdminDivisiController::class, 'update']);
$router->post('/admin/divisi/{id}/delete', [AdminDivisiController::class, 'destroy']);

// Pengaturan situs.
$router->get('/admin/pengaturan', [AdminPengaturanController::class, 'index']);
$router->post('/admin/pengaturan', [AdminPengaturanController::class, 'update']);
$router->post('/admin/pengaturan/reset', [AdminPengaturanController::class, 'reset']);
