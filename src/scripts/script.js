// Documentação - 
$('#documentacao').on('click', () => {

	// Utilizando requisições ajax para substituir o conteúdo html - load, get e post
	// $('#pagina').load('documentacao.html')

	// $.get('documentacao.html', (data) => {

	// 	$('#pagina').html(data)
	// })

	$.post('documentacao.html', (data) => {

		$('#pagina').html(data)
	})


})

// Suporte - 
$('#suporte').on('click', () => {
	
	// Utilizando requisições ajax para substituir o conteúdo html - load, get e post
	// $('#pagina').load('suporte.html')

	// $.get('suporte.html', (data) => {

	// 	$('#pagina').html(data)
	// })

	$.post('suporte.html', (data) => {

		$('#pagina').html(data)
	})
})