@if (session('success'))
    <div class="mb-6 rounded-2xl border border-emerald-200 dark:border-emerald-900 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-950/50 dark:to-teal-950/50 p-4 flex items-start gap-3 shadow-sm animate-fade-in-up">
        <div class="w-10 h-10 rounded-xl grid place-items-center bg-emerald-500 text-white flex-shrink-0 shadow-md shadow-emerald-500/30">
            <i class="bi bi-check-lg text-lg"></i>
        </div>
        <div class="flex-grow">
            <p class="font-bold text-emerald-900 dark:text-emerald-100">¡Operación exitosa!</p>
            <p class="text-sm text-emerald-700 dark:text-emerald-300">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 rounded-2xl border border-rose-200 dark:border-rose-900 bg-gradient-to-r from-rose-50 to-red-50 dark:from-rose-950/50 dark:to-red-950/50 p-4 flex items-start gap-3 shadow-sm animate-fade-in-up">
        <div class="w-10 h-10 rounded-xl grid place-items-center bg-rose-500 text-white flex-shrink-0 shadow-md shadow-rose-500/30">
            <i class="bi bi-x-lg text-lg"></i>
        </div>
        <div class="flex-grow">
            <p class="font-bold text-rose-900 dark:text-rose-100">Algo salió mal</p>
            <p class="text-sm text-rose-700 dark:text-rose-300">{{ session('error') }}</p>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-amber-200 dark:border-amber-900 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/50 dark:to-orange-950/50 p-4 flex items-start gap-3 shadow-sm animate-fade-in-up">
        <div class="w-10 h-10 rounded-xl grid place-items-center bg-amber-500 text-white flex-shrink-0 shadow-md shadow-amber-500/30">
            <i class="bi bi-exclamation-triangle-fill text-lg"></i>
        </div>
        <div class="flex-grow">
            <p class="font-bold text-amber-900 dark:text-amber-100">Revisa los siguientes errores</p>
            <ul class="text-sm text-amber-800 dark:text-amber-200 list-disc list-inside mt-1 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
