<?php
namespace App\Libraries;

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;
use App\Libraries\customlibraries;
use Modules\global_templates\Models\templates_model;
use Config\Email;

class ses_secret_manager
{
    public $mysqldb;
    protected $error_log;

    public function __construct()
    {        
        $this->mysqldb = \Config\Database::connect('mysqldb'); 
        
    }

    public static function getCredentials()
    {
        try {

            $templates_model = new templates_model();

            $aws_secrets_manager_acc_key_whereConditions = [
                'key_name' => 'AWS_SECRETS_MANAGER_ACCESS_KEY_ID',              
                'status' => 'active',                                   
            ];

            $aws_secrets_manager_acc_key = $templates_model->GetTableValue('credentials_details', 'key_value', $aws_secrets_manager_acc_key_whereConditions);       

            $aws_secrets_manager_sec_key_whereConditions = [
                'key_name' => 'AWS_SECRETS_MANAGER_SECRET_ACCESS_KEY',              
                'status' => 'active',                                   
            ];

            $aws_secrets_manager_sec_key = $templates_model->GetTableValue('credentials_details', 'key_value', $aws_secrets_manager_sec_key_whereConditions);    
        
            if ($aws_secrets_manager_acc_key && $aws_secrets_manager_sec_key) {

                $acc_key = array_column($aws_secrets_manager_acc_key,'key_value');
                $sec_key = array_column($aws_secrets_manager_sec_key,'key_value');

                if (!empty($acc_key) && !empty($sec_key)) {             

                        $client = new SecretsManagerClient([
                            'region' => AWS_SES_REGION,  
                            'version' => 'latest',
                            'credentials' => [
                                'key'    => $acc_key[0],  
                                'secret' => $sec_key[0],  
                            ],
                        ]);
                }
                else
                {
                    log_message('error', 'AWS Secrets Manager credentials not found or inactive in the database.');
                    return null;
                }   

            } else {
                
                log_message('error', 'AWS Secrets Manager credentials not found or inactive in the database.');
                return null;
            }

            // Fetch the secret from Secrets Manager
            $result = $client->getSecretValue([
                'SecretId' => AWS_SECRET_ID,
            ]);

            if (isset($result['SecretString'])) {
                // Decode the SecretString
                $decodedResult = json_decode($result['SecretString'], true);

                if (isset($decodedResult['username']) && isset($decodedResult['password'])) {
                    // Prepare the credentials for email configuration
                    $credentials = [
                        'username' => $decodedResult['username'],
                        'password' => $decodedResult['password'],
                    ];

                   // Get the current Email configuration class instance
                    $config = new Email(); // Instantiate the Email config class

                    // Change only username and password
                    $config->SMTPUser = $credentials['username'];
                    $config->SMTPPass = $credentials['password'];

                    // Reinitialize the email service with the updated config
                    service('email')->initialize($config);

                } else {
                    log_message('error', 'Username or password not found in the decoded SecretString');
                }
            } else {
                log_message('error', 'No SecretString found or empty SecretString');
                return null;
            }
            
        } catch (AwsException $e) {
            $currentURL = current_url();
            $error_log = new customlibraries();  
            $error_log->error_exception_log('Libraries\ses_secret_manager', $currentURL, 'getCredentials', $e->getMessage());
            return null;
        }
    }
}

?>