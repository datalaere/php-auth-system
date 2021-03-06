<?php
require_once 'src/core/init.php';

use Classes\Request;
use Classes\Validate;
use Classes\Database;
use Classes\Error;
use Classes\Config;
use Classes\Token;

if(!Request::token()) {

$db = new Database(Config::get('db'));
$error = new Error;

$rules = [
    'username' => [
        'required' => true,
        'max' => 20,
        'min' => 3,
        'alnum' => true,
        'unique' => 'users'
    ],
    'password' => [
        'required' => true,
        'min' => 6
    ],
    'password_match' => [
        'match' => 'password'
    ],
    'name' => [
        'required' => true
    ]
];

$simple_rules = [
    'name' => 'required',
    'username' => 'required|unique:users|max:20|min:3|alnum',
    'password' => 'required|min:6',
    'password_match' => 'required|match:password'

];
    $validater = new Validate($db, $error);
    $validation = $validater->validate($simple_rules);

    if($validation->fails()) {
        foreach($validation->errors()->get() as $errors) {
            foreach($errors as $error) {
                e($error . '<br>', true);
            }
        }
    }
} else {
    echo 'ERROR!';
}
?>

<form action="" method="post">
    <div class="field">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="<?php e(Request::old('name')); ?>" autocomplete="off">
    </div>

    <div class="field">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?php e(Request::old('username')); ?>" autocomplete="off">
    </div>

    <div class="field">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" autocomplete="off">
    </div>

    <div class="field">
    <label for="password_match">Password repeat</label>
    <input type="password" name="password_match" id="password_match" autocomplete="off">
    </div>

    <?php e(Token::csrf(), true) ?>
    <input type="submit" value="Register">
</form>