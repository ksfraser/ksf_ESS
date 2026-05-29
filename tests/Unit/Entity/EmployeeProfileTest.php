<?php

declare(strict_types=1);

namespace Ksfraser\ESS\Tests\Unit\Entity;

use DateTime;
use Ksfraser\ESS\Entity\EmployeeProfile;
use PHPUnit\Framework\TestCase;

class EmployeeProfileTest extends TestCase
{
    private EmployeeProfile $profile;

    protected function setUp(): void
    {
        $this->profile = new EmployeeProfile();
    }

    public function testSetAndGetId(): void
    {
        $result = $this->profile->setId('prof_123');
        $this->assertSame($this->profile, $result);
        $this->assertSame('prof_123', $this->profile->getId());
    }

    public function testSetAndGetUserId(): void
    {
        $result = $this->profile->setUserId('user_456');
        $this->assertSame($this->profile, $result);
        $this->assertSame('user_456', $this->profile->getUserId());
    }

    public function testSetAndGetEmployeeId(): void
    {
        $result = $this->profile->setEmployeeId('EMP001');
        $this->assertSame($this->profile, $result);
        $this->assertSame('EMP001', $this->profile->getEmployeeId());
    }

    public function testSetAndGetName(): void
    {
        $this->profile->setFirstName('John');
        $this->profile->setLastName('Doe');
        $this->assertSame('John', $this->profile->getFirstName());
        $this->assertSame('Doe', $this->profile->getLastName());
        $this->assertSame('John Doe', $this->profile->getFullName());
    }

    public function testSetAndGetEmail(): void
    {
        $result = $this->profile->setEmail('john@example.com');
        $this->assertSame($this->profile, $result);
        $this->assertSame('john@example.com', $this->profile->getEmail());
    }

    public function testSetAndGetDepartment(): void
    {
        $result = $this->profile->setDepartment('Engineering');
        $this->assertSame($this->profile, $result);
        $this->assertSame('Engineering', $this->profile->getDepartment());
    }

    public function testSetAndGetJobTitle(): void
    {
        $result = $this->profile->setJobTitle('Software Engineer');
        $this->assertSame($this->profile, $result);
        $this->assertSame('Software Engineer', $this->profile->getJobTitle());
    }

    public function testIsManager(): void
    {
        $this->assertFalse($this->profile->isManager());
        $this->profile->setType(EmployeeProfile::TYPE_EMPLOYEE);
        $this->assertFalse($this->profile->isManager());
        $this->profile->setType(EmployeeProfile::TYPE_MANAGER);
        $this->assertTrue($this->profile->isManager());
        $this->profile->setType(EmployeeProfile::TYPE_ADMIN);
        $this->assertTrue($this->profile->isManager());
    }

    public function testIsAdmin(): void
    {
        $this->assertFalse($this->profile->isAdmin());
        $this->profile->setType(EmployeeProfile::TYPE_ADMIN);
        $this->assertTrue($this->profile->isAdmin());
    }

    public function testSetAndGetManagerId(): void
    {
        $result = $this->profile->setManagerId('manager_123');
        $this->assertSame($this->profile, $result);
        $this->assertSame('manager_123', $this->profile->getManagerId());
    }

    public function testGetTenureYears(): void
    {
        $this->assertSame(0.0, $this->profile->getTenureYears());
        $this->profile->setHireDate(new DateTime('-2 years'));
        $this->assertGreaterThanOrEqual(2.0, $this->profile->getTenureYears());
    }

    public function testToArrayReturnsAllFields(): void
    {
        $this->profile->setId('prof_123');
        $this->profile->setUserId('user_456');
        $this->profile->setEmployeeId('EMP001');
        $this->profile->setFirstName('Jane');
        $this->profile->setLastName('Smith');
        $this->profile->setEmail('jane@example.com');
        $this->profile->setDepartment('HR');
        $this->profile->setJobTitle('HR Manager');

        $array = $this->profile->toArray();

        $this->assertSame('prof_123', $array['id']);
        $this->assertSame('user_456', $array['user_id']);
        $this->assertSame('EMP001', $array['employee_id']);
        $this->assertSame('Jane', $array['first_name']);
        $this->assertSame('Smith', $array['last_name']);
        $this->assertSame('jane@example.com', $array['email']);
        $this->assertSame('HR', $array['department']);
        $this->assertSame('HR Manager', $array['job_title']);
    }

    public function testFromArrayCreatesProfile(): void
    {
        $data = [
            'id' => 'prof_789',
            'user_id' => 'user_001',
            'employee_id' => 'EMP002',
            'first_name' => 'Bob',
            'last_name' => 'Wilson',
            'email' => 'bob@company.com',
            'department' => 'Finance',
            'job_title' => 'Accountant',
            'type' => EmployeeProfile::TYPE_EMPLOYEE,
        ];

        $profile = EmployeeProfile::fromArray($data);

        $this->assertSame('prof_789', $profile->getId());
        $this->assertSame('user_001', $profile->getUserId());
        $this->assertSame('EMP002', $profile->getEmployeeId());
        $this->assertSame('Bob', $profile->getFirstName());
        $this->assertSame('Wilson', $profile->getLastName());
        $this->assertSame('bob@company.com', $profile->getEmail());
        $this->assertSame('Finance', $profile->getDepartment());
        $this->assertSame('Accountant', $profile->getJobTitle());
    }
}
