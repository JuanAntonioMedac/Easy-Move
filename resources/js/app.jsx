import './bootstrap'
import '../css/app.css'
import React from 'react'
import { createRoot } from 'react-dom/client'
import { createInertiaApp } from '@inertiajs/react'

const appName = import.meta.env.VITE_APP_NAME || 'EasyMove'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        // Resolver para pages (Inertia pages)
        const pages = import.meta.glob('./pages/**/*.jsx', { eager: true })
        const page = pages[`./pages/${name}.jsx`]
        
        if (!page) {
            throw new Error(`Page "${name}" not found in ./pages.`)
        }
        
        return page.default || page
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />)
    },
    progress: {
        color: '#4f46e5',
    },
})
