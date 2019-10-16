<?php
// namespace Bookapp\users\index;
$file = dirname(dirname(dirname(__FILE__))) . "\\application_controller.php";
require_once($file);

class Registrationcontroller extends Applicationcontroller {
  public function content_print(){
    $content = "  <div class='main'>
                    <h1> 新規登録</h1>
                    <form action='../../users/create/insert' method='post' class='new-user-form'>
                      <td>
                        <tr>
                          <p>メールアドレス</p>
                          <input type='text' name='email' class='form-input'>
                        </tr>
                        <tr>
                          <p>パスワード</p>
                          <input type='text' name='password'class='form-input'>
                        </tr>
                      </td>
                      <button type='submit' class='btn btn-success btn-lg'>新規登録</button>
                    </form>
                  </div>";
    return[
      "content" => "{$content}"
    ];
  }
}

?>