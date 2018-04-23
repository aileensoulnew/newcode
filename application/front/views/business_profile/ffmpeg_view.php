<?php echo form_open_multipart('business_profile/add_video'); ?>
  <table>
    <tr>
      <td>Select Video :</td>
      <td><input type="file" id="video" name="video" ></td>
    </tr>
    <tr>
      <td><input type="submit" id="button" name="submit" value="Submit" /></td>
    </tr>
  </table>
<?php echo form_close(); ?>