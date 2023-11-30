AWS Cloud Connecter, Login Module File Movement Steps:
1)Public Folder ('index.php', .htaccess, assets) file/folder move to main folder
2)index.php file open to require FCPATH . './app/Config/Paths.php'; path dot removed
3).htaccce file changed -> RewriteBase /cloud_connector => Subfolder Name Setup Enabled
4)Database File connection "Postgre" P Caps Set Done ( 'DBDriver' => 'Postgre')
5)route_to() -> base URL set to solved redirect not found issues
6)App->Config->App.php => $baseURL = 'http://3.110.35.56/cloud_connector/';