import type {Module} from '../types/Module';

import api from '@/services/ApiClient';

export async function getModules(): Promise<Record<string, Module>> {
    const response = await api.get('/api/v1/admin/modules');

    return response.data.data;
}

export async function enableModule(moduleName: string): Promise<Module> {
    const response = await api.post(
        `/api/v1/admin/modules/${encodeURIComponent(moduleName)}/enable`,
    );

    return response.data.data;
}

export async function disableModule(moduleName: string): Promise<Module> {
    const response = await api.post(
        `/api/v1/admin/modules/${encodeURIComponent(moduleName)}/disable`,
    );

    return response.data.data;
}

export async function deleteModule(moduleName: string): Promise<void> {
    await api.delete(
        `/api/v1/admin/modules/${encodeURIComponent(moduleName)}`,
    );
}