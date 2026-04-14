var allcolors = {'red':'أحمر','green':'أخضر','blue':'أزرق','white':'أبيض','black':'أسود','yellow':'أصفر','pink':'وردي ',
'purple':'بنفسجي','brown':'بني','orange':'برتقالي','gray':'رمادي','baby blue':'سماوي','navy blue':'كحلي ',
'turquoise':'فيروزي','beige':'بيج','burgundy':'أرجواني غامق','baby pink':'زهري','hot pink':'فوشي','mustard':'أصفر غامق ','caramel':'بني فاتح'};


function fix_image(image){
image = image.split("/");
return image[(image.length)-1];
}

var imageurl = "https://beljoumla-products.s3.us-east-2.amazonaws.com/";

function getproductcolors(id,colors,itemid){

$.ajax({url: base_url + "/products/getById/"+id, success: function(result){
var data = JSON.parse(result,true);
var html ='';
for (let i = 0; i < data.gallery.length; i++) {
    var imgurl = data.gallery[i]['gallery_img'];
    var imagelink =  imageurl+'uploads/products/'+fix_image(imgurl);
    var imgcolor = data.gallery[i]['color'];
    var colorcount = colors[imgcolor]??0;
    if(typeof allcolors[imgcolor] != 'undefined'){
        html += '<div class="col-md-3 popupsection"><div class="box-one-prod" style="transform: none;"><div class="pro-img popupimages">';
        html += '<img onclick="popupover(\''+imagelink+'\')" src="'+imagelink+'" alt="">';
        html += '</div></div>';
        html += '<h5 style="text-align: center;">'+allcolors[imgcolor]+'</h5>';
        html += '<input type="hidden" value="'+imgcolor+'" class="qyntinputcolor"  tabindex="0">';
        html += '<div class="quantity1"><input type="number" onchange="updatePrice()" onclick="updatePrice()" min="0" min="0" value="'+colorcount+'"  class="qyntinput" style="width: 40%;text-align: center;border-radius: 10px;" id="qnty" tabindex="0"></div> <span class="qyntinputspan">ثرية</span>';
        html += '</div>';
    }            
}
if(typeof colors == 'object') var length = Object.keys(colors).length;
else var length = colors.length;
var footer ="";
if(length > 0) footer += '<button type="submit" style="padding: 1% 10%;" onclick="edititemcolor('+id+','+itemid+')" class="btn btn-danger"  data-id="'+id+'" > '+Update+' </button>'
else footer += '<button type="submit" style="padding: 1% 10%;" onclick=\'additemcolor('+JSON.stringify(data)+')\' class="btn btn-danger"  data-id="'+id+'" > '+Add+' </button>'
footer += '<button type="button" class="btn btn-secondary" data-dismiss="modal">'+Cancel+'</button>';

if($(window).width() > 992 ){
    $('#htmlcolorid').html(html);
}else{
    $('#htmlcoloridslider').html('<div class="productslider" >' + html +'</div>');
}
$('#popupfooter').html(footer);
$('#optModel').modal('show');

customNumberInput(1);
sliderproduct();
}});

}

function sliderproduct(){
    $(".productslider").slick({
        dots: false,
        infinite: false,
        arrows : true,
        variableWidth: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1
    });
}

function edititemcolor(id,itemid) {
var datestamp =  new Date().getTime();
var qyntinput = document.getElementsByClassName('qyntinput');
var qyntinputcolor = document.getElementsByClassName('qyntinputcolor');
var colors = {};
if(qyntinputcolor.length > 0){
var qty = 0;
var htmlvalue = '';var htmlqyn = '';
for(var i=0; i<qyntinput.length; i++) {
    if(typeof colors[qyntinputcolor[i].value] == 'undefined' || parseInt(colors[qyntinputcolor[i].value]) <= 0){
        colors[qyntinputcolor[i].value] = qyntinput[i].value;
        qty += parseInt(qyntinput[i].value);
    }
}
let _colors = JSON.stringify(colors);
var colors = {}
for(var i=0; i<qyntinput.length; i++) {
    if(typeof colors[qyntinputcolor[i].value] == 'undefined' || parseInt(colors[qyntinputcolor[i].value]) <= 0){
        var value = qyntinput[i].value;
        if(value > 0){
            htmlvalue += '<h6>'+allcolors[qyntinputcolor[i].value]+'</h6>';
            htmlqyn += "<div class='quantity quantity"+datestamp+"'><input type='number' onchange='getproductcolors("+id+","+_colors+","+itemid+")' onclick='getproductcolors("+id+","+_colors+","+itemid+")' value="+value+"></input></div>";
        }
    }
    
}

htmlqyn += '<input type="hidden" class="qty" name="qty[]" value="'+qty+'" >';
htmlqyn += '<input type="hidden" name="colorids[]" value="'+itemid+'" >';
htmlqyn += '<input type="hidden" name="colors[]" value=\''+_colors+'\' >';
$('#colorsetvalue'+id).html(htmlvalue);
$('#colorsetqyn'+id).html(htmlqyn);
$('#optModel').modal('hide');
updatePrice();
customNumberInput(datestamp);
}		
};

function autocompelte(){
    var val = $('#myInput').val();
    if(val.length < 3) $('#myInputautocomplete-list').html('');
    else{
        $.ajax({
            url: base_url + "/products/search?val="+val,
            type: "GET",
            processData: false,
            contentType: false,
            success: function (data) {
                var html = '';
                data = JSON.parse(data);
                for(var key of Object.keys(data)) {
                    var image = imageurl+'uploads/products/'+fix_image(data[key]['main_image']);
                    html += '<div id="cus'+key+'"  onclick=\'addProduct('+JSON.stringify(data[key])+')\' > <img src="'+image+'" ><span class="product_name">'+data[key]['data']['product_name']+'</span></div>';
                }
                $('#myInputautocomplete-list').html(html);
                $("#myInputautocomplete-list").show();
            },
        });
    }
}

window.addEventListener('click', function(e){   
if (!document.getElementById('autocomplete').contains(e.target)){
$("#myInputautocomplete-list").hide();
}
});

function addProduct(data){
    var counter = 0;
    var productids = document.getElementsByClassName('productids');
    var pices = 'readonly'; var seri = '';
    var datestamp =  new Date().getTime();
    for(var i=0; i<productids.length; i++) {
    if(productids[i].value == data['id']) counter++;
        if(counter > 1){
            alert('هذا المنتج موجود بالفعل');
            $("#myInputautocomplete-list").hide();
            return;
        }else if(counter > 0){
            pices = ''; seri = 'readonly';
        }
    }

    if(data['stock_quantity'] < 1){
        if (confirm('غير متوفر فى المخزون هل تريد المتابعة؟')) {
        } else {
          throw '';
        }
    }
    
    if(data['colors_set'] > 0){
      getproductcolorsandsize(data)
    }else{
      showsingleproduct(data);
    }
}

function addProductSeri(data){
    var pices = 'readonly'; var seri = '';
    var datestamp =  new Date().getTime();
    if(data['sale_price'] > 0) var price = data['sale_price']; else var price = data['price'];
    var total = price * data['seri_count'] * data['min_order_qty'];
    data['main_image'] = imageurl+'uploads/products/'+fix_image(data['main_image']);
    var html = '<tr id="main'+data['id']+datestamp+'"><td></td>';
    html += '<td><a class="product-gallary" data-fancybox="gallery" > <img src="'+data['main_image']+'" class="order-img" ></a><div class="ord-info">'+
            data['data']['product_name']+'<br> <small>'+data['barcode']+' </small></div></td>';
    html += '<td>لايوجد</td><td><div class="quantity quantity'+datestamp+'"><input type="number" onchange="updatePrice()" onclick="updatePrice()" min="0"  '+seri+' class="qty" name="qty[]" value="'+data['min_order_qty']+'"></div></td><td>Kupano</td>';
    html += '<input type="hidden" class="ids" name="ids[]" value="'+data['id']+datestamp+'">';
    html += '<input type="hidden" class="productids" name="productids[]" value="'+data['id']+'"><td>';
    html += '<div class="quantity quantity'+datestamp+'"><input type="number" onchange="updatePrice()" onclick="updateconfirmPrice(this,'+price+')" min="0" class="prices" name="prices[]" value="'+price+'"></div></td>';
    html += '<td style="text-align: center;">'+data['seri_count']+'<input type="hidden" onchange="updatePrice()" onclick="updatePrice()" min="0" '+pices+'  class="seri_count"  name="seri_count[]" value="'+data['seri_count']+'"></td>';
    html += '<td><strong id="'+data['id']+datestamp+'">'+total+' EGP</strong></td>';
    html += '<td><div class="remove-cart col-md-1 centerline" ><a onclick="removeItems(\'main'+data['id']+datestamp+'\')" ><i class="fa fa-trash"></i></a></div></td></tr>';
    $('#producthead').append(html);
    $("#myInputautocomplete-list").hide();
    $('#showsingleproduct').modal('hide');
    customNumberInput(datestamp);
    updatePrice();
}

function getproductcolorsandsize(data){
    $('#selecttype').modal('show');
    $('#selecttypeId').val(data.id);
  }

  function showsingleproductsize(type=''){
    $('#showsingleproduct').modal('hide');
    var thisvalue = $('#selecttypeId-single').val();
    getsingleproductsizes(thisvalue);
  }
  

  function showsingleproduct(data){
    $('#selecttypeId-single').val(data.id);
    var html = '<a style="cursor:pointer" id="singlelink" onclick=\'addProductSeri('+JSON.stringify(data)+')\' >'+AddSeri+'</a>';
    $('#singleproductcontent').html(html);
    $('#showsingleproduct').modal('show');
  }

  function showproductcolorsandsize(type=''){
    $('#selecttype').modal('hide');
    var thisvalue = $('#selecttypeId').val();

    if(type != '' && type =='seri'){
      getproductcolors(thisvalue,'','');
    }else if(type != '' && type =='pices'){
      $('#selecttype').modal('hide');
      getproductcolorssizes(thisvalue,[]);
    }
  }

var change = true;
function updateconfirmPrice(e,value){
if(change){
if (confirm('هل انت متاكد من تغيير السعر ')) {
    updatePrice();
    change=false;
} else {
    e.value =value;
}
}
}

function updatePrice(){
    var currency = "EGP";
    var productids = document.getElementsByClassName('productids');
    var ids = document.getElementsByClassName('ids');
    var qty = document.getElementsByClassName('qty');
    var seri_count = document.getElementsByClassName('seri_count');
    var prices = document.getElementsByClassName('prices');
    var amount =0 ;
    for(var i=0; i< ids.length; i++) {
        var id = ids[i].value ;
        var sum = qty[i].value *seri_count[i].value * prices[i].value ;
        console.log('#'+id , sum);
        $('#'+id).html(sum+' EGP');
        amount += sum;
    }

let cashback = parseFloat($('#cashback').val());
let shipping_fees = parseFloat($('#shipping_fees').val());
let total = parseFloat(amount) + shipping_fees - cashback;
$('#paid_amount').html(amount + ' ' + currency);
$('#total_amount').html(total.toFixed(2) + ' ' + currency);
}

function removeItems(id){
    $('#'+id).remove();
    updatePrice();
}

function customNumberInput(val=''){
    jQuery('<div class="quantity-nav-down"><div class="quantity-button quantity-down"> -	</div></div>').insertBefore('.quantity'+val+' input');
    jQuery('<div class="quantity-nav-up"><div class="quantity-button quantity-up">+</div></div>').insertAfter('.quantity'+val+' input');
    jQuery('.quantity'+val).each(function() {
    var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');
  
    btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
        var newVal = oldValue;
        } else {
        var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });
  
    btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
        var newVal = oldValue;
        } else {
        var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });
  
    });
  }
  customNumberInput();



  var moredata = '';
function getproductcolorssizes(id,currentsizes,itemid){
    var allsizes = currentsizes;
  
    var allcolors = {'red':'أحمر','green':'أخضر','blue':'أزرق','white':'أبيض','black':'أسود','yellow':'أصفر','pink':'وردي ',
        'purple':'بنفسجي','brown':'بني','orange':'برتقالي','gray':'رمادي','baby blue':'سماوي','navy blue':'كحلي',
        'turquoise':'فيروزي','beige':'بيج','burgundy':'أرجواني غامق','baby pink':'زهري','hot pink':'فوشي','mustard':'أصفر غامق','caramel':'بني فاتح'};
        
    $.ajax({url:  base_url + "/products/getById/"+id, success: function(result){
        var data = JSON.parse(result,true);
        if(allsizes.length == 0){
          allsizes  = createProductSizes(data);
        }
        if(!data['main_image'].includes('uploads/products'))  data['main_image'] = 'uploads/products/150/'+data['main_image'];
        var htmlsizes ='';var htmlcolor='<div style="text-align: center;">';var i=1;
        for(var sizes of allsizes){
            if(typeof sizes.color != 'undefined'){
                for(var image of data.gallery){
                if(sizes.color == image.color  || sizes.color == allcolors[image.color]) {
                  var imgurl = image.gallery_img;
                  var color_en = image.color.replace(' ','_');
                  var _image  = imageurl+'uploads/products/150/'+fix_image(imgurl) } }

                if(i==1) {var active="activecolor"; var style="";}else {var active=""; var style='style="display: none;"';}
                htmlcolor += '<img class="colorsizseselect '+active+'" id="active'+color_en+'" onclick="tabcolor(\''+color_en+'\')" src="'+_image+'"><input type="hidden" value="'+sizes.color+'" class="qyntinputcolors">';
                htmlsizes += '<div class="sizeselection sizescontent" '+style+' id="'+color_en+'">';
                for(var item of sizes.values){
                    htmlsizes += '<div class="" style="height:40px"><span class="quantity-button quntity-button-edit">'+item.size+'</span>';
                    htmlsizes += '<input type="hidden" class="qyntinputsizes" value="'+item.size+'" >';
                    htmlsizes +='<div class="quantity1 quantity1_eidt"><input type="number" min="0" class="qyntinputsizesvalues" class="form-control" value="'+item.value+'"></div></div>';
                }
                htmlsizes += '</div>';
                i++;
            }else{
                htmlsizes += '<div class="sizescontent" style="height:40px"><span class="quantity-button quntity-button-edit">'+sizes.size+'</span>';
                htmlsizes += '<input type="hidden" class="qyntinputsizes" value="'+sizes.size+'" >';
                htmlsizes +='<div class="quantity1 quantity1_eidt"><input type="number" min="0" class="qyntinputsizesvalues" class="form-control" value="'+sizes.value+'"></div></div>';
            }
  }
        var footer="";
        if(currentsizes.length > 0) footer = '<button type="submit" style="padding: 1% 10%;" onclick="edititemcolorsizes('+id+','+itemid+')" class="btn btn-danger" data-id="'+id+'"> '+Update+' </button>';
        else footer = '<button type="submit" style="padding: 1% 10%;" onclick=\'additemcolorsizes('+JSON.stringify(data)+')\' class="btn btn-danger" data-id="'+id+'"> '+Add+' </button>';
        footer += '<button type="button" class="btn btn-secondary" data-dismiss="modal">'+Cancel+'</button>';

        $('#sizescontent').html( htmlcolor+'</div>' + htmlsizes);
        $('#sizesfooter').html(footer);
        $('#showsizes').modal('show');

        customNumberInput(1);
    }});
    
}


function getsingleproductsizes(id){
    var allcolors = {'red':'أحمر','green':'أخضر','blue':'أزرق','white':'أبيض','black':'أسود','yellow':'أصفر','pink':'وردي ',
        'purple':'بنفسجي','brown':'بني','orange':'برتقالي','gray':'رمادي','baby blue':'سماوي','navy blue':'كحلي',
        'turquoise':'فيروزي','beige':'بيج','burgundy':'أرجواني غامق','baby pink':'زهري','hot pink':'فوشي','mustard':'أصفر غامق','caramel':'بني فاتح'};

    $.ajax({url: base_url + "/products/getById/"+id, success: function(result){
        var data = JSON.parse(result,true);
        var allsizes  = createsingleProductSizes(data);
        

        if(!data['main_image'].includes('uploads/products'))  data['main_image'] = 'uploads/products/150/'+data['main_image'];
        var htmlsizes ='';var htmlcolor='<div style="text-align: center;">';var i=1;
       for(var sizes of allsizes){
            if(typeof sizes.color != 'undefined'){
                for(var image of data.gallery){ if(sizes.color == allcolors[image.color]) {
                  var color_en = image.color.replace(' ','_');
                  var _image  =  imageurl+'uploads/products/150/'+fix_image(image.gallery_img)} }

                if(i==1) {var active="activecolor"; var style="";}else {var active=""; var style='style="display: none;"';}
                htmlcolor += '<img class="colorsizseselect '+active+'" id="active'+color_en+'" onclick="tabcolor(\''+color_en+'\')" src="'+_image+'"><input type="hidden" value="'+sizes.color+'" class="qyntinputcolors">';
                htmlsizes += '<div class="sizeselection sizescontent" '+style+' id="'+color_en+'">';
                for(var item of sizes.values){
                    htmlsizes += '<div class="" style="height:40px"><span class="quantity-button quntity-button-edit">'+item.size+'</span>';
                    htmlsizes += '<input type="hidden" class="qyntinputsizes" value="'+item.size+'" >';
                    htmlsizes +='<div class="quantity1 quantity1_eidt"><input type="number" min="0" class="qyntinputsizesvalues" class="form-control" value="'+item.value+'"></div></div>';
                }
                htmlsizes += '</div>';
                i++;
            }else{
                htmlsizes += '<div class="sizescontent" style="height:40px"><span class="quantity-button quntity-button-edit">'+sizes.size+'</span>';
                htmlsizes += '<input type="hidden" class="qyntinputsizes" value="'+sizes.size+'" >';
                htmlsizes +='<div class="quantity1 quantity1_eidt"><input type="number" min="0" class="qyntinputsizesvalues" class="form-control" value="'+sizes.value+'"></div></div>';
            }
  }

        footer = '<button type="submit" style="padding: 1% 10%;"  onclick=\'additemsizes('+JSON.stringify(data)+')\' class="btn btn-danger" data-id="'+id+'"> '+Add+' </button>';
        footer += '<button type="button" class="btn btn-secondary" data-dismiss="modal">'+Cancel+'</button>';

        $('#sizescontent').html( htmlcolor+'</div>' + htmlsizes);
        $('#sizesfooter').html(footer);
        $('#showsizes').modal('show');

        customNumberInput(1);
    }});
    
}


function createProductSizes(product){

    var allcolors = {'red':'أحمر','green':'أخضر','blue':'أزرق','white':'أبيض','black':'أسود','yellow':'أصفر','pink':'وردي ',
    'purple':'بنفسجي','brown':'بني','orange':'برتقالي','gray':'رمادي','baby blue':'سماوي','navy blue':'كحلي',
    'turquoise':'فيروزي','beige':'بيج','burgundy':'أرجواني غامق','baby pink':'زهري','hot pink':'فوشي','mustard':'أصفر غامق','caramel':'بني فاتح'};
  
    let sizes = []; let colors = [];
    product['options'].forEach(value=>{
        sizes.push({'size': value['data']['option_name'], 'value':0});
    });


  
    product['gallery'].forEach(image => {
        if(image['color'] != ''){
            colors.push({'color' : allcolors[image['color']],'values' : sizes});
        }
    });
    return colors;
  }

function createsingleProductSizes(product){
    let sizes = []; let colors = [];
    product['options'].forEach(value=>{
        sizes.push({'size': value['data']['option_name'], 'value':0});
    });
    return sizes;
  }


function getproductsizes(id,sizes,itemid){
    var allsizes = sizes;  
    var allcolors = {'red':'أحمر','green':'أخضر','blue':'أزرق','white':'أبيض','black':'أسود','yellow':'أصفر','pink':'وردي ',
        'purple':'بنفسجي','brown':'بني','orange':'برتقالي','gray':'رمادي','baby blue':'سماوي','navy blue':'كحلي',
        'turquoise':'فيروزي','beige':'بيج','burgundy':'أرجواني غامق','baby pink':'زهري','hot pink':'فوشي','mustard':'أصفر غامق','caramel':'بني فاتح'};

    $.ajax({url: base_url + "/products/getById/"+id, success: function(result){
        var data = JSON.parse(result,true);
        if(!data['main_image'].includes('uploads/products'))  data['main_image'] = 'uploads/products/150/'+data['main_image'];
        var htmlsizes ='';var htmlcolor='<div style="text-align: center;">';var i=1;
       for(var sizes of allsizes){
            if(typeof sizes.color != 'undefined'){
                for(var image of data.gallery){ if(sizes.color == allcolors[image.color]) {
                  var color_en = image.color.replace(' ','_');
                  var _image  = imageurl+'uploads/products/150/'+fix_image(image.gallery_img)} }

                if(i==1) {var active="activecolor"; var style="";}else {var active=""; var style='style="display: none;"';}
                htmlcolor += '<img class="colorsizseselect '+active+'" id="active'+color_en+'" onclick="tabcolor(\''+color_en+'\')" src="'+_image+'"><input type="hidden" value="'+sizes.color+'" class="qyntinputcolors">';
                htmlsizes += '<div class="sizeselection sizescontent" '+style+' id="'+color_en+'">';
                for(var item of sizes.values){
                    htmlsizes += '<div class="" style="height:40px"><span class="quantity-button quntity-button-edit">'+item.size+'</span>';
                    htmlsizes += '<input type="hidden" class="qyntinputsizes" value="'+item.size+'" >';
                    htmlsizes +='<div class="quantity1 quantity1_eidt"><input type="number" min="0" class="qyntinputsizesvalues" class="form-control" value="'+item.value+'"></div></div>';
                }
                htmlsizes += '</div>';
                i++;
            }else{
                htmlsizes += '<div class="sizescontent" style="height:40px"><span class="quantity-button quntity-button-edit">'+sizes.size+'</span>';
                htmlsizes += '<input type="hidden" class="qyntinputsizes" value="'+sizes.size+'" >';
                htmlsizes +='<div class="quantity1 quantity1_eidt"><input type="number" min="0" class="qyntinputsizesvalues" class="form-control" value="'+sizes.value+'"></div></div>';
            }
  }

        footer = '<button type="submit" style="padding: 1% 10%;" onclick="edititemsizes('+id+','+itemid+')" class="btn btn-danger" data-id="'+id+'"> '+Update+' </button>';
        footer += '<button type="button" class="btn btn-secondary" data-dismiss="modal">'+Cancel+'</button>';

        $('#sizescontent').html( htmlcolor+'</div>' + htmlsizes);
        $('#sizesfooter').html(footer);
        $('#showsizes').modal('show');

        customNumberInput(1);
    }});
    
}


function edititemsizes(id,itemid) {
    var datestamp =  new Date().getTime();
    var qyntinputsizes = document.getElementsByClassName('qyntinputsizes');
    var qyntinputsizesvalues = document.getElementsByClassName('qyntinputsizesvalues');
    if(qyntinputsizes.length > 0){
        var qty = 0;
        var sizes = [];
        for(var i=0; i<qyntinputsizes.length; i++) {
            if(typeof qyntinputsizes[i].value != 'undefined' ){
               sizes.push({"size":qyntinputsizes[i].value,"value":qyntinputsizesvalues[i].value})
               qty += parseInt(qyntinputsizesvalues[i].value);
            }
            
        }
        let _sizes = JSON.stringify(sizes);
        var htmlvalue = '';var htmlqyn = '';
        for(var i=0; i<qyntinputsizes.length; i++) {
            if(typeof qyntinputsizes[i].value != 'undefined' && parseInt(qyntinputsizesvalues[i].value) > 0){
                htmlvalue += '<h6>--( '+qyntinputsizes[i].value+' )</h6>';
                htmlqyn += "<div class='quantity quantity"+datestamp+"'><input type='number' onchange='getproductsizes("+id+","+_sizes+","+itemid+")' onclick='getproductsizes("+id+","+_sizes+","+itemid+")' value="+qyntinputsizesvalues[i].value+"></input></div>";
            }
            
        }
        
        htmlqyn += '<input type="hidden" class="qty" name="qty[]" value="'+qty+'" >';
        htmlqyn += '<input type="hidden" name="sizeids[]" value="'+itemid+'" >';
        htmlqyn += '<input type="hidden" name="sizes[]" value=\''+_sizes+'\' >';

        $('#sizesetvalue'+id).html(htmlvalue);
        $('#sizesetqyn'+id).html(htmlqyn);
        
        $('#showsizes').modal('hide');
        updatePrice();
        customNumberInput(datestamp);
    }		
 };

 function additemsizes(data) {
    var datestamp =  new Date().getTime();
    var qyntinputsizes = document.getElementsByClassName('qyntinputsizes');
    var qyntinputsizesvalues = document.getElementsByClassName('qyntinputsizesvalues');
    if(qyntinputsizes.length > 0){
        var qty = 0;
        var sizes = [];
        for(var i=0; i<qyntinputsizes.length; i++) {
            if(typeof qyntinputsizes[i].value != 'undefined' ){
               sizes.push({"size":qyntinputsizes[i].value,"value":qyntinputsizesvalues[i].value})
               qty += parseInt(qyntinputsizesvalues[i].value);
            }
            
        }
        let _sizes = JSON.stringify(sizes);
        var htmlvalue = '';var htmlqyn = '';
        for(var i=0; i<qyntinputsizes.length; i++) {
            if(typeof qyntinputsizes[i].value != 'undefined' && parseInt(qyntinputsizesvalues[i].value) > 0){
                htmlvalue += '<h6>--( '+qyntinputsizes[i].value+' )</h6>';
                htmlqyn += "<div class='quantity quantity"+datestamp+"'><input type='number' onchange='getproductsizes("+data['id']+","+_sizes+","+data['id']+datestamp+")' onclick='getproductsizes("+data['id']+","+_sizes+","+data['id']+datestamp+")' value="+qyntinputsizesvalues[i].value+"></input></div>";
            }
            
        }
        
        htmlqyn += '<input type="hidden" class="qty" name="qty[]" value="'+qty+'" >';
        htmlqyn += '<input type="hidden" name="sizeids[]" value="'+data['id']+datestamp+'" >';
        htmlqyn += '<input type="hidden" name="sizes[]" value=\''+_sizes+'\' >';

        
        if(data['sale_price'] > 0) var price = data['sale_price']; else var price = data['price'];
        var total = price * data['seri_count'] * data['min_order_qty'];
        data['main_image'] = imageurl+'uploads/products/'+fix_image(data['main_image']);
        var html = '<tr id="main'+data['id']+datestamp+'"><td></td>';
        html += '<td><div class="ord-img"><img src="'+data['main_image']+'" class="order-img" ></div><div class="ord-info">'+
                data['data']['product_name']+'<br> <small>'+data['barcode']+' </small><div class="ord-ops"></div></div></td>';
        html += '<td><div id="sizesetvalue'+data['id']+'">'+htmlvalue+'</div></td>';
        html += '<td><div id="sizesetqyn'+data['id']+'">'+htmlqyn+'</div></td><td>Kupano</td>';
        html += '<input type="hidden" class="ids" name="ids[]" value="'+data['id']+datestamp+'">';
        html += '<input type="hidden" class="productids" name="productids[]"  value="'+data['id']+'"><td>';
        html += '<div class="quantity quantity'+datestamp+'"><input type="number" onchange="updatePrice()" onclick="updateconfirmPrice(this,'+price+')" min="0" class="prices" name="prices[]" value="'+price+'"></div></td>';
        html += '<td style="text-align: center;">1<input type="hidden" onchange="updatePrice()" onclick="updatePrice()" min="0"  class="seri_count" readonly name="seri_count[]" value="1"></td>';
        html += '<td><strong id="'+data['id']+datestamp+'">'+total+' EGP</strong></td>';
        html += '<td><div class="remove-cart col-md-1 centerline" ><a onclick="removeItems(\'main'+data['id']+datestamp+'\')" ><i class="fa fa-trash"></i></a></div></td></tr>';

        $('#producthead').append(html);
      
        $('#showsizes').modal('hide');
        updatePrice();
        customNumberInput(datestamp);
    }		
 };


 function edititemcolorsizes(id,itemid) {
    var datestamp =  new Date().getTime();
    
    var qyntinputcolors = document.getElementsByClassName('qyntinputcolors');
    var qyntinputsizes = document.getElementsByClassName('qyntinputsizes');
    var qyntinputsizesvalues = document.getElementsByClassName('qyntinputsizesvalues');
    var sizelenght = qyntinputsizes.length / qyntinputcolors.length ;

    if(qyntinputsizes.length > 0){
        var qty = 0;
        var sizes = [];
        for(var k=0; k< qyntinputcolors.length; k++) {
            var i = (k * sizelenght); var end = i + sizelenght;
            var tempsize = [];
            for(i; i < end ; i++) {
                if(typeof qyntinputsizes[i].value != 'undefined' ){
                    tempsize.push({"size":qyntinputsizes[i].value,"value":qyntinputsizesvalues[i].value})
                   qty += parseInt(qyntinputsizesvalues[i].value);
                }
            }
            sizes.push({"color":qyntinputcolors[k].value , "values":tempsize});
        }
        
        let _sizes = JSON.stringify(sizes);

        var htmlvalue = '';var htmlqyn = '';
        for(var k=0; k< qyntinputcolors.length; k++) {
            var i = (k * sizelenght); var end = i + sizelenght;
            var tempsize = [];
            for(i; i < end ; i++) {
                if(typeof qyntinputsizes[i].value != 'undefined' && parseInt(qyntinputsizesvalues[i].value) > 0){
                    htmlvalue += '<h6>'+qyntinputcolors[k].value+' ( '+qyntinputsizes[i].value+' )</h6>';
                    htmlqyn += "<div class='quantity quantity"+datestamp+"'><input type='number' onchange='getproductcolorssizes("+id+","+_sizes+","+itemid+")' onclick='getproductcolorssizes("+id+","+_sizes+","+itemid+")' value="+qyntinputsizesvalues[i].value+"></input></div>";
                }
            }
        }
        
        htmlqyn += '<input type="hidden" class="qty" name="qty[]" value="'+qty+'" >';
        htmlqyn += '<input type="hidden" name="sizeids[]" value="'+itemid+'" >';
        htmlqyn += '<input type="hidden" name="sizes[]" value=\''+_sizes+'\' >';
        $('#sizesetvalue'+id).html(htmlvalue);
        $('#sizesetqyn'+id).html(htmlqyn);
        $('#showsizes').modal('hide');
        updatePrice();
        customNumberInput(datestamp);
    }		
 };

 function additemcolorsizes(data) {
    var datestamp =  new Date().getTime();
    
    var qyntinputcolors = document.getElementsByClassName('qyntinputcolors');
    console.log(qyntinputcolors);
    var qyntinputsizes = document.getElementsByClassName('qyntinputsizes');
    var qyntinputsizesvalues = document.getElementsByClassName('qyntinputsizesvalues');
    var sizelenght = qyntinputsizes.length / qyntinputcolors.length ;

    if(qyntinputsizes.length > 0){
        var qty = 0;
        var sizes = [];
        for(var k=0; k< qyntinputcolors.length; k++) {
            var i = (k * sizelenght); var end = i + sizelenght;
            var tempsize = [];
            for(i; i < end ; i++) {
                if(typeof qyntinputsizes[i].value != 'undefined' ){
                    tempsize.push({"size":qyntinputsizes[i].value,"value":qyntinputsizesvalues[i].value})
                   qty += parseInt(qyntinputsizesvalues[i].value);
                }
            }
            sizes.push({"color":qyntinputcolors[k].value , "values":tempsize});
        }
        
        let _sizes = JSON.stringify(sizes);

        var htmlvalue = '';var htmlqyn = '';
        for(var k=0; k< qyntinputcolors.length; k++) {
            var i = (k * sizelenght); var end = i + sizelenght;
            var tempsize = [];
            for(i; i < end ; i++) {
                if(typeof qyntinputsizes[i].value != 'undefined' && parseInt(qyntinputsizesvalues[i].value) > 0){
                    htmlvalue += '<h6>'+qyntinputcolors[k].value+' ( '+qyntinputsizes[i].value+' )</h6>';
                    htmlqyn += "<div class='quantity quantity"+datestamp+"'><input type='number' onchange='getproductcolorssizes("+data['id']+","+_sizes+","+data['id']+datestamp+")' onclick='getproductcolorssizes("+data['id']+","+_sizes+","+data['id']+datestamp+")' value="+qyntinputsizesvalues[i].value+"></input></div>";
                }
            }
        }
        
        htmlqyn += '<input type="hidden" class="qty" name="qty[]" value="'+qty+'" >';
        htmlqyn += '<input type="hidden" name="sizeids[]" value="'+data['id']+datestamp+'" >';
        htmlqyn += '<input type="hidden" name="sizes[]" value=\''+_sizes+'\' >';


        if(data['sale_price'] > 0) var price = data['sale_price']; else var price = data['price'];
        var total = price * data['seri_count'] * data['min_order_qty'];
        data['main_image'] = imageurl+'uploads/products/'+fix_image(data['main_image']);
        var html = '<tr id="main'+data['id']+datestamp+'"><td></td>';
        html += '<td><div class="ord-img"><img src="'+data['main_image']+'" class="order-img" ></div><div class="ord-info">'+
                data['data']['product_name']+'<br> <small>'+data['barcode']+' </small><div class="ord-ops"></div></div></td>';
        html += '<td><div id="sizesetvalue'+data['id']+'">'+htmlvalue+'</div></td>';
        html += '<td><div id="sizesetqyn'+data['id']+'">'+htmlqyn+'</div></td><td>Kupano</td>';
        html += '<input type="hidden" class="ids" name="ids[]" value="'+data['id']+datestamp+'">';
        html += '<input type="hidden" class="productids" name="productids[]" value="'+data['id']+'"><td>';
        html += '<div class="quantity quantity'+datestamp+'"><input type="number" onchange="updatePrice()" onclick="updateconfirmPrice(this,'+price+')" min="0" class="prices" name="prices[]" value="'+price+'"></div></td>';
        html += '<td style="text-align: center;">1<input type="hidden" onchange="updatePrice()" onclick="updatePrice()" min="0"  class="seri_count" readonly name="seri_count[]" value="1"></td>';
        html += '<td><strong id="'+data['id']+datestamp+'">'+total+' EGP</strong></td>';
        html += '<td><div class="remove-cart col-md-1 centerline" ><a onclick="removeItems(\'main'+data['id']+datestamp+'\')" ><i class="fa fa-trash"></i></a></div></td></tr>';

        $('#producthead').append(html);
        $('#showsizes').modal('hide');
        updatePrice();
        customNumberInput(datestamp);
    }		
 };


 function additemcolor(data) {
    var datestamp =  new Date().getTime();
    var qyntinput = document.getElementsByClassName('qyntinput');
    var qyntinputcolor = document.getElementsByClassName('qyntinputcolor');
    var colors = {};
    if(qyntinputcolor.length > 0){
    var qty = 0;
    var htmlvalue = '';var htmlqyn = '';
    for(var i=0; i<qyntinput.length; i++) {
        if(typeof colors[qyntinputcolor[i].value] == 'undefined' || parseInt(colors[qyntinputcolor[i].value]) <= 0){
            colors[qyntinputcolor[i].value] = qyntinput[i].value;
            qty += parseInt(qyntinput[i].value);
        }
    }
    let _colors = JSON.stringify(colors);
    var colors = {}
    for(var i=0; i<qyntinput.length; i++) {
        if(typeof colors[qyntinputcolor[i].value] == 'undefined' || parseInt(colors[qyntinputcolor[i].value]) <= 0){
            var value = qyntinput[i].value;
            if(value > 0){
                htmlvalue += '<h6>'+allcolors[qyntinputcolor[i].value]+'</h6>';
                htmlqyn += "<div class='quantity quantity"+datestamp+"'><input type='number' onchange='getproductcolors("+data['id']+","+_colors+","+data['id']+datestamp+")' onclick='getproductcolors("+data['id']+","+_colors+","+data['id']+datestamp+")' value="+value+"></input></div>";
            }
        }
        
    }
    
    htmlqyn += '<input type="hidden" class="qty" name="qty[]" value="'+qty+'" >';
    htmlqyn += '<input type="hidden" name="colorids[]" value="'+data['id']+datestamp+'" >';
    htmlqyn += '<input type="hidden" name="colors[]" value=\''+_colors+'\' >';

    if(data['sale_price'] > 0) var price = data['sale_price']; else var price = data['price'];
    var total = price * data['seri_count'] * data['min_order_qty'];
    data['main_image'] = imageurl+'uploads/products/'+fix_image(data['main_image']);
    var html = '<tr id="main'+data['id']+datestamp+'"><td></td>';
    html += '<td><div class="ord-img"><img src="'+data['main_image']+'" class="order-img" ></div><div class="ord-info">'+
            data['data']['product_name']+'<br> <small>'+data['barcode']+' </small><div class="ord-ops"></div></div></td>';
    html += '<td><div id="colorsetvalue'+data['id']+'">'+htmlvalue+'</div></td>';
    html += '<td><div id="colorsetqyn'+data['id']+'">'+htmlqyn+'</div></td><td>Kupano</td>';
    html += '<input type="hidden" class="ids" name="ids[]" value="'+data['id']+datestamp+'">';
    html += '<input type="hidden" class="productids" name="productids[]" value="'+data['id']+'"><td>';
    html += '<div class="quantity quantity'+datestamp+'"><input type="number" onchange="updatePrice()" onclick="updateconfirmPrice(this,'+price+')" min="0" class="prices" name="prices[]" value="'+price+'"></div></td>';
    html += '<td style="text-align: center;">'+data['seri_count']+'<input type="hidden" onchange="updatePrice()" onclick="updatePrice()" min="0"  class="seri_count" readonly name="seri_count[]" value="'+data['seri_count']+'"></td>';
    html += '<td><strong id="'+data['id']+datestamp+'">'+total+' EGP</strong></td>';
    html += '<td><div class="remove-cart col-md-1 centerline" ><a onclick="removeItems(\'main'+data['id']+datestamp+'\')" ><i class="fa fa-trash"></i></a></div></td></tr>';

    $('#producthead').append(html);

    $('#optModel').modal('hide');
    updatePrice();
    customNumberInput(datestamp);
    }		
    };

function tabcolor(color){
    $('.sizeselection').hide();
    $(".colorsizseselect").removeClass("activecolor");
    $('#active'+color).addClass("activecolor");
    $('#'+color).show();
}