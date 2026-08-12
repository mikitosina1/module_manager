import type { RouteObject } from 'react-router-dom';
import type { MenuItem } from '@/types/Menu';
import type { ReactModule } from '@/types/Module';

import { PuzzleIcon } from 'lucide-react';

import DashboardPage from './pages/Dashboard/DashboardPage';

const routes: RouteObject[] = [
    {
        path: 'module-manager',
        element: <DashboardPage />,
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