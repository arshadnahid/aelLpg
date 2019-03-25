<div class="main-content">
<div class="main-content-inner">
<div class="page-content">
      <div class="row">
      
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">AEL</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="<?php echo base_url().$admin_info->admin_picture?>" class="img-circle img-responsive"> </div>
                
                <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                  <dl>
                    <dt>DEPARTMENT:</dt>
                    <dd>Administrator</dd>
                    <dt>HIRE DATE</dt>
                    <dd>11/12/2013</dd>
                    <dt>DATE OF BIRTH</dt>
                       <dd>11/12/2013</dd>
                    <dt>GENDER</dt>
                    <dd>Male</dd>
                  </dl>
                </div>-->
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Name:</td>
                        <td><?php echo $admin_info->admin_name ?></td>
                      </tr>
                      <tr>
                        <td>Date:</td>
                        <td><?php echo $admin_info->join_date ?></td>
                      </tr>
                     
                   
                       
                        
                        <tr>
                        <td>Home Address</td>
                        <td><?php echo $admin_info->admin_address ?></td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td><a href="mailto:<?php echo $admin_info->admin_email ?>"><?php echo $admin_info->admin_email ?></a></td>
                      </tr>
                        <td>Phone Number</td>
                        <td><?php echo $admin_info->admin_phone ?>
                        </td>
                           
                      </tr>
                     
                    </tbody>
                  </table>
                  
                  <a href="<?php echo base_url()?>edit_profile/<?php echo $admin_info->admin_id ?>" class="btn btn-primary">Edit Profile</a>
                  <!-- <a href="#" class="btn btn-primary">Team Sales Performance</a> -->
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                        <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                        
                    </div>
            
          </div>
        </div>
      </div>
    </div>

      </div>
    </div>