/* ═══════════════════════════════════════════════════════════════════════════
   ORGANIZATION MANAGEMENT FEATURE - SETUP GUIDE
   ═══════════════════════════════════════════════════════════════════════════ */

COMPONENTS CREATED:
───────────────────────────────────────────────────────────────────────────────

1. DATABASE MIGRATION
   File: DBfiles/organization_profile_migration.sql
   Purpose: Adds two new columns to the organization table:
   • org_profile_pic (varchar 500) - Path to organization profile picture
   • org_color (varchar 7) - Organization primary color in hex format

   ACTION REQUIRED: Execute this SQL migration on your database
   ───────────────────────────────────────────────────────────────────────
   ALTER TABLE `organization` 
   ADD COLUMN `org_profile_pic` varchar(500) DEFAULT NULL,
   ADD COLUMN `org_color` varchar(7) DEFAULT '#1a8f7a';
   ───────────────────────────────────────────────────────────────────────


2. API ENDPOINT
   File: management/org-manangement/api.php
   Purpose: Handles all organization data operations
   
   Endpoints:
   • GET  ?action=load&org_id=ID           → Returns org data (JSON)
   • POST ?action=save_name&org_id=ID      → Update organization name
   • POST ?action=save_pic&org_id=ID       → Upload/change profile picture
   • POST ?action=save_color&org_id=ID     → Update organization color
   
   Security:
   ✓ Requires user to be authenticated (via session)
   ✓ Only organization owner can make changes (verified in API)
   ✓ File uploads validated for type, size, and MIME
   ✓ All inputs sanitized and prepared statements used


3. MANAGEMENT PAGE
   File: management/org-manangement/organization_management.php
   Purpose: UI for organization owners to manage their organization
   
   Features:
   ✓ Organization name editing
   ✓ Profile picture upload (with preview)
   ✓ Color picker for organization branding
   ✓ Real-time form validation
   ✓ Status messages for user feedback
   ✓ Auto-save functionality via AJAX
   
   Access: Requires ?org_id=ID query parameter
   Example: /management/org-manangement/organization_management.php?org_id=1


4. STYLING
   File: management/org-manangement/style.css
   Purpose: Complete styling for the organization management interface
   
   Includes:
   ✓ Profile section with avatar upload
   ✓ Color picker interface
   ✓ Form groups and validation states
   ✓ Status message styling
   ✓ Responsive layout


═══════════════════════════════════════════════════════════════════════════════
PERMISSION CHECK - OWNER ONLY
═══════════════════════════════════════════════════════════════════════════════

The API automatically verifies that the current user is the organization owner:

    SELECT o.org_id FROM organization o
    WHERE o.org_id = ? AND o.org_owner = (
       SELECT a.account_id FROM account a WHERE a.username = ?
    )

If verification fails, the API returns HTTP 403 Forbidden with error message.


═══════════════════════════════════════════════════════════════════════════════
FILE UPLOAD DIRECTORY
═══════════════════════════════════════════════════════════════════════════════

Profile pictures are stored in: /assets/images/org-profiles/
The directory is created automatically if it doesn't exist.

Files are named: org_{org_id}_{timestamp}.{ext}
This prevents naming conflicts and makes cleanup easier.


═══════════════════════════════════════════════════════════════════════════════
INTEGRATION WITH MANAGEMENT DASHBOARD
═══════════════════════════════════════════════════════════════════════════════

To link from the management dashboard to this page, use:
    /management/org-manangement/organization_management.php?org_id=123

Where 123 is the organization ID.

You can get the user's organization ID from the org_acc table or session data.


═══════════════════════════════════════════════════════════════════════════════
TESTING CHECKLIST
═══════════════════════════════════════════════════════════════════════════════

Before deploying:

☐ Run the database migration SQL
☐ Test as organization owner - verify can edit name, color, picture
☐ Test as non-owner - verify access denied (HTTP 403)
☐ Test file upload with valid image (JPG, PNG, GIF, WebP)
☐ Test file upload with invalid file type
☐ Test file upload with >5MB file
☐ Test color picker with valid hex color
☐ Test color picker with invalid color format
☐ Verify profile picture preview shows correctly
☐ Verify status messages appear for all actions
☐ Test removing profile picture
☐ Check that old profile pictures are deleted from server


═══════════════════════════════════════════════════════════════════════════════
FUTURE ENHANCEMENTS
═══════════════════════════════════════════════════════════════════════════════

The "Additional Settings" section is ready for expansion. You can add:
• Billing information and payment methods
• Integrations with third-party services
• Organization-wide policies
• Member management
• Audit logs
• API keys
• Custom branding options (fonts, logos, etc.)

All follow the same pattern as the existing features.
