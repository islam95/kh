<?php

	
$form = new Form();
$validation = new Valid($form);
$user = new User();
	
	
// Login form
if($form->isPost('login_email')){
	if($user->exist($form->getPost('login_email'), $form->getPost('login_password'))) {
		Login::userLogin($user->user_id, URL::getRedirectURL());
	} else {
		$validation->inErrors('login');
	}
}


// Registration form
if($form->isPost('first_name')){
	
	$validation->expect = array(
		'first_name',
		'last_name',
		'address_1',
		'address_2',
		'city',
		'county',
		'post_code',
		'country',
		'email',
		'password',
		'confirm_password'
	);
	
	$validation->requirement = array(
		'first_name',
		'last_name',
		'address_1',
		'city',
		'post_code',
		'country',
		'email',
		'password',
		'confirm_password'
	);
	
	$validation->spec_field = array('email' => 'email');
	$validation->remove_post = array('confirm_password');
	$validation->format_post = array('password' => 'password');
	
	// Password validation.
	$p1 = $form->getPost('password');
	$p2 = $form->getPost('confirm_password');
	
	if(!empty($p1) && !empty($p2) && $p1 != $p2){
		$validation->inErrors('password_match');
	}
	
	
	$email = $form->getPost('email');
	$theUser = $user->getByEmail($email);
	
	if(!empty($theUser)){
		$validation->inErrors('same-email');
	}
	
	if($validation->isValid()){
		echo "It is valid!";
		// adding coding to created account
		$validation->post['encode'] = mt_rand().date('YmdHis').mt_rand();
		
		// adding date of registration
		$validation->post['date'] = Check::setDate();
		
		if($user->addUser($validation->post, $form->getPost('password'))) {
			Check::redirect('?page=registered');
		} else {
			Check::redirect('?page=reg-failed');
		}
		
		
	}
	
}
	
require_once('header.php');
require_once('navigation.php');
require_once('sidebar.php');
?>

<div class="log_reg">
<h2>Login</h2>
<form action="" method="post">

	<table class="table_login">
		
		<tr>
			<th>
				<label for="login_email">Login:</label>
			</th>
			<td>
				<?php echo $validation->warn('login'); ?>
				<input type="text" name="login_email" 
					   id="login_email" class="ship_input" 
					   value="" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="login_password">Password:</label>
			</th>
			<td>
				<input type="password" name="login_password" 
					   id="login_password" class="ship_input" 
					   value="" />
			</td>
		</tr>
		
		<tr>
			<th>&nbsp;</th>
			<td>
				<label for="login_button" class="login_button">
					<input type="submit" id="login_button"
						   class="aButton" value="Login" />
				</label>
			</td>
		</tr>
		
	</table>

</form>

<hr>

<h3>Not registered?</h3>

<form action="" method="post">
	
	<table class="table_reg">
		
		<tr>
			<th>
				<label for="first_name">First name: <span>*</span></label>
			</th>
			<td>
				<?php echo $validation->warn('first_name'); ?>
				<input type="text" name="first_name" 
				id="first_name" class="ship_input" 
				value="<?php echo $form->textField('first_name'); ?>" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="last_name">Last name: <span>*</span></label>
			</th>
			<td>
				<?php echo $validation->warn('last_name'); ?>
				<input type="text" name="last_name" 
				id="last_name" class="ship_input" 
				value="<?php echo $form->textField('last_name'); ?>" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="address_1">Address 1: <span>*</span></label>
			</th>
			<td>
				<?php echo $validation->warn('address_1'); ?>
				<input type="text" name="address_1" 
				id="address_1" class="ship_input" 
				value="<?php echo $form->textField('address_1'); ?>" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="address_2">Address 2: </label>
			</th>
			<td>
				<?php echo $validation->warn('address_2'); ?>
				<input type="text" name="address_2" 
				id="address_2" class="ship_input" 
				value="<?php echo $form->textField('address_2'); ?>" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="city">City: <span>*</span></label>
			</th>
			<td>
				<?php echo $validation->warn('city'); ?>
				<input type="text" name="city" 
				id="city" class="ship_input" 
				value="<?php echo $form->textField('city'); ?>" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="county">County: </label>
			</th>
			<td>
				<?php echo $validation->warn('county'); ?>
				<input type="text" name="county" 
				id="county" class="ship_input" 
				value="<?php echo $form->textField('county'); ?>" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="post_code">Postcode: <span>*</span></label>
			</th>
			<td>
				<?php echo $validation->warn('post_code'); ?>
				<input type="text" name="post_code" 
				id="post_code" class="ship_input" 
				value="<?php echo $form->textField('post_code'); ?>" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="country">Country: <span>*</span></label>
			</th>
			<td>
				<?php echo $validation->warn('country'); ?>
				<input type="text" name="country" 
				id="country" class="ship_input" 
				value="<?php echo $form->textField('country'); ?>" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="email">Email: <span>*</span></label>
			</th>
			<td>
				<?php echo $validation->warn('email'); ?>
				<?php echo $validation->warn('same-email'); ?>
				<input type="text" name="email" 
				id="email" class="ship_input" 
				value="<?php echo $form->textField('email'); ?>" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="password">Password: <span>*</span></label>
			</th>
			<td>
				<?php echo $validation->warn('password'); ?>
				<?php echo $validation->warn('password_match'); ?>
				<input type="password" name="password" 
				id="password" class="ship_input" 
				value="" />
			</td>
		</tr>
		
		<tr>
			<th>
				<label for="confirm_password">Confirm password: <span>*</span></label>
			</th>
			<td>
				<?php echo $validation->warn('confirm_password'); ?>
				<input type="password" name="confirm_password" 
				id="confirm_password" class="ship_input" 
				value="" />
			</td>
		</tr>
		
		<tr>
			<th>&nbsp;</th>
			<td>
				<label for="button" class="button">
					<input type="submit" id="button"
						   class="aButton" value="Register" />
				</label>
			</td>
		</tr>

	</table>
	
</form>
</div>



<?php require_once('footer.php'); ?>