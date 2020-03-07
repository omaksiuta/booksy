
</div>

<!-- Delete Modal Start -->
<div class="modal fade" id="delete-record">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $attributes = array('id' => 'DeleteRecordForm', 'name' => 'DeleteRecordForm', 'method' => "post");
            echo form_open('', $attributes);
            ?>
            <input type="hidden" id="record_id"/>
            <div class="modal-header">
                <h4 id='some_name' class="modal-title" style="font-size: 18px;"><?php echo translate('delete'); ?></h4>
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p id='confirm_msg' style="font-size: 15px;"></p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary font_size_12" href="javascript:void(0)" id="RecordDelete" ><?php echo translate('confirm'); ?></a>
                <button data-dismiss="modal" class="btn btn-danger font_size_12" type="button"><?php echo translate('close'); ?></button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Delete Modal End -->


<script src="<?php echo base_url('assets/global/js/jquery-3.2.1.min.js'); ?>"></script>
<!-- Bootstrap Core JS -->
<script src="<?php echo base_url('assets/global/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/global/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>

<!-- Datatables JS -->
<script src="<?php echo base_url('assets/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/datatables.min.js'); ?>"></script>
<script>
    var site_url = "<?php echo site_url(); ?>";
    var base_url = '<?php echo base_url() ?>';
    var userid = '<?php echo $this->session->userdata('ADMIN_ID'); ?>';

    var csrf_token_name = '<?php echo $this->security->get_csrf_hash(); ?>';
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    });
    $(document).ajaxComplete(function () {
        $.ajaxSetup({
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            }
        });
    });
</script>
<!-- Custom JS -->
<script src="<?php echo $this->config->item('assets_url'); ?>loader/js/jquery.preloader.min.js"></script>
<script src="<?php echo base_url('assets/global/js/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/global/js/toastr.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/admin/js/script.js'); ?>"></script>
<script src="<?php echo $this->config->item('js_url'); ?>datepicker.js"></script>
<script src="<?php echo $this->config->item('js_url'); ?>jquery-slidePanel.js"></script>
<!-- Summer Note -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script src="<?php echo base_url('assets/js/summernote_custom.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/function.js'); ?>"></script>
</body>
</html>