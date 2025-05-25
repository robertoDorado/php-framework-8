<?php

function verifyRequestHttpOrigin(?string $serverOrigin)
{
    $allowedOrigin = [
        CONF_URL_BASE,
        CONF_URL_TEST
    ];

    $origin = !empty($serverOrigin) ? $serverOrigin : '';
    if (!in_array($origin, $allowedOrigin)) {
        header("Content-Type: application/json");
        http_response_code(403);
        echo json_encode([
            'error' => 'acesso negado',
            'code' => 403
        ]);
        die;
    }
}


function uploadFileData(array $requestFiles, string $filePath): void
{
    if (empty($requestFiles["error"])) {
        $maxFileSize = 1 * 1024 * 1024;
        $fileSize = $requestFiles['size'];

        if ($fileSize > $maxFileSize) {
            throw new \Exception("arquivo inválido, tamanho máximo permitido é de 1MB.");
        }

        if (!is_dir($filePath)) {
            mkdir($filePath, 0777, true);
        }

        $fileDestination = $filePath . "/" . basename($requestFiles["name"]);
        $verifyImage = getimagesize($requestFiles["tmp_name"]);

        if (!$verifyImage) {
            throw new \Exception("arquivo inválido");
        }

        if (!move_uploaded_file($requestFiles["tmp_name"], $fileDestination)) {
            throw new \Exception("erro no upload do arquivo");
        }
    }
}

function dumpAndDie($data)
{
    var_dump($data);
    die;
}

function printData($data) 
{
    echo "<pre/>";
    print_r($data);
    die;
}

function session() {
    return new \Source\Core\Session();
}

function executeMigrations(string $instance)
{
    echo "------------ CLASSE: " . $instance . " -----------------\n";
    $object = new $instance();
    $classMethods = get_class_methods($instance);
    $ddlClassMethods = get_class_methods(\Source\Migrations\Core\DDL::class);

    $diffMethods = array_diff($classMethods, $ddlClassMethods);
    $methods = array_reverse($diffMethods);

    foreach ($methods as $method) {
        if ($method != "__construct") {
            echo "EXECUTANDO: " . $method . "\n";
            $object->$method();
        }
    }
    echo "----------------------------------------------\n";
}

function transformCamelCaseToSnakeCase(array $args)
{
    foreach ($args as &$originalString) {
        $transformedString = preg_replace('/([a-z])([A-Z])/', '$1_$2', $originalString);
        $originalString = strtolower($transformedString);
    }
    return $args;
}

/**
 * @param string $path
 * @return string
 */
function url(string $path = null): string
{
    if (str_replace("www.", "", $_SERVER['HTTP_HOST']) == "localhost") {
        if ($path) {
            return CONF_URL_TEST .
                "/" .
                ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST;
    }

    if ($path) {
        return CONF_URL_BASE .
            "/" .
            ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}

/**
 * @param string|null $path
 * @param string $theme
 * @return string
 */
function theme(string $path = null, string $theme = CONF_VIEW_THEME): string
{
    if (str_replace("www.", "", $_SERVER['HTTP_HOST']) == "localhost") {
        if ($path) {
            return CONF_URL_TEST . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST . "/themes/{$theme}";
    }

    if ($path) {
        return CONF_URL_BASE . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE . "/themes/{$theme}";
}

/**
 * @param string $url
 * @return void
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit();
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit();
    }
}

/**
 * filter_type: Principais campos de consulta para os relatórios. O que não estiver
 * nessa lista será tratado como FILTER_SANITIZE_STRIPPED pelos helpers de filtro
 * @return null|array
 */
function filter_type(): array
{
    $filterFields = [
        "route" => FILTER_SANITIZE_SPECIAL_CHARS,
        "product" => FILTER_SANITIZE_NUMBER_INT,
        "product_id" => FILTER_SANITIZE_NUMBER_INT,
        "country" => FILTER_SANITIZE_SPECIAL_CHARS,
        "device" => FILTER_SANITIZE_NUMBER_INT,
        "redirect" => FILTER_SANITIZE_ENCODED,
        "status" => FILTER_SANITIZE_NUMBER_INT,
        "upsell" => FILTER_SANITIZE_NUMBER_INT,
        "paymentMethod" => FILTER_SANITIZE_NUMBER_INT,
        "company" => FILTER_SANITIZE_NUMBER_INT,
        "affiliate" => FILTER_SANITIZE_NUMBER_INT,
        "level" => FILTER_SANITIZE_NUMBER_INT,
        "group_id" => FILTER_SANITIZE_NUMBER_INT,
        "report_id" => FILTER_SANITIZE_NUMBER_INT,
    ];
    return $filterFields;
}

/**
 * filter_array: Filtrar campos de array ou globais GET e POST
 * @param array $array
 * @return array
 */
function filter_array(array $array): array
{
    $filterFields = filter_type();

    foreach ($array as $key => $value) {
        if (in_array($key, array_keys($filterFields))) {
            $filterArr[$key] = $filterFields[$key];
        } else {
            $filterArr[$key] = FILTER_SANITIZE_SPECIAL_CHARS;
        }
    }
    return filter_var_array($array, $filterArr);
}

/**
 * @param string $string
 * @param string $type = int, string, chars, etc
 * @return string
 */
function filter_variable(string $string, $type = null): string
{
    if (!empty($type)) {
        $type = mb_convert_case($type, MB_CASE_LOWER);

        if ($type == 'default') {
            return filter_var($string, FILTER_DEFAULT);
        } elseif ($type == 'int') {
            return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
        } elseif ($type == 'string') {
            return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
        } elseif ($type == 'chars') {
            return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
        } elseif ($type == 'mail' || $type == 'email') {
            return filter_var($string, FILTER_VALIDATE_EMAIL);
        }
    }
    return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
}
