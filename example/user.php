<?php
require __DIR__ . "/assets/config.php";
require __DIR__ . "/../vendor/autoload.php";

use vagnerlemos\apifsphp15\Me;
//preenche para qual url, email e senha
$me = new Me(
    "localhost/1/fsphpMVC14/cafeapi/",
    "vagner.lemos@outlook.com",
    "12345678"
);
echo "<h1>Prepara o objeto</h1>";
var_dump($me);


/**
 * me
 */
echo "<h1>me() faz request com curl preenchendo o objeto</h1>";
//Retorna um objeto com o response preenchido como os dados de quem fez login
//preenche método e endpoint e dispatch (curl) que fárá a conexão com o cliente e trará o objeto
$user = $me->me();



var_dump($user);
echo "<h1>Resposta do objeto</h1>";
//do objeto extraio a resposta
var_dump($user->response());
/**
 * update
 */
echo "<h1>UPDATE</h1>";
//Até aqui não foi passado nem get nem post
//filtra se for metodo post senao é null
$update = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
echo "<h1>_POST</h1>";
var_dump($update);

echo "<h1>response</h1>";
if ($update && !empty($update["user"])) {
    $user->update($update);

    if ($user->error()) {
        echo "<p class='error'>{$user->error()->message}</p>";
    } else {
        var_dump($user->response()->user);
    }
}

$userData = $user->me()->response()->user;
?>
    <form action="" method="post">
        <input type="hidden" name="user" value="true"/>
        <input type="text" name="first_name" value="<?= ($userData->first_name ?? null); ?>"/>
        <input type="text" name="last_name" value="<?= ($userData->last_name ?? null); ?>"/>
        <input type="text" name="genre" value="<?= ($userData->genre ?? null); ?>"/>
        <input type="text" name="datebirth" value="<?= ($userData->datebirth ?? null); ?>"/>
        <input type="text" name="document" value="<?= ($userData->document ?? null); ?>"/>
        <button>Atualizar</button>
    </form>
<?php

/**
 * PHOTO
 */
echo "<h1>PHOTO</h1>";

$photo = ($_FILES["photo"] ?? null);

if ($photo) {
    $user->photo($photo);

    if ($user->error()) {
        echo "<p class='error'>{$user->error()->message}</p>";
    } else {
        var_dump($user->me()->response()->user->photo);
    }
}
?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="photo"/>
        <button>Atualizar</button>
    </form>
<?php

