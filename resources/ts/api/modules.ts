import type {Module} from '../types/Module';

import tr from '@/services/TranslationService';

interface ModulesResponse {
    data: Record<string, Module>;
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