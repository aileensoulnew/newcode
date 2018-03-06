<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
    </head>
<body class="page-container-bg-solid page-boxed">
    <?php echo $header; ?>
    <img src="<?php echo base_url() ?>assets/images/404.jpg?ver=<?php echo time(); ?>" alt="404" />
    <script>
        var base_url = '<?php echo base_url(); ?>';
    </script>
    <footer>
        <?php echo $footer; ?>
    </footer>
</body>
</html>
