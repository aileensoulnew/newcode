<?php echo $head; ?>
<?php if (IS_OUTSIDE_CSS_MINIFY == '0') { ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.min.css?ver=<?php echo time(); ?>" />
<?php } else { ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>css_min/bootstrap.min.css?ver=<?php echo time(); ?>" />
<?php } ?>

<?php echo $header; ?>
<body   class="page-container-bg-solid page-boxed">
    <img src="<?php echo base_url() ?>images/404.jpg?ver=<?php echo time(); ?>" alt="404" />
</body>

</html>
