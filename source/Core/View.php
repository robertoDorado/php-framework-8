<?php

namespace Source\Core;

use League\Plates\Engine;

/**
 * Class View
 * @package Source\Core
 */
class View
{
    /**
     * @var Engine
     */
    private $engine;

    /**
     * @param string $path
     * @param string $ext
     */
    public function __construct(string $path = CONF_VIEW_PATH, string $ext = CONF_VIEW_EXT)
    {
        $this->engine = new Engine($path, $ext);
    }

    /**
     * @param string $name
     * @param string $path
     * @return View
     */
    public function path(string $name, string $path): View
    {
        $this->engine->addFolder($name, $path);
        return $this;
    }

    /**
     * @param string $templateName
     * @param array $data
     * @return string
     */
    public function render(string $templateName, array $data): string
    {
        if (preg_match("/\//", $templateName)) {
            $templateNameArray = explode("/", $templateName);
            $templateName = array_pop($templateNameArray);
            
            foreach ($templateNameArray as $template) {
                $this->engine->addData($data, $template);
            }
        }
        return $this->engine->render($templateName, $data);
    }

    /**
     * @return \League\Plates\Engine
     */
    public function engine(): Engine
    {
        return $this->engine();
    }
}
