import React, { useState } from 'react'

export default function Navbar() {
    const [isDark, setIsDark] = useState(true)

    return (
        <nav className="bg-white dark:bg-slate-950 border-b p-4">
            <div className="max-w-7xl mx-auto flex justify-between items-center">
                <h1 className="text-2xl font-bold text-purple-600">EasyMove</h1>
                <button
                    onClick={() => setIsDark(!isDark)}
                    className="px-4 py-2 bg-purple-600 text-white rounded-lg"
                >
                    {isDark ? '☀️' : '🌙'}
                </button>
            </div>
        </nav>
    )
}


