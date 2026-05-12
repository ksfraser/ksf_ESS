<?php

declare(strict_types=1);

namespace Ksfraser\ESS\Entity;

class EmployeeProfile
{
    public const TYPE_EMPLOYEE = 'employee';
    public const TYPE_MANAGER = 'manager';
    public const TYPE_ADMIN = 'admin';

    private ?string $id = null;
    private string $userId = '';
    private string $employeeId = '';
    private string $firstName = '';
    private string $lastName = '';
    private string $email = '';
    private string $department = '';
    private string $jobTitle = '';
    private string $type = self::TYPE_EMPLOYEE;
    private ?string $managerId = null;
    private ?string $profilePhoto = null;
    private string $phone = '';
    private ?\DateTime $hireDate = null;
    private ?\DateTime $createdAt = null;
    private ?\DateTime $updatedAt = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getEmployeeId(): string
    {
        return $this->employeeId;
    }

    public function setEmployeeId(string $employeeId): self
    {
        $this->employeeId = $employeeId;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getDepartment(): string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;
        return $this;
    }

    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function isManager(): bool
    {
        return in_array($this->type, [self::TYPE_MANAGER, self::TYPE_ADMIN]);
    }

    public function isAdmin(): bool
    {
        return $this->type === self::TYPE_ADMIN;
    }

    public function getManagerId(): ?string
    {
        return $this->managerId;
    }

    public function setManagerId(?string $managerId): self
    {
        $this->managerId = $managerId;
        return $this;
    }

    public function getProfilePhoto(): ?string
    {
        return $this->profilePhoto;
    }

    public function setProfilePhoto(?string $profilePhoto): self
    {
        $this->profilePhoto = $profilePhoto;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getHireDate(): ?\DateTime
    {
        return $this->hireDate;
    }

    public function setHireDate(?\DateTime $hireDate): self
    {
        $this->hireDate = $hireDate;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getTenureYears(): float
    {
        if (!$this->hireDate) {
            return 0;
        }
        return $this->hireDate->diff(new \DateTime())->y + ($this->hireDate->diff(new \DateTime())->m / 12);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'employee_id' => $this->employeeId,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'department' => $this->department,
            'job_title' => $this->jobTitle,
            'type' => $this->type,
            'manager_id' => $this->managerId,
            'profile_photo' => $this->profilePhoto,
            'phone' => $this->phone,
            'hire_date' => $this->hireDate?->format('Y-m-d'),
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromArray(array $data): self
    {
        $profile = new self();
        
        if (isset($data['id'])) $profile->setId($data['id']);
        if (isset($data['user_id'])) $profile->setUserId($data['user_id']);
        if (isset($data['employee_id'])) $profile->setEmployeeId($data['employee_id']);
        if (isset($data['first_name'])) $profile->setFirstName($data['first_name']);
        if (isset($data['last_name'])) $profile->setLastName($data['last_name']);
        if (isset($data['email'])) $profile->setEmail($data['email']);
        if (isset($data['department'])) $profile->setDepartment($data['department']);
        if (isset($data['job_title'])) $profile->setJobTitle($data['job_title']);
        if (isset($data['type'])) $profile->setType($data['type']);
        if (isset($data['manager_id'])) $profile->setManagerId($data['manager_id']);
        if (isset($data['profile_photo'])) $profile->setProfilePhoto($data['profile_photo']);
        if (isset($data['phone'])) $profile->setPhone($data['phone']);
        if (isset($data['hire_date'])) $profile->setHireDate(new \DateTime($data['hire_date']));
        
        return $profile;
    }
}
