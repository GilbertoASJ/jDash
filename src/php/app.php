<?php 
	
// Classe Dashboard
class Dashboard {

	public $dataInicio;
	public $dataFim;

	// Vendas
	public $numeroVendas;
	public $totalVendas;

	// Clientes
	public $clientesAtivos;
	public $clientesInativos;

	// Tipo contato
	public $reclamacoes;
	public $elogios;
	public $sugestoes;

	// Despesas
	public $despesas;

	public function __get($attr) {

		return $this->$attr;
	}

	public function __set($attr, $value) {

		$this->$attr = $value;

		return $this;
	}
}

// Classe Conexão com o banco de dados
class Conexao {

	private $host = 'localhost';
	private $dbname = 'dashboard';
	private $user = 'root';
	private $password = '';

	// Método de conexão com o banco de dados
	public function conectar() {

		try {

			$conexao = new PDO(
				"mysql:host=$this->host;dbname=$this->dbname", 
				"$this->user",
				"$this->password"
			);

			// Atribuindo collection utf-8 para a aplicação
			$conexao->exec('set charset utf8');

			return $conexao;

		} catch(PDOException $e) {

			echo "<p> $e->getMessage() </p>";
		}
	}
}

// Classe model
class Bd {

	private $conexao;
	private $dashboard;

	public function __construct(Conexao $conexao, Dashboard $dashboard) {

		$this->conexao = $conexao->conectar();
		$this->dashboard = $dashboard;
	}

	// Função para recuperar o número de vendas
	public function getNumeroVendas() {

		$query = "SELECT 
					COUNT(*) as numeroVendas 
				FROM 
					tb_vendas 
				WHERE 
					data_venda BETWEEN :dataInicio AND :dataFim ";

		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':dataInicio', $this->dashboard->__get('dataInicio'));
		$stmt->bindValue(':dataFim', $this->dashboard->__get('dataFim'));

		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ)->numeroVendas;
	}

	// Função para recuperar o total de vendas
	public function getTotalVendas() {

		$query = "SELECT 
					SUM(total) as totalVendas 
				FROM 
					tb_vendas 
				WHERE 
					data_venda BETWEEN :dataInicio AND :dataFim ";

		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':dataInicio', $this->dashboard->__get('dataInicio'));
		$stmt->bindValue(':dataFim', $this->dashboard->__get('dataFim'));

		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ)->totalVendas;
	}

	// Função para recuperar o total de clientes ativos e inativos
	public function getEstadoCliente($estadoCliente) {

		$query = "SELECT 
					COUNT(*) as estadoCliente
				FROM 
					tb_clientes
				WHERE 
					cliente_ativo = $estadoCliente";

		$stmt = $this->conexao->prepare($query);

		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ)->estadoCliente;
	}

	// Função para recuperar o total do tipo de contato
	public function getTipoContato($tipoContato) {

		$query = "SELECT 
					COUNT(*) as reclamacao
				FROM 
					`tb_contatos`
				WHERE 
					tipo_contato = $tipoContato";

		$stmt = $this->conexao->prepare($query);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ)->reclamacao;
	}

	// Função para recuperar o total de despesas
	public function getTotalDespesas() {

		$query = "SELECT 
					SUM(total) as totalDespesas 
				FROM 
					tb_despesas
				WHERE 
					data_despesa BETWEEN :dataInicio AND :dataFim";

		$stmt = $this->conexao->prepare($query);

		$stmt->bindValue(':dataInicio', $this->dashboard->__get('dataInicio'));
		$stmt->bindValue(':dataFim', $this->dashboard->__get('dataFim'));

		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ)->totalDespesas;

	}
}

/*
	Instânciando as classes
*/

# Dashboard
$dashboard = new Dashboard();

# Conexão
$conexao = new Conexao();

# Bd
$bd = new Bd($conexao, $dashboard);

/*
	Atribuindo valores
*/

$competencia = explode('-', $_GET['competencia']);
$ano = $competencia[0];
$mes = $competencia[1];

$diasDoMes = cal_days_in_month(calendar, month, year);

$dashboard->__set('dataInicio', '2021-02-01');
$dashboard->__set('dataFim', '2021-02-31');

$dashboard->__set('numeroVendas', $bd->getNumeroVendas());
$dashboard->__set('totalVendas', $bd->getTotalVendas());

$dashboard->__set('clientesAtivos', $bd->getEstadoCliente(1));
$dashboard->__set('clientesInativos', $bd->getEstadoCliente(0));

$dashboard->__set('reclamacoes', $bd->getTipoContato(1));
$dashboard->__set('elogios', $bd->getTipoContato(2));
$dashboard->__set('sugestoes', $bd->getTipoContato(3));

$dashboard->__set('despesas', $bd->getTotalDespesas());

echo "<pre>";
	print_r($competencia);
echo "</pre>";

?>