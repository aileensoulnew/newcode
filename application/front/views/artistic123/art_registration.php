<!DOCTYPE html>
<html>
<head>

</head>
<body>

<!--Field validation javascript-->


 <?php echo form_open(base_url('artistic/art_registration'), array('id' => 'regform','name' => 'regform')); ?>

<fieldset><legend>Registration Form</legend><br>
	
<table>



<tr>
<label>Name <span style="color:red">*</span></label>
 <input type="text" name="name" id="name" placeholder="NAME" />&nbsp;&nbsp;&nbsp; <span id="name-error"> </span>
<?php echo form_error('name'); ?>
</tr><br><br>

<tr>
<label>Email Address <span style="color:red">*</span></label>
 <input type="text" name="email" id="email" placeholder="EMAIL ADDRESS"/>&nbsp;&nbsp;&nbsp; <span id="email-error"> </span>
 <?php echo form_error('email'); ?>
</tr><br><br>

<tr>
<label>Mobile Number <span style="color:red">*</span></label>
 <input type="text" name="phnno" id="phnno" placeholder="MOBILE NUMBER"/>&nbsp;&nbsp;&nbsp; <span id="phnno-error"> </span>
 <?php echo form_error('phnno'); ?>
</tr><br><br>

<tr>
<label><b>Address<span style="color:red">*</span></b></label>
</tr><br><br>

<tr>

<select name="country" >
    <option value="" SELECTED disabled>--SELECT COUNTRY--</option>
    <option value="afghanistan">Afghanistan</option>
    <option value="india">India</option>    
</select>
<?php echo form_error('country'); ?>
</tr>

<tr>
<select name="state">
    <option value="" SELECTED disabled>--SELECT STATE--</option>
    <option value="gujarat">Gujarat</option>
    <option value="rajstan">Rajstan</option>    
</select>
<?php echo form_error('state'); ?>
</tr>

<tr>

<select name="city">
    <option value="" SELECTED disabled>--SELECT CITY--</option>
    <option value="ahmedabad">Ahmedabad</option>
    <option value="udaipur">Udaipur</option>    
</select>
<?php echo form_error('city'); ?>
</tr>

<tr>
<select name="area">
    <option value="" SELECTED disabled>--SELECT AREA--</option>
    <option value="shivranjni">Shivranjni</option>
    <option value="motibag">Motibag</option>    
</select>
<?php echo form_error('area'); ?>
</tr><br><br>

<tr>
 <textarea name="address" id="address" rows="5" cols="40" placeholder="Address" style="resize: none;"></textarea>
 <?php echo form_error('address'); ?>
</tr><br><br>

<tr>
<input type="radio" name="radio" value="2"/>POST
</br>

<input type="radio" name="radio" value="5"/>HIRE
  </br>
</tr></br></br>

<input type="submit"  value="Submit" name="submit">&nbsp;&nbsp;&nbsp;
<input type="reset"  value="Cancel" name="cancel">

</table>
</fieldset>
</form>

<!-- javascript link -->


</body>
</html>