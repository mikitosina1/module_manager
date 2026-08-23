import api from '@/services/ApiClient';

export interface ModuleRole {
    id: number;
    name: string;
    permissions: Record<string, boolean>;
}

export interface ModuleSettingsResponse {
    module: {
        id: string;
        name: string;
        alias: string;
    };
    permissions: string[];
    roles: ModuleRole[];
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

    return response.data.data;
}

export async function setModulePermissions(
    module: string,
    permissions: Record<string, Record<string, boolean>>,
): Promise<void> {
    await api.put(
        `/api/v1/admin/modules/${encodeURIComponent(module)}/settings/access`,
        {
            permissions,
        },
    );
}