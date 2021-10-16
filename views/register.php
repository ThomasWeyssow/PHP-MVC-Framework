<?php 
    
use app\core\form\Form;
use app\core\Request; 

?>

<h1>Registration</h1>

<?php Form::begin('', Request::POST); ?>
<div class="row">
    <div class="col"><?php Form::field($model, 'firstname', 'First Name', 'text'); ?></div>
    <div class="col"><?php Form::field($model, 'lastname', 'Last Name', 'text'); ?></div>
</div>
<?php Form::field($model, 'email', 'Email', 'text'); ?>
<?php Form::field($model, 'password', 'Password', 'password'); ?>
<?php Form::field($model, 'passwordConfirm', 'Confirm password', 'password'); ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php echo Form::end() ?>