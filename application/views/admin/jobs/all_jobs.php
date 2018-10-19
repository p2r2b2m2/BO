

<!-- Container fluid  -->

<div class="container-fluid">

    <!-- Bread crumb and right sidebar toggle -->

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
            </ol>
        </div>
    </div>

    <!-- End Bread crumb and right sidebar toggle -->



    <!-- Start Page Content -->

    <div class="row">
        <div class="col-12">

            <?php $msg = $this->session->flashdata('msg'); ?>
            <?php if (isset($msg)): ?>
                <div class="alert alert-success delete_msg pull" style="width: 100%"> <i class="fa fa-check-circle"></i> <?php echo $msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>

            <?php $error_msg = $this->session->flashdata('error_msg'); ?>
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger delete_msg pull" style="width: 100%"> <i class="fa fa-times"></i> <?php echo $error_msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>

            <div class="card">

                <div class="card-body">

                    <a href="<?php echo base_url('admin/jobs/add/0') ?>" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add New Job</a>

                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ASL Reference #</th>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Mission</th>
                                    <th>Job Type</th>
                                    <th>ETD</th>
                                    <th>ETA</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                  <th>ASL Reference #</th>
                                  <th>Invoice #</th>
                                  <th>Customer</th>
                                  <th>Mission</th>
                                  <th>Job Type</th>
                                  <th>ETD</th>
                                  <th>ETA</th>
                                  <th>Action</th>
                                </tr>
                            </tfoot>

                            <tbody>
                            <?php $i = 1; foreach ($jobs as $job): ?>

                                <tr>
                                    <td><a href="<?php echo base_url('admin/jobs/edit/'.$job['id']) ?>" data-toggle="tooltip" data-original-title="Edit Job"><?php echo $job['asl_reference_no']; ?> </a></td>
                                    <td><?php echo $job['invoice_number']; ?></td>
                                    <td><?php echo $job['customer']; ?></td>
                                    <td><?php echo $job['mission_name']; ?></td>
                                    <td><?php echo $job['type']; ?></td>
                                    <td><?php echo $job['sail_date']; ?></td>
                                    <td><?php echo $job['eta']; ?></td>


                                    <td class="text-nowrap">


                                            <a href="<?php echo base_url('admin/jobs/edit/'.$job['id']) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-success m-r-10"></i> </a>


                                    </td>
                                </tr>

                            <?php $i++; endforeach ?>

                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- End Page Content -->

</div>



<?php foreach ($jobs as $job): ?>

<div class="modal fade" id="confirm_delete_<?php echo $job['id'];?>">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

            <div class="form-body">

                Are you sure want to delete? <br> <hr>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="<?php echo base_url('admin/jobs/delete/'.$job['id']) ?>" class="btn btn-danger"> Delete</a>

            </div>

      </div>


    </div>
  </div>
</div>


<?php endforeach ?>
