<?php namespace IceCollection\Multisite\Seeds;

use Seeder;
use System\Classes\PluginManager;

class MultisiteMigrate extends Seeder
{
    /**
     * Migrates old table to new
     */
    public function run()
    {
        if (\Schema::hasTable('voipdeploy_multisite_settings')) {
            $rows = \DB::table('voipdeploy_multisite_settings')->get(
                [
                    'domain',
                    'theme',
                    'is_protected',
                    'created_at',
                    'updated_at',
                ]
            );

            $data = [];
            foreach ($rows as $row) {
                $data[] = get_object_vars($row);
            }

            \DB::table('icecollection_multisite_settings')->insert($data);

            if (PluginManager::instance()->exists('Voipdeploy.Multisite')) {
                \Artisan::call('plugin:remove', ['name' => 'Voipdeploy.Multisite', '--force' => true]);
            }

            \Schema::dropIfExists('voipdeploy_multisite_settings');
        }

    }
}
