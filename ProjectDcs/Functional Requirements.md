# Functional Requirements - ksf_ESS

## Document Information
- **Module**: ksf_ESS
- **Version**: 1.0.0
- **Date**: 2026-05-24
- **Status**: Draft
- **Author**: KSFII Development Team

---

## 1. Portal Dashboard

### FR-ESS-001: Employee Home Page
**Description**: The ESS dashboard displays a personalized home page for the logged-in employee showing:
- Upcoming leave balance and pending requests
- Recent timesheet submission status
- Pending training enrollments and certifications expiring
- Performance review status (open reviews requiring acknowledgment)
- Quick actions (submit timesheet, request leave, enroll in training)

---

## 2. Self-Service Features

### FR-ESS-002: Profile View
**Description**: Employee can view their personal details, employment information, and documents via the portal. Profile data is sourced from ksf_HRM (employee module) via RBAC-gated queries.

### FR-ESS-003: Timesheet Submission
**Description**: Employee can submit weekly timesheets through the portal. Timesheet data is written to ksf_Timesheets via its service interface. Employee's individual RBAC team grants can_create on timesheet records.

### FR-ESS-004: Leave Requests
**Description**: Employee can submit leave requests through the portal. Leave data is written to ksf_Leave via its service interface. Employee's individual RBAC team grants can_create on leave_request records.

### FR-ESS-005: Training Access
**Description**: Employee can browse the course catalog (PUBLIC projection), view own enrollments (FULL projection via individual team), and self-enroll in available sessions.

### FR-ESS-006: Performance Review Access
**Description**: Employee can view their own performance reviews (PUBLIC projection) and acknowledge completed reviews through the portal.

---

## 3. RBAC Integration

### FR-ESS-007: Portal RBAC Gating
**Description**: ESS does not own business data. All data access is delegated to the source module's RBAC implementation. The portal checks RBAC grants before rendering any data.

| Feature | RBAC Check | Source Module |
|---------|-----------|---------------|
| View profile | can_view on employee record | ksf_HRM |
| Submit timesheet | can_create on timesheet | ksf_Timesheets |
| Submit leave | can_create on leave_request | ksf_Leave |
| Browse courses | PUBLIC projection (no RBAC gate) | ksf_Training |
| View enrollments | can_view (FULL) on own enrollment | ksf_Training |
| View reviews | can_view (PUBLIC) on own review | ksf_Performance |

### FR-ESS-008: Person Registry Requirement
**Description**: Every portal user must have a crm_persons entry provisioned by ksf_FA_RBAC. The person registry is used for cross-module identity resolution. ESS authenticates against the WordPress user table, which must be linked to the person registry.

### FR-ESS-009: Cross-Module Access
**Description**: When ESS queries data from other modules, it uses the standard RBAC SQL JOIN pattern via the source module's service layer. The logged-in employee's person ID is passed as the RBAC subject for access evaluation.

---

## 4. Document Access

### FR-ESS-010: View Documents
**Description**: Employee can view and download documents linked to their profile (contracts, tax forms, policies). Document access is gated by the source module's RBAC grants.

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-24*
