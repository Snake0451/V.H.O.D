<?php
error_reporting(E_ALL ^ E_DEPRECATED); 
$link = mysqli_connect("localhost", "root", "", "entrance") or die (mysqli_error($link)); //Попытка подключения к БД
mysqli_set_charset($link, "utf8");  //настройка кодировки
if (mysqli_connect_errno()) {  //проверка соединение с БД
    printf("Connect failed: %s\n", mysqli_connect_error()); 
    exit();
}


$data = $_POST; //получение условных данных
$login = "\"" . strval($data['login']) . "\""; //поле данных с логином
$password = "\"" . strval($data['password']) . "\""; //поле условным с паролем
$korp = "\"" . strval($data['korp']) . "\""; //поле данных с номером корпуса

$check = mysqli_query($link, "select id from users where login like $login and password like $password");  //Найти пользователя по логину и паролю в БД

if(mysqli_num_rows($check) > 0)  //если пользователь существует...
    mysqli_query($link, "INSERT INTO `entrance`.`querries` (`login`, `password`, `korp`) VALUES ($login, $password, $korp)"); //внести запрос в очередь на обработку
$responce[] = mysqli_fetch_array($check);  //

mysqli_close($link);
header('Content-type: application/json');
echo json_encode(array("responce"=>$responce, true));
file_put_contents('C:\test.txt', json_encode(array("responce"=>$responce)));//записать данные о пользователе в текстовый файл
?>
