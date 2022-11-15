<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::post('logout', 'AuthController@logout');

Route::post('refresh', 'AuthController@refresh');

// MDB 22/JUL/2021
// Servicios de integración para clientes con plataformas existentes
// Funciona como single sign on
// Cliente inicial: NIP
Route::post('tenant_login', 'TenantAuthController@tenant_login');
Route::post('tenant_manage_user', 'TenantAuthController@tenant_manage_user');
Route::post('tenant_delete_user', 'TenantAuthController@tenant_delete_user');

