import api from '@/services/ApiClient';

import tr from '@/services/TranslationService';

export interface ModuleRole {
    id: number;
    name: string;
    access: boolean;
}

export interface ModuleSettingsResponse {
    module: {
        id: string;
        name: string;
        alias: string;
    };
    roles: ModuleRole[];
    settings: {
        permissions?: Record<
            string,
            {
                access?: boolean;
            }
        >;
    };
}

interface Response {
    data: ModuleSettingsResponse;
}

export async function getModuleSettings(
    module: string,
): Promise<ModuleSettingsResponse> {
    const response = await api.get<Response>(
        `/api/v1/admin/modules/${encodeURIComponent(module)}/settings`,
    );

    if (response.status < 200 || response.status >= 300) {
        throw new Error(tr.t('modulemanager.settings_load_error'));
    }

    return response.data.data;
}

export async function setModuleAccess(
    module: string,
    permissions: Record<string, {access: boolean}>,
): Promise<void> {
    await api.put(
        `/api/v1/admin/modules/${encodeURIComponent(module)}/settings/access`,
        {
            permissions,
        },
    );
}