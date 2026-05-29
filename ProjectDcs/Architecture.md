# Architecture - ksf_ESS

## Document Information
- **Module**: ksf_ESS
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Proposed
- **Author**: KSFII Development Team

---

## 1. Module Overview

ksf_ESS provides Employee Self-Service portal functionality as a WordPress plugin.

### 1.1 Namespace
```php
Ksfraser\ESS\
```

### 1.2 WordPress Plugin Structure
```
ksf_ESS/
├── hooks.php
├── includes/
├── pages/
└── src/
```

---

## 2. WordPress Integration

| Component | Description |
|-----------|-------------|
| hooks.php | Plugin hooks |
| pages/ | ESS pages |
| includes/ | Shared includes |

## 3. RBAC Integration (ksfraser/rbac)

ksf_ESS is a WordPress portal module that surfaces employee self-service views into data owned by other modules (HRM, Timesheets, Leave, Training, Performance). It does NOT own its own business data — it's a presentation layer.

### 3.1 RBAC Role

ESS acts as a gate that controls WHICH modules' data is visible to the employee via the portal. The employee's RBAC team membership determines:

| Portal Feature | Source Module | RBAC Gate |
|---------------|---------------|-----------|
| View profile | ksf_HRM (employee) | Employee's {userId}_individual team with can_view on own employee record |
| View timesheets | ksf_Timesheets | Employee's individual team with can_view on own timesheets |
| Submit leave request | ksf_Leave | Employee's individual team with can_create on leave_request |
| View training enrollments | ksf_Training | Employee's individual team with can_view on own enrollments |
| View performance reviews | ksf_Performance | Employee's individual team with can_view on own reviews |

### 3.2 Portal Access Control

- ESS does NOT register its own record types with RBAC
- Portal access is determined by the underlying module's RBAC grants for the logged-in employee
- The ESS portal uses the standard RBAC SQL JOIN pattern when querying data from other modules via their service interfaces
- Employee identity is resolved through the FA person registry (0_crm_persons/0_crm_contacts)

### 3.3 Persons Registry

ESS requires that every portal user has a crm_persons entry (provisioned by ksf_FA_RBAC) for cross-module identity resolution.

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-24*
