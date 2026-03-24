<?php

namespace Tests\Feature;

use Tests\TestCase;

class InstallationTest extends TestCase
{
    /**
     * Test that required packages are installed.
     */
    public function test_required_packages_are_installed(): void
    {
        $packages = [
            'artesaos/seotools',
            'cviebrock/eloquent-sluggable',
            'intervention/image',
            'maatwebsite/excel',
            'orchid/platform',
            'propaganistas/laravel-phone',
            'spatie/laravel-image-optimizer',
            'spatie/laravel-sitemap',
        ];

        $composerJson = json_decode(file_get_contents(base_path('composer.json')), true);
        $installedPackages = array_keys($composerJson['require'] ?? []);

        foreach ($packages as $package) {
            $this->assertTrue(
                in_array($package, $installedPackages),
                "Package {$package} is not installed."
            );
        }
    }

    /**
     * Test that configuration files are published.
     */
    public function test_configuration_files_are_published(): void
    {
        $configFiles = [
            'seotools.php',
            'sluggable.php',
            'image-optimizer.php',
            'sitemap.php',
            'platform.php',
        ];

        foreach ($configFiles as $configFile) {
            $this->assertFileExists(
                config_path($configFile),
                "Configuration file {$configFile} is not published."
            );
        }
    }

    /**
     * Test that environment is properly configured.
     */
    public function test_environment_is_properly_configured(): void
    {
        $this->assertNotNull(config('app.key'), 'Application key is not set.');
        $this->assertNotNull(env('APP_URL'), 'APP_URL is not set.');
    }
}
