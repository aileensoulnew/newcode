<style>

    .okk{
        text-align: center;
    }

    .pop_content .okbtn{
        position: absolute;
        transition: all 200ms;
        font-size: 16px;
        text-decoration: none;
        color: #fff;
        padding: 8px 18px;
        background-color: #0A2C5D;
        left: 170px;
        margin-top: 8px;
        width: 100px; 
        border-radius: 8px;
    }


    .pop_content .cnclbtn {
        position: absolute;
        transition: all 200ms;
        font-size: 16px;
        text-decoration: none;
        color: #fff;
        padding: 8px 18px;
        background-color: #0A2C5D;
        right: 170px;
        margin-top: 8px;
        width: 100px;
        border-radius: 8px;
    }

    .popup .pop_content {
        text-align: center;
        margin-top: 40px;

    }
    .model_ok_cancel{
        width:200px !important;
    }



</style>


<!--post save success pop up style strat -->
<style type="text/css">
    .dropdown-content_hover {
        display: none;
        position: absolute;
        color: #3b5283;
        background-color: #fff;
        min-width: 139px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        margin-top: 3px;
        z-index: 1;
        left: 25px;
        border-radius: 4px;
    } .dropdown-content_hover::before {
        /* top: -1px; */
        content: '';
        display: block;
        position: absolute;
        width: 0;
        height: 0;
        color: transparent;
        border: 9px solid black;
        border-color: transparent transparent #fff;
        margin-top: -18px;
        /* margin-left: 104px; */
        right: 9px;
    </style>

    <!--post save success pop up style end -->


    <header>
        <div class="bg-search">
            <div class="header2 animated fadeInDownBig">
                <div class="container">
                    <div class="row">
                        <?php echo $freelancer_post_search; ?>
                        <div class="col-md-5 col-sm-5">
                            <div class=" ">
                                <ul class="">
                                    <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'home')) { ?> class="active" <?php } ?>><a title="Home"  href="<?php echo base_url('freelance-work/home'); ?>"><?php echo $this->lang->line("home"); ?></a>
                                    </li>
                                    <li>
                                        <div class="dropdown_hover">
                                            <span id="art_profile"><?php echo $this->lang->line("freelancer_profile"); ?> <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                            <div class="dropdown-content_hover" id="dropdown-content_hover">
                                                <a title="View Profile" href="<?php echo base_url('freelance-work/freelancer-details'); ?>"><i class="fa fa-user" aria-hidden="true"></i><?php echo $this->lang->line("view_profile"); ?></a>
                                                <a title="Edit Profile" href="<?php echo base_url('freelance-work/basic-information'); ?>"><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo $this->lang->line("edit_profile"); ?></a>
                                                <?php
                                                $userid = $this->session->userdata('aileenuser');
                                                ?>
                                                <a title="Deactivate Profile" onClick="deactivate(<?php echo $userid; ?>)"><i class="fa fa-minus-circle" aria-hidden="true"></i> <?php echo $this->lang->line("deactivate_profile"); ?></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </header>

    <!-- Bid-modal  -->
    <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
        <div class="modal-dialog modal-lm deactive">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <span class="mes"></span>
                </div>
            </div>
        </div>
    </div>
    <!-- Model Popup Close -->


    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropdown_hover').click(function (event) {
                event.stopPropagation();
                $(".dropdown-content_hover").slideToggle("fast");
            });
            $(".dropdown-content_hover").on("dropdown_hover", function (event) {
                event.stopPropagation();
            });
        });

        $(document).on("dropdown_hover", function () {
            $(".dropdown-content_hover").hide();
        });

        $(document).ready(function () {
            $("body").click(function (event) {
                $(".dropdown-content_hover").hide();
                event.stopPropagation();
            });

        });
    </script>


    <script type="text/javascript">
        function deactivate(clicked_id) {
            $('.biderror .mes').html("<div class='pop_content'> Are you sure you want to deactive your Freelancer Apply profile?<div class='model_ok_cancel'><a title="yes" class='okbtn' id=" + clicked_id + " onClick='deactivate_profile(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a title="No" class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
            $('#bidmodal').modal('show');
        }
        function deactivate_profile(clicked_id) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "freelancer/deactivate" ?>',
                data: 'id=' + clicked_id,
                success: function (data) {
                    window.location = "<?php echo base_url() ?>dashboard";

                }
            });
        }
    </script>
    <!-- all popup close close using esc start -->
    <script type="text/javascript">
        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) {
                $("#dropdown-content_hover").hide();
            }
        });
        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) {
                //$( "#bidmodal" ).hide();
                $('#bidmodal').modal('hide');
            }
        });

    </script>
    <!-- all popup close close using esc end -->