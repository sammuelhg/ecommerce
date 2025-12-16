# Marketing Analytics & ROI Dashboard Implementation

I have implemented the core backend tracking and reporting capabilities for the Marketing Engine.

## Changes

### 1. Database Schema
Added support for performance tracking directly in the database to ensure fast reporting:
- **Campaigns Table**: Added `generated_revenue` and `conversion_count`.
- **Campaign Emails Table**: Added `sent_count`.

### 2. Actions
#### [NEW] [GetCampaignRoiReportAction](file:///c:/xampp/htdocs/ecommerce/ecommerce-hp/app/Actions/Analytics/GetCampaignRoiReportAction.php)
Calculates key performance indicators (KPIs) for any given campaign:
- **Open Rate**: Unique Opens / Sent Count.
- **Conversion Rate**: Conversions / Unique Opens.
- **Revenue**: Total attributed revenue.
- **AOV**: Average Order Value.

### 3. Models
- **[Campaign](file:///c:/xampp/htdocs/ecommerce/ecommerce-hp/app/Models/Campaign.php)**: Added `opens` relationship and analytics fields.
- **[CampaignEmail](file:///c:/xampp/htdocs/ecommerce/ecommerce-hp/app/Models/CampaignEmail.php)**: Added `sent_count` support.

## Verification
- **Code Audit**: Validated that `AttributeConversionAction` correctly increments the new columns on the `Campaign` model.
- **Migrations**: Created and queued migrations to update the schema structure securely.

## Next Steps
- **Visualization**: Connect `GetCampaignRoiReportAction` to a Livewire Component (e.g., `CampaignDashboard`).
- **Integration**: Implement `SendConversionEventToMetaAction` to push these conversions to Facebook CAPI.
