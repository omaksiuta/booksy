<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
?>
<input id="folder_name" name="folder_name" type="hidden" value="<?php echo isset($folder_name) && $folder_name != '' ? $folder_name : ''; ?>"/>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ". translate('service') . " " . translate('category'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/service-category'); ?>"><?php echo translate('service') . " " . translate('category'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name.'/add-service-category'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('service') . " " . translate('category'); ?></a>
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
                                    <th class="text-center">#</th>
                                    <th class="text-left"><?php echo translate('title'); ?></th>
                                    <th class="text-center"><?php echo translate('image'); ?></th>
                                    <th class="text-center"><?php echo translate('status'); ?></th>
                                    <th class="text-center"><?php echo translate('created_date'); ?></th>
                                    <th class="text-center"><?php echo translate('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($category_data) && count($category_data) > 0) {
                                    foreach ($category_data as $key => $row) {
                                        if ($row['status'] == "A") {
                                            $status_string = '<span class="badge badge-success">' . translate('active') . '</span>';
                                        } else {
                                            $status_string = '<span class="badge badge-danger">' . translate('inactive') . '</span>';
                                        }

                                        $event_category_image =$row['event_category_image'];
                                        if (isset($event_category_image) && $event_category_image != "") {
                                            if (file_exists(FCPATH . 'assets/uploads/category/' . $event_category_image)) {
                                                $image = base_url("assets/uploads/category/" . $event_category_image);
                                            } else {
                                                $image = base_url("assets/images/no-image.png");
                                            }
                                        } else {
                                            $image = base_url("assets/images/no-image.png");
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $key + 1; ?></td>
                                            <td class="text-left"><?php echo $row['title']; ?></td>
                                            <td class="text-center"><a href="<?php echo $image; ?>" target="_blank"><img class="img-thumbnail" width="50" src="<?php echo $image; ?>"/></a></td>
                                            <td class="text-center"><?php echo $status_string; ?></td>
                                            <td class="text-center"><?php echo get_formated_date($row['created_on'], "N"); ?></td>
                                            <td class="td-actions text-center">
                                                <?php
                                                if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
                                                    $created_by = $this->session->userdata('Vendor_ID');
                                                    if ($created_by == $row['created_by']) {
                                                        ?>
                                                        <a href="<?php echo base_url($folder_name.'/update-service-category/' . $row['id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>"><i class="fe fe-pencil"></i></a>
                                                        <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn btn-sm bg-danger-light" title="<?php echo translate('delete'); ?>"><i class="fe fe-trash"></i></a>
                                                        <?php
                                                    } else {
                                                        echo '-';
                                                    }
                                                } else {
                                                    ?>
                                                    <a href="<?php echo base_url($folder_name.'/update-service-category/' . $row['id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a>
                                                    <span class="d-inline-block" title="<?php echo translate('delete'); ?>" data-toggle="tooltip" data-placement="top"><a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn btn-sm bg-danger-light"><i class="fe fe-trash"></i></a></span>
                                                <?php } ?>
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
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>
<script src="<?php echo $this->config->item('js_url'); ?>module/service-category.js" type='text/javascript'></script>
