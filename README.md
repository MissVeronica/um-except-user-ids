# UM Except Users Shortcode
Extension to Ultimate Member Shortcode to exclude logged in Users from Pages/Posts.

This shortcode is based on the UM shortcode "Restrict content on a page/post to logged in users".

https://docs.ultimatemember.com/article/177-restrict-content-on-a-page-post-to-logged-in-users

Additional parameter is a list of "except" user ID's either entered in the shortcode or at the UM Settings incl a Lockout text.
## Shortcode
1. Setting with the except User IDs via UM Settings: [um_except_user_ids]  ... page/post content ...  [/um_except_user_ids]
2. Setting with the except User IDs via the shortcode [um_except_user_ids except="4568,4569"]  ... page/post content ... [/um_except_user_ids]
3. Additional parameters show_lock="yes", show_lock="no", lock_text=" ... text ... " for logged out users
4. Lockout text for User IDs is set from UM Settings
5. If the except parameter in the shortcode is being used this User ID list will override the UM Setting of except User IDs
6. Default UM Template ('login-to-view.php') is being used for Lock and Lockout text.
7. Setting with one meta_key where a meta_value make the current user of the post/Page status to be excluded from viewing the content.
8. Highest parameter priority "meta_key:meta_value".
## Settings
UM Settings -> Access -> Other
1. Except Users - User ID list
2. Except Users - meta_key:meta_value
3. Except Users - Lock out text
## Installation
Download the zip file and install as a WP Plugin, activate the plugin.
