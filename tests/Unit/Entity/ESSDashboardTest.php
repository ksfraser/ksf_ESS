<?php

declare(strict_types=1);

namespace Ksfraser\ESS\Tests\Unit\Entity;

use Ksfraser\ESS\Entity\ESSDashboard;
use PHPUnit\Framework\TestCase;

class ESSDashboardTest extends TestCase
{
    private ESSDashboard $dashboard;

    protected function setUp(): void
    {
        $this->dashboard = new ESSDashboard();
    }

    public function testSetAndGetUserId(): void
    {
        $result = $this->dashboard->setUserId('user_123');
        $this->assertSame($this->dashboard, $result);
        $this->assertSame('user_123', $this->dashboard->getUserId());
    }

    public function testPendingLeaveRequests(): void
    {
        $this->assertEmpty($this->dashboard->getPendingLeaveRequests());
        
        $this->dashboard->addPendingLeaveRequest(['id' => 'lr_1', 'type' => 'vacation']);
        $this->dashboard->addPendingLeaveRequest(['id' => 'lr_2', 'type' => 'sick']);
        
        $this->assertCount(2, $this->dashboard->getPendingLeaveRequests());
    }

    public function testPendingTimesheets(): void
    {
        $timesheets = [
            ['id' => 'ts_1', 'week' => '2024-W01'],
            ['id' => 'ts_2', 'week' => '2024-W02'],
        ];
        
        $this->dashboard->setPendingTimesheets($timesheets);
        
        $this->assertCount(2, $this->dashboard->getPendingTimesheets());
    }

    public function testPendingDocuments(): void
    {
        $documents = [['id' => 'doc_1', 'name' => 'Policy.pdf']];
        $this->dashboard->setPendingDocuments($documents);
        
        $this->assertCount(1, $this->dashboard->getPendingDocuments());
    }

    public function testUpcomingEvents(): void
    {
        $events = [
            ['id' => 'evt_1', 'title' => 'Meeting'],
        ];
        $this->dashboard->setUpcomingEvents($events);
        
        $this->assertCount(1, $this->dashboard->getUpcomingEvents());
    }

    public function testRecentAnnouncements(): void
    {
        $announcements = [
            ['id' => 'ann_1', 'title' => 'Holiday Schedule'],
        ];
        $this->dashboard->setRecentAnnouncements($announcements);
        
        $this->assertCount(1, $this->dashboard->getRecentAnnouncements());
    }

    public function testTeamPerformance(): void
    {
        $this->assertNull($this->dashboard->getTeamPerformance());
        
        $this->dashboard->setTeamPerformance(85.5);
        
        $this->assertSame(85.5, $this->dashboard->getTeamPerformance());
    }

    public function testOpenTickets(): void
    {
        $this->assertNull($this->dashboard->getOpenTickets());
        
        $this->dashboard->setOpenTickets(3);
        
        $this->assertSame(3, $this->dashboard->getOpenTickets());
    }

    public function testGetTotalPendingItems(): void
    {
        $this->assertSame(0, $this->dashboard->getTotalPendingItems());
        
        $this->dashboard->addPendingLeaveRequest(['id' => 'lr_1']);
        $this->dashboard->setPendingTimesheets([['id' => 'ts_1']]);
        $this->dashboard->setPendingDocuments([['id' => 'doc_1']]);
        
        $this->assertSame(3, $this->dashboard->getTotalPendingItems());
    }

    public function testHasActionRequired(): void
    {
        $this->assertFalse($this->dashboard->hasActionRequired());
        
        $this->dashboard->addPendingLeaveRequest(['id' => 'lr_1']);
        
        $this->assertTrue($this->dashboard->hasActionRequired());
    }

    public function testToArrayReturnsAllFields(): void
    {
        $this->dashboard->setUserId('user_123');
        $this->dashboard->addPendingLeaveRequest(['id' => 'lr_1']);
        $this->dashboard->setPendingTimesheets([['id' => 'ts_1']]);
        $this->dashboard->setTeamPerformance(90.0);
        $this->dashboard->setOpenTickets(5);

        $array = $this->dashboard->toArray();

        $this->assertSame('user_123', $array['user_id']);
        $this->assertCount(1, $array['pending_leave_requests']);
        $this->assertCount(1, $array['pending_timesheets']);
        $this->assertSame(90.0, $array['team_performance']);
        $this->assertSame(5, $array['open_tickets']);
        $this->assertSame(2, $array['total_pending_items']);
        $this->assertTrue($array['action_required']);
    }
}
