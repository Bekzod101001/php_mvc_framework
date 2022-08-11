<?php
/** @var $model app\models\User */
?>
<h1>REGISTER</h1>

<?php $form = app\core\form\Form::begin('/register', 'post'); ?>

<?php echo new app\core\form\FieldInput($model, 'name', 'Your name'); ?>
<?php echo new app\core\form\FieldInput($model, 'surname', 'Your surname'); ?>
<?php echo new app\core\form\FieldInput($model, 'email', 'Your email'); ?>
<?php echo new app\core\form\FieldInput($model, 'password', 'Your password','password'); ?>

<button type="submit" class="btn btn-primary">Submit</button>

<?php app\core\form\Form::end(); ?>