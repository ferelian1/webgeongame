
$('#mytable').dataTable( {
    "createdRow": function( row, data, dataIndex){
        if( data[2] ==  `someVal`){
            $(row).addClass('green');
        }else{
            $(row).addClass('lightgreen');
        }
    }
});
