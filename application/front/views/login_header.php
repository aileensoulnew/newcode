<header>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-3">
                <div class="logo"><a style="cursor: pointer;" href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="Aileensoul"></a></div>
            </div>
            <div class="col-md-8 col-sm-9">
                <div class="btn-right pull-right">

                    <?php if(!$this->session->userdata('aileenuser')) {?>
                    <a title="Login" href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                    <a title="Creat an account" href="<?php echo base_url('registration'); ?>" class="btn3">Creat an account</a>

                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</header>