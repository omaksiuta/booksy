<?php
include VIEWPATH . 'admin/header.php';
$folder_name = 'admin';
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('testimonial'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/testimonial'); ?>"><?php echo translate('testimonial'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name.'/add-testimonial'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('testimonial'); ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mdl-data-table booking_datatable" id="example">
                                <thead>
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left"><?php echo translate('name'); ?></th>
                                    <th class="text-left"><?php echo translate('image'); ?></th>
                                    <th class="text-left"><?php echo translate('details'); ?></th>
                                    <th class="text-left"><?php echo translate('status'); ?></th>
                                    <th class="text-left"><?php echo translate('created_date'); ?></th>
                                    <th class="text-left"><?php echo translate('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($testimonial_data) && count($testimonial_data) > 0) {
                                    foreach ($testimonial_data as $key => $row) {
                                        if ($row['status'] == "A") {
                                            $status_string = '<span class="badge badge-success">' . translate('active') . '</span>';
                                        } else {
                                            $status_string = '<span class="badge badge-danger">' . translate('inactive') . '</span>';
                                        }

                                        $image = $row['image'];
                                        if (isset($image) && $image != "") {
                                            if (file_exists(FCPATH . 'assets/uploads/category/' . $image)) {
                                                $image_path = base_url("assets/uploads/category/" . $image);
                                            } else {
                                                $image_path = base_url() . img_path . "/avatar.png";
                                            }
                                        } else {
                                            $image_path = base_url() . img_path . "/avatar.png";
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-left"><?php echo $key + 1; ?></td>
                                            <td class="text-left"><?php echo $row['name']; ?></td>
                                            <td class="text-left"><img src="<?php echo $image_path; ?>" height="70" width="70" class="img-responsive img-thumbnail"/></td>
                                            <td class="text-left"><?php echo $row['details']; ?></td>
                                            <td class="text-left"><?php echo $status_string; ?></td>
                                            <td class="text-left"><?php echo get_formated_date($row['created_date'], "N"); ?></td>
                                            <td class="td-actions text-left">
                                                <a href="<?php echo base_url('admin/update-testimonial/' . $row['id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
                                                <span class="d-inline-block" title="<?php echo translate('delete'); ?>" data-toggle="tooltip" data-placement="top"> <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn btn-sm bg-danger-light"><i class="fe fe-trash"></i></a></span>
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
<script src="<?php echo $this->config->item('js_url'); ?>module/testimonial.js" type='text/javascript'></script>
<?php
include VIEWPATH . 'admin/footer.php';
?>