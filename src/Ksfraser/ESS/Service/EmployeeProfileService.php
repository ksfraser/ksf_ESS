<?php

declare(strict_types=1);

namespace Ksfraser\ESS\Service;

use Ksfraser\ESS\Entity\EmployeeProfile;
use Ksfraser\ESS\Entity\ESSDashboard;

class EmployeeProfileService
{
    private array $profiles = [];

    public function create(array $data): EmployeeProfile
    {
        $profile = EmployeeProfile::fromArray($data);
        $profile->setId($data['id'] ?? uniqid('profile_'));
        $profile->setCreatedAt(new \DateTime());
        $profile->setUpdatedAt(new \DateTime());

        $this->profiles[$profile->getId()] = $profile;

        return $profile;
    }

    public function get(string $id): ?EmployeeProfile
    {
        return $this->profiles[$id] ?? null;
    }

    public function getByUserId(string $userId): ?EmployeeProfile
    {
        foreach ($this->profiles as $profile) {
            if ($profile->getUserId() === $userId) {
                return $profile;
            }
        }
        return null;
    }

    public function getByEmployeeId(string $employeeId): ?EmployeeProfile
    {
        foreach ($this->profiles as $profile) {
            if ($profile->getEmployeeId() === $employeeId) {
                return $profile;
            }
        }
        return null;
    }

    public function update(string $id, array $data): EmployeeProfile
    {
        $profile = $this->get($id);
        if (!$profile) {
            throw new \RuntimeException("Profile not found: {$id}");
        }

        foreach ($data as $key => $value) {
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
            if (method_exists($profile, $method)) {
                $profile->$method($value);
            }
        }
        $profile->setUpdatedAt(new \DateTime());

        return $profile;
    }

    public function delete(string $id): bool
    {
        if (!isset($this->profiles[$id])) {
            return false;
        }
        unset($this->profiles[$id]);
        return true;
    }

    public function findByDepartment(string $department): array
    {
        return array_filter(
            $this->profiles,
            fn(EmployeeProfile $p) => $p->getDepartment() === $department
        );
    }

    public function findManagers(): array
    {
        return array_filter(
            $this->profiles,
            fn(EmployeeProfile $p) => $p->isManager()
        );
    }

    public function findByType(string $type): array
    {
        return array_filter(
            $this->profiles,
            fn(EmployeeProfile $p) => $p->getType() === $type
        );
    }

    public function getDirectReports(string $managerId): array
    {
        return array_filter(
            $this->profiles,
            fn(EmployeeProfile $p) => $p->getManagerId() === $managerId
        );
    }

    public function search(string $query): array
    {
        $query = strtolower($query);
        return array_filter(
            $this->profiles,
            fn(EmployeeProfile $p) => 
                stripos($p->getFullName(), $query) !== false ||
                stripos($p->getEmail(), $query) !== false ||
                stripos($p->getDepartment(), $query) !== false
        );
    }

    public function getAll(): array
    {
        return $this->profiles;
    }
}
