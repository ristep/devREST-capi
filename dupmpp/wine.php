<?php
require "conn.php";
require "rest.inc.php";
error_reporting(E_ALL ^ E_DEPRECATED);
    
class Wine extends REST
{

    public $data = "";

    private $db = $conn;

    public function __construct()
    {
        parent::__construct();                // Init parent contructor
    }

    /*
 * Public method for access api.
 * This method dynmically call the method based on the query string
 *
 */
    public function processApi()
    {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'])));
        if ((int)method_exists($this, $func) > 0) {
            $this->$func();
        } else {
            $this->response('', 400);                // If the method not exist with in this class, response would be "Page not found".
        }
    }

    /*************API SPACE START*******************/

    private function about()
    {

        if ($this->get_request_method() != "POST") {
            $error = array('status' => 'WRONG_CALL', "msg" => "The type of call cannot be accepted by our servers.");
            $error = $this->json($error);
            $this->response($error, 406);
        }
        $data = array('version' => '0.1', 'desc' => 'This API is created by Blovia Technologies Pvt. Ltd., for the public usage for accessing data about vehicles.');
        $data = $this->json($data);
        $this->response($data, 200);
    }



    /*************API SPACE END*********************/

    function json($data)
    {
        if (is_array($data)) {
            return json_encode($data, JSON_PRETTY_PRINT);
        }
    }
}

    // Initiiate Library

    $api = new API;
    $api->processApi();
