<h2>Please log in to continue</h2>
<?= Form::open(); ?>

<?= Form::email("email", null, array("class"=>"required email form-control", "placeholder"=>"email", "autocomplete"=>"off")); ?>
<?= Form::password("password", array("class"=>"form-control", "placeholder"=>"password")); ?>

<?= Form::button("Log in", array("type"=>"submit", "class"=>"btn btn-primary")); ?>

<?= Form::close(); ?>