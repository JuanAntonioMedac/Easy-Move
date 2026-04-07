import React, { useState, useEffect } from 'react';
import { Download, Mail, Lock, Loader } from 'lucide-react';
import Navbar from '../components/Navbar';

/**
 * Componente Home
 *
 * Features:
 * - Formulario elegante para CP y Tipo de Servicio
 * - Lista de resultados en cards
 * - Componente Blur/Lock para usuarios no autenticados
 * - Botones de descarga PDF y envío por email
 *
 * @param {Object} user - Objeto del usuario autenticado o null
 * @param {Array} tiposServicios - Lista de tipos de servicios disponibles
 */
export default function Home({ user = null, tiposServicios = [] }) {
    const [codigoPostal, setCodigoPostal] = useState('');
    const [tipoServicio, setTipoServicio] = useState('');
    const [ciudad, setCiudad] = useState('');
    const [provincia, setProvincia] = useState('');
    const [loading, setLoading] = useState(false);
    const [results, setResults] = useState(null);
    const [showEmailModal, setShowEmailModal] = useState(false);
    const [emailForm, setEmailForm] = useState({ email: user?.email || '' });

    const handleSearch = async (e) => {
        e.preventDefault();
        if (!codigoPostal || !tipoServicio) return;

        setLoading(true);
        try {
            const response = await fetch('/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({
                codigo_postal: codigoPostal,
                id_tipo_servicio: parseInt(tipoServicio), // ← Convierte a integer
                ciudad,
                provincia,
            }),
            });

            const data = await response.json();
            if (data.success) {
                setResults(data.data);
            } else {
                alert('Error en la búsqueda: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al realizar la búsqueda');
        } finally {
            setLoading(false);
        }
    };

    const handleExportPdf = async () => {
        if (!results?.comparacion_id) return;
        try {
            const response = await fetch('/export-pdf', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({ comparacion_id: results.comparacion_id }),
            });

            if (response.ok) {
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `comparativa-tarifas-${new Date().toISOString().split('T')[0]}.pdf`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al descargar el PDF');
        }
    };

    const handleSendEmail = async (e) => {
        e.preventDefault();
        if (!results?.comparacion_id) return;

        try {
            const response = await fetch('/send-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({
                    comparacion_id: results.comparacion_id,
                    email: emailForm.email,
                }),
            });

            const data = await response.json();
            if (data.success) {
                alert(data.message);
                setShowEmailModal(false);
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al enviar email');
        }
    };

    const hasMoreResults = results?.meta?.is_limited && results?.meta?.total_resultados > 2;

    return (
        <div className="min-h-screen bg-gray-900 dark:bg-gray-950 text-white">
            <Navbar user={user} />

            {/* Hero Section con Formulario */}
            <section className="py-12 px-4 sm:px-6 lg:px-8">
                <div className="max-w-2xl mx-auto">
                    <h1 className="text-4xl md:text-5xl font-bold text-center mb-3 bg-gradient-to-r from-purple-600 to-purple-400 bg-clip-text text-transparent">
                        Comparador de Tarifas
                    </h1>
                    <p className="text-gray-400 text-center mb-8">
                        Encuentra las mejores tarifas de telefonía, luz y gas en tu zona
                    </p>

                    {/* Formulario de Búsqueda */}
                    <form onSubmit={handleSearch} className="bg-gray-800/50 border border-gray-700 rounded-lg p-6 space-y-4">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-300 mb-2">Código Postal</label>
                                <input
                                    type="text"
                                    value={codigoPostal}
                                    onChange={(e) => setCodigoPostal(e.target.value)}
                                    placeholder="Ej: 28001"
                                    className="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-purple-600 transition"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-300 mb-2">Tipo de Servicio</label>
                                <select
                                    value={tipoServicio}
                                    onChange={(e) => setTipoServicio(e.target.value)}
                                    className="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-purple-600 transition"
                                >
                                    <option value="">Selecciona un servicio</option>
                                    {tiposServicios.map((tipo) => (
                                        <option key={tipo.id_tipo_servicio} value={tipo.id_tipo_servicio}>
                                            {tipo.nombre}
                                        </option>
                                    ))}
                                </select>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-300 mb-2">Ciudad (Opcional)</label>
                                <input
                                    type="text"
                                    value={ciudad}
                                    onChange={(e) => setCiudad(e.target.value)}
                                    placeholder="Ej: Madrid"
                                    className="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-purple-600 transition"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-300 mb-2">Provincia (Opcional)</label>
                                <input
                                    type="text"
                                    value={provincia}
                                    onChange={(e) => setProvincia(e.target.value)}
                                    placeholder="Ej: Madrid"
                                    className="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-purple-600 transition"
                                />
                            </div>
                        </div>

                        <button
                            type="submit"
                            disabled={loading}
                            className="w-full px-6 py-3 bg-purple-600 hover:bg-purple-700 disabled:bg-gray-600 text-white rounded-lg transition font-medium flex items-center justify-center space-x-2"
                        >
                            {loading ? (
                                <>
                                    <Loader className="w-5 h-5 animate-spin" />
                                    <span>Buscando...</span>
                                </>
                            ) : (
                                <span>Comparar Tarifas</span>
                            )}
                        </button>
                    </form>
                </div>
            </section>

            {/* Resultados */}
            {results && (
                <section className="py-12 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-6xl mx-auto">
                        <h2 className="text-2xl font-bold mb-6 text-gray-200">
                            Resultados en {results.ubicacion.ciudad} ({results.ubicacion.codigo_postal})
                        </h2>

                        {/* Botones de Acciones (Solo si autenticado) */}
                        {user && (
                            <div className="mb-6 flex flex-wrap gap-4">
                                <button
                                    onClick={handleExportPdf}
                                    className="flex items-center space-x-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg transition"
                                >
                                    <Download className="w-5 h-5" />
                                    <span>Descargar PDF</span>
                                </button>

                                <button
                                    onClick={() => setShowEmailModal(true)}
                                    className="flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition"
                                >
                                    <Mail className="w-5 h-5" />
                                    <span>Enviar por Email</span>
                                </button>
                            </div>
                        )}

                        {/* Cards de Tarifas */}
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {results.tarifas.map((tarifa, index) => (
                                <div key={tarifa.id_tarifa} className="bg-gray-800/50 border border-gray-700 rounded-lg p-6 hover:border-purple-600/50 transition">
                                    {/* Posición */}
                                    <div className="mb-4">
                                        <span className="inline-block px-3 py-1 bg-purple-600/20 text-purple-400 text-sm font-medium rounded-full">
                                            #{index + 1}
                                        </span>
                                    </div>

                                    {/* Logo del Proveedor */}
                                    {tarifa.proveedor.logo && (
                                        <img
                                            src={tarifa.proveedor.logo}
                                            alt={tarifa.proveedor.nombre}
                                            className="h-12 mb-4 object-contain"
                                        />
                                    )}

                                    {/* Nombre del Proveedor */}
                                    <h3 className="text-lg font-bold text-white mb-2">{tarifa.proveedor.nombre}</h3>

                                    {/* Nombre de la Tarifa */}
                                    <p className="text-gray-400 text-sm mb-4">{tarifa.nombre_tarifa}</p>

                                    {/* Precio destacado */}
                                    <div className="mb-4 py-4 border-y border-gray-700">
                                        <p className="text-3xl font-bold text-purple-400">
                                            {tarifa.precio}€
                                            {tarifa.unidad_precio && <span className="text-lg text-gray-400">/{tarifa.unidad_precio}</span>}
                                        </p>
                                    </div>

                                    {/* Permanencia */}
                                    {tarifa.permanencia && (
                                        <p className="text-sm text-gray-400 mb-2">
                                            <strong>Permanencia:</strong> {tarifa.permanencia}
                                        </p>
                                    )}

                                    {/* Condiciones */}
                                    {tarifa.condiciones && (
                                        <details className="mb-4">
                                            <summary className="text-sm text-gray-400 cursor-pointer hover:text-white transition">
                                                Ver condiciones
                                            </summary>
                                            <p className="text-sm text-gray-500 mt-2">{tarifa.condiciones}</p>
                                        </details>
                                    )}

                                    {/* Botón a oferta */}
                                    {tarifa.url_oferta_externa && (
                                        <a
                                            href={tarifa.url_oferta_externa}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="block w-full text-center px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition text-sm font-medium text-white"
                                        >
                                            Ver oferta →
                                        </a>
                                    )}
                                </div>
                            ))}
                        </div>

                        {/* Componente Blur/Lock para Invitados */}
                        {hasMoreResults && (
                            <div className="relative mt-8 pt-8 border-t border-gray-700">
                                <div className="absolute inset-0 bg-gradient-to-b from-transparent via-gray-900 to-gray-950 backdrop-blur-md rounded-lg flex items-center justify-center">
                                    <div className="text-center">
                                        <Lock className="w-12 h-12 text-purple-600 mx-auto mb-4" />
                                        <h3 className="text-xl font-bold text-white mb-2">¡Descubre más ofertas!</h3>
                                        <p className="text-gray-400 mb-4">
                                            Regístrate para ver {results.meta.total_resultados} ofertas y descargar la comparativa completa
                                        </p>
                                        <a
                                            href="/register"
                                            className="inline-block px-6 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg transition font-medium"
                                        >
                                            Registrarse Gratis
                                        </a>
                                    </div>
                                </div>

                                {/* Cards con blur debajo */}
                                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 opacity-50 pointer-events-none">
                                    {results.tarifas.map((tarifa) => (
                                        <div key={`blur-${tarifa.id_tarifa}`} className="bg-gray-800/50 border border-gray-700 rounded-lg p-6 h-48" />
                                    ))}
                                </div>
                            </div>
                        )}

                        {/* Texto informativo sobre limitación */}
                        {results.meta.is_limited && (
                            <div className="mt-8 p-4 bg-blue-600/10 border border-blue-600/30 rounded-lg">
                                <p className="text-sm text-blue-300">
                                    <strong>ℹ️ Versión vista previa:</strong> Estás viendo {results.meta.resultados_mostrados} de {results.meta.total_resultados} resultados disponibles.
                                    {!user && ' Inicia sesión para ver todos los resultados.'}
                                </p>
                            </div>
                        )}
                    </div>
                </section>
            )}

            {/* Modal de Email */}
            {showEmailModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                    <div className="bg-gray-900 rounded-lg shadow-lg max-w-md w-full mx-4 border border-gray-700">
                        <div className="p-6">
                            <h2 className="text-2xl font-bold text-white mb-2">Enviar Comparativa</h2>
                            <p className="text-gray-400 text-sm mb-6">Recibirás la comparativa en PDF por email</p>

                            <form onSubmit={handleSendEmail} className="space-y-4">
                                <div>
                                    <label className="block text-white text-sm font-medium mb-2">Email</label>
                                    <input
                                        type="email"
                                        value={emailForm.email}
                                        onChange={(e) => setEmailForm({ email: e.target.value })}
                                        placeholder="tu@email.com"
                                        className="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-purple-600 transition"
                                        required
                                    />
                                </div>

                                <button
                                    type="submit"
                                    className="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition font-medium"
                                >
                                    Enviar
                                </button>
                            </form>
                        </div>

                        <div className="px-6 py-4 border-t border-gray-700 bg-gray-800/30">
                            <button
                                onClick={() => setShowEmailModal(false)}
                                className="w-full px-4 py-2 text-gray-300 hover:text-white rounded-lg transition"
                            >
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
