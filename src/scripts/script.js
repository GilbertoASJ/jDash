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

	// Método da requisição, url, dados, sucesso, erro.
	$.ajax({
		type: 'GET',
		url: '../php/app.php',
		data: 'competencia=2021-02', // x-www-form-urlencoded
		success: () => {console.log('Sucesso')},
		error: () => {console.log('Erro')},
	})
})