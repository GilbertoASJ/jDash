// Dashboard - 
$('#documentacao').on('click', () => {

	$.post('index.html', (data) => {

		$('#pagina').html(data)
	})


})

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