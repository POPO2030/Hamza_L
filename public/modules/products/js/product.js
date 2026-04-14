function barcodePrint()
{
    var img = $("#barcode_print")
    img.printThis({
        loadCSS:"https://beljoumla.com/dashboard/css/print.css",
        afterPrint: $(".product-code").attr('hidden',false),

    })



}

function sizePrint(id)
{

    var img = $("#size_barcode_img_content_"+id)
    img.printThis({
        loadCSS:"https://beljoumla.com/dashboard/css/print.css",
        afterPrint: $(".product-code").attr('hidden',false),

    })
}
function colorSizePrint(id,code)
{
    var img = $("#color_size_barcode_img_content_"+code+"_"+id)
    img.printThis({
        loadCSS:"https://beljoumla.com/dashboard/css/print.css",
        afterPrint: $(".product-code").attr('hidden',false),

    })
}

function colorPrint(key)
{
    var img = $("#color_barcode_img_content_"+key)
    img.printThis({
        loadCSS:"https://beljoumla.com/dashboard/css/print.css",
        afterPrint: $(".product-code").attr('hidden',false),

    })
}

function standHolder()
{
    $(".view-location").attr('hidden',false)
    var val = document.getElementById('stand').value
    console.log(val)
    $("#stand_holder").text(val)
}
function shelfHolder()
{
    $(".view-location").attr('hidden',false)
    var val = document.getElementById('shelf').value
    console.log(val)
    $("#shelf_holder").text(val)
}
function boxHolder()
{
    $(".view-location").attr('hidden',false)
    var val = document.getElementById('box').value
    console.log(val)
    $("#box_holder").text(val)
}


