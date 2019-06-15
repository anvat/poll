<?php
//обрабатывается в Input.php
require_once '../rbac/core/init.php';

if(Input::exists()) {
   $validate = new Validate();
   $validation = $validate->check($_POST, array(
       'username' => array(
           'required' => true,
           'min' => 2,
           'max' => 20,
           'unique' => 'users'
       ),
       'password' => array(
           'required' => true,
           'min' => 6
       ),
       'password_again' => array(
           'required' => true,
           'matches' => 'password'
       ),
       'name' => array(
           'required' => true,
           'min' => 2,
           'max' => 50
       )

   ));

   if($validation->passed()) {
       echo 'Passed';
   } else {
        foreach($validation->errors() as $error) {
            echo $error, '<br />';
        }
   }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="username">Имя пользователя</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Введите пароль<label>
        <input type="password" name="password" id="password">
    </div>

    <div class="field">
        <label for="password_again">Повторите пароль<label>
        <input type="password" name="password_again" id="password_again">
    </div>

    <div class="field">
        <label for="name">Ваше имя<label>
        <input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name">
    </div>

    <input type="submit" value="Зарегистрировать">
</form>