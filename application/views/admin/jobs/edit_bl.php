
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?= base_url()?>global/bootstrap/assets/js/vendor/jquery.min.js"><\/script>')</script>


  <!-- Bootstrap core CSS -->
  <link href="<?= base_url()?>global/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->

  <script type="text/javascript" src="<?= base_url() ?>global/admin/ckeditor/ckeditor.js"></script>


<script>
    $(document).ready(function(){

        CKEDITOR.replace( 'textEditor', {
        disallowedContent : 'img{width,height}',
        customConfig: '../ckeditor/config.js',
        uiColor: '#3592E0',
        codeSnippet_theme: 'atelier-dune.light'
    });
    });

</script>
<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 col-8 align-self-center">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/jobs'); ?>">Jobs</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/jobs/edit/'.$id); ?>"><?php echo $id; ?></a></li>
              <li class="breadcrumb-item active">MBL</li>
          </ol>
      </div>

  </div>
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
<div class="row">

    <div class="col-lg-12 main">
        <h4 class="page-header">Edit MBL </h4>

        <?= form_open_multipart(base_url('admin/jobs/edit_bl/'.$id), array('class' => 'form-horizontal')) ?>


        <div class="form-group">
            <label class="control-label" for="activation_content">Content</label>
            <textarea   id="textEditor" name="content" class="form-control"
                                           placeholder="activation_content"><?= set_value('content',$content) ?></textarea>
            <p class="text-red"><?= form_error('content'); ?></p>
        </div>

        <input class="btn btn-primary" type="submit" name="save" value="Save Changes"/>

        <a class="btn btn-success disableafteroneclick" id = "one" data-disabledtext="Processing..."  href="<?= base_url('admin/jobs/create_bl/'.$id) ?>">Generate BL</a>

        <a class="btn btn-info" href="<?= base_url('admin/jobs/job_docs/'.$id) ?>">Go To DOC Upload</a>

        <a href="<?php echo base_url('admin/jobs/edit_bl_data_from_db/'.$id) ?>" class="pull-right" data-toggle="tooltip" data-original-title="Get Content From Database"> <i class="fa fa-database  text-info m-r-10 fa-2x"></i> </a>

        <a href="<?php echo base_url('admin/jobs/bl_refresh_copy/'.$id) ?>" class="pull-right" data-toggle="tooltip" data-original-title="Erase and Download a Fresh Copy"> <i class="fa fa-eraser  text-info m-r-10 fa-2x"></i> </a>






        <?php echo form_close(); ?>
    </div>
</div>
</div>

<script src="<?= base_url()?>global/bootstrap/assets/js/vendor/holder.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url()?>global/bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
