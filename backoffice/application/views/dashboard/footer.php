</div>
</div>


<!--Loader/Spinner-->
<div class="loading">
    <div class="sk-cube-grid">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
        <div class="sk-cube sk-cube3"></div>
        <div class="sk-cube sk-cube4"></div>
        <div class="sk-cube sk-cube5"></div>
        <div class="sk-cube sk-cube6"></div>
        <div class="sk-cube sk-cube7"></div>
        <div class="sk-cube sk-cube8"></div>
        <div class="sk-cube sk-cube9"></div>
    </div>
</div>

<?php $CI =& get_instance(); ?>
<script> 
    var csrf_name = '<?php echo $CI->security->get_csrf_token_name(); ?>';
    var csrf_hash = '<?php echo $CI->security->get_csrf_hash(); ?>';
</script>

<script type="text/javascript" src="<?=assets();?>js/popper.min.js"></script>
<script type="text/javascript" src="<?=assets();?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=assets();?>js/toggle.min.js?v=213874"></script>
<script type="text/javascript" src="<?=assets();?>js/swal.min.js"></script>
<script type="text/javascript" src="<?=assets();?>dt/datatables.min.js"></script>
<script type="text/javascript">const ajaxURL = "<?=base_url();?>api/";</script>
<script type="text/javascript">const baseURL = "<?=base_url();?>";</script>
<!-- Helpers -->
<script type="text/javascript" src="<?=assets();?>js/shared.js?v=34758628345"></script>







<script type="text/javascript" src="<?=assets();?>js/mainHelper.js?v=917263"></script>
<script type="text/javascript" src="<?=assets();?>js/jquery.numeric.js"></script>
<script type="text/javascript" src="<?=assets();?>js/jquery.table2excel.js"></script>
<script type="text/javascript" src="<?=assets();?>js/jquery-dateformat.js"></script>
</body>
</html>