<?php
include VIEWPATH . 'admin/header.php';
$folder_name = 'admin';
?>
<input id="folder_name" name="folder_name" type="hidden" value="<?php echo isset($folder_name) && $folder_name != '' ? $folder_name : ''; ?>"/>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('language'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/language'); ?>"><?php echo translate('language'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name.'/add-language'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('language'); ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered booking_datatable mdl-data-table" id="example">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-left"><?php echo translate('title'); ?></th>
                                    <th class="text-center"><?php echo translate('status'); ?></th>
                                    <th class="text-center"><?php echo translate('created_date'); ?></th>
                                    <th width="350" class="text-center"><?php echo translate('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($language_data) && count($language_data) > 0) {

                                    foreach ($language_data as $key => $row) {

                                        $update_url = 'admin/update-language/' . $row['id'];
                                        $translate_url = 'admin/language-translate/' . $row['id'];
                                        if ($row['status'] == "A") {
                                            $status_string = '<span class="badge badge-success">' . translate('active') . '</span>';
                                        } else {
                                            $status_string = '<span class="badge badge-danger">' . translate('inactive') . '</span>';
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $key + 1; ?></td>
                                            <td class="text-left"><?php echo ($row['title']); ?></td>
                                            <td class="text-center"><?php echo $status_string; ?></td>
                                            <td class="text-center"><?php echo get_formated_date($row['created_date'], "N"); ?></td>
                                            <td class="td-actions text-center" w>
                                                <a href="<?php echo base_url($translate_url); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('translate_word'); ?>" data-toggle="tooltip" data-placement="top"><i class="fa fa-language"></i> <?php echo translate('translate_word'); ?></a>
                                                <a href="<?php echo base_url($update_url); ?>" class="btn btn-sm bg-info-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
                                                <span class="d-inline-block" title="<?php echo translate('delete'); ?>" data-toggle="tooltip" data-placement="top"><a data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn bt-sm bg-danger-light"><i class="fe fe-trash"></i></a></span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--col-md-12-->
        </div>
    </div>
</div>
<?php
include VIEWPATH . 'admin/footer.php';
?>
<script src="<?php echo $this->config->item('js_url'); ?>module/language.js" type='text/javascript'></script>
