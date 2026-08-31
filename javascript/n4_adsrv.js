
function get_params (v_form){
	
alert(document.getElementById('nombre_usuario').getAttribute('value'));
	
	document.getElementById('volver_form').elements[14].value = 'hola';
	document.getElementById(v_form.name).childNodes[16].value = document.getElementById('p_apellidos').value;
	document.getElementById(v_form.name).childNodes[18].value = document.getElementById('p_telefono_usuario').getAttribute('value');
	document.getElementById(v_form.name).childNodes[20].value = document.getElementById('p_email_usuario').getAttribute('value');
	document.getElementById(v_form.name).childNodes[22].value = document.getElementById('p_username').getAttribute('value');
	
	alert (document.getElementById(v_form.name).elements[14].getAttribute('value'));

}