<script>
     $(document).on('click','.check-left-product',function(){
    
        if($(this).prop("checked")) {
             $(this).attr('data-output',1);
        }else {
             $(this).attr('data-output',0);
        } 
     });


     $(document).on('click','.check-right-product',function(index){
       console.log($(this));
        if($(this).prop("checked")) {
             $(this).attr('data-output',1);
        }else {
             $(this).attr('data-output',0);
        } 
     });

 

      $('#check-all').click(function(){
 
            if($(this).prop("checked")) {
                $(".check-left-product").prop("checked", true);
                $(".check-left-product").attr('data-output',1);
                $(".check-right-product").prop("checked", true);
                $(".check-right-product").attr('data-output',1);
            } else {
                $(".check-left-product").prop("checked", false);
                $(".check-left-product").attr('data-output',0);
                $(".check-right-product").prop("checked", false);
                $(".check-right-product").attr('data-output',0);
            }                
        });

      $("#export-data").submit(function(e){
           // e.preventDefault();
            var formEx=$(this);
            var data=[];
            $(".check-right-product").each(function(index){
                var asins=$(this).attr('data-asin');
                var output=$(this).attr('data-output');
                var price=$(this).attr('data-price');
                var sale=$(this).attr('data-sale');
                $("<input />").attr('type','hidden').attr('name','asin['+index+']').attr('value',asins).appendTo(formEx);
                $("<input />").attr('type','hidden').attr('name','output['+index+']').attr('value',output).appendTo(formEx);
                $("<input />").attr('type','hidden').attr('name','price['+index+']').attr('value',price).appendTo(formEx);
                $("<input />").attr('type','hidden').attr('name','sale['+index+']').attr('value',sale).appendTo(formEx);
              
            });
        
      });

     // $("#load-item").click(function(){
    inc=1;
    shownAlert=false;
    function load_data(){
            var btn=$('#load-item');
            var page=btn.attr('data-page');
            $.ajax({
                url:"load-item.php",
                type:"post",
                data:{page:page},
                beforeSend:function(){
                    $("#btn-loader").css('display','inline');
                    btn.css('visibility','visible');
                },
                complete:function(){
                    $("#btn-loader").css('display','none');
                    btn.css('visibility','hidden');
                   // addDrag($('.row'));
                },
                success:function(res){
                if(res.start==false){
                    btn.css('display','none');
                }else{
                    btn.attr('data-page',res.start);
                }
                  if(res.data){
                    for(var i=0;i<res.data.length;i++){

                        if(res.data[i].largeImage != ""){
                            var image=res.data[i].largeImage;
                        }else if(res.data[i].mediumImage != ""){
                            image=res.data[i].mediumImage;
                        }else if(res.data[i].smallImage != ""){
                            image=res.data[i].smallImage;
                        }else{
                            image="images/no-product.jpeg";
                        }

                        var html="<div class='row row-load"+inc+"'>"+
                                        "<div class='col-xs-1'>"+
                                             "<input id='imgs"+res.start+"' type='checkbox' class='check-left-product checkbox-inline' data-asin='"+res.data[i].asin+"' data-output='0' data-price='"+res.data[i].lowestPrice+"' data-sale='"+res.data[i].sales+"'>"+
                                        "</div>"+
                                        "<div class='col-xs-2'>"+
                                            "<h4>"+res.data[i].sales+"</h4>"+
                                        "</div>"+
                                         "<div class='col-xs-3'>"+
                                            "<label for='imgss"+res.start+"'><img src='"+image+"' height='200' width='200'></label>"+
                                        "</div>"+
                                         "<div class='col-xs-5'>"+
                                            "<h4><a target='_blank' href='"+res.data[i].url+"'>"+res.data[i].title+"</a></h4>"+
                                            "<p><b>Price</b> : $"+res.data[i].lowestPrice+"</p>"+
                                        "</div>"+
                                        "<div class='col-xs-1'>"+
                                            "<div class='round'>"+
                                                "<input id='imgs"+res.start+"' type='checkbox' class='check-right-product checkbox-inline right-product' data-asin='"+res.data[i].asin+"' data-output='0' data-price='"+res.data[i].lowestPrice+"' data-sale='"+res.data[i].sales+"' />"+
                                                    "<label for='imgs"+res.start+"'></label>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div><hr>";
                        $("#line-break").before(html);
                        res.start++;

                       // addDrag(html);
                        //console.log(res.data[i].asin);
                    }
                    addDrag($('.row-load'+inc));
                    inc++;
                 }else{
                    
                    if(!shownAlert){
                        var html="<div class='alert alert-info'>No more items to display</div>";
                        $("#line-break").before(html);
                        shownAlert=true;
                    }
                 }
                },
                error:function(err){
                    console.log(err);
                }
            });
      };

    $(window).scroll(function(){
        if ($(window).scrollTop() == $(document).height() - $(window).height()){
             load_data();
        }
    });

    // $(document).on('click','.round',function(){
    //     $(this).find('input').click();
    // });
    var addDrag=function(el){
        console.log(el);
        el.dragCheck({
            onDragEnd:function(element){
                $(element).find(".check-left-product").click();
                $(element).find(".check-right-product").click();
            }
        });
 
    }
    addDrag($('.row'));

    // $(document).on('.row','click',function(){
    //     console.log($(this));
    //     $(this).dragCheck({
    //         onDragEnd:function(element){
    //             $(element).find(".check-product").click();
    //             $(element).find(".check-right-product").click();
    //         }
    //     });
    // });


</script>