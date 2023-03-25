<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <?php echo $style;?>
        <title><?php echo title;?></title>
        <!-- This page plugin CSS -->
        <link href="<?=asset_url()?>css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?=asset_url()?>select2/dist/css/select2.min.css">
    </head>
    <body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <?=$header?>
            <?=$leftmain?>
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-12 align-self-center">
                        <h3 class="text-themecolor mb-0">Transfer Pins</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Transfer Pins</li>
                        </ol>
                    </div>
                </div>
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->          
                    <?php
                    if( $this->session->flashdata('message') != null )
                        echo $this->session->flashdata('message');
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Transfer Pins</h4>
                            <div class="card-tools"></div><hr> 
                            <form id="category_form" onsubmit="return validateForm();">
                                <input type="hidden" name="id" id="id" value="0" />
                                <div class="form-group row">
                                    <label class="col-sm-4 text-right control-label col-form-label">Pin Type</label>
                                    <div class="col-sm-6">
                                        <select name="type" id="type" class="form-control select2" >
                                            <option value="">--Select--</option>
                                            <option value="1">Package</option>
                                            <option value="2">Service</option>
                                            <option value="3">Equipment</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="packageinput">
                                    <div class="form-group row">
                                        <label class="col-sm-4 text-right control-label col-form-label">Select Package</label>
                                        <div class="col-sm-6">
                                            <select name="package_id" id="package_id" class="form-control select2">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="otherinput">
                                    <div class="form-group row">
                                        <label class="col-sm-4 text-right control-label col-form-label">Select Category</label>
                                        <div class="col-sm-6">
                                            <select name="cat_id" id="cat_id" class="form-control select2" >
                                                <option value="">--Select--</option>
                                                <?php
                                                foreach($category as $item){
                                                    ?>
                                                    <option value="<?=$item->id?>"><?=$item->name?></option>
                                                    <?php
                                                }    
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-4 text-right control-label col-form-label">Select Sub Category</label>
                                        <div class="col-sm-6">
                                            <select name="subcat_id" id="subcat_id" class="form-control select2" >
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row serviceinput">
                                        <label class="col-sm-4 text-right control-label col-form-label">Select Service</label>
                                        <div class="col-sm-6">
                                            <select name="service" id="service" class="form-control select2">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row iteminput">
                                        <label class="col-sm-4 text-right control-label col-form-label">Select Equipment/Item</label>
                                        <div class="col-sm-6">
                                            <select name="item_id" id="item_id" class="form-control select2">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-4 text-right control-label col-form-label">Select Channel Partner</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2" id="partner_type" name="partner_type">
                                            <option value="">--- Select Channel Partner --- </option>
                                            <option value="1">COUNTRY PARTNER </option>
                                            <option value="3">STATE C&F </option>
                                            <option value="4">DISTRIBUTOR </option>
                                            <option value="5">DEALER </option>
                                            <option value="6">RETAILER </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 text-right control-label col-form-label">Select Partner</label>
                                    <div class="col-sm-6">
                                        <select name="partner_id" id="partner_id" class="form-control select2">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 text-right control-label col-form-label">Enter Quantity</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control onlynumbers" name="qty" id="qty" value='' />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                                        <a href="<?=base_url().'pin/transfer'?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                                    </div>
                                </div>            

                                <div class="pagecontent"></div>               
                            </form>
                            
                        </div>
                    </div>
                </div>
                <!-- End Container fluid  -->
                <!-- footer -->
                <?=$footer?>
                <!-- End footer -->
            </div>
            <!-- End Page wrapper  -->
        </div>
        <!-- End Wrapper -->
    
        <div class="chat-windows"></div>
        <?=$jsfile?>
        <script src="<?=asset_url()?>/select2/dist/js/select2.full.min.js"></script>
        <script src="<?=asset_url()?>/select2/dist/js/select2.min.js"></script>
        <script src="<?=asset_url()?>select2/select2.init.js"></script>
        <script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>
        <script>
            var category = <?php echo json_encode($category) ?>;
            $(document).ready(function(){
                $('.packageinput').css('display','none');
                $('.otherinput').css('display','none');

                $('#type').change(function(){
                    var output = '<option value="">--Select--</option>';
                    if( this.value == 1 ){
                        $('.packageinput').css('display','block');
                        $('.otherinput').css('display','none');

                        var str = "";
                        $.post("<?=base_url().'pin/getPackagesPins'?>", str, function(data){
                            data = JSON.parse(data);
                            //console.log(data);return false;
                            $(data).each(function(){
                                output += "<option value="+this.id+" price="+this.price+" qty="+this.qty+" >"+this.name+" - Price : "+this.price+" PINS : "+this.qty+"</option>";
                            });
                            $('#package_id').html(output);
                        });

                        var catoutput = '<option value="">--Select--</option>';
                        $(category).each(function(){
                            catoutput += "<option value="+this.id+">"+this.name+"</option>";
                        });
                        $('#cat_id').html(catoutput);

                    }else if( this.value == 2 ){
                        $('.packageinput').css('display','none');
                        $('.otherinput').css('display','block');
                        $('.serviceinput').css('display','flex');
                        $('.iteminput').css('display','none');
                        $('#package_id').html(output);

                        var catoutput = '<option value="">--Select--</option>';
                        $(category).each(function(){
                            if( this.type == 1 ){
                                catoutput += "<option value="+this.id+">"+this.name+"</option>";
                            }                            
                        });
                        $('#cat_id').html(catoutput);
                    }else if( this.value == 3 ){
                        $('.packageinput').css('display','none');
                        $('.otherinput').css('display','block');
                        $('.serviceinput').css('display','none');
                        $('.iteminput').css('display','flex');
                        $('#package_id').html(output);

                        var catoutput = '<option value="">--Select--</option>';
                        $(category).each(function(){
                            if( this.type == 2 ){
                                catoutput += "<option value="+this.id+">"+this.name+"</option>";
                            }                            
                        });
                        $('#cat_id').html(catoutput);
                    }
                });

                var v = $("#category_form").validate({                
                    errorClass: "help-block", 
                    errorElement: 'span',
                    onkeyup: false,
                    onblur: true,
                    rules: {
                        
                    },
                    messages: {
                        
                    },
                    onfocusout: function(element) {$(element).valid()},
                    errorElement: 'span',
                    highlight: function (element, errorClass, validClass) {
                        $(element).parents('.form-group').addClass('has-error');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).parents('.form-group').removeClass('has-error');
                    }			        		    
                });

                $('#cat_id').change(function(){
                    var output = '<option value="">--Select--</option>';
                    if( this.value != '' ){
                        var str = "category="+this.value;
                        $.post("<?=base_url().'master/getSubCategoryList'?>", str, function(data){
                            data = JSON.parse(data);
                            //console.log(data.data)
                            $(data.data).each(function(){
                                output += "<option value="+this.id+">"+this.name+"</option>";
                            });
                            $('#subcat_id').html(output);
                        });
                    }else{
                        $('#subcat_id').html(output);
                    }                    
                });

                $('#subcat_id').change(function(){
                    var output = '<option value="">--Select--</option>';
                    if( $('#type').val() == '' ){
                        Swal.fire('Select pin type');
                        return false;
                    }else if( $('#cat_id').val() == '' ){
                        Swal.fire('Select category');
                        return false;
                    }else if( $('#subcat_id').val() == '' ){
                        Swal.fire('Select sub category');
                        return false;
                    }else{
                        if( this.value != '' ){
                            var str = "cat_id="+$('#cat_id').val()+"&subcat_id="+this.value;
                            var type = $.trim($('#type').val());
                            var url = "";
                            if( type == 2 ){
                                var url = "<?=base_url().'pin/getServicePins'?>";
                            }else if( type == 3 ){
                                var url = "<?=base_url().'pin/getItemPins'?>";
                            }                            
                            $.post(url, str, function(data){
                                data = JSON.parse(data);
                                //console.log(data.data);return false;
                                $(data.data).each(function(){
                                    output += "<option value="+this.id+" price="+this.price+" qty="+this.qty+" >"+this.name+" - Price : "+this.price+" PINS : "+this.qty+"</option>";
                                });
                                if( type == 2 ){
                                    $('#service').html(output);
                                }else if( type == 3 ){
                                    $('#item_id').html(output);
                                }   
                            });
                        }else{
                            if( type == 2 ){
                                $('#service').html(output);
                            }else if( type == 3 ){
                                $('#item_id').html(output);
                            }   
                        }       
                    }                                 
                });

                $('#partner_type').change(function(){
                    var output = '<option value="">--Select--</option>';
                    if( this.value != '' ){
                        var str = "partner_type="+this.value;
                        $.post("<?=base_url().'pin/getPartners'?>", str, function(data){
                            data = JSON.parse(data);
                            //console.log(data.data)
                            $(data.data).each(function(){
                                output += "<option value="+this.id+">"+this.company_name+" - "+this.code+"</option>";
                            });
                            $('#partner_id').html(output);
                        });
                    }else{
                        $('#partner_id').html(output);
                    }                    
                });
            });

            function validateForm(){

                var type = $.trim($('#type').val());
                if( type == '' ){
                    Swal.fire('Select pin type');
                    return false;
                }

                var package_id = $.trim($('#package_id').val());
                var cat_id = $.trim($('#cat_id').val());
                var subcat_id = $.trim($('#subcat_id').val());

                var avail_qty = 0;
                if( type == 1 ){
                    if( package_id == '' ){
                        Swal.fire('Select package');
                        return false;
                    }
                    avail_qty = $("#package_id option:selected").attr('qty');
                }else{
                    if( cat_id == '' ){
                        Swal.fire('Select category');
                        return false;
                    }

                    if( subcat_id == '' ){
                        Swal.fire('Select sub category');
                        return false;
                    }

                    if( type == 2 ){
                        avail_qty = $("#service option:selected").attr('qty');
                    }else{
                        avail_qty = $("#item_id option:selected").attr('qty');
                    }
                }

                var service = $.trim($('#service').val());
                var item_id = $.trim($('#item_id').val());
                if( type == 2 && service == '' ){
                    Swal.fire('Select service');
                    return false;
                }

                if( type == 3 && item_id == '' ){
                    Swal.fire('Select item');
                    return false;
                }

                var partner_type = $.trim($('#partner_type').val());
                if( partner_type == '' ){
                    Swal.fire('Select channel partner type');
                    return false;
                }
                
                var partner_id = $.trim($('#partner_id').val());
                if( partner_id == '' ){
                    Swal.fire('Select partner');
                    return false;
                }

                var qty = $.trim($('#qty').val());
                if( qty == '' ){
                    Swal.fire('Enter pin quantity');
                    return false;
                }

                console.log(avail_qty+" "+qty);
                if( parseInt(qty) > parseInt(avail_qty) ){
                    Swal.fire('Entered pin quantity is greater than available pins :'+avail_qty);
                    return false;
                }

                var postdata =  {   
                    type:type,package_id:package_id,cat_id:cat_id,subcat_id:subcat_id,
                    service_id:service,item_id:item_id,qty:qty,partner_type:partner_type,
                    partner_id:partner_id,
                };        
                //console.log(postdata);return false;
                Swal.fire({
                    title: '',
                    text: 'Are you sure want to transfer pins to channel partner?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            allowOutsideClick: false,
                            html : '<i class="fas fa-spinner fa-spin"></i> Updating please wait...',
                            buttons: false,
                            showConfirmButton: false,
                        })
                        $.ajax({
                            url: "<?=base_url().'pin/savetransfer'?>",
                            type: "post",
                            data:  postdata ,
                            dataType : 'html',
                            success: function (response) {                        
                                if( response == '1' ){
                                    Swal.fire({
                                        type: 'success',
                                        text: 'Pin transfered successfully',
                                    }).then((result) => {
                                        window.location.href = "<?=base_url().'pin/transfer'?>";
                                    });
                                }else if( response == '-1' ){
                                    Swal.fire({
                                        type: 'error',
                                        text: 'Required fields are missing',
                                    })
                                }else if( response == '-2' ){
                                    Swal.fire({
                                        type: 'error',
                                        text: 'Pin not found',
                                    })
                                }else if( response == '-3' ){
                                    Swal.fire({
                                        type: 'error',
                                        text: 'Partner not found',
                                    })
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                Swal.fire({
                                    type: 'error',
                                    text: 'Something went wrong!',
                                })
                            }
                        });
                    }
                });
                return false;
            }
        </script>
    </body>

</html>