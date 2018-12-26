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

<div id="container">

<div class="row">
    <div class="col-md-12">
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add Style</button>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Style Header</h4>
              </div>
              <div class="modal-body">
                <input type="text" name="name" class="form-controle">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>

    </div>
</div>



<table border="1">
    
    <tr>
        <th>Style</th>
        <th>Action</th>
    </tr>
    <?php foreach($lists as $val){?>
        <tr>
            <td><?php echo $val->style_id;?></td>
            <td><a href="<?=base_url('welcome/edit/')?><?=$val->style_id;?>">Edit</a></td>
        </tr>
    <?php } ?>

</table>


<p>Paste excel data here:</p>
    <textarea name="excel_data" style="width:600px;height:150px;"></textarea><br>
    <input type="button" onclick="javascript:generateTable()" value="Genereate Table"/>
<br><br>
    <p>Table data will appear below</p>
<hr>
<?=form_open('welcome/save')?>
<div id="excel_table"></div>


<button type="submit" class="btn btn-success btn-sm"> save</button>
<?=form_close()?>

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
            row.append('<input type="text" name="test'+n+pr+'" value="'+cells[x]+'"/>');
        }
        table.append(row);
    }

// Insert into DOM
$('#excel_table').html(table);
}
</script>



</body>
</html>
