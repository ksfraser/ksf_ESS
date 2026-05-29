<?php

declare(strict_types=1);

namespace Ksfraser\ESS\Service;

use Ksfraser\ESS\Entity\ESSDashboard;

class DashboardService
{
    private array $dashboards = [];

    public function getDashboard(string $userId): ESSDashboard
    {
        $dashboard = new ESSDashboard();
        $dashboard->setUserId($userId);
        $dashboard->setGeneratedAt(new \DateTime());

        $this->dashboards[$userId] = $dashboard;

        return $dashboard;
    }

    public function refreshDashboard(string $userId): ESSDashboard
    {
        return $this->getDashboard($userId);
    }

    public function getCachedDashboard(string $userId): ?ESSDashboard
    {
        return $this->dashboards[$userId] ?? null;
    }

    public function addPendingLeaveRequest(string $userId, array $request): void
    {
        $dashboard = $this->getDashboard($userId);
        $dashboard->addPendingLeaveRequest($request);
    }

    public function addPendingTimesheet(string $userId, array $timesheet): void
    {
        $dashboard = $this->getDashboard($userId);
        $dashboard->getPendingTimesheets[] = $timesheet;
    }

    public function addPendingDocument(string $userId, array $document): void
    {
        $dashboard = $this->getDashboard($userId);
        $dashboard->getPendingDocuments[] = $document;
    }

    public function setUpcomingEvents(string $userId, array $events): void
    {
        $dashboard = $this->getDashboard($userId);
        $dashboard->setUpcomingEvents($events);
    }

    public function setRecentAnnouncements(string $userId, array $announcements): void
    {
        $dashboard = $this->getDashboard($userId);
        $dashboard->setRecentAnnouncements($announcements);
    }

    public function setTeamPerformance(string $userId, float $performance): void
    {
        $dashboard = $this->getDashboard($userId);
        $dashboard->setTeamPerformance($performance);
    }

    public function setOpenTickets(string $userId, int $count): void
    {
        $dashboard = $this->getDashboard($userId);
        $dashboard->setOpenTickets($count);
    }

    public function clearCache(string $userId): void
    {
        unset($this->dashboards[$userId]);
    }

    public function clearAllCache(): void
    {
        $this->dashboards = [];
    }
}
