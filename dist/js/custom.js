$('#pft-form select[name=\'finyear\'], #pft-form select[name=\'center\'],#pft-form select[name=\'month\']').on('change', function() {
    location = 'physical-financial-target.php?finyear=' + encodeURIComponent($('#pft-form select[name=\'finyear\']').val()) + '&center_id=' + encodeURIComponent($('#pft-form select[name=\'center\']').val())+ '&month=' + encodeURIComponent($('#pft-form select[name=\'month\']').val());
});

$('#pfa-form select[name=\'finyear\'], #pfa-form select[name=\'center\'], #pfa-form select[name=\'month\']').on('change', function() {
    location = 'physical-financial-achievement.php?finyear=' + encodeURIComponent($('#pfa-form select[name=\'finyear\']').val()) + '&center_id=' + encodeURIComponent($('#pfa-form select[name=\'center\']').val()) + '&month=' + encodeURIComponent($('#pfa-form select[name=\'month\']').val());
});

$('#ed-form select[name=\'finyear\'], #ed-form select[name=\'center\']').on('change', function() {
    location = 'employment-details.php?finyear=' + encodeURIComponent($('#ed-form select[name=\'finyear\']').val()) + '&center_id=' + encodeURIComponent($('#ed-form select[name=\'center\']').val());
});

$('#prorepo select[name=\'finyear\'], #prorepo select[name=\'center\'], #prorepo select[name=\'district\']').on('change', function() {
    location = 'progress-report.php?finyear=' + encodeURIComponent($('#prorepo select[name=\'finyear\']').val()) + '&district=' + encodeURIComponent($('#prorepo select[name=\'district\']').val()) + '&center_id=' + encodeURIComponent($('#prorepo select[name=\'center\']').val());
});

$('#trainplc select[name=\'finyear\'], #trainplc select[name=\'center\'],#trainplc select[name=\'month\'],#trainplc select[name=\'district\']').on('change', function() {
    location = 'training-and-placement.php?finyear=' + encodeURIComponent($('#trainplc select[name=\'finyear\']').val()) + '&district=' + encodeURIComponent($('#trainplc select[name=\'district\']').val()) + '&center_id=' + encodeURIComponent($('#trainplc select[name=\'center\']').val())+ '&month=' + encodeURIComponent($('#trainplc select[name=\'month\']').val());
});

$('#noc select[name=\'finyear\'], #noc select[name=\'center\'], #noc select[name=\'district\']').on('change', function() {
    location = 'number-of-candidates.php?finyear=' + encodeURIComponent($('#noc select[name=\'finyear\']').val()) + '&district=' + encodeURIComponent($('#noc select[name=\'district\']').val()) + '&center_id=' + encodeURIComponent($('#noc select[name=\'center\']').val());
});

$('#ysdp select[name=\'finyear\'], #ysdp select[name=\'center\'],#ysdp select[name=\'month\'], #ysdp select[name=\'district\']').on('change', function() {
    location = 'year-skill-development-program.php?finyear=' + encodeURIComponent($('#ysdp select[name=\'finyear\']').val()) + '&district=' + encodeURIComponent($('#ysdp select[name=\'district\']').val()) + '&center_id=' + encodeURIComponent($('#ysdp select[name=\'center\']').val())+ '&month=' + encodeURIComponent($('#ysdp select[name=\'month\']').val());
});

$('#bwtrain select[name=\'finyear\'], #bwtrain select[name=\'center\'], #bwtrain select[name=\'district\']').on('change', function() {
    location = 'batchwise-training.php?finyear=' + encodeURIComponent($('#bwtrain select[name=\'finyear\']').val()) + '&district=' + encodeURIComponent($('#bwtrain select[name=\'district\']').val()) + '&center_id=' + encodeURIComponent($('#bwtrain select[name=\'center\']').val());
});

$('#tc-form select[name=\'center\']').on('change', function() {
    location = 'home.php?center_id=' + encodeURIComponent($('#tc-form select[name=\'center\']').val());
});

$("#pft-form .frm2").on('input', function(e){
    var $total = 0;
    $("#pft-form .frm2").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#pft-form #phytot").val($total);
});

$("#pft-form .frm3").on('input', function(e){
    var $total = 0;
    $("#pft-form .frm3").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#pft-form #fintot").val($total);
});

$("#pft-form .frm4m").on('input', function(e){
    var $total = 0;
    $("#pft-form .frm4m").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
	//alert(e.target.id);
	if(e.target.id == "genphymale1"){
		$("#genphyfmale1total").val(parseInt($('#genphymale1').val())+parseInt($('#genphyfmale1').val()));
		$("#genfinfmale1Total").val(parseInt($('#genphymale1').val())+parseInt($('#genfinmale1').val()));
		
	}else if(e.target.id == "scpphymale2"){
		$("#scpphyfmale2total").val(parseInt($('#scpphymale2').val())+parseInt($('#scpphyfmale2').val()));
		$("#scpfinfmale2Total").val(parseInt($('#scpphymale2').val())+parseInt($('#scpfinmale2').val()));
		
	}else if(e.target.id == "tspphymale2"){
		$("#tspphyfmale2total").val(parseInt($('#tspphymale2').val())+parseInt($('#tspphyfmale2').val()));
		$("#tspfinfmale2Total").val(parseInt($('#tspfinmale2').val())+parseInt($('#tspphymale2').val()));
		
	}
	
    $("#pft-form #phytotmale2").val($total);
	$("#phytotfmale2Total").val(parseInt($("#phytotmale2").val())+parseInt($("#phytotfmale2").val()));
	$("#fintotffemale2Total").val(parseInt($("#phytotfmale2").val())+parseInt($("#fintotfmale2").val()));	
});

$("#pft-form .frm4f").on('input', function(e){
    var $total = 0;
    $("#pft-form .frm4f").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
	if(e.target.id == "genphyfmale1"){
		$("#genphyfmale1total").val(parseInt($('#genphymale1').val())+parseInt($('#genphyfmale1').val()));
		$("#genfinffemale1Total").val(parseInt($('#genfinfmale1').val())+parseInt($('#genphyfmale1').val()));
		
	}else if(e.target.id == "scpphyfmale2"){
		$("#scpphyfmale2total").val(parseInt($('#scpphymale2').val())+parseInt($('#scpphyfmale2').val()));
		$("#scpfinffemale2Total").val(parseInt($('#scpfinfmale2').val())+parseInt($('#scpphyfmale2').val()));
		
	}else if(e.target.id == "tspphyfmale2"){
		$("#tspphyfmale2total").val(parseInt($('#tspphymale2').val())+parseInt($('#tspphyfmale2').val()));
		$("#tspfinffemale2Total").val(parseInt($('#tspphyfmale2').val())+parseInt($('#tspfinfmale2').val()));
		
		
	}
	
    $("#pft-form #phytotfmale2").val($total);
	$("#phytotfmale2Total").val(parseInt($("#phytotmale2").val())+parseInt($("#phytotfmale2").val()));
});

$("#pft-form .frm5m").on('input', function(e){
    var $total = 0;
    $("#pft-form .frm5m").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
	if(e.target.id == "genfinmale1"){
		$("#genfinfmale1Total").val(parseInt($('#genfinmale1').val())+parseInt($('#genphymale1').val()));
		
	}else if(e.target.id == "scpfinmale2"){
		$("#scpfinfmale2Total").val(parseInt($('#scpfinmale2').val())+parseInt($('#scpphymale2').val()));
		
	}else if(e.target.id == "tspfinmale2"){
		$("#tspfinfmale2Total").val(parseInt($('#tspfinmale2').val())+parseInt($('#tspphymale2').val()));
		
	}
	
    $("#pft-form #fintotmale2").val($total);
		$("#fintotfmale2Total").val(parseInt($("#phytotmale2").val())+parseInt($("#fintotmale2").val()));
});

$("#pft-form .frm5f").on('input', function(e){
    var $total = 0;
    $("#pfa-form .frm5f").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#pft-form #fintotfmale2").val($total);
	if(e.target.id == "genfinfmale1"){
		//$("#genfinfmale1Total").val(parseInt($('#genfinmale1').val())+parseInt($('#genfinfmale1').val()));
		$("#genfinffemale1Total").val(parseInt($('#genfinfmale1').val())+parseInt($('#genphyfmale1').val()));
	}else if(e.target.id == "scpfinfmale2"){
		
	$("#scpfinffemale2Total").val(parseInt($('#scpfinfmale2').val())+parseInt($('#scpphyfmale2').val()));
		
	}else if(e.target.id == "tspfinfmale2"){
		//$("#tspfinfmale2Total").val(parseInt($('#tspfinmale2').val())+parseInt($('#tspphymale2').val()));
		$("#tspfinffemale2Total").val(parseInt($('#tspphyfmale2').val())+parseInt($('#tspfinfmale2').val()));
		
	}
     $("#fintotffemale2Total").val(parseInt($("#phytotfmale2").val())+parseInt($("#fintotfmale2").val()));	
	
	
});


$("#pfa-form .frm4m").on('input', function(e){
    var $total = 0;
    $("#pfa-form .frm4m").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
	if(e.target.id == "genphymale1"){
		$("#genphyfmale1total").val(parseInt($('#genphymale1').val())+parseInt($('#genphyfmale1').val()));
		$("#genfinfmale1Total").val(parseInt($('#genfinmale1').val())+parseInt($('#genphymale1').val()));
		
	}else if(e.target.id == "scpphymale2"){
		$("#scpphyfmale2total").val(parseInt($('#scpphymale2').val())+parseInt($('#scpphyfmale2').val()));
		$("#scpfinfmale2Total").val(parseInt($('#scpfinmale2').val())+parseInt($('#scpphymale2').val()));
		
	}else if(e.target.id == "tspphymale2"){
		$("#tspphyfmale2total").val(parseInt($('#tspphymale2').val())+parseInt($('#tspphyfmale2').val()));
		$("#tspfinfmale2Total").val(parseInt($('#tspfinmale2').val())+parseInt($('#tspphymale2').val()));
		
	}
	
    $("#pfa-form #phytotmale2").val($total);
	$("#phytotfmale2Total").val(parseInt($("#phytotmale2").val())+parseInt($("#phytotfmale2").val()));
	$("#fintotffemale2Total").val(parseInt($("#phytotfmale2").val())+parseInt($("#fintotfmale2").val()));	
});

$("#pfa-form .frm4f").on('input', function(e){
    var $total = 0;
    $("#pfa-form .frm4f").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
	if(e.target.id == "genphyfmale1"){
		$("#genphyfmale1total").val(parseInt($('#genphymale1').val())+parseInt($('#genphyfmale1').val()));
		$("#genfinffemale1Total").val(parseInt($('#genfinfmale1').val())+parseInt($('#genphyfmale1').val()));
		
	}else if(e.target.id == "scpphyfmale2"){
		$("#scpphyfmale2total").val(parseInt($('#scpphymale2').val())+parseInt($('#scpphyfmale2').val()));
		$("#scpfinffemale2Total").val(parseInt($('#scpfinfmale2').val())+parseInt($('#scpphyfmale2').val()));
		
	}else if(e.target.id == "tspphyfmale2"){
		$("#tspphyfmale2total").val(parseInt($('#tspphymale2').val())+parseInt($('#tspphyfmale2').val()));
		$("#tspfinffemale2Total").val(parseInt($('#tspphyfmale2').val())+parseInt($('#tspfinfmale2').val()));
		
		
	}
	
    $("#pfa-form #phytotfmale2").val($total);
	$("#phytotfmale2Total").val(parseInt($("#phytotmale2").val())+parseInt($("#phytotfmale2").val()));
});

$("#pfa-form .frm5m").on('input', function(e){
    var $total = 0;
    $("#pfa-form .frm5m").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
	if(e.target.id == "genfinmale1"){
		$("#genfinfmale1Total").val(parseInt($('#genfinmale1').val())+parseInt($('#genphymale1').val()));
		
	}else if(e.target.id == "scpfinmale2"){
		$("#scpfinfmale2Total").val(parseInt($('#scpfinmale2').val())+parseInt($('#scpphymale2').val()));
		
	}else if(e.target.id == "tspfinmale2"){
		$("#tspfinfmale2Total").val(parseInt($('#tspfinmale2').val())+parseInt($('#tspphymale2').val()));
		
	}
	
    $("#pfa-form #fintotmale2").val($total);
		$("#fintotfmale2Total").val(parseInt($("#phytotmale2").val())+parseInt($("#fintotmale2").val()));
});

$("#pfa-form .frm5f").on('input', function(e){
    var $total = 0;
    $("#pfa-form .frm5f").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#pfa-form #fintotfmale2").val($total);
	if(e.target.id == "genfinfmale1"){
		$("#genfinfmale1Total").val(parseInt($('#genfinmale1').val())+parseInt($('#genfinfmale1').val()));
		$("#genfinffemale1Total").val(parseInt($('#genfinfmale1').val())+parseInt($('#genphyfmale1').val()));
	}else if(e.target.id == "scpfinfmale2"){
		
	$("#scpfinffemale2Total").val(parseInt($('#scpfinfmale2').val())+parseInt($('#scpphyfmale2').val()));
		
	}else if(e.target.id == "tspfinfmale2"){
		//$("#tspfinfmale2Total").val(parseInt($('#tspfinmale2').val())+parseInt($('#tspphymale2').val()));
		$("#tspfinffemale2Total").val(parseInt($('#tspphyfmale2').val())+parseInt($('#tspfinfmale2').val()));
		
	}
     $("#fintotffemale2Total").val(parseInt($("#phytotfmale2").val())+parseInt($("#fintotfmale2").val()));	
	
	
});

$("#pfa-form .frm6m").on('input', function(e){
    var $total = 0;
    $("#pfa-form .frm6m").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#pfa-form #phytotmale3").val($total);
	
	if(e.target.id == "indusphymale1"){
		$("#indusphyfmale1Total").val(parseInt($('#indusphymale1').val())+parseInt($('#indusphyfmale1').val()));
		$("#indusfinfmale1Total").val(parseInt($('#indusphymale1').val())+parseInt($('#indusfinmale1').val()));
		
	}else if(e.target.id == "ownphymale2"){
		$("#ownphyfmale2Total").val(parseInt($('#ownphymale2').val())+parseInt($('#ownphyfmale2').val()));
		$("#ownfinfmale2Total").val(parseInt($('#ownphymale2').val())+parseInt($('#ownfinmale2').val()));
		
	}else if(e.target.id == "grpphymale2"){
		$("#grpphyfmale2Total").val(parseInt($('#grpphymale2').val())+parseInt($('#grpphyfmale2').val()));
		$("#grpfinfmale2Total").val(parseInt($('#grpphymale2').val())+parseInt($('#grpfinmale2').val()));
		
	}else if(e.target.id == "othphymale2"){
		$("#othphyfmale2Total").val(parseInt($('#othphymale2').val())+parseInt($('#othphyfmale2').val()));
		$("#othfinfmale2Total").val(parseInt($('#othphymale2').val())+parseInt($('#othfinmale2').val()));
		
	}
     $("#phytotfmale3Total").val(parseInt($("#phytotmale3").val())+parseInt($("#phytotfmale3").val()));	
	
});

$("#pfa-form .frm6f").on('input', function(e){
    var $total = 0;
    $("#pfa-form .frm6f").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#pfa-form #phytotfmale3").val($total);
	if(e.target.id == "indusphyfmale1"){
		$("#indusphyfmale1Total").val(parseInt($('#indusphymale1').val())+parseInt($('#indusphyfmale1').val()));
		$("#indusfinffemale1Total").val(parseInt($('#indusphyfmale1').val())+parseInt($('#indusfinfmale1').val()));
		
	}else if(e.target.id == "ownphyfmale2"){
		$("#ownphyfmale2Total").val(parseInt($('#ownphymale2').val())+parseInt($('#ownphyfmale2').val()));
		$("#ownfinffemale2Total").val(parseInt($('#ownphyfmale2').val())+parseInt($('#ownfinfmale2').val()));
		
	}else if(e.target.id == "grpphyfmale2"){
		$("#grpphyfmale2Total").val(parseInt($('#grpphymale2').val())+parseInt($('#grpphyfmale2').val()));
		$("#grpfinffemale2Total").val(parseInt($('#grpphyfmale2').val())+parseInt($('#grpfinfmale2').val()));
		
	}else if(e.target.id == "othphyfmale2"){
		$("#othphyfmale2Total").val(parseInt($('#othphymale2').val())+parseInt($('#othphyfmale2').val()));
		$("#othfinffemale2Total").val(parseInt($('#othphyfmale2').val())+parseInt($('#othfinfmale2').val()));
		
	}
	$("#phytotfmale3Total").val(parseInt($("#phytotmale3").val())+parseInt($("#phytotfmale3").val()));
});

$("#pfa-form .frm7m").on('input', function(e){
    var $total = 0;
    $("#pfa-form .frm7m").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#pfa-form #fintotmale3").val($total);
	if(e.target.id == "indusfinmale1"){
		$("#indusfinfmale1Total").val(parseInt($('#indusfinmale1').val())+parseInt($('#indusfinfmale1').val()));
		$("#indusfinfmale1Total").val(parseInt($('#indusphymale1').val())+parseInt($('#indusfinmale1').val()));
		
	}else if(e.target.id == "ownfinmale2"){
		//$("#ownfinfmale2Total").val(parseInt($('#ownfinmale2').val())+parseInt($('#ownfinfmale2').val()));
		$("#ownfinfmale2Total").val(parseInt($('#ownphymale2').val())+parseInt($('#ownfinmale2').val()));
		
	}else if(e.target.id == "grpfinmale2"){
		$("#grpfinfmale2Total").val(parseInt($('#grpfinmale2').val())+parseInt($('#grpfinfmale2').val()));
		$("#grpfinfmale2Total").val(parseInt($('#grpphymale2').val())+parseInt($('#grpfinmale2').val()));
		
	}else if(e.target.id == "othfinmale2"){
		//$("#othfinfmale2Total").val(parseInt($('#othfinmale2').val())+parseInt($('#othfinfmale2').val()));
		//$("#othfinfmale2Total").val(parseInt($('#othphymale2').val())+parseInt($('#othfinmale2').val()));
		//$("#othfinffemale2Total").val(parseInt($('#othphyfmale2').val())+parseInt($('#othfinfmale2').val()));
		$("#othfinfmale2Total").val(parseInt($('#othphymale2').val())+parseInt($('#othfinmale2').val()));
	}
	$("#fintotfmale3Total").val(parseInt($("#fintotmale3").val())+parseInt($("#fintotfmale3").val()));
	
});

$("#pfa-form .frm7f").on('input', function(e){
    var $total = 0;
    $("#pfa-form .frm7f").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#pfa-form #fintotfmale3").val($total);
	if(e.target.id == "indusfinfmale1"){
		//$("#indusfinfmale1Total").val(parseInt($('#indusfinmale1').val())+parseInt($('#indusfinfmale1').val()));
		$("#indusfinffemale1Total").val(parseInt($('#indusphyfmale1').val())+parseInt($('#indusfinfmale1').val()));
	}else if(e.target.id == "ownfinfmale2"){
		//$("#ownfinfmale2Total").val(parseInt($('#ownfinmale2').val())+parseInt($('#ownfinfmale2').val()));
		$("#ownfinffemale2Total").val(parseInt($('#ownphyfmale2').val())+parseInt($('#ownfinfmale2').val()));
		
	}else if(e.target.id == "grpfinfmale2"){
		//$("#grpfinfmale2Total").val(parseInt($('#grpfinmale2').val())+parseInt($('#grpfinfmale2').val()));
		$("#grpfinffemale2Total").val(parseInt($('#grpphyfmale2').val())+parseInt($('#grpfinfmale2').val()));
		
	}else if(e.target.id == "othfinfmale2"){
		//$("#othfinfmale2Total").val(parseInt($('#othfinmale2').val())+parseInt($('#othfinfmale2').val()));
		$("#othfinffemale2Total").val(parseInt($('#othphyfmale2').val())+parseInt($('#othfinfmale2').val()));
	}
	$("#fintotfmale3Total").val(parseInt($("#fintotmale3").val())+parseInt($("#fintotfmale3").val()));
});

$("#ed-form .frmcand").on('input', function(e){
    var $total = 0;
    $("#ed-form .frmcand").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#ed-form #candtot").val($total);
});
$("#ed-form .frminex").on('input', function(e){
    var $total = 0;
    $("#ed-form .frminex").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#ed-form #inextot").val($total);
});
$("#ed-form .frmrawmaterial").on('input', function(e){
    var $total = 0;
    $("#ed-form .frmrawmaterial").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#ed-form #rawmaterialtot").val($total);
});
$("#ed-form .frmstipend").on('input', function(e){
    var $total = 0;
    $("#ed-form .frmstipend").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#ed-form #stipendtot").val($total);
});

$("#ed-form .frmexpend").on('input', function(e){
    var $total = 0;
    $("#ed-form .frmexpend").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#ed-form #expendtot").val($total);
});

$("#ed-form .frmcandemp").on('input', function(e){
    var $total = 0;
    $("#ed-form .frmcandemp").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#ed-form #expemptot").val($total);
});

$("#ed-form .frmexpemp").on('input', function(e){
    var $total = 0;
    $("#ed-form .frmexpemp").each(function(index, elem) {
        $total = $total + parseInt($(elem).val());
    });
    $("#ed-form #expendituretot").val($total);
});

$(".frmtrainstart, #trainingstart").datepicker({
    dateFormat: "dd-mm-yy",
});

$(".frmtrainend").datepicker({
    dateFormat: "dd-mm-yy",
});

$('.tc-delete, .fy-delete').on('click',function (e) {
    if(!confirm('Do you want to delete?')){
         e.preventDefault();
    }
});

$('.tc-edit').on('click',function (e) {
   $('#center-model form').attr('action', 'centers.php?center=' + $(this).data('id'));
   $('#center-model #name').val($(this).data('center'));
   $('#center-model #district').val($(this).data('district'));
   $('#center-model').modal('show');
});

$('#center-model').on('hidden.bs.modal', function () {
    $('#center-model form').attr('action', 'centers.php');
    $('#center-model #name').val('');
    $('#center-model #district').val('');
  });

$('.fy-edit').on('click',function (e) {
    $('#finyear-model form').attr('action', 'financial-year.php?id=' + $(this).data('id'));
    $('#finyear-model #finyear').val($(this).data('finyear'));
    $('#finyear-model').modal('show');
});

$('#finyear-model').on('hidden.bs.modal', function () {
    $('#finyear-model form').attr('action', 'financial-year.php');
    $('#finyear-model #finyear').val('');
});