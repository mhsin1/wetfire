// pour afficher div grise au rollover dans resultat de recherche
$(document).ready(function() {
  $('#recherche').ketchup();
  $('#banque').trigger('change');
});

function toggleDisplay(id){
    if(document.getElementById("option"+id).style.display=="none")
        document.getElementById("option"+id).style.display="";
    else
        document.getElementById("option"+id).style.display="none";
}

// pour afficher les infobulles
function toggleDisplayBulle(id){
    if(document.getElementById("infobulle"+id).style.display=="none")
        document.getElementById("infobulle"+id).style.display="";
    else
        document.getElementById("infobulle"+id).style.display="none";
}

function check_carte_2() {

    if($('[name=compte]:checked').val() == "joint") {
        $('#show_carte_2').show();
    }
    else {
        $('#carte2').hide();
        $('#carte2').val('selection');
        $('#show_carte_2').hide();
        $('#hide_carte_2').hide();
    }

}

function add_carte_2() {
    $('#carte2').show();
    $('#show_carte_2').hide();
    $('#hide_carte_2').show();
}

function remove_carte_2() {
    $('#carte2').hide();
    $('#carte2').val('selection');
    $('#show_carte_2').show();
    $('#hide_carte_2').hide();
}

function addLinkerEvents() {

}

//rempli les champs select pour les cartes

function load_card() {

    var banque = $('#banque').val();
    var compte = $('[name=compte]:checked').val();

    $('#carte1').removeAttr('disabled');
    $('#carte2').removeAttr('disabled');
	if(banque!=''){
		$('#logo').attr('src', 'http://files.choisir-sa-banque-en-ligne.com/images/logoRes/'+banque+'.png');

		$.ajax({
			type: "POST",
			url: "/ajax/load_card.php",
			data: "banque="+banque+"&compte="+compte,
			dataType:'json',
			success: function(data) {
				$('#carte1 option').remove();
				$('#carte2 option').remove();
				$('<option value=""> Choisissez une carte... </option>').appendTo('#carte1');
				$('<option value=""> Choisissez une carte... </option>').appendTo('#carte2');
				$.each(data, function(i, name) {
					$('<option value="'+i+'">'+name+'</option>').appendTo('#carte1');
					$('<option value="'+i+'">'+name+'</option>').appendTo('#carte2');
				});
			}
		});
	}
}

function load_banque() {

    var prestation = $('#select_prestation').val();

    $.ajax({
        type: "POST",
        url: "/ajax/load_bank.php",
        data: "prestation="+prestation,
        dataType:'json',
        success: function(data) {
            $('#select_banque option').remove();
			$('<option value="indifferent">pratiqué par...</option>').appendTo('#select_banque');
			$('<option disabled>------------------------------</option>').appendTo('#select_banque');
			$('<option value="indifferent">Toutes les banques</option>').appendTo('#select_banque');
			$('<option disabled>------------------------------</option>').appendTo('#select_banque');
            $.each(data, function(i, name) {
                $('<option value="'+i+'">'+name+'</option>').appendTo('#select_banque');
            });
        }
    });

}

//envoie les donné au script qui gere le calcul des banques moins chere
function calcul() {

    var banque = $('#banque').val();
    var compte = $('[name=compte]:checked').val();
    var carte1 = $("#carte1").val();
    var carte2 = $("#carte2").val();

    var internet = 0;
    if($('[name=internet]:checked').length)
        internet = $('[name=internet]:checked').val();

    var bourse = 0;
    if($('[name=bourse]:checked').length)
        bourse = 1;

    var etranger = 0;
    if($('[name=etranger]:checked').length)
        etranger = 1;

    var incident = 0;
    if($('[name=incident]:checked').length)
        incident = 1;

    if(compte && carte1 !='') {
        var post = "banque="+banque+"&compte="+compte+"&carte1="+carte1+"&carte2="+carte2+"&internet="+internet+"&bourse="+bourse+"&etranger="+etranger+"&incident="+incident;

        $.ajax({
            type: "POST",
            url: "/ajax/calcul.php",
            data: post,
            success: function(msg) {
                $("#resultContent").html(msg);
            }
        });
    }
}

/**
 * check() 
 * Vérification de la saisie du formulaire de recherche
 */
function check() {

    var banque = $('#banque').val();
    var compte = $('[name=compte]:checked').val() || false;
    var carte1 = $("#carte1").val();
    var carte2 = $("#carte2").val();
    var internet = $('[name=internet]:checked').val() || 0;
    var bourse = $('[name=bourse]:checked').val() || 0;
    var etranger = $('[name=etranger]:checked').val() || 0;
    var incident = $('[name=incident]:checked').val() || 0;

    if(carte1 == "selection")
        carte1 = '';

    if(carte2 == "selection")
        carte2 = '';

    if(carte1 != '' && compte != false) {
        var post = "banque="+banque+"&compte="+compte+"&carte1="+carte1+"&carte2="+carte2+"&internet="+internet+"&bourse="+bourse+"&etranger="+etranger+"&incident="+incident;

        $.ajax({
            type: "POST",
            url: "/ajax/log_critere.php",
            data: post
        });

    }
    else {
        var msg_error = "";
        //if(banque == "indifferent")
          //  msg_error = "Vous n'avez pas indiqué votre banque actuelle.<br />";
        if(compte == false)
            msg_error += "Vous n'avez pas indiqué votre type de compte.<br />";
        //if(carte1 == "")
           // msg_error += "Vous n'avez pas indiqué votre type de carte.<br />";
        $('#msg_error').html(msg_error);
        return false;
    }
}

//appel le script qui insert les clic pour une banque
function log_banque(banque) {

    $.ajax({
        type: "POST",
        url: "/ajax/log_banque.php",
        data: 'banque='+banque
    });

}

var lnk='', txt = '';
function transformText(){
	var s = document.getElementsByTagName('span');
	for(i=0; i< s.length;i++){
		if((s[i].className.indexOf('url') != -1) || (s[i].className.indexOf('urllink') != -1)){
			lnk = document.createElement('a');
			lnk.href = s[i].title;
			lnk.rel = "nofollow";
			txt = s[i].innerHTML;
			if(s[i].className.indexOf('blank') != -1){
				lnk.target = '_blank';
			}
			lnk.innerHTML = txt;
			s[i].innerHTML = '';
			s[i].appendChild(lnk);
		}
	}
}

//fonction a appeler au chargement de la page
function fonctionsOnload(){
	addLinkerEvents();
	transformText();
	var div_revenus = '<div id="revenues_mensuels" ><h3>Quels sont vos revenus ? </h3> <select class="checkbox1" id="revenus_net" name="revenus_net"><option value="indifferent">vos revenus nets mensuels</option><option>moins de 1 200 euros</option><option>de 1 200 à 2 300 euros</option><option>de 2 300 à 4 000 euros</option><option>plus de 4 000 euros</option></select>   <div id="revenus_net_non_choisi" class="erreur">merci de choisir vos revenus</div><div style="clear: both;"></div></div> ';
	$('#accordion_1').after(div_revenus);
}

function showConditionalBlock(){
    var div_epargne = '<div id="block_montant_epargne" ><h3>Quel montant souhaitez-vous placer ?</h3>'
        + '<select class="checkbox1" id="montant_epargne" name="montant_epargne">'
        + '<option value="">sélectionnez une fourchette</option>'
        + '<option disabled="disabled" value="">----------</option>'
        + '<option value="moins de 5 000 €">inférieur de 5 000 €</option>'
        + '<option>de 5 000 € à 10 000 €</option>'
        + '<option>de 10 000 € à 20 000 €</option>'
        + '<option>de 20 000 € à 50 000 €</option>'
        + '<option>supérieur à 50 000 €</option>-->'
        + '</select>'
        + '<div style="clear: both;"></div>'
        + '</div>';
    $('#accordion_2').after(div_epargne);
}


// script d'affichage du menu deroulant site
$(document).ready( function () {
    // On cache les sous-menus :
   /* $(".navigation ul.subMenu").hide();
    // On sélectionne tous les items de liste portant la classe "toggleSubMenu"
    // et on remplace l'élément span qu'ils contiennent par un lien :
    $(".navigation li.toggleSubMenu span").each( function () {
        // On stocke le contenu du span :
        var TexteSpan = $(this).text();
        $(this).replaceWith('<a href="" title="Afficher le sous-menu">' + TexteSpan + '<\/a>') ;
    } ) ;
    // On modifie l'évènement "click" sur les liens dans les items de liste
    // qui portent la classe "toggleSubMenu" :
    $(".navigation li.toggleSubMenu > a").click( function () {
        // Si le sous-menu était déjà ouvert, on le referme :
        if ($(this).next("ul.subMenu:visible").length != 0) {
            $(this).next("ul.subMenu").slideUp("normal");
        }
        // Si le sous-menu est caché, on ferme les autres et on l'affiche :
        else {
            $(".navigation ul.subMenu").slideUp("normal");
            $(this).next("ul.subMenu").slideDown("normal");
        }
        // On empêche le navigateur de suivre le lien :
        return false;
    });
	*/
	$('div#navigation_site').click(function (e) {
		$('#subMenuSlide').slideToggle('fast');
		$('div#navigation_avance').slideUp('fast');
		e.stopPropagation();
    });

	
	
	$('div#nav_av').click(function (e) {
		$('div#navigation_avance').slideToggle('fast');
		$('#subMenuSlide').slideUp('fast');
		e.stopPropagation();
    });

	$(this).click(function () {	
		if($('div#navigation_avance').css('display')=='block'){
			 $('div#navigation_avance').slideUp('fast');
		}	
		if($('#subMenuSlide').css('display')=='block'){
			$('#subMenuSlide').slideUp('fast');
		}
   });
} ) ;
