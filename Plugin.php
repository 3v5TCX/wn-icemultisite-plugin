<?php namespace IceCollection\Multisite;

use System\Classes\PluginBase;
use IceCollection\Multisite\Models\Setting;
use BackendAuth;
use Backend;
use Config;
use Event;
use Cache;
use Request;
use App;
use Flash;
use Cms\Classes\Theme;

class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'icecollection.multisite::lang.details.title',
            'description' => 'icecollection.multisite::lang.details.description',
            'author'      => 'icecollection',
            'icon'        => 'icon-cubes',
        ];
    }

    /**
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'icecollection.multisite.access_settings' => [
                'tab'   => 'icecollection.multisite::lang.permissions.tab',
                'label' => 'icecollection.multisite::lang.permissions.settings',
            ],
        ];
    }

    /**
     * @return array
     */
    public function registerSettings()
    {
        return [
            'multisite' => [
                'label'       => 'icecollection.multisite::lang.details.title',
                'description' => 'icecollection.multisite::lang.details.description',
                'category'    => 'system::lang.system.categories.cms',
                'icon'        => 'icon-cubes',
                'url'         => Backend::url('icecollection/multisite/settings'),
                'permissions' => ['icecollection.multisite.settings'],
                'order'       => 500,
                'keywords'    => 'multisite domains themes',
            ],
        ];
    }

    /**
     * Multisite boot method
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \UnexpectedValueException
     */
    public function boot()
    {
        $backendUri = Config::get('cms.backendUri');
        $requestUrl = Request::url();
        $currentHostUrl = Request::getHost();
        $currentTheme = Setting::getTheme($currentHostUrl);

        Theme::setActiveTheme($currentTheme);

//        $backendUri = Config::get('cms.backendUri');
//        $requestUrl = Request::url();
//        $currentHostUrl = Request::getHost();
//
//        /*
//         * Get domain to theme bindings from cache, if it's not there, load them from database,
//         * save to cache and use for theme selection.
//         */
//        $binds = Cache::rememberForever(
//            'icecollection_multisite_settings',
//            function () {
//                try {
//                    $cacheableRecords = Setting::generateCacheableRecords();
//                } catch (\Illuminate\Database\QueryException $e) {
//                    if (BackendAuth::check()) {
//                        Flash::error(trans('icecollection.multisite:lang.flash.db-error'));
//                    }
//
//                    return null;
//                }
//
//                return $cacheableRecords;
//
//            });
//        /*
//         * Oooops something went wrong, abort.
//         */
//        if ($binds === null) {
//            return null;
//        }
//        /*
//         * Check if this request is in backend scope and is using domain,
//         * that is protected from using backend
//         */
//        foreach ($binds as $domain => $bind) {
//            if (preg_match('/\\'.$backendUri.'/', $requestUrl) && preg_match(
//                    '/'.$currentHostUrl.'/i',
//                    $domain) && $bind['is_protected']
//            ) {
//                return App::abort(401, 'Unauthorized.');
//            }
//        }
//
//        /*
//         * If current request is in backend scope, do not check cms themes
//         * Allows for current theme changes in October Theme Selector
//         */
//        if (preg_match('/\\'.$backendUri.'/', $requestUrl)) {
//            return null;
//        }
//        /*
//         * Listen for CMS activeTheme event, change theme according to binds
//         * If there's no match, let CMS set active theme
//         */
//        Event::listen(
//            'cms.theme.getActiveTheme',
//            function () use ($binds, $currentHostUrl) {
//                foreach ($binds as $domain => $bind) {
//                    if (preg_match('/'.$currentHostUrl.'/i', $domain)) {
//                        Config::set('app.url', $domain);
//
//                        return $bind['theme'];
//                    }
//                }
//            });
    }

}
