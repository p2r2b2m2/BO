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
               <li class="breadcrumb-item active">Add Customer</li>
           </ol>
       </div>

   </div>
   <!-- ============================================================== -->
   <!-- End Bread crumb and right sidebar toggle -->
   <!-- ============================================================== -->
   <!-- ============================================================== -->
   <!-- Start Page Content -->
   <!-- ============================================================== -->
   <!-- Row -->
   <div class="row">
       <!-- Column -->

       <!-- Column -->
       <!-- Column -->
       <div class="col-lg-12">
           <div class="card">
             <?php $msg = $this->session->flashdata('msg'); ?>
             <?php $tab = $this->session->flashdata('tab'); ?>
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
               <!-- Nav tabs -->

               <?php if (isset($tab)): ?>
                 <?php if($tab == 'address'):?>

                   <ul class="nav nav-tabs profile-tab" role="tablist">
                       <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#home" role="tab"><strong>Contact</strong></a> </li>

                       <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#settings" role="tab">Address</a> </li>
                   </ul>
                 <?php else: ?>
                 <ul class="nav nav-tabs profile-tab" role="tablist">
                     <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><strong>Contact</strong></a> </li>

                     <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Address</a> </li>
                 </ul>
               <?php endif; ?>


             <?php else: ?>
               <ul class="nav nav-tabs profile-tab" role="tablist">
                   <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><strong>Contact</strong></a> </li>

                   <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Address</a> </li>
               </ul>
               <?php endif ?>
               <!-- Tab panes -->
               <div class="tab-content">
                 <?php if($tab != 'address'):?>
                 <div class="tab-pane active" id="home" role="tabpanel">
                 <?php else: ?>
                   <div class="tab-pane" id="home" role="tabpanel">
                 <?php endif ?>
                     <div class="card-body">
                       <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/customers/edit') ?>" class="form-horizontal form-material" novalidate>
                            <div class="form-group">
                                 <label class="col-md-12">First Name <span class="text-danger">*</span></label>
                                 <div class="col-md-12">
                                     <input type="text" placeholder="John" name="first_name"  required="" class="form-control form-control-line" value="<?php echo $customer->first_name; ?>" >
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-12">Last Name <span class="text-danger">*</span></label>
                                 <div class="col-md-12">
                                     <input type="text" placeholder="Smith"  name="last_name"  required="" class="form-control form-control-line" value="<?php echo $customer->last_name; ?>" >
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-sm-12">Mission</label>
                                 <div class="col-sm-12">
                                   <select class="form-control form-control-line" name="mission_id">

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
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label for="example-email" class="col-md-12">Email <span class="text-danger">*</span></label>
                                 <div class="col-md-12">
                                     <input type="email"  placeholder="johnathan@admin.com" required="" class="form-control form-control-line" name="email" value="<?php echo $customer->email; ?>" >
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-12">Phone No</label>
                                 <div class="col-md-12">
                                     <input type="text" name="phone" class="form-control form-control-line" value="<?php echo $customer->phone; ?>" >
                                 </div>
                             </div>
                             <!-- CSRF token -->
                             <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />


                             <div class="form-group">
                                 <div class="col-sm-12">
                                     <button class="btn btn-success">Save Customer</button>
                                 </div>
                             </div>

                         </form>
                     </div>
                 </div>






                   <!--second tab-->
                   <?php if($tab == 'address'):?>
                   <div class="tab-pane active" id="settings" role="tabpanel">
                  <?php else: ?>
                     <div class="tab-pane" id="settings" role="tabpanel">
                  <?php endif ?>
                       <div class="card-body">
                           <form class="form-horizontal form-material">
                               <div class="form-group">
                                   <label class="col-md-12">Street</label>
                                   <div class="col-md-12">
                                       <input type="text" placeholder="Street" class="form-control form-control-line">
                                   </div>
                               </div>
                               <div class="form-group">
                                   <label class="col-md-12">City</label>
                                   <div class="col-md-12">
                                       <input type="text" placeholder="City" class="form-control form-control-line">
                                   </div>
                               </div>
                               <div class="form-group">
                                   <label class="col-md-12">State</label>
                                   <div class="col-md-12">
                                       <input type="text" placeholder="State" class="form-control form-control-line">
                                   </div>
                               </div>
                               <div class="form-group">
                                   <label class="col-md-12">Zip</label>
                                   <div class="col-md-12">
                                       <input type="text" placeholder="Zip" class="form-control form-control-line">
                                   </div>
                               </div>
                               <div class="form-group">
                                   <label class="col-sm-12">Country</label>
                                   <div class="col-sm-12">
                                       <select class="form-control form-control-line">
                                           <option>London</option>
                                           <option>India</option>
                                           <option>Usa</option>
                                           <option>Canada</option>
                                           <option>Thailand</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group">
                                   <label class="col-sm-12">Country </label>
                                   <div class="col-sm-12 controls">
                                       <div class="form-group has-success">
                                           <select class="form-control form-control-line" name="country" aria-invalid="false">
                                               <option value="null">Select</option>
                                               <?php foreach ($country as $cn): ?>
                                                   <option value="<?php echo $cn['id']; ?>"><?php echo $cn['name']; ?></option>
                                               <?php endforeach ?>
                                           </select>
                                       </div>
                                   </div>
                               </div>

                               <!-- CSRF token -->
                               <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />


                               <div class="form-group">
                                   <div class="col-sm-12">
                                       <button class="btn btn-success">Save Customer</button>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!-- Column -->
   </div>
   <!-- Row -->
   <!-- ============================================================== -->
   <!-- End PAge Content -->
   <!-- ============================================================== -->

</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
