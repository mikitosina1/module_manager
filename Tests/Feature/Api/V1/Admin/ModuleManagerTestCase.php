<?php

namespace Modules\ModuleManager\Tests\Feature\Api\V1\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Nwidart\Modules\Facades\Module;
use Tests\TestCase;

class ModuleManagerTestCase extends TestCase
{
    protected const MODULES_BASE_URL = '/api/v1/admin/modules/';

    public function test_user_can_not_acting_with_modules_settings(): void
    {
        $this->actingAsUser();
        $this->createTestModule123();

        $this->get(static::MODULES_BASE_URL)->assertForbidden();
        $this->post(static::MODULES_BASE_URL.'TestModule123/enable')->assertForbidden();
        $this->post(static::MODULES_BASE_URL.'TestModule123/disable')->assertForbidden();
        $this->delete(static::MODULES_BASE_URL.'TestModule123')->assertForbidden();
    }

    public function test_admin_can_get_modules_list()
    {
        $this->actingAsAdmin();
        $this->createTestModule123();

        $response = $this->get(static::MODULES_BASE_URL);
        $response->assertOk();

        foreach ($response->json('data') as $module) {
            $this->assertArrayHasKey('name', $module);
            $this->assertArrayHasKey('alias', $module);
            $this->assertArrayHasKey('enabled', $module);
            $this->assertArrayHasKey('path', $module);
            $this->assertArrayHasKey('version', $module);
            $this->assertArrayHasKey('description', $module);
            $this->assertArrayHasKey('admin_actions', $module);
        }
    }

    public function test_admin_can_enable_module(): void
    {
        $this->actingAsAdmin();
        $this->createTestModule123();

        $response = $this->post(static::MODULES_BASE_URL.'TestModule123/enable');
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'data' => [
                'name',
                'alias',
                'enabled',
                'path',
                'version',
                'description',
                'admin_actions',
            ],
        ]);
    }

    public function test_admin_can_disable_module(): void
    {
        $this->actingAsAdmin();
        $this->createTestModule123();

        $response = $this->post(static::MODULES_BASE_URL.'TestModule123/disable');
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'data' => [
                'name',
                'alias',
                'enabled',
                'path',
                'version',
                'description',
                'admin_actions',
            ],
        ]);
    }

    public function test_admin_can_delete_module(): void
    {
        $this->actingAsAdmin();
        $this->createTestModule123();

        $this->delete(static::MODULES_BASE_URL.'TestModule123')
            ->assertOk()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * acting test user as simple
     */
    protected function actingAsUser(): User
    {
        $user = $this->createUser();

        Sanctum::actingAs($user);

        return $user;
    }

    /**
     * creates simple user
     */
    protected function createUser(): User
    {
        $role = Role::firstOrCreate(['title' => Role::USER]);

        return User::factory()->create([
            'role_id' => $role->id,
        ]);
    }

    /**
     * acting test user as admin
     */
    protected function actingAsAdmin(): User
    {
        $admin = $this->createAdmin();

        Sanctum::actingAs($admin);

        return $admin;
    }

    /**
     * creates admin user
     */
    protected function createAdmin(): User
    {
        $role = Role::firstOrCreate(['title' => Role::ADMIN]);

        return User::factory()->create([
            'role_id' => $role->id,
        ]);
    }

    protected function createTestModule123(): void
    {
        Artisan::call('module:make', [
            'name' => ['TestModule123'],
        ]);
    }

    protected function tearDown(): void
    {
        $module = Module::find('TestModule123');

        if ($module) {
            $module->delete();
        }

        parent::tearDown();
    }
}
