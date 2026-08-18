import {useState} from 'react';
import {Link} from 'react-router-dom';
import {MoreVertical, Power, Settings, Trash2} from 'lucide-react';

import type {Module} from '../types/Module';
import tr from '@/services/TranslationService';

interface ModuleCardProps {
    module: Module;
    onToggle: (module: Module) => void;
    onDelete: (module: Module) => void;
    disabled?: boolean;
}

export default function ModuleCard({
                                       module,
                                       onToggle,
                                       onDelete,
                                       disabled = false,
                                   }: ModuleCardProps) {
    const [open, setOpen] = useState(false);

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
                    title={
                        module.enabled
                            ? tr.t('modulemanager.module_enabled')
                            : tr.t('modulemanager.module_disabled')
                    }
                    className={[
                        'block h-3 w-3 shrink-0 rounded-full',
                        module.enabled
                            ? 'bg-emerald-400'
                            : 'bg-slate-500',
                    ].join(' ')}
                />
            </div>

            <div className="mt-6 flex items-center justify-between border-t border-slate-800 pt-4">
                <span className="text-sm text-slate-500">
                    v{module.version}
                </span>

                <div className="relative">
                    <button
                        type="button"
                        disabled={disabled}
                        onClick={() => setOpen((value) => !value)}
                        className="rounded-lg border border-slate-600 p-2 text-slate-300 transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                        aria-label={tr.t('modulemanager.actions')}
                    >
                        <MoreVertical size={18} />
                    </button>

                    {open && (
                        <div className="absolute right-0 bottom-full z-20 mb-2 w-48 rounded-xl border border-slate-700 bg-slate-900 p-1 shadow-xl">
                            <Link
                                to={`/module-manager/modules/${module.alias}`}
                                onClick={() => setOpen(false)}
                                className="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-200 transition hover:bg-slate-800"
                            >
                                <Settings size={16} />

                                {tr.t('modulemanager.settings')}
                            </Link>

                            <button
                                type="button"
                                disabled={disabled}
                                onClick={() => {
                                    setOpen(false);
                                    onToggle(module);
                                }}
                                className="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-200 transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <Power size={16} />

                                {module.enabled
                                    ? tr.t('modulemanager.module_disable')
                                    : tr.t('modulemanager.module_enable')}
                            </button>

                            <div className="my-1 border-t border-slate-800" />

                            <button
                                type="button"
                                disabled={disabled}
                                onClick={() => {
                                    setOpen(false);
                                    onDelete(module);
                                }}
                                className="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-red-400 transition hover:bg-red-500/10 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <Trash2 size={16} />

                                {tr.t('modulemanager.module_delete_btn')}
                            </button>
                        </div>
                    )}
                </div>
            </div>
        </article>
    );
}