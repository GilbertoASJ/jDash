<?php 
	
// Classe Dashboard
class Dashboard {

	public $dataInicio;
	public $dataFim;

	public $numeroVendas;
	public $totalVendas;
	public $clientesAtivos;
	public $clientesInativos;

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

	// Função para recuperar o total de clientes ativos
	public function getClientesAtivos() {

		$query = "SELECT 
					COUNT(*) as clientesAtivos 
				FROM 
					tb_clientes
				WHERE 
					cliente_ativo = 1";

		$stmt = $this->conexao->prepare($query);

		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ)->clientesAtivos;
	}

	// Função para recuperar o total de clientes inativos
	public function getClientesInativos() {

		$query = "SELECT 
					COUNT(*) as clientesInativos 
				FROM 
					tb_clientes
				WHERE 
					cliente_ativo = 0";

		$stmt = $this->conexao->prepare($query);

		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ)->clientesInativos;
	}
}

// Instânciando as classes

// Dashboard

$dashboard = new Dashboard();

$dashboard->__set('dataInicio', '2021-02-01');
$dashboard->__set('dataFim', '2021-02-31');

// Conexão

$conexao = new Conexao();

// Bd
$bd = new Bd($conexao, $dashboard);

$dashboard->__set('numeroVendas', $bd->getNumeroVendas());
$dashboard->__set('totalVendas', $bd->getTotalVendas());
$dashboard->__set('clientesAtivos', $bd->getClientesAtivos());
$dashboard->__set('clientesInativos', $bd->getClientesInativos());

print_r($dashboard);

?>