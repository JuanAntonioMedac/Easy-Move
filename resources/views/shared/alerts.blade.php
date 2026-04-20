@if (session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 dark:bg-green-950 dark:border-green-800 dark:text-green-200 px-4 py-4 rounded-lg mb-6 flex items-start gap-3">
        <i class="bi bi-check-circle-fill mt-0.5 text-lg"></i>
        <div>
            <p class="font-medium">¡Éxito!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 dark:bg-red-950 dark:border-red-800 dark:text-red-200 px-4 py-4 rounded-lg mb-6 flex items-start gap-3">
        <i class="bi bi-exclamation-circle-fill mt-0.5 text-lg"></i>
        <div>
            <p class="font-medium">Error</p>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="bg-orange-50 border border-orange-200 text-orange-800 dark:bg-orange-950 dark:border-orange-800 dark:text-orange-200 px-4 py-4 rounded-lg mb-6 flex items-start gap-3">
        <i class="bi bi-exclamation-triangle-fill mt-0.5 text-lg"></i>
        <div>
            <p class="font-medium">Por favor revisa los errores</p>
            <ul class="text-sm list-disc list-inside mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
