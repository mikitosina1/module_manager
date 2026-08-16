import type {RouteObject} from 'react-router-dom';
import type {MenuItem} from '@/types/Menu';
import type {ReactModule} from '@/types/Module';

import {PuzzleIcon} from 'lucide-react';

import ModuleManagerPage from './pages/ModuleManager/ModuleManagerPage';
import ModuleSettingsPage from './pages/ModuleManager/ModuleSettingsPage';

const routes: RouteObject[] = [
    {
        path: 'module-manager',
        element: <ModuleManagerPage/>,
        handle: {
            title: 'modulemanager.widget_title',
        },
    },
    {
        path: 'module-manager/modules/:module',
        element: <ModuleSettingsPage />,
        handle: {
            title: 'modulemanager.settings',
        },
    },
];

const navigation: MenuItem[] = [
    {
        id: 'module-manager',
        title: 'modulemanager.widget_title',
        route: '/module-manager',
        section: 'modules',
        order: 100,
        active: true,
        icon: 'modulemanager:puzzle',
        roles: ['admin'],
    },
];

const icons = {
    puzzle: PuzzleIcon,
};

const moduleDefinition: ReactModule = {
    id: 'modulemanager',
    name: 'ModuleManager',
    routes,
    navigation,
    icons,
};

export default moduleDefinition;