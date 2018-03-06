<div class="col-sm-7 col-md-7 col-xs-7 hidden-mob">
    <div class="job-search-box1 clearfix">
       
        <form action=<?php echo base_url('artist/search')?> method="get">

        <fieldset class="col-md-3 col-sm-5 col-xs-5">
            <input type="text" id="tags" name="skills" placeholder=" Artists, Skills, Keywords">
        </fieldset>
        <fieldset class="col-md-3 col-sm-5 col-xs-5">
           
              <input type="text" id="searchplace" name="searchplace" placeholder="Location">
        </fieldset>
       
        <fieldset class="col-md-2 col-sm-2 col-xs-2">
            <label for="search_btn" id="search_f"><i class="fa fa-search" aria-hidden="true"></i></label>
            <input id="search_btn" style="display: none;" type="submit" name="search-submit" value="Search" onclick="return checkvalue()">
        </fieldset>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){

     document.getElementById('tags').value = null;
     document.getElementById('searchplace').value = null;

    });
</script>

