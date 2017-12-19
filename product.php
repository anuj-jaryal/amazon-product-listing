<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Amazon product Listing</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="js/jquery.dragcheck.js"></script>
     <style>
            .round {
              position: relative;
            }

            .round label {
              background-color: #f1f1f1;
              border: 1px solid #ccc;
              border-radius: 50%;
              cursor: pointer;
              height: 28px;
              left: 0;
              position: absolute;
              top: 0;
              width: 28px;
            }

            .round label:after {
              border: 2px solid #fff;
              border-top: none;
              border-right: none;
              content: "";
              height: 6px;
              left: 7px;
              opacity: 0;
              position: absolute;
              top: 8px;
              transform: rotate(-45deg);
              width: 12px;
            }

            .round input[type="checkbox"] {
              visibility: hidden;
            }

            .round input[type="checkbox"]:checked + label {
              background-color: #66bb6a;
              border-color: #66bb6a;
            }

            .round input[type="checkbox"]:checked + label:after {
              opacity: 1;
            }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Amazon product Listing</h2>
        <div>
            <input type="checkbox" id="check-all" name="check-all-product" >&nbsp;<label for="check-all">Check All</label>
            <form style="display: inline-block;" id="export-data" action="export-xlsx.php" method="post">
                <input type="submit" id="export" class="btn btn-primary" value="Export">
            </form>
        </div>
    <div class="row" style="margin-bottom:10px; ">
        <div class="col-xs-1">
            <h4>Selected</h4>
        </div>
        <div class="col-xs-2">
               <?php
                if(isset($_GET['field']) && $_GET['field']=="sales"){
                    $direction=$_GET['direction'];
                    $new_direction=($direction=='asc')? 'desc' :'asc';
                    $new_icon=($direction=='asc')?'fa fa-sort-asc':'fa fa-sort-desc';
                }else{
                    $new_direction="asc";
                    $new_icon='';
                }
            ?>
            <h4><a href="product.php?field=sales&direction=<?php echo $new_direction; ?>"><span style="color:black">Estimated sales</span><i style="float: right;" class="<?php echo $new_icon; ?>" aria-hidden="true"></i></a></h4>
        </div>
        <div class="col-xs-3" >
            
        </div>
        <div class="col-xs-7" id="title">
            <?php
                if(isset($_GET['field']) && $_GET['field']=="title"){
                    $direction=$_GET['direction'];
                    $new_direction=($direction=='asc')? 'desc' :'asc';
                    $new_icon=($direction=='asc')?'fa fa-sort-asc':'fa fa-sort-desc';
                }else{
                    $new_direction="asc";
                    $new_icon='';
                }
            ?>
             <h4 class="text-center"><a href="product.php?field=title&direction=<?php echo $new_direction; ?>"><span style="color:black">Title</span><i style="float: right;" class="<?php echo $new_icon; ?>" aria-hidden="true"></i></a></h4> 
        </div>
    </div>
    <div id="product-container">
    <?php 
    foreach($items as $index=>$item){
        include 'product-listing.php';
     } 
    ?>

    <?php if(isset($_SESSION['start']) && $_SESSION['start']<=count($_SESSION['sheet']['asin'])) { ?>
     <div id="line-break" style="padding-bottom: 10px;visibility: visible;"><a class="btn btn-primary" id="load-item" data-page="<?php echo $_SESSION['start']; ?>"><i class="fa fa-spinner fa-spin" aria-hidden="true" id="btn-loader"></i> Please wait...</a></div>
    </div>
   
    <?php } ?>
     </div>
<?php require_once 'script.php'; ?>
</body>
</html>