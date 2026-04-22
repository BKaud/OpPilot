/* ═══════════════════════════════════════════════════════════════════════════
   INTEGRATION GUIDE - Link Organization Management to Dashboard
   ═══════════════════════════════════════════════════════════════════════════ */

QUICK START:
───────────────────────────────────────────────────────────────────────────────

The Organization Management feature is now available at:
/management/org-manangement/organization_management.php?org_id=ID


INTEGRATION POINTS:
───────────────────────────────────────────────────────────────────────────────

1. FROM MANAGEMENT DASHBOARD
   Location: management/management-dashboard/management-dashboard.php
   
   Option A: Update the existing "Organization Management" button to link to the page
   
   Option B: Add a new link within the dashboard section
   
   Example URL: /management/org-manangement/organization_management.php?org_id=1


2. GETTING ORGANIZATION ID
   
   From Session:
   $org_id = $_SESSION['org_id'] ?? null;
   
   From User's Account (via database):
   SELECT oa.org_acc_org_id FROM org_acc oa
   JOIN account a ON a.account_id = oa.org_acc_acc_id
   WHERE a.username = ?
   
   From Query Parameter:
   ?org_id=123


3. PERMISSION VERIFICATION
   
   The API endpoint (api.php) automatically verifies the user is the org owner.
   If the user is NOT the owner, they will receive HTTP 403 Forbidden.
   
   The frontend page checks if org_id is provided. If not, it shows:
   "No organization selected. Please select an organization from the dashboard."


═══════════════════════════════════════════════════════════════════════════════
EXAMPLE IMPLEMENTATIONS
═══════════════════════════════════════════════════════════════════════════════

SIMPLE DIRECT LINK (if you know the org_id):
─────────────────────────────────────────────────────────────────────────────
<a href="/management/org-manangement/organization_management.php?org_id=1">
    Manage Organization
</a>


DYNAMIC LINK (from session):
─────────────────────────────────────────────────────────────────────────────
<?php
$org_id = $_SESSION['org_id'] ?? null;
if ($org_id) {
    echo '<a href="/management/org-manangement/organization_management.php?org_id=' . htmlspecialchars($org_id) . '">';
    echo 'Manage Organization</a>';
} else {
    echo '<span class="text-muted">No organization assigned</span>';
}
?>


DASHBOARD BUTTON UPDATE:
─────────────────────────────────────────────────────────────────────────────
Update the management dashboard button to navigate to:

JavaScript approach:
    document.querySelector('[data-section="org"]').addEventListener('click', () => {
        const orgId = '<?php echo $_SESSION['org_id'] ?? ''; ?>';
        if (orgId) {
            window.location.href = '/management/org-manangement/organization_management.php?org_id=' + orgId;
        }
    });


VERIFICATION FLOW:
─────────────────────────────────────────────────────────────────────────────
1. User visits: /management/org-manangement/organization_management.php?org_id=1
2. Page checks if org_id parameter is present
3. Page calls api.php?action=load&org_id=1
4. API verifies user is authenticated AND is the org owner
5. If permission check passes, organization data is loaded
6. If permission check fails, API returns HTTP 403
7. User can edit name, color, and profile picture
8. All changes go through api.php with same permission verification


═══════════════════════════════════════════════════════════════════════════════
NAVIGATION BREADCRUMB
═══════════════════════════════════════════════════════════════════════════════

The page displays:
Admin › Management › [Organization Name]

The organization name is automatically populated from the database and updates
when the user changes the organization name.


═══════════════════════════════════════════════════════════════════════════════
NEXT STEPS
═══════════════════════════════════════════════════════════════════════════════

1. ✓ Database migration applied (org_profile_pic, org_color columns added)
2. ✓ API endpoint created and secured
3. ✓ UI page built with forms
4. → Integrate link into management dashboard
5. → Test as organization owner
6. → Add additional settings as needed (billing, integrations, policies, etc.)


═══════════════════════════════════════════════════════════════════════════════
TROUBLESHOOTING
═══════════════════════════════════════════════════════════════════════════════

Issue: Page shows "No organization selected"
Solution: Make sure you pass ?org_id=123 in the URL

Issue: HTTP 403 "You do not have permission"
Solution: Verify the logged-in user is the organization owner in the database
        SELECT * FROM organization WHERE org_id = 123
        Check that org_owner = current user's account_id

Issue: Profile picture not saving
Solution: Verify /assets/images/ directory exists and is writable
        Check file permissions on the directory (755+)
        Verify MIME type validation in api.php

Issue: Color picker not showing
Solution: Clear browser cache
        Verify style.css is being loaded
        Check browser console for JavaScript errors
