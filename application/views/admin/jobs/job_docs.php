

<!-- Container fluid  -->

<div class="container-fluid">

    <!-- Bread crumb and right sidebar toggle -->

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/jobs'); ?>">Jobs</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $jobs->id; ?></a></li>
                <li class="breadcrumb-item active">Document Uploads</li>
            </ol>
        </div>

    </div>

    <!-- End Bread crumb and right sidebar toggle -->

    <div class="row">
        <div class="col-lg-12">
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
        </div>
    </div>

    <!-- Start Page Content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Manage Job</h4>
                  <h6 class="card-subtitle">Complete all applicable tabs</h6>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/edit/'.$jobs->id) ?>">Job Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/shipinfo/'.$jobs->id) ?>">Shipment</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/doccontrol/'.$jobs->id) ?>">Doc Control</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="<?php echo base_url('admin/jobs/job_docs/'.$jobs->id) ?>">Uploads</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url('admin/jobs/job_status/'.$jobs->id) ?>">Status</a>
                    </li>
                  </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" role="tabpanel">
                            <div class="p-20">
                                <h6 class="card-subtitle">One upload for each document type is allowed.</h6>
                                <h6 class="card-subtitle">In case you need to re-upload please delete the existing file first.</h6>


                                <div class="row">



                                    <div class="col-md-6">
                                        <div class="card card-outline-info">
                                            <div class="card-header">
                                                <h6 class="m-b-0 text-white"> New Upload
                                            </div>
                                            <div class="card-body">
                                                <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/jobs/job_docs/'.$jobs->id) ?>" class="form-horizontal" novalidate>
                                                    <div class="form-body">
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label class="control-label text-right col-md-3">Doc Type <span class="text-danger">*</span></label>
                                                                    <div class="col-md-9 controls">
                                                                        <select class="form-control" name="doc_type_id" required data-validation-required-message=" Document type should be selected">
                                                                            <option  value="">--Select Doc Type--</option>

                                                                            <?php foreach ($dtypes as $dtype): ?>
                                                                                <option  value="<?php echo $dtype['id']; ?>"><?php echo $dtype['type']; ?></option>
                                                                            <?php endforeach ?>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--/span-->
                                                        </div>



                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label class="control-label text-right col-md-3">Upload File <span class="text-danger">*</span></label>
                                                                    <div class="col-md-9 controls">

                                                                        <input type="file" name="userfile" size = "20" class="form-control" required data-validation-required-message=" A file should be selected">


                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--/span-->
                                                        </div>

                                                        <!-- CSRF token -->
                                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label class="control-label text-right col-md-3"></label>
                                                                    <div class="col-md-9 controls">
                                                                        <button type="submit" class="btn btn-success">Upload</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="card card-outline-info">
                                            <div class="card-header">
                                                <h6 class="m-b-0 text-white"> Uploaded Documents</h6>
                                            </div>
                                            <div class="card-body">

                                                <div class="table-responsive m-t-40">
                                                    <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                              <th>Doc Type</th>
                                                              <th>URL</th>
                                                              <th>Uploaded By</th>
                                                              <th>Uploaded Date</th>
                                                              <th>Action</th>
                                                          </tr>
                                                        </thead>

                                                        <tbody>
                                                        <?php $i = 1; foreach ($jdocs as $row): ?>

                                                            <tr>
                                                                <td><?php echo $row['type']; ?></td>
                                                                <td><a href="<?php echo base_url('admin/jobs/doc_download/'.$row['id']) ?>" ><?php echo $row['file_name']; ?></a> </td>
                                                                <td><?php echo $row['uploaded_by']; ?></td>
                                                                <td><?php echo $row['uploaded_date']; ?></td>

                                                                <td class="text-nowrap">

                                                                    <a id="delete" href="<?php echo base_url('admin/jobs/delete_doc/'.$row['id']) ?>"  data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash text-danger m-r-10"></i> </a>

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












                            </div>
                        </div>

                    </div> <!--tab content border -->
                </div>
            </div>
        </div>
      </div>




    <!-- End Page Content -->

</div>
