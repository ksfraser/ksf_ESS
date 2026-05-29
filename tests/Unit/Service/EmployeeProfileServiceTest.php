<?php

declare(strict_types=1);

namespace Ksfraser\ESS\Tests\Unit\Service;

use Ksfraser\ESS\Entity\EmployeeProfile;
use Ksfraser\ESS\Service\EmployeeProfileService;
use PHPUnit\Framework\TestCase;

class EmployeeProfileServiceTest extends TestCase
{
    private EmployeeProfileService $service;

    protected function setUp(): void
    {
        $this->service = new EmployeeProfileService();
    }

    public function testCreate(): void
    {
        $data = [
            'user_id' => 'user_123',
            'employee_id' => 'EMP001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
        ];

        $profile = $this->service->create($data);

        $this->assertInstanceOf(EmployeeProfile::class, $profile);
        $this->assertSame('user_123', $profile->getUserId());
        $this->assertSame('EMP001', $profile->getEmployeeId());
        $this->assertSame('John', $profile->getFirstName());
        $this->assertSame('Doe', $profile->getLastName());
        $this->assertNotNull($profile->getId());
    }

    public function testGet(): void
    {
        $created = $this->service->create(['user_id' => 'user_123', 'first_name' => 'Test']);

        $retrieved = $this->service->get($created->getId());

        $this->assertSame($created, $retrieved);
    }

    public function testGetReturnsNullForNonexistent(): void
    {
        $result = $this->service->get('nonexistent');
        $this->assertNull($result);
    }

    public function testGetByUserId(): void
    {
        $this->service->create(['user_id' => 'user_1', 'first_name' => 'User1']);
        $this->service->create(['user_id' => 'user_2', 'first_name' => 'User2']);

        $profile = $this->service->getByUserId('user_1');

        $this->assertSame('User1', $profile->getFirstName());
    }

    public function testGetByEmployeeId(): void
    {
        $this->service->create(['employee_id' => 'EMP001', 'first_name' => 'Emp1']);
        $this->service->create(['employee_id' => 'EMP002', 'first_name' => 'Emp2']);

        $profile = $this->service->getByEmployeeId('EMP001');

        $this->assertSame('Emp1', $profile->getFirstName());
    }

    public function testUpdate(): void
    {
        $profile = $this->service->create([
            'user_id' => 'user_123',
            'first_name' => 'Original',
        ]);

        $updated = $this->service->update($profile->getId(), ['first_name' => 'Updated']);

        $this->assertSame('Updated', $updated->getFirstName());
    }

    public function testDelete(): void
    {
        $profile = $this->service->create(['user_id' => 'user_123']);
        $id = $profile->getId();

        $result = $this->service->delete($id);

        $this->assertTrue($result);
        $this->assertNull($this->service->get($id));
    }

    public function testFindByDepartment(): void
    {
        $this->service->create(['user_id' => 'u1', 'department' => 'Engineering']);
        $this->service->create(['user_id' => 'u2', 'department' => 'HR']);
        $this->service->create(['user_id' => 'u3', 'department' => 'Engineering']);

        $engProfiles = $this->service->findByDepartment('Engineering');

        $this->assertCount(2, $engProfiles);
    }

    public function testFindManagers(): void
    {
        $this->service->create(['user_id' => 'u1', 'type' => EmployeeProfile::TYPE_EMPLOYEE]);
        $this->service->create(['user_id' => 'u2', 'type' => EmployeeProfile::TYPE_MANAGER]);
        $this->service->create(['user_id' => 'u3', 'type' => EmployeeProfile::TYPE_ADMIN]);

        $managers = $this->service->findManagers();

        $this->assertCount(2, $managers);
    }

    public function testGetDirectReports(): void
    {
        $manager = $this->service->create(['user_id' => 'mgr', 'type' => EmployeeProfile::TYPE_MANAGER]);
        $this->service->create(['user_id' => 'emp1', 'manager_id' => $manager->getId()]);
        $this->service->create(['user_id' => 'emp2', 'manager_id' => $manager->getId()]);
        $this->service->create(['user_id' => 'emp3']);

        $reports = $this->service->getDirectReports($manager->getId());

        $this->assertCount(2, $reports);
    }

    public function testSearch(): void
    {
        $this->service->create(['user_id' => 'u1', 'first_name' => 'Alice', 'department' => 'Engineering']);
        $this->service->create(['user_id' => 'u2', 'first_name' => 'Bob', 'department' => 'HR']);

        $results = $this->service->search('alice');

        $this->assertCount(1, $results);
    }

    public function testGetAll(): void
    {
        $this->service->create(['user_id' => 'u1']);
        $this->service->create(['user_id' => 'u2']);

        $all = $this->service->getAll();

        $this->assertCount(2, $all);
    }
}
