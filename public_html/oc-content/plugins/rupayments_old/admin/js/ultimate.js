$(document).ready(function(){
    $('span#country-switcher').click(function() {
        var countryId = $(this).attr('country-id'),
            status = $(this).attr('status');

        if(status == 'hide') {
            $(this).attr('status','show').find('i.fa-plus-circle').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            $('tr[region-country-id="' + countryId + '"]').fadeIn(1000);
        }
        else {
            $('tr[region-country-id="' + countryId + '"]').fadeOut(500).find('i.fa-minus-circle').removeClass('fa-minus-circle').addClass('fa-plus-circle').parent('span#region-switcher').attr('status','hide'); 
            $('tr[city-country-id="' + countryId + '"]').fadeOut(500); 
            $(this).attr('status','hide').find('i.fa-minus-circle').removeClass('fa-minus-circle').addClass('fa-plus-circle');
        }        
    });
    
    $('span#region-switcher').click(function() {
        var regionId = $(this).attr('region-id'),
            status = $(this).attr('status');
        
        if(status == 'hide') {
            $(this).attr('status','show').find('i.fa-plus-circle').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            $('tr[city-region-id="' + regionId + '"]').fadeIn(1000);
        }
        else {
            $('tr[city-region-id="' + regionId + '"]').fadeOut(500); 
            $(this).attr('status','hide').find('i.fa-minus-circle').removeClass('fa-minus-circle').addClass('fa-plus-circle');
        }
    });
    
    $('span#cat-switcher').click(function(){
        var catId = $(this).attr('category-id'),
            groupId = $(this).attr('group-id'),
            status = $(this).attr('status');
            
        if(status == 'hide') {
            $(this).attr('status','show').find('i.fa-plus-circle').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            $('tr#subcategories[parent-id="' + catId + '"][group-id="' + groupId + '"]').fadeIn(1000);
        }
        else {
            $('tr#subcategories[parent-id="' + catId + '"][group-id="' + groupId + '"]').fadeOut(500); 
            $(this).attr('status','hide').find('i.fa-minus-circle').removeClass('fa-minus-circle').addClass('fa-plus-circle');
        }
    });
    
    $('span#cat-prices-switcher').click(function(){
        var catId = $(this).attr('category-id'),
            status = $(this).attr('status');
            
        if(status == 'hide') {
            $(this).attr('status','show').find('i.fa-plus-circle').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            $('tr#subcategories[parent-id="' + catId + '"]').fadeIn(1000);
        }
        else {
            $('tr#subcategories[parent-id="' + catId + '"]').fadeOut(500); 
            $(this).attr('status','hide').find('i.fa-minus-circle').removeClass('fa-minus-circle').addClass('fa-plus-circle');
        }
    });
    
    $('span#publish-policy-switcher').click(function(){
        var catId = $(this).attr('category-id'),
            groupId = $(this).attr('group-id'),
            status = $(this).attr('status');
            
        if(status == 'hide') {
            $(this).attr('status','show').find('i.fa-plus-circle').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            $('tr#subcategories[parent-id="' + catId + '"][group-id="' + groupId + '"]').fadeIn(1000);
        }
        else {
            $('tr#subcategories[parent-id="' + catId + '"][group-id="' + groupId + '"]').fadeOut(500); 
            $(this).attr('status','hide').find('i.fa-minus-circle').removeClass('fa-minus-circle').addClass('fa-plus-circle');
        }
    });
    
    $('div[data-toggle="mitcher"]').hurkanSwitch({
        'on':function(el){
            var catId = $(el).parents('td.col-free-publishing').find('input#free-publishing-switcher').attr('category-id'),
                groupID = $(el).parents('td.col-free-publishing').find('input#free-publishing-switcher').attr('group-id');
            
            $('input[type="number"][name^="num_free_ads[' + catId + '][' + groupID + ']"]').attr('readonly', true).css({'opacity' : 0.5});
        },
        'off':function(el){
            var catId = $(el).parents('td.col-free-publishing').find('input#free-publishing-switcher').attr('category-id'),
                groupID = $(el).parents('td.col-free-publishing').find('input#free-publishing-switcher').attr('group-id');
            
            $('input[type="number"][name^="num_free_ads[' + catId + '][' + groupID + ']"]').removeAttr('readonly').css({'opacity' : 1});
        },
        
        'onTitle' : 'Yes',
        'offTitle' : 'No',
        'animate' : true,
        'offColor' : 'danger',
        'onColor' : 'success',
        'width': 40
    });
    
    $('[data-toggle="switch"]').hurkanSwitch({
        'onTitle' : 'On',
        'offTitle' : 'Off',
        'animate' : true,
        'offColor' : 'danger',
        'onColor' : 'success',
        'width': 40
    });
    
    $('i#tips').tipso({
        position: 'top',
        background: '#018be3',
		color: '#eee',
        width: '',
		maxWidth: 500,
        tooltipHover: true,
        animationIn: 'flipInX',
		animationOut: 'flipOutX'
    });
    
    $('i#info').tipso({
        position: 'top',
        background: '#d90909',
		color: '#eee',
        width: '',
		maxWidth: 500,
        tooltipHover: true,
        animationIn: 'flipInX',
		animationOut: 'flipOutX'
    });
});