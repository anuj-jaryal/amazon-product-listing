    <div class="row">
        <div class="col-xs-1">
            <input id="img<?php echo $index; ?>" type="checkbox" class="checkbox-inline" data-asin="<?php echo $item['asin']; ?>" data-output="0" data-price="<?php echo $item['lowestPrice']; ?>" data-sale="<?php echo $item['sales']; ?>" >
        </div>
        <div class="col-xs-2">
              <h4><?php echo $item['sales']?></h4>
        </div>
        <div class="col-xs-3">
            <?php
                if(!empty($item['largeImage'])){
                    $image=$item['largeImage'];
                }else if(!empty($item['mediumImage'])){
                     $image=$item['mediumImage'];
                }else if(!empty($item['smallImage'])){
                     $image=$item['smallImage'];
                }else{
                    $image='images/no-product.jpeg';
                }
            ?>
            <label for="imgss<?php echo $index; ?>"><img src="<?php echo $image ; ?>" height="200" width="200"></label>
        </div>
        <div class="col-xs-5">
            <h4><a target="_blank" href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a></h4>
            <p><b>Price </b>: <?php echo  "$".$item['lowestPrice']?></p>
             
        </div>
        <div class="col-xs-1">
            <div class="round" >
                <input id="img<?php echo $index; ?>" type="checkbox" class="check-right-product checkbox-inline" data-asin="<?php echo $item['asin']; ?>" data-output="0" data-price="<?php echo $item['lowestPrice']; ?>" data-sale="<?php echo $item['sales']; ?>" />
                <label for="img<?php echo $index; ?>" class="right-product-label"></label>
            </div>
        </div>
    </div>
    <hr>