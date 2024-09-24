<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * Example Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Example extends Model
{
    protected string $param = "param";

    /**
     * Example constructor
     */
    public function __construct()
    {
        parent::__construct(CONF_DB_NAME . ".example", ["id"], [
            $this->param
        ]);
    }
}
