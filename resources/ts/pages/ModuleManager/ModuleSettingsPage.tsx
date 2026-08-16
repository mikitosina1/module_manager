import {useParams} from 'react-router-dom';

import tr from '@/services/TranslationService';

export default function ModuleSettingsPage() {
    const {module} = useParams<{module: string}>();

    return (
        <section className="space-y-8">
            <div>
                <h1 className="text-2xl font-semibold text-white">
                    {tr.t('modulemanager.settings')}
                </h1>

                <p className="mt-2 text-sm text-slate-400">
                    {module}
                </p>
            </div>

            <section>
                <h2 className="text-lg font-medium text-white">
                    {tr.t('modulemanager.access')}
                </h2>

                <p className="mt-1 text-sm text-slate-400">
                    {tr.t('modulemanager.access_description')}
                </p>
            </section>
        </section>
    );
}