# UM Except User IDs
Extension to Ultimate Member Shortcode to exclude logged in user IDs from Pages/Posts.

This shortcode is based on the UM shortcode "Restrict content on a page/post to logged in users".

https://docs.ultimatemember.com/article/177-restrict-content-on-a-page-post-to-logged-in-users

Additional parameter is a list of "except" user ID's either entered in the shortcode or at the UM Settings incl a Lockout text.
## Shortcode
1. Setting except User IDs via UM Settings: [um_except_user_ids]  ... page/post content ...  [/um_except_user_ids]
2. Setting except User IDs via the shortcode [um_except_user_ids except="4568,4569"]  ... page/post content ... [/um_except_user_ids]
3. Additional parameters show_lock="yes", show_lock="no", lock_text=" ... text ... " for logged out users
4. Lockout text for User IDs is set from UM Settings
## Settings
UM Settings -> Access -> Other
1. Except User IDs - User ID list
2. Except User IDs - Lock out text
## Installation
Download the zip file and install as a WP Plugin, activate the plugin.
