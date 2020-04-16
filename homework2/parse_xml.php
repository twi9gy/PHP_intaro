<?php
require ('connect.php');
$path_to_xml = "test.xml";
//получаем информацию из файла
$xml_data = file_get_contents($path_to_xml);
str_to_sql($xml_data);


function str_to_sql ($xml_text) {
    global $connection;
    // Проверяем что xml соответствует стандарту
    if(@simplexml_load_string($xml_text)) {
        // Преобразует в SimpleXMLElement
        $xmls = simplexml_load_string($xml_text);
        // Проходим до всем записям
        foreach($xmls as $xml){
            $prepared = $connection->prepare("INSERT INTO users (fullname_user, email_user, gender_user) 
                                                        VALUES (:full_name, :email, :gender)");
            $prepared->bindParam(':full_name',$xml->fullname);
            $prepared->bindParam(':email',$xml->email);
            $prepared->bindParam(':gender',$xml->gender);
            $result = $prepared->execute();
            if ($result)
                echo 'Success'. "\n";
            else
                echo 'Unsuccess';
        }
    } else {
        echo "Файл не соответствует стандарту xml".PHP_EOL;
    }
}
