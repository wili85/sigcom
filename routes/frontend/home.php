<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\SolicitudController;
use App\Http\Controllers\Frontend\PersonaController;
use App\Http\Controllers\Frontend\MantenController;
use App\Http\Controllers\Frontend\PrestamoController;
use App\Http\Controllers\Frontend\CronogramaController;
use App\Http\Controllers\Frontend\FacturaController;
use App\Http\Controllers\Frontend\ReporteController;
use App\Http\Controllers\Frontend\GraficoController;
use App\Http\Controllers\Frontend\EmpresaController;
use App\Http\Controllers\Frontend\CompraController;
use App\Http\Controllers\Frontend\ProduccionController;
use App\Http\Controllers\Frontend\VentaController;
/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('solicitud/create', [SolicitudController::class, 'create'])->name('solicitud.create');
Route::post('solicitud/listar_solicitud_ajax', [SolicitudController::class, 'listar_solicitud_ajax'])->name('solicitud.listar_solicitud_ajax');
Route::post('solicitud/send', [SolicitudController::class, 'send'])->name('solicitud.send');
Route::post('solicitud/send_solicitud_aprobar', [SolicitudController::class, 'send_solicitud_aprobar'])->name('solicitud.send_solicitud_aprobar');
Route::get('solicitud/obtener_solicitud/{id}', [SolicitudController::class, 'obtener_solicitud'])->name('solicitud.obtener_solicitud');
Route::get('solicitud/modal_solicitud/{id}', [SolicitudController::class, 'modal_solicitud'])->name('solicitud.modal_solicitud');
Route::get('solicitud/create_desembolso', [SolicitudController::class, 'create_desembolso'])->name('solicitud.create_desembolso');
Route::post('solicitud/listar_desembolso_ajax', [SolicitudController::class, 'listar_desembolso_ajax'])->name('solicitud.listar_desembolso_ajax');

Route::get('solicitud/create_cronograma', [SolicitudController::class, 'create_cronograma'])->name('solicitud.create_cronograma');

Route::get('persona/obtener_persona/{tipo_documento}/{numero_documento}', [PersonaController::class, 'obtener_persona'])->name('persona.obtener_persona');

Route::get('manten/create', [MantenController::class, 'create'])->name('manten.create'); 
Route::post('manten/listar_maestra_ajax', [MantenController::class, 'listar_maestra_ajax'])->name('manten.listar_maestra_ajax');
Route::post('manten/send', [MantenController::class, 'send'])->name('manten.send');
Route::get('manten/obtener_maestra/{id}', [MantenController::class, 'obtener_maestra'])->name('manten.obtener_maestra');
Route::get('manten/create_color', [MantenController::class, 'create_color'])->name('manten.create_color');
Route::post('manten/send_color', [MantenController::class, 'send_color'])->name('manten.send_color');
Route::get('manten/send_restablecer_color', [MantenController::class, 'send_restablecer_color'])->name('manten.send_restablecer_color');

Route::post('prestamo/send', [PrestamoController::class, 'send'])->name('prestamo.send');
Route::get('prestamo/obtener_desembolso/{id}', [PrestamoController::class, 'obtener_desembolso'])->name('prestamo.obtener_desembolso');
Route::get('prestamo/obtener_cronograma/{id}', [PrestamoController::class, 'obtener_cronograma'])->name('prestamo.obtener_cronograma');
Route::post('prestamo/upload', [PrestamoController::class, 'upload'])->name('prestamo.upload');

Route::get('prestamo/test', [PrestamoController::class, 'test'])->name('prestamo.test');
Route::get('prestamo/test2', [PrestamoController::class, 'test2'])->name('prestamo.test2');
Route::get('prestamo/test3', [PrestamoController::class, 'test3'])->name('prestamo.test3');

Route::get('cronograma/create_ingreso', [CronogramaController::class, 'create_ingreso'])->name('cronograma.create_ingreso');
Route::get('cronograma/obtener_cronograma/{tipo_documento}/{persona_id}', [CronogramaController::class, 'obtener_cronograma'])->name('cronograma.obtener_cronograma');
Route::get('cronograma/obtener_pago/{tipo_documento}/{persona_id}', [CronogramaController::class, 'obtener_pago'])->name('cronograma.obtener_pago');
Route::get('cronograma/modal_cronograma_factura/{id}', [CronogramaController::class, 'modal_cronograma_factura'])->name('cronograma.modal_cronograma_factura');

Route::post('factura/create', [FacturaController::class, 'create'])->name('factura.create');
Route::post('factura/send', [FacturaController::class, 'send'])->name('factura.send');
Route::get('factura/{id}', [FacturaController::class, 'show'])->name('factura.show');
//Route::get('factura', [FacturaController::class, 'index'])->name('factura.all');
//Route::post('factura/listar_factura_ajax', [FacturaController::class, 'listar_factura_ajax'])->name('factura.listar_factura_ajax');
//Route::get('factura/exportar_factura/{fecha_ini}/{fecha_fin}/{tipo_documento}/{serie}/{numero}/{razon_social}/{estado_pago}/{anulado}', [FacturaController::class, 'exportar_factura'])->name('factura.exportar_factura');

Route::get('reporte/consulta_consolidado', [ReporteController::class, 'consulta_consolidado'])->name('reporte.consulta_consolidado');
Route::get('reporte/consulta_individual', [ReporteController::class, 'consulta_individual'])->name('reporte.consulta_individual');
Route::get('reporte/consulta_vencidos', [ReporteController::class, 'consulta_vencidos'])->name('reporte.consulta_vencidos');
Route::get('reporte/resumen_ingreso', [ReporteController::class, 'resumen_ingreso'])->name('reporte.resumen_ingreso');

Route::post('reporte/listar_consolidado_ajax', [ReporteController::class, 'listar_consolidado_ajax'])->name('reporte.listar_consolidado_ajax');
Route::get('reporte/exportar_consolidado/{numero_documento}/{afiliado}/{fecha_desde}/{fecha_hasta}/{id_estado}', [ReporteController::class, 'exportar_consolidado'])->name('reporte.exportar_consolidado');
Route::get('reporte/obtener_solicitud_cronograma/{id}', [ReporteController::class, 'obtener_solicitud_cronograma'])->name('reporte.obtener_solicitud_cronograma');
Route::get('reporte/exportar_individual/{id}', [ReporteController::class, 'exportar_individual'])->name('reporte.exportar_individual');
Route::post('reporte/listar_vencidos_ajax', [ReporteController::class, 'listar_vencidos_ajax'])->name('reporte.listar_vencidos_ajax');
Route::get('reporte/obtener_solicitud_cronograma_vencidos/{id}', [ReporteController::class, 'obtener_solicitud_cronograma_vencidos'])->name('reporte.obtener_solicitud_cronograma_vencidos');
Route::get('reporte/exportar_vencidos/{numero_documento}/{afiliado}/{fecha_desde}/{fecha_hasta}', [ReporteController::class, 'exportar_vencidos'])->name('reporte.exportar_vencidos');
Route::get('reporte/exportar_individual_vencidos/{id}', [ReporteController::class, 'exportar_individual_vencidos'])->name('reporte.exportar_individual_vencidos');
Route::post('reporte/listar_resumen_ingreso_ajax', [ReporteController::class, 'listar_resumen_ingreso_ajax'])->name('reporte.listar_resumen_ingreso_ajax');
Route::get('reporte/obtener_resumen_ingreso_fecha/{id}', [ReporteController::class, 'obtener_resumen_ingreso_fecha'])->name('reporte.obtener_resumen_ingreso_fecha');
Route::get('reporte/exportar_resumen_ingreso/{fecha_desde}/{fecha_hasta}', [ReporteController::class, 'exportar_resumen_ingreso'])->name('reporte.exportar_resumen_ingreso');
Route::get('reporte/exportar_individual_resumen_ingreso/{fecha}', [ReporteController::class, 'exportar_individual_resumen_ingreso'])->name('reporte.exportar_individual_resumen_ingreso');

Route::get('grafico/all/{anio?}', [GraficoController::class, 'all'])->name('grafico.all');

/*********************************/

Route::get('persona/listar', [PersonaController::class, 'listar'])->name('persona.listar');
Route::post('persona/listar_persona_ajax', [PersonaController::class, 'listar_persona_ajax'])->name('persona.listar_persona_ajax');
Route::get('persona/obtener_tarifa/{id}', [PersonaController::class, 'obtener_tarifa'])->name('prestamo.obtener_tarifa');

Route::get('empresa/listar', [EmpresaController::class, 'listar'])->name('empresa.listar');
Route::post('empresa/listar_empresa_ajax', [EmpresaController::class, 'listar_empresa_ajax'])->name('empresa.listar_empresa_ajax');
Route::get('empresa/obtener_vehiculo/{id}', [EmpresaController::class, 'obtener_vehiculo'])->name('empresa.obtener_vehiculo');
Route::get('empresa/obtener_chofer/{id}', [EmpresaController::class, 'obtener_chofer'])->name('empresa.obtener_chofer');

Route::get('compra/listar', [CompraController::class, 'listar'])->name('compra.listar');
Route::post('compra/listar_compra_ajax', [CompraController::class, 'listar_compra_ajax'])->name('compra.listar_compra_ajax');

Route::get('produccion/listar', [ProduccionController::class, 'listar'])->name('produccion.listar');
Route::post('produccion/listar_produccion_ajax', [ProduccionController::class, 'listar_produccion_ajax'])->name('produccion.listar_produccion_ajax');

Route::get('venta/listar', [VentaController::class, 'listar'])->name('venta.listar');
Route::post('venta/listar_venta_ajax', [VentaController::class, 'listar_venta_ajax'])->name('venta.listar_venta_ajax');

/*********test*************/
Route::get('solicitud/create_test', [SolicitudController::class, 'create_test'])->name('solicitud.create_test');
Route::get('/prestamo/css', function() {
	$contents = ".navbar-nav .nav-link{color:#ffffff!important}
				.breadcrumb{border-radius:initial!important}";
    $response = Response::make($contents);
    $response->header('Content-Type', 'text/css');
    return $response;
});

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        // User Dashboard Specific
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User Account Specific
        Route::get('account', [AccountController::class, 'index'])->name('account');

        // User Profile Specific
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });
});
