<?php
require('connect.php');
$date = date('H:i:s d-m-Y');
$date_reverse = date('Y-m-d H:i:s');
$can_create = true;

$prepared = $connection->prepare("SELECT full_name, date_created FROM message WHERE email = :email");
$prepared->bindParam(':email',$_POST['email']);
$res = $prepared->execute();


if ($prepared->rowCount() > 0) {
    $message_info = $prepared->fetch();
    $date1 = new DateTime($message_info['date_created']);
    $date2 = new DateTime($date_reverse);
    $interval = date_diff($date1, $date2);
    if ($interval->h >= 1 && $interval->i > 0) {
        $can_create = true;
    } else{
        $time = new DateTime($message_info['date_created']);
        $time->add(new DateInterval('PT1H'));
        echo json_encode(array('success' => 2, 'text' => $message_info['full_name'].
            ", используйте другой email или повторите попытку после ". $time->format('H:i:s d.m.Y'). "."));
    }
} else{
    if ($can_create) {
        $prepared = $connection->prepare("INSERT INTO message (full_name, email, phone, comment, date_created)
                                                    VALUES (:fullname, :email, :phone, :comment, :date_)");
        $prepared->bindParam(':fullname',$_POST['fullname']);
        $prepared->bindParam(':email',$_POST['email']);
        $prepared->bindParam(':phone',$_POST['phone']);
        $prepared->bindParam(':comment',$_POST['comment']);
        $prepared->bindParam(':date_',$date_reverse);
        $res = $prepared->execute();

        if ($res) {
            $message = "ФИО: ". $_POST['fullname'] ."\n
                        Email: ". $_POST['email'] ."\n
                        Телефон: ". $_POST['phone'] ."\n
                        Дата заявки: ". $date ."\n
                        Комментарий: ". $_POST['comment'] ."\n";
            $to  = "twi9gy@mail.ru";
            $from = "va16_1999@mail.ru";
            $subject = "Сообщение из заявки";
            $headers = "From: $from\r\n";
            $headers .= "Reply-To: $from\r\n";
            $headers .= "Content-type: text/plain; charset=utf-8\r\n";

            if (mail($to, $subject, $message, $headers)) {
                $time = new DateTime($date);
                $time->add(new DateInterval('PT1H30M'));
                preg_match('/([а-яА-Я]+) ([а-яА-Я]+) ([а-яА-Я]+)/',
                    $_POST['fullname'], $matches, PREG_OFFSET_CAPTURE);
                echo json_encode(array('success' => 1, 'block' => "
                                    <p>Имя: ". $matches[1][0] ."</p>
                                    <p>Фамилия: ". $matches[2][0] ."</p>
                                    <p>Отчество: ". $matches[3][0] ."</p>
                                    <p>E-mail: ". $_POST['email'] ."</p>
                                    <p>Телефон: ". $_POST['phone'] ."</p>
                                    <p>C Вами свяжутся после ". $time->format('H:i:s d.m.Y')));
            } else
                echo json_encode(array('success' => 2, 'text' => 'Сообщение не отправлено'));
        } else
            echo json_encode(array('success' => 2, 'text' => "Неудачно."));
    }
}
