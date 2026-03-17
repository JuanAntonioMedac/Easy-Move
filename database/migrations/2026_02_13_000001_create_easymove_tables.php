<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones - Crear todas las tablas de EasyMove
     */
    public function up(): void
    {
        // ====================================================================
        // Tabla: usuarios
        // ====================================================================
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('fecha_registro')->useCurrent();
            $table->enum('rol', ['admin', 'usuario'])->default('usuario');
            $table->json('preferencias')->nullable();
            $table->timestamps();
            $table->index('email');
            $table->index('rol');
        });

        // ====================================================================
        // Tabla: ubicaciones
        // ====================================================================
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->increments('id_ubicacion');
            $table->string('codigo_postal', 10);
            $table->string('ciudad', 100);
            $table->string('provincia', 100);
            $table->integer('numero')->nullable();
            $table->timestamps();
            $table->unique(['codigo_postal', 'ciudad', 'provincia', 'numero']);
            $table->index('codigo_postal');
            $table->index('ciudad');
        });

        // ====================================================================
        // Tabla: tipos_servicios
        // ====================================================================
        Schema::create('tipos_servicios', function (Blueprint $table) {
            $table->increments('id_tipo_servicio');
            $table->string('nombre', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->index('nombre');
        });

        // ====================================================================
        // Tabla: proveedores
        // ====================================================================
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id_proveedor');
            $table->string('nombre', 255)->unique();
            $table->string('web')->nullable();
            $table->string('logo')->nullable();
            $table->enum('tipo_proveedor', ['telefonica', 'luz', 'gas', 'mixto']);
            $table->boolean('api_disponible')->default(false);
            $table->timestamps();
            $table->index('nombre');
            $table->index('tipo_proveedor');
        });

        // ====================================================================
        // Tabla: servicios
        // ====================================================================
        Schema::create('servicios', function (Blueprint $table) {
            $table->increments('id_servicio');
            $table->string('nombre_servicio', 255);
            $table->text('descripcion')->nullable();
            $table->unsignedInteger('id_tipo_servicio');
            $table->unsignedInteger('id_proveedor');
            $table->timestamps();
            $table->foreign('id_tipo_servicio')
                ->references('id_tipo_servicio')
                ->on('tipos_servicios')
                ->onDelete('cascade');
            $table->foreign('id_proveedor')
                ->references('id_proveedor')
                ->on('proveedores')
                ->onDelete('cascade');
            $table->index('id_tipo_servicio');
            $table->index('id_proveedor');
        });

        // ====================================================================
        // Tabla: tarifas
        // ====================================================================
        Schema::create('tarifas', function (Blueprint $table) {
            $table->increments('id_tarifa');
            $table->string('nombre_tarifa', 255);
            $table->decimal('precio', 10, 2);
            $table->string('unidad_precio', 50)->nullable();
            $table->string('permanencia', 100)->nullable();
            $table->text('condiciones')->nullable();
            $table->string('url_oferta_externa')->nullable();
            $table->unsignedInteger('id_servicio');
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
            $table->foreign('id_servicio')
                ->references('id_servicio')
                ->on('servicios')
                ->onDelete('cascade');
            $table->index('id_servicio');
            $table->index('precio');
            $table->index('fecha_actualizacion');
        });

        // ====================================================================
        // Tabla: disponibilidad
        // ====================================================================
        Schema::create('disponibilidad', function (Blueprint $table) {
            $table->increments('id_disponibilidad');
            $table->unsignedInteger('id_tarifa');
            $table->unsignedInteger('id_ubicacion');
            $table->timestamps();
            $table->foreign('id_tarifa')
                ->references('id_tarifa')
                ->on('tarifas')
                ->onDelete('cascade');
            $table->foreign('id_ubicacion')
                ->references('id_ubicacion')
                ->on('ubicaciones')
                ->onDelete('cascade');
            $table->unique(['id_tarifa', 'id_ubicacion']);
            $table->index('id_tarifa');
            $table->index('id_ubicacion');
        });

        // ====================================================================
        // Tabla: comparaciones
        // ====================================================================
        Schema::create('comparaciones', function (Blueprint $table) {
            $table->increments('id_comparacion');
            $table->timestamp('fecha')->useCurrent();
            $table->unsignedInteger('id_usuario')->nullable();
            $table->unsignedInteger('id_ubicacion');
            $table->unsignedInteger('id_tipo_servicio');
            $table->timestamps();
            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('usuarios')
                ->onDelete('set null');
            $table->foreign('id_ubicacion')
                ->references('id_ubicacion')
                ->on('ubicaciones')
                ->onDelete('cascade');
            $table->foreign('id_tipo_servicio')
                ->references('id_tipo_servicio')
                ->on('tipos_servicios')
                ->onDelete('cascade');
            $table->index('id_usuario');
            $table->index('id_ubicacion');
            $table->index('id_tipo_servicio');
            $table->index('fecha');
        });

        // ====================================================================
        // Tabla pivote: comparacion_tarifas
        // ====================================================================
        Schema::create('comparacion_tarifas', function (Blueprint $table) {
            $table->increments('id_comparacion_tarifa');
            $table->unsignedInteger('id_comparacion');
            $table->unsignedInteger('id_tarifa');
            $table->integer('posicion_resultado')->nullable();
            $table->timestamps();
            $table->foreign('id_comparacion')
                ->references('id_comparacion')
                ->on('comparaciones')
                ->onDelete('cascade');
            $table->foreign('id_tarifa')
                ->references('id_tarifa')
                ->on('tarifas')
                ->onDelete('cascade');
            $table->unique(['id_comparacion', 'id_tarifa']);
            $table->index('id_comparacion');
            $table->index('id_tarifa');
        });

        // ====================================================================
        // Índices adicionales de optimización
        // ====================================================================
        Schema::table('usuarios', function (Blueprint $table) {
            $table->index('fecha_registro');
        });

        Schema::table('tarifas', function (Blueprint $table) {
            $table->index(['id_servicio', 'precio']);
        });

        Schema::table('comparaciones', function (Blueprint $table) {
            $table->index(['id_usuario', 'fecha']);
        });
    }

    /**
     * Revertir las migraciones - Eliminar todas las tablas
     */
    public function down(): void
    {
        Schema::dropIfExists('comparacion_tarifas');
        Schema::dropIfExists('comparaciones');
        Schema::dropIfExists('disponibilidad');
        Schema::dropIfExists('tarifas');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('tipos_servicios');
        Schema::dropIfExists('ubicaciones');
        Schema::dropIfExists('usuarios');
    }
};
