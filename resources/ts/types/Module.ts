export interface Module {
    id: string;
    name: string;
    alias: string;
    enabled: boolean;
    path: string;
    version: string;
    description: string | null;
    admin_actions: string[];
}