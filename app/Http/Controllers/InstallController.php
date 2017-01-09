<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

use App\User;

use Validator;

class InstallController extends Controller
{
	/**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    public function index()
    {
        if(file_exists(storage_path('installed'))){
            return view('install-done');
        }else{
            return view('install');
        }
    	
    }

    public function install(Request $request)
    {
    	$v = Validator::make($request->all(), [
			"db_database" => "required",
		  	"db_username" => "required",
		  	"db_password" => "required",
		  	"name" => "required",
		  	"email" => "required|email",
		  	"password" => "required|min:6|confirmed",
		  	"password_confirmation" => "required|min:6"
    		]);

    	if ($v->fails()) {
    		return back()->withErrors($v)->withInput();
    	}

    	$fields = $this->getEnvData();

    	$fields['DB_DATABASE'] = trim($request->db_database);
    	$fields['DB_USERNAME'] = trim($request->db_username);
    	$fields['DB_PASSWORD'] = trim($request->db_password);
    	$fields['MAIL_HOST'] = trim($request->mail_host);
    	$fields['MAIL_PORT'] = trim($request->mail_port);
    	$fields['MAIL_USERNAME'] = trim($request->mail_username);
    	$fields['MAIL_PASSWORD'] = trim($request->mail_password);
    	$fields['MAIL_ENCRYPTION'] = trim($request->mail_encryption);
    	$fields['ADMIN_NAME'] = '"'.trim($request->name).'"';
    	$fields['ADMIN_EMAIL'] = trim($request->email);
    	$fields['ADMIN_PASS'] = trim($request->password);

    	$this->saveFile($fields);

    	Artisan::call('key:generate');
    	
        $installResult = $this->migrateAndSeed();

        if ($installResult['status'] == 'danger') {
        	Artisan::call('migrate:rollback');
        	return back()->withErrors(['Falha na instalação']);
        }

        $this->createAdmin($request);

        file_put_contents(storage_path('installed'), '');

        return redirect('/login');
    }

    public function createAdmin($request)
    {
    	try{
            User::create([
	        	'name' => trim($request->name),
	        	'email' => trim($request->email),
	        	'password' => Hash::make(trim($request->password)),
	        	'company' => 1,
	        	'status' => 'active'
        	]);
        }
        catch(Exception $e){
            return $this->response($e->getMessage());
        }
    }

    /**
     * Migrate and seed the database.
     *
     * @return array
     */
    public function migrateAndSeed()
    {
        $this->sqlite();
        return $this->migrate();
    }

    /**
     * Run the migration and call the seeder.
     *
     * @return array
     */
    private function migrate()
    {
        try{
            Artisan::call('migrate', ["--force"=> true ]);
        }
        catch(Exception $e){
            return $this->response($e->getMessage());
        }

        return $this->seed();
    }

    /**
     * Seed the database.
     *
     * @return array
     */
    private function seed()
    {
        try{
            Artisan::call('db:seed');
        }
        catch(Exception $e){
            return $this->response($e->getMessage());
        }

        return $this->response('Instalação Realizada com Sucesso!', 'success');
    }

    /**
     * Return a formatted error messages.
     *
     * @param $message
     * @param string $status
     * @return array
     */
    private function response($message, $status = 'danger')
    {
        return array(
            'status' => $status,
            'message' => $message
        );
    }
    
        /**
     * check database type. If SQLite, then create the database file.
     */
    private function sqlite()
    {
        if(\DB::connection() instanceof SQLiteConnection) {
            $database = \DB::connection()->getDatabaseName();
            if(!file_exists($database)) {
                touch($database);
                \DB::reconnect(Config::get('database.default'));
            }
        }
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (!file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Save the edited content to the file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFile(Array $input)
    {
        $message = true;
        $content = "";
        
        for ($i=0; $i < count($input); $i++) { 
        	$content .= key($input)."=". current($input)."\r\n";
        	next($input);
        }

        try {
            file_put_contents($this->envPath, $content);
        }
        catch(Exception $e) {
            $message = $e->getMessage();
        }

        return $message;
    }

    public function getEnvData()
    {
    	$env = $this->getEnvContent();

    	$result = [];
    	$result[] = array_filter(array_map("trim", explode("\n", $env)));
    	$view = [];
    	foreach ($result[0] as $res) {
    		$field = explode('=', $res);
    		$view[$field[0]] = $field[1];
    	}

    	return $view;
    }
}
