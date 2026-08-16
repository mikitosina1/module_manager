import type {Module} from '../types/Module';

import api from '@/services/ApiClient';
import tr from '@/services/TranslationService';

interface ModulesResponse {
    data: Record<string, Module>;
}

interface ModuleResponse {
    message: string;
    data: Module;
}

export async function getModules(): Promise<Record<string, Module>> {
    try {
        const response = await api.get<ModulesResponse>(
            '/api/v1/admin/modules',
        );

        return response.data.data;
    } catch {
        throw new Error(tr.t('modulemanager.load_error'));
    }
}

export async function enableModule(moduleName: string): Promise<Module> {
    try {
        const response = await api.post<ModuleResponse>(
            `/api/v1/admin/modules/${encodeURIComponent(moduleName)}/enable`,
        );

        return response.data.data;
    } catch {
        throw new Error(tr.t('modulemanager.module_enable_error'));
    }
}

export async function disableModule(moduleName: string): Promise<Module> {
    try {
        const response = await api.post<ModuleResponse>(
            `/api/v1/admin/modules/${encodeURIComponent(moduleName)}/disable`,
        );

        return response.data.data;
    } catch {
        throw new Error(tr.t('modulemanager.module_disable_error'));
    }
}