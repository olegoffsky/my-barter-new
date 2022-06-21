$(document).ready(function(){ 
    var url = '/index.php?page=ajax&action=custom&ajaxfile=rupayments/ajax.php';
    
    $("#cityId").change(function(){
        var cityId = $(this).val(),
            catId = $('#catId').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {"do" : "region-prices", "cityId" : cityId, "catId" : catId},
            error: function(){},
            success: function(data){
                $('#itemform-block').html(data);
            }
        }); 
    });
    
    $("#catId").change(function(){
        var cityId = $('#cityId').val(),
            catId = $(this).val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {"do" : "region-prices", "cityId" : cityId, "catId" : catId},
            error: function(){},
            success: function(data){
                $('#itemform-block').html(data);
            }
        }); 
    });
    
    $('a#site-banner').click(function() {
        var bannerId = $(this).attr('banner-id');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {"do" : "banner-clicks", "bannerId" : bannerId},
            error: function(){},
            success: function(data){}
        }); 
    });
});