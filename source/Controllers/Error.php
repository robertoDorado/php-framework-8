<?php
namespace Source\Controllers;

use DateTime;
use Laminas\Diactoros\ResponseFactory;
use Source\Core\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Error Controllers
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Controllers
 */
class Error extends Controller
{
    /** @var array Path da View */
    private array $path = [];

    /**
     * Error constructor
     */
    public function __construct()
    {
        $this->path = ['fail', sprintf("%s/%s", CONF_VIEW_PATH, CONF_VIEW_THEME)];
        parent::__construct();
    }
    
    public function index(Request $request, Response $response, $args): Response
    {
        return $this->view($response, $this->path, "fail::error", [
            "title" => "Error",
            "status_code" => $args['status_code']
        ], $args['status_code']);
    }

   /**
    * process Error
    *
    * @param integer $statusCode
    * @param string $exceptionMessage
    * @return void
    */
    public function process(int $statusCode, string $exceptionMessage): void
    {
        $path = dirname(dirname(__DIR__)) . "/Logs/error.log";
        $dateTime = new DateTime();
        $log = "Datetime " . $dateTime->format("Y-m-d H:i:s") . " - " . $exceptionMessage . PHP_EOL;

        file_put_contents($path, $log, FILE_APPEND);
        redirect("/ops/error/{$statusCode}");
    }
}
