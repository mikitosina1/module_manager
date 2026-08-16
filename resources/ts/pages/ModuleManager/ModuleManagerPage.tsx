import {useEffect, useState} from 'react';

import {
    getModules,
    enableModule,
    disableModule,
} from '../../api/modules';
import ModuleCard from '../../components/ModuleCard';
import type {Module} from '../../types/Module';

import tr from '@/services/TranslationService';

export default function ModuleManagerPage() {
    const [modules, setModules] = useState<Record<string, Module>>({});
    const [loading, setLoading] = useState(true);
    const [errorKey, setErrorKey] = useState<string | null>(null);
    const [processingModule, setProcessingModule] = useState<string | null>(null);

    useEffect(() => {
        getModules()
            .then(setModules)
            .catch(() => {
                setErrorKey('modulemanager.load_error');
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    const handleToggle = async (module: Module) => {
        setProcessingModule(module.id);

        try {
            const updatedModule = module.enabled
                ? await disableModule(module.name)
                : await enableModule(module.name);

            setModules((current) => ({
                ...current,
                [module.alias]: updatedModule,
            }));
        } catch {
            setErrorKey('modulemanager.action_error');
        } finally {
            setProcessingModule(null);
        }
    };

    if (loading) {
        return (
            <div>
                {tr.t('modulemanager.loading')}
            </div>
        );
    }

    if (errorKey) {
        return (
            <div>
                {tr.t(errorKey)}
            </div>
        );
    }

    return (
        <section className="space-y-8">
            <div className="grid grid-cols-1 gap-5 xl:grid-cols-2">
                {Object.values(modules).map((module) => (
                    <ModuleCard
                        key={module.id}
                        module={module}
                        onToggle={handleToggle}
                        disabled={processingModule === module.id}
                    />
                ))}
            </div>
        </section>
    );
}