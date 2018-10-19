<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
   <!-- ============================================================== -->
   <!-- Bread crumb and right sidebar toggle -->
   <!-- ============================================================== -->
   <div class="row page-titles">
       <div class="col-md-5 col-8 align-self-center">
           <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
               <li class="breadcrumb-item active">Edit Customer</li>
           </ol>
       </div>

   </div>
   <!-- ============================================================== -->
   <!-- End Bread crumb and right sidebar toggle -->
   <!-- ============================================================== -->
   <!-- ============================================================== -->
   <!-- Start Page Content -->
   <!-- ============================================================== -->
<div

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
           <div class="card card-outline-info">
               <div class="card-header">
                   <h6 class="m-b-0 text-white">Edit Customer <a href="<?php echo base_url('admin/customers') ?>" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Back</a></h6>
               </div>
               <div class="card-body">
                   <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/customers/edit/'.$customer->id) ?>" >
                       <div class="form-body">
                           <h3 class="card-title">Customer Info</h3>
                           <hr>
                           <div class="row p-t-20">
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label class="control-label">Name <span class="text-danger">*</span></label>
                                       <input type="text" name="name"  required="" class="form-control" value="<?php echo $customer->name; ?>" >
                               </div>
                               </div>
                               <!--/span-->
                               <div class="col-md-3">
                                   <div class="form-group">
                                       <label class="control-label">Phone No</label>
                                       <input type="text" name="phone" class="form-control" value="<?php echo $customer->phone; ?>" >
                                   </div>
                               </div>

                               <div class="col-md-3">
                                   <div class="form-group">
                                       <label class="control-label">Login</label>
                                       <input type="text" name="phone" class="form-control" value="<?php echo $customer->password; ?>" readonly>
                                   </div>
                               </div>
                               <!--/span-->
                           </div>
                           <!--/row-->
                           <div class="row">
                               <div class="col-md-6">
                                   <div class="form-group has-success">
                                       <label class="control-label">Mission</label>
                                       <select class="form-control select2" style="width: 100%" name="mission_id">

                                           <?php foreach ($missions as $mission): ?>
                                               <?php
                                                   if($mission['id'] == $customer->mission_id){
                                                       $selec = 'selected';
                                                   }else{
                                                       $selec = '';
                                                   }
                                               ?>
                                               <option <?php echo $selec; ?> value="<?php echo $mission['id']; ?>"><?php echo $mission['mission_name']; ?></option>
                                           <?php endforeach ?>

                                       </select>
                                       <small class="form-control-feedback"> Select Mission</small> </div>
                               </div>
                               <!--/span-->
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label class="control-label">Email <span class="text-danger">*</span></label>
                                       <input type="email" required="" class="form-control" name="email" value="<?php echo $customer->email; ?>" >
                                   </div>
                               </div>
                               <!--/span-->
                           </div>
                           <!--/row-->

                           <!--/row-->
                           <h3 class="box-title m-t-40">Address</h3>
                           <hr>
                           <div class="row">
                               <div class="col-md-12 ">
                                   <div class="form-group">
                                       <label>Street</label>
                                       <input type="text" name="street" class="form-control" value="<?php echo $customer->street; ?>">
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label>City</label>
                                       <input type="text" name="city" class="form-control" value="<?php echo $customer->city; ?>">
                                   </div>
                               </div>
                               <!--/span-->
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label>State</label>
                                       <input type="text" name="state" class="form-control" value="<?php echo $customer->state; ?>">
                                   </div>
                               </div>
                               <!--/span-->
                           </div>
                           <!--/row-->
                           <div class="row">
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label>Zip Code</label>
                                       <input type="text" name="zip" class="form-control" value="<?php echo $customer->zip; ?>">
                                   </div>
                               </div>
                               <!--/span-->
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label>Country</label>
                                       <select class="form-control select2" style="width: 100%" name="country_id">

                                           <?php foreach ($country as $cn): ?>
                                               <?php
                                                   if($cn['id'] == $customer->country_id){
                                                       $selec = 'selected';
                                                   }else{
                                                       $selec = '';
                                                   }
                                               ?>
                                               <option <?php echo $selec; ?> value="<?php echo $cn['id']; ?>"><?php echo $cn['name']; ?></option>
                                           <?php endforeach ?>

                                       </select>
                                   </div>
                               </div>
                               <!--/span-->
                           </div>
                       </div>
                       <!-- CSRF token -->
                       <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

                       <div class="form-actions">
                           <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save Customer</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>

   <!-- ============================================================== -->
   <!-- End PAge Content -->
   <!-- ============================================================== -->

</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
