import type { Module } from '../types/Module';

import tr from '@/services/TranslationService'

interface ModuleCardProps {
    module: Module;
}

export default function ModuleCard({ module }: ModuleCardProps) {
    return (
        <article className="rounded-2xl border border-slate-700 bg-slate-900/70 p-6 shadow-lg">
            <div className="flex items-start justify-between gap-4">
                <div>
                    <h2 className="text-xl font-semibold text-white">
                        {module.name}
                    </h2>

                    <p className="mt-2 text-sm text-slate-400">
                        {module.description}
                    </p>
                </div>

                <span
                    className={[
                        'rounded-full px-3 py-1 text-xs font-medium',
                        module.enabled
                            ? 'bg-emerald-500/15 text-emerald-400'
                            : 'bg-slate-700 text-slate-400',
                    ].join(' ')}
                >
                    {module.enabled ? 'Enabled' : 'Disabled'}
                </span>
            </div>

            <div className="mt-6 flex items-center justify-between border-t border-slate-800 pt-4">
                <span className="text-sm text-slate-500">
                    v{module.version}
                </span>

                <button
                    type="button"
                    className="rounded-lg border border-slate-600 px-4 py-2 text-sm text-slate-200 transition hover:bg-slate-800"
                >
                    { tr.t('modulemanager.settings') }
                </button>
            </div>
        </article>
    );
}