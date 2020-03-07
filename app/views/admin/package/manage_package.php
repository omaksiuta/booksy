<?php
include VIEWPATH . 'admin/header.php';
$folder_name = "admin";
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage') . " " . translate('package'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/package'); ?>"><?php echo translate('package'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mdl-data-table booking_datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-left"><?php echo translate('title'); ?></th>
                                        <th class="text-center"><?php echo translate('price'); ?></th>
                                        <th class="text-center"><?php echo translate('validity'); ?></th>
                                        <th class="text-center"><?php echo translate('status'); ?></th>
                                        <th class="text-center"><?php echo translate('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (isset($package_data) && count($package_data) > 0) {
                                        foreach ($package_data as $row) {

                                            $status_string = "";
                                            if ($row['status'] == "A") {
                                                $status_string = '<span class="badge badge-success">' . translate('active') . '</span>';
                                            } else {
                                                $status_string = '<span class="badge badge-danger">' . translate('inactive') . '</span>';
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i; ?></td>
                                                <td class="text-left"><?php echo $row['title']; ?></td>
                                                <td class="text-center"><?php echo price_format(number_format($row['price'], 0)); ?></td>
                                                <td class="text-center"><?php echo $row['package_month']." ".translate('month');; ?></td>
                                                <td class="text-center"><?php echo $status_string; ?></td>
                                                <td class="td-actions text-center">
                                                    <a href="<?php echo base_url('admin/update-package/' . $row['id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>"><i class="fa fa-pencil"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
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
<?php include VIEWPATH . 'admin/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/package.js" type='text/javascript'></script>
