<?php

declare(strict_types=1);

namespace Ksfraser\ESS\Entity;

class ESSDashboard
{
    private ?string $userId = null;
    private array $pendingLeaveRequests = [];
    private array $pendingTimesheets = [];
    private array $pendingDocuments = [];
    private array $upcomingEvents = [];
    private array $recentAnnouncements = [];
    private ?float $teamPerformance = null;
    private ?int $openTickets = null;
    private ?\DateTime $generatedAt = null;

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getPendingLeaveRequests(): array
    {
        return $this->pendingLeaveRequests;
    }

    public function setPendingLeaveRequests(array $requests): self
    {
        $this->pendingLeaveRequests = $requests;
        return $this;
    }

    public function addPendingLeaveRequest(array $request): self
    {
        $this->pendingLeaveRequests[] = $request;
        return $this;
    }

    public function getPendingTimesheets(): array
    {
        return $this->pendingTimesheets;
    }

    public function setPendingTimesheets(array $timesheets): self
    {
        $this->pendingTimesheets = $timesheets;
        return $this;
    }

    public function getPendingDocuments(): array
    {
        return $this->pendingDocuments;
    }

    public function setPendingDocuments(array $documents): self
    {
        $this->pendingDocuments = $documents;
        return $this;
    }

    public function getUpcomingEvents(): array
    {
        return $this->upcomingEvents;
    }

    public function setUpcomingEvents(array $events): self
    {
        $this->upcomingEvents = $events;
        return $this;
    }

    public function getRecentAnnouncements(): array
    {
        return $this->recentAnnouncements;
    }

    public function setRecentAnnouncements(array $announcements): self
    {
        $this->recentAnnouncements = $announcements;
        return $this;
    }

    public function getTeamPerformance(): ?float
    {
        return $this->teamPerformance;
    }

    public function setTeamPerformance(?float $performance): self
    {
        $this->teamPerformance = $performance;
        return $this;
    }

    public function getOpenTickets(): ?int
    {
        return $this->openTickets;
    }

    public function setOpenTickets(?int $tickets): self
    {
        $this->openTickets = $tickets;
        return $this;
    }

    public function getGeneratedAt(): ?\DateTime
    {
        return $this->generatedAt;
    }

    public function setGeneratedAt(?\DateTime $generatedAt): self
    {
        $this->generatedAt = $generatedAt;
        return $this;
    }

    public function getTotalPendingItems(): int
    {
        return count($this->pendingLeaveRequests) 
            + count($this->pendingTimesheets) 
            + count($this->pendingDocuments);
    }

    public function hasActionRequired(): bool
    {
        return $this->getTotalPendingItems() > 0;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'pending_leave_requests' => $this->pendingLeaveRequests,
            'pending_timesheets' => $this->pendingTimesheets,
            'pending_documents' => $this->pendingDocuments,
            'upcoming_events' => $this->upcomingEvents,
            'recent_announcements' => $this->recentAnnouncements,
            'team_performance' => $this->teamPerformance,
            'open_tickets' => $this->openTickets,
            'total_pending_items' => $this->getTotalPendingItems(),
            'action_required' => $this->hasActionRequired(),
            'generated_at' => $this->generatedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
