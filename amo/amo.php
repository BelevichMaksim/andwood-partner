<?php

ini_set('display_errors', 1);

$final_result = "";

function get_string_between($string, $start, $end) {
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function Get_Access_Token_with_AUTHCODE () {
    clearstatcache();
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://aristokrats.amocrm.ru/oauth2/access_token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"client_id\":\"129e6dce-beaa-4533-a147-a11fb8c6c203\",\"client_secret\":\"A7tAJZlWJilYOIYuXHR9JwOV2GyqYETpptoOiDrOkcYLzrKKW8xWgo0J7LZmmc6Y\",\"grant_type\":\"authorization_code\",\"code\":\"def5020017df142da2d86ca55c50d86c3476a25b8bae161fa57e5250fec2d2b84ca7ac378b3dcdd9b340cd3abeb8305ff44df23e0755caa34cfb5d5392755f4518c7a97fb1455878723e7954120a9396a6c9f99b127ec6ebb71da34baca4f19434d84b31e053f4362ff644c4ef8aa7e58ffacc7bad865c7b22d6cbf776a99186f291eee233b1d1fc142be684ad409f2ffaf2f8a7f3f6262ca400b4264f11549d746c69a9fb8e11d19ff26fff2edfe376436e7c8289227cefd1a3b3aef0fe6257a1f83a5ca8691b1fcc9ed9f63de9391bbd5d96b197ce29de6bf833107d05e085a4313efa2de37e6a4c27213b4d08e275b67a24106dd5a27110c7a906bd34a92f16b5c162d0593034fd26a0829db43f0495e12bbf16aad9a86f244f30b2fb228a095cbb9a871bfa71e75a9702642150fdebb379055dec25937a45b46acea823bcfaef5a4e3c09985af9cc7f9a53440b56bf54869aaf01a2c2d15a85bedf8fff5809f6326cafaf3d9609076d5e905b05f4554de0f93aba87d80a8cd0ac1fa32806a94471381b01bc516bdc16847cd70d1f6ed1e7ff2e592e7780b461fedcf570a94547264d06a1132eac88c0b8e68b86b77e0bd472e4217617c45c909c0e1ae98c51db70d7e0a04fd45ea0f5d84e47cad08a865b5056c47226dde7f27eb65df8b8d9a748858b455c7abb\",\"redirect_uri\":\"https://andwood-partner.ru/amo/amo.php\"}");

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    echo $result;

    $f = fopen('tokens.txt', 'w');
    fwrite($f, $result . "!!!");
    fclose($f);
}

function Get_Access_Token_with_REFRESHTOKEN () {
    clearstatcache();
    $f = fopen('tokens.txt', 'r');
    $dataToken = fread($f, filesize('tokens.txt'));
    fclose($f);
    $dataToken = get_string_between($dataToken, '"refresh_token":"', '"}!!!');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://aristokrats.amocrm.ru/oauth2/access_token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"client_id\":\"fe041223-1076-4f11-b49b-74ad8eae360d\",\"client_secret\":\"tWnDIQa8bGj0CqIK2EZ9bYO13Vtva76itlxkvLsd2Y5BJkDFQnjUpFm49KPjY0as\",\"grant_type\":\"refresh_token\",\"refresh_token\":\"".$dataToken."\",\"redirect_uri\":\"https://andwood-partner.ru/amo/amo.php\"}");

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $code = (int) $code;

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    if ($code != 200) {
        echo "REFRESH_ERROR: $result\n\n$dataToken";
        exit();
    }

    $f = fopen('tokens.txt', 'w');
    fwrite($f, $result . "!!!");
    fclose($f);
}

function Add_Lead () {
    $name_field = $_POST["username"];
    $phone_field = $_POST["phone"];
    $email_field = $_POST["email"];
    $question_field = $_POST["question"];

    if (!$email_field) $email_field = "";
    if (!$question_field) $question_field = "";

    $data = [
        [
            "name" => $name_field,
            "price" => 0,
            "responsible_user_id" => 0,
            "pipeline_id" => 5232073,
            "_embedded" => [
                "metadata" => [
                    "category" => "forms",
                    "form_id" => 1,
                    "form_name" => "Заявка на партнерку",
                    "form_page" => "Заявка на партнерку",
                    "form_sent_at" => strtotime(date("Y-m-d H:i:s")),
                    "ip" => $_SERVER['REMOTE_ADDR'],
                    "referer" => "andwood-partner.ru"
                ],
                "contacts" => [
                    [
                        "first_name" => $name_field,
                        "custom_fields_values" => [
                        	[
                                "field_code" => "EMAIL",
                                "values" => [
                                    [
                                        "enum_code" => "WORK",
                                        "value" => $email_field
                                    ]
                                ]
                            ],
                            [
                                "field_code" => "PHONE",
                                "values" => [
                                    [
                                        "enum_code" => "WORK",
                                        "value" => $phone_field
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "custom_fields_values" => [
                [
                    "field_id" => 1166573,
                    "values" => [
                        [
                            "value" => $question_field
                        ]
                    ]
                ]
            ]
        ]
    ];

    clearstatcache();
    $f = fopen('tokens.txt', 'r');
    $dataToken = fread($f, filesize('tokens.txt'));
    fclose($f);
    $dataToken = get_string_between($dataToken, '{"token_type":"Bearer","expires_in":86400,"access_token":"', '","refresh_token"');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://aristokrats.amocrm.ru/api/v4/leads/complex');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = "Authorization: Bearer ".$dataToken;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $code = (int) $code;

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    if ($code >= 400 && $GLOBALS['isAttempted'] == false) {
        echo "LEAD >> $result\n\n$dataToken";
        Get_Access_Token_with_REFRESHTOKEN();
        Add_Lead();
        $GLOBALS['isAttempted'] = true;
    } else {
        echo $result;
        $GLOBALS['final_result'] = $result;
    }
}

Add_Lead();

//Get_Access_Token_with_AUTHCODE();