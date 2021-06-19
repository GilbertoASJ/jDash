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
		dataType: 'json',
		success: (dados) => {
			console.log(dados)
			$('#numeroVendas').html(dados.numeroVendas);
			$('#totalVendas').html(`R$ ${dados.totalVendas}`);
			$('#clientesAtivos').html(dados.clientesAtivos);
			$('#clientesInativos').html(dados.clientesInativos);
			$('#reclamacoes').html(dados.reclamacoes);
			$('#elogios').html(dados.elogios);
			$('#sugestoes').html(dados.sugestoes);
			$('#totalDespesas').html(`R$ ${dados.despesas}`);
		},
		error: (erro) => { console.log(erro) },
	})
})