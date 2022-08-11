<?php
/** @var $login app\models\Login */

use app\core\form\FieldInput;
use app\core\form\FieldTextarea;

?>
<h1>LOGIN</h1>
<?php $form = app\core\form\Form::begin('/login', 'post'); ?>

<?php echo new FieldInput($login, 'email', 'Your email'); ?>
<?php echo new FieldInput($login, 'password', 'Your Password','password'); ?>

<button type="submit" class="btn btn-primary">Submit</button>

<?php app\core\form\Form::end(); ?>