// Documentação - 
$('#documentacao').on('click', () => {

	$.post('documentacao.html', (data) => {

		$('#pagina').html(data)
	})


})

// Suporte - 
$('#suporte').on('click', () => {

	$.post('suporte.html', (data) => {

		$('#pagina').html(data)
	})
})

// Implementação do Ajax na aplicação - 
$('#competencia').on('change', (e) => {

	let competencia = $(e.target).val();

	// Método da requisição, url, dados, sucesso, erro.
	$.ajax({
		type: 'GET',
		url: './src/php/app.php',
		data: `competencia=${competencia}`, // x-www-form-urlencoded
		success: dados => { console.log(dados) },
		error: erro => { console.log(erro) },
	})
})