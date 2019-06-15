<!-- <?php
// форма создания опроса
require_once '../rbac/core/init.php';

if(Poll_create::exists()) {
    $poll_create = new Poll_create();
    $poll_check = $poll_create->check($_POST, array(
        'poll_name' => array(
            'required' => true
        ),
        'poll_desc' => array(
            'required' => true
        ),
        'variant' => array(
            'required' => true
        )
        ));
} else {
    foreach($poll_create->errors() as $error) {
        echo $error, '<br />';
}

?> -->

<form action="" method="post">
    <div class="field">
        <label for="header">Название опроса</label>
        <input type="text" name="poll_name" id="poll_name" autocomplete="off">
    </div><br />
    <div class="field">
        <label for="description">Описание опроса</label>
        <!-- <input type="text" name="poll_desc" id="poll_desc" autocomplete="off"> -->
        <textarea name="poll_desc" id="poll_desc" cols="30" rows="5"></textarea>
    </div><br />

    <div class="field">
        <label for="variant">Вариант ответа1<label>
        <input type="text" name="variant" id="variant">
    </div><br />

    <div class="field">
        <label for="variant">Вариант ответа2<label>
        <input type="text" name="variant" id="variant">
    </div><br />

    <input type="submit" value="Создать">
</form>