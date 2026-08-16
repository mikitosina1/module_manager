import type {Module} from '../types/Module';

import tr from '@/services/TranslationService';

interface ModulesResponse {
    data: Record<string, Module>;
}

interface ModuleResponse {
    message: string;
    data: Module;
}

export async function getModules(): Promise<Record<string, Module>> {
    const response = await fetch('/api/v1/admin/modules', {
        headers: {
            Accept: 'application/json',
        },
        credentials: 'include',
    });

    if (!response.ok) {
        throw new Error(tr.t('modulemanager.load_error'));
    }

    const result: ModulesResponse = await response.json();

    return result.data;
}

export async function enableModule(moduleName: string): Promise<Module> {
    const response = await fetch(
        `/api/v1/admin/modules/${encodeURIComponent(moduleName)}/enable`,
        {
            method: 'POST',
            headers: {
                Accept: 'application/json',
            },
            credentials: 'include',
        },
    );

    if (!response.ok) {
        throw new Error(tr.t('modulemanager.module_enable_error'));
    }

    const result: ModuleResponse = await response.json();

    return result.data;
}

export async function disableModule(moduleName: string): Promise<Module> {
    const response = await fetch(
        `/api/v1/admin/modules/${encodeURIComponent(moduleName)}/disable`,
        {
            method: 'POST',
            headers: {
                Accept: 'application/json',
            },
            credentials: 'include',
        },
    );

    if (!response.ok) {
        throw new Error(tr.t('modulemanager.module_disable_error'));
    }

    const result: ModuleResponse = await response.json();

    return result.data;
}