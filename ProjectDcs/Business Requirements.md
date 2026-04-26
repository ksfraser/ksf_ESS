# Business Requirements - ksf_ESS

## Project Overview
Employee Self Service (ESS) - WordPress plugin providing employee access to HRM functions.

## Problem Statement
- Employees need self-service access
- Similar to WP Customer Portal but for employees
- Web access for leave requests, timesheets, profile

## Scope

### Features
1. **Employee Dashboard**
   - My Tasks
   - My Leave Balance
   - My Timesheets
   - My Profile

2. **Leave Self-Service**
   - Submit leave request
   - View leave balance
   - View leave history

3. **Timesheet Self-Service**
   - Enter time for week
   - View submitted timesheets
   - View approved hours

4. **Profile**
   - View employee info
   - Update emergency contacts
   - View pay stubs (if available)

5. **My Documents**
   - View assigned documents
   - Acknowledge policies

### Technical
- WordPress plugin
- Integrates with all HRM APIs
- Uses WP user authentication
- Role-based access (employee vs manager)

## Integration
- ksf_HRM: Employee data
- ksf_Leave: Leave requests
- ksf_Timesheets: Time entry
- ksf_Documents: Policy acknowledgment