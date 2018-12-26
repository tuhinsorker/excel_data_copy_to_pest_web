<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>


    <style type="text/css">
        table{
        border-collapse:collapse;
        /*//border:1px solid #000000;*/
        }

        table td{
        /*border:1px solid #000000;*/
        }


    </style>
</head>
<body>

<div class="container">


<div class="row">
    <div class="col-md-12">
        <br>
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">Add Style</button>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <?=form_open('#',array('id' => 'formId'))?>
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Style Header</h4>
              </div>
              <div class="modal-body">
                <div> Style name</div>
                <input type="text" name="name" class="form-control" placeholder="Enter style name">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
              </div>
            </div>
            <?=form_close()?>

          </div>
        </div>

    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="btn-group">
            <?php foreach($slist as $s){?>
                <a  href="javascript:void" class="btn btn-primary btn-sm" onclick="editTable('<?php echo $s->style_id?>')"><?=$s->style_name?></a>
            <?php }?>
        </div>
    </div>



    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div id="exdata">
                    <p>Paste excel data here:</p>
                    <textarea name="excel_data" style="width:550px;height:150px;" onblur="javascript:generateTable()"></textarea>
                </div>
            </div>

<div class="col-md-6">
    <div class="form-group">
        <label for="supplier_discount">Supplier Discount:</label>
        <input type="number" class="form-control" id="supplier_discount">
    </div>

    <div class="form-group">
        <label for="domistic_markup">Domistic markup:</label>
        <input type="number" class="form-control" id="domistic_markup">
    </div>

    <div class="form-group">
        <label for="contract_markup">Contract markup:</label>
        <input type="number" class="form-control" id="contract_markup">
    </div>


    <div class="form-group">
        <label for="trade_markup">Trade markup:</label>
        <input type="number" class="form-control" id="trade_markup">
    </div>

    <div class="checkbox">
        <label><input type="checkbox">Hide Price on order</label>
    </div>


    <div class="checkbox">
        <label><input type="checkbox">Price inclusive on Vat</label>
    </div>

</div>


            <div class="col-md-6">
                <p>The .table-bordered class adds borders to a table:</p>            
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Edit Price by</th>
                        <th>Apply to</th>
                        <th>Value</th>
                        <th width="100">Action</th>
                      </tr>
                    </thead>

                    <tbody>

                      <tr>

                        <td>
                            <label class="radio-inline">
                                <input type="radio" name="optradio" id="percentage" value=""> Percentage
                            </label>

                            <label class="radio-inline">
                                <input type="radio" name="optradio" id="fixed" value=""> Fixed
                            </label>
                            
                        </td>

                        <td>
                            <label class="radio-inline">
                                <input type="radio" name="apply" id="whole" value=""> Whole table 
                            </label>
                          
                        </td>

                        <td>
                            <label class="radio-inline">
                                Enter value
                            </label>

                            <input type="number" name="val" id="setVal" class="form-control">
                            
                        </td>

                        <td>
                            <button class="btn btn-sm btn-success" onclick="plusData()" style="font-size:20px;">+</button>
                            <button class="btn btn-sm btn-danger" onclick="minusData()" style="font-size:20px;" >-</button>
                            
                        </td>
                       
                      </tr>
                      
                    </tbody>
                </table>


            </div>
        </div>
    </div>


    <div class="col-md-12">
        <p>Table data will appear below</p>

        <!-- array('id'=>'formStylePrice') -->
        <?=form_open('#',array('id'=>'formStylePrice','name'=>'formStylePrice'))?>

            <div class="row">
                <div class="col-md-6">
                    <select name="style_id" class="form-control" required="" id="style_id">
                        <option value="">--Select One--</option>
                        <?php foreach($slist as $s){?>
                            <option value="<?=$s->style_id;?>"><?=$s->style_name;?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="excel_table"></div><br>
                    <button type="submit" class="btn btn-success btn-sm"> Save</button>
                </div>
            </div>

        <?=form_close()?>

    </div>

</div>


<script type="text/javascript">

function generateTable() {

    var data = $('textarea[name=excel_data]').val();
    //console.log(data);

    var rows = data.split("\n");

    var table = $('<table />');

    var pr=0;

        for(var y in rows) {
           pr++;
            var cells = rows[y].split("\t");
            var row = $('<tr />');
                row.append('<input type="hidden" name="row[]" value="'+cells+'"/>');
                var n=0;
            for(var x in cells) {
                n++;

                if(pr!=1 && n!=1){
                    var clss = n+"_"+pr;
                    row.append('<input type="text" name="test'+n+pr+'" value="'+cells[x]+'" class="price_input" id="'+clss+'" autocomplete="off"/>');
                }else{
                    
                    row.append('<input type="text" name="test'+n+pr+'" value="'+cells[x]+'" autocomplete="off"/>');
                }
            }
            table.append(row);
        }

    // Insert into DOM
    $('#excel_table').html(table);
}




$( "#whole" ).on( "click", function() {
    $('.price_input').css('border',' 2px solid #d5f3d5');
    $("#whole").val(1);
    $("#selection").val(0);
});

$( "#selection" ).on( "click", function() {
    $('.price_input').css('border','');
    $("#whole").val(0);
    $("#selection").val(1);
});


$( "#percentage" ).on( "click", function() {
    $("#percentage").val(1);
    $("#fixed").val(0);
});

$( "#fixed" ).on( "click", function() {
    $("#percentage").val(0);
    $("#fixed").val(1);
});




function plusData(){

    var percentage = $("#percentage").val();

    var setVal = $("#setVal").val();

    
    var whole = $("#whole").val();
    var selection = $("#selection").val();
    if(whole!=0){

        if(percentage!=0){

            $(".price_input").each(function(){
               var id = $(this).attr('id');
               var getVal = $("#"+id).val();
               var newVal = (getVal/100)*setVal;
               $("#"+id).val(parseInt(getVal)+parseInt(newVal));
            });
        
        }else{

            $(".price_input").each(function(){
               var id = $(this).attr('id');
               var getVal = $("#"+id).val();
               $("#"+id).val(parseInt(getVal)+parseInt(setVal));
            });

        }

        
    }

}

function minusData(){

    var percentage = $("#percentage").val();
    var setVal = $("#setVal").val();
    var whole = $("#whole").val();
    var selection = $("#selection").val();

    if(whole!=0){
        if(percentage!=0){

            $(".price_input").each(function(){
               var id = $(this).attr('id');
               var getVal = $("#"+id).val();
               var newVal = (getVal/100)*setVal;
               $("#"+id).val(parseInt(getVal)-parseInt(newVal));
            });
        
        } else {

            $(".price_input").each(function(){
               var id = $(this).attr('id');
               var getVal = $("#"+id).val();
               $("#"+id).val(parseInt(getVal)-parseInt(setVal));
            });

        }
        
    }
}



function editTable(id) {


    var url = "<?php echo site_url('welcome/edit')?>/"+id;
    $.ajax({
        url : url,
        type: "GET",
        success: function(data)
        {
            $('#excel_table').html(data)
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}



    // submit form and add data
    $("#formStylePrice").on('submit',function(e){
        e.preventDefault();

            var submit_url = "<?php echo base_url(); ?>"+"welcome/save";

            $.ajax({
                type: 'POST',
                url: submit_url,
                data: $(this).serialize(),
                success: function(res) {
                   window.location.href="<?php echo base_url(); ?>"+"welcome";
                    
                },error: function() {

                }
            });
    });



    // submit form and add data
    $("#formId").on('submit',function(e){
        e.preventDefault();

            var submit_url = "<?php echo base_url(); ?>"+"welcome/save_style";

            $.ajax({
                type: 'POST',
                url: submit_url,
                data: $(this).serialize(),
                success: function(res) {
                   window.location.href="<?php echo base_url(); ?>"+"welcome";
                    
                },error: function() {

                }
            });
    });




</script>



</body>
</html>
