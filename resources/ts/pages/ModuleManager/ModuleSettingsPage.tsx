import {useEffect, useState} from 'react';
import {useParams} from 'react-router-dom';

import {
    getModuleSettings,
    setModuleAccess,
    type ModuleRole,
} from '../../api/moduleSettings';

import tr from '@/services/TranslationService';

export default function ModuleSettingsPage() {
    const {module} = useParams<{module: string}>();

    const [roles, setRoles] = useState<ModuleRole[]>([]);
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [errorKey, setErrorKey] = useState<string | null>(null);

    useEffect(() => {
        if (!module) {
            return;
        }

        getModuleSettings(module)
            .then((settings) => {
                setRoles(settings.roles);
            })
            .catch(() => {
                setErrorKey('modulemanager.settings_load_error');
            })
            .finally(() => {
                setLoading(false);
            });
    }, [module]);

    const toggleRole = (roleId: number) => {
        setRoles((current) =>
            current.map((role) =>
                role.id === roleId
                    ? {...role, access: !role.access}
                    : role,
            ),
        );
    };

    const handleSave = async () => {
        if (!module) {
            return;
        }

        setSaving(true);
        setErrorKey(null);

        try {
            const permissions = Object.fromEntries(
                roles.map((role) => [
                    role.id,
                    {
                        access: role.access,
                    },
                ]),
            );

            await setModuleAccess(module, permissions);
        } catch {
            setErrorKey('modulemanager.access_update_error');
        } finally {
            setSaving(false);
        }
    };

    if (loading) {
        return (
            <section>
                {tr.t('modulemanager.loading')}
            </section>
        );
    }

    if (errorKey) {
        return (
            <section>
                {tr.t(errorKey)}
            </section>
        );
    }

    return (
        <section className="space-y-8">
            <div>
                <h1 className="text-2xl font-semibold text-white">
                    {tr.t('modulemanager.settings')}
                </h1>

                <p className="mt-2 text-sm text-slate-400">
                    {module}
                </p>
            </div>

            <section className="rounded-2xl border border-slate-700 bg-slate-900/70 shadow-lg">
                <div className="border-b border-slate-800 px-6 py-5">
                    <h2 className="text-lg font-medium text-white">
                        {tr.t('modulemanager.access')}
                    </h2>

                    <p className="mt-1 text-sm text-slate-400">
                        {tr.t('modulemanager.access_description')}
                    </p>
                </div>

                <div className="divide-y divide-slate-800">
                    {roles.map((role) => (
                        <div
                            key={role.id}
                            className="flex items-center justify-between px-6 py-4"
                        >
                            <div>
                                <p className="text-sm font-medium text-slate-200">
                                    {role.name}
                                </p>
                            </div>

                            <button
                                type="button"
                                role="switch"
                                aria-checked={role.access}
                                disabled={saving}
                                onClick={() => toggleRole(role.id)}
                                className={[
                                    'relative h-6 w-11 rounded-full transition',
                                    role.access
                                        ? 'bg-emerald-500'
                                        : 'bg-slate-700',
                                    'disabled:cursor-not-allowed disabled:opacity-50',
                                ].join(' ')}
                            >
                                <span
                                    className={[
                                        'absolute top-1 h-4 w-4 rounded-full bg-white shadow transition',
                                        role.access
                                            ? 'right-1'
                                            : 'left-1',
                                    ].join(' ')}
                                />
                            </button>
                        </div>
                    ))}
                </div>

                <div className="flex justify-end border-t border-slate-800 px-6 py-4">
                    <button
                        type="button"
                        disabled={saving}
                        onClick={handleSave}
                        className="rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 transition hover:bg-white disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        {tr.t('modulemanager.submit')}
                    </button>
                </div>
            </section>
        </section>
    );
}